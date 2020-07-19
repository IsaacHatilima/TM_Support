<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class Devices extends Database
    {
        public $mechtype;
        public $mechname;
        public $mechID;
        public $mechprov;
        public $mechtown;

        function NewRepiaredDevice($devtype,$device_serial,$ptid,$warranty,$fault,$gen_prob,$repair_status)
        {
            $ref_num = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);

            try
            {
                $sql = "INSERT INTO device_repair(reference_num,device_type,device_serial,ptid,warrant_sticker,fault_on_screen,general_problem,created_by,date_created,repair_status) VALUES(?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ref_num);
                $stmt->bindvalue(2, $devtype);
                $stmt->bindvalue(3, $device_serial);
                $stmt->bindvalue(4, $ptid);
                $stmt->bindvalue(5, $warranty);
                $stmt->bindvalue(6, $fault);
                $stmt->bindvalue(7, $gen_prob);
                $stmt->bindvalue(8, $_SESSION['person']);
                $stmt->bindvalue(9, date('Y-m-d H:i:s'));
                $stmt->bindvalue(10, $repair_status);
                if($stmt->execute())
                {
                    echo "Success";
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
                // .$e->getMessage()
            }
        }

        function getRepairDetails($repair_id)
        {
            try
            {
                $sql = "SELECT * FROM device_repair WHERE repair_id = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $repair_id);
                $stmt->execute();

                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                $json = array("ref_numb" => $rows['reference_num'],"status" => $rows['repair_status'],"dev_type" => $rows['device_type'],"serial" => $rows['device_serial'],"ptid" => $rows['ptid'],"warrant_sticker" => $rows['warrant_sticker'],"fault_on_screen" => $rows['fault_on_screen'],"general_problem" => $rows['general_problem']);

                echo json_encode($json);
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }

        function closeRepairDetails($parts_used, $eos_reload,$repaire_date,$final_test,$comment,$fixed_by,$repair_id)
        {
            $status = "Completed";
            try
            {
                $sql = "UPDATE device_repair SET parts_used=?, eos_reload=?, date_repaired=?, final_test=?, status_comment=?, repair_status=?, repaired_by=? WHERE repair_id = ?";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $parts_used);
                $stmt->bindvalue(2, $eos_reload);
                $stmt->bindvalue(3, $repaire_date);
                $stmt->bindvalue(4, $final_test);
                $stmt->bindvalue(5, $comment);
                $stmt->bindvalue(6, $status);
                $stmt->bindvalue(7, $fixed_by);
                $stmt->bindvalue(8, $repair_id);
                if($stmt->execute())
                {
                    echo 'Success';
                }
                else
                {
                    echo 'Failed';
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }
        }
        
    }

    $dev = new Devices();

    if(!empty($_POST['devtype']))
    {
        $devtype = $_POST['devtype'];
        $device_serial = $_POST['device_serial'];
        $warranty = ucwords($_POST['warranty']);
        $fault = ucwords($_POST['fault']);
        $gen_prob = ucwords($_POST['gen_prob']) ;
        // $parts_used = ucwords($_POST['parts_used']);
        // $eos_reload = $_POST['eos_reload'];
        // $repaire_date = $_POST['repaire_date'];
        // $final_test = ucwords($_POST['final_test']);
        // $comment = ucwords($_POST['comment']);
        $ptid = $_POST['ptid'];
        $repair_status = 'In Progress';
        $dev -> NewRepiaredDevice($devtype,$device_serial,$ptid,$warranty,$fault,$gen_prob,$repair_status);
    }
    // ,$gen_prob,$parts_used,$eos_reload,$repaire_date,$final_test,$comment

    if(!empty($_POST['repairs_id']))
    {
        $repair_id = $_POST['repairs_id'];
        list($repair_id, $enc_iv) = explode("::", $repair_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($repair_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $repair_id = $token;
        $dev -> getRepairDetails($repair_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['parts_used']))
    {
        $repair_id = $_POST['repaired_id'];
        list($repair_id, $enc_iv) = explode("::", $repair_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($repair_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $repair_id = $token;
        unset($token, $cipher_method, $enc_key, $enc_iv);

        $parts_used = ucwords($_POST['parts_used']);
        $eos_reload = $_POST['eos_reload'];
        $repaire_date = date('Y-m-d');
        $final_test = ucwords($_POST['test_results']);
        $comment = ucwords($_POST['comment']);

        $fixed_by = $_POST['fixed_by'];
        list($fixed_by, $enc_iv) = explode("::", $fixed_by);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($fixed_by, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $fixed_by = $token;
        unset($token, $cipher_method, $enc_key, $enc_iv);

        $dev -> closeRepairDetails($parts_used, $eos_reload,$repaire_date,$final_test,$comment,$fixed_by,$repair_id);
        
    }

?>