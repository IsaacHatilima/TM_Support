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

        function NewRepiaredDevice($devtype,$device_serial,$ptid,$warranty,$fault,$gen_prob,$parts_used,$eos_reload,$repaire_date,$final_test,$comment)
        {
            try
            {
                $sql = "INSERT INTO device_repair(device_type,device_serial,ptid,warrant_sticker,fault_on_screen,general_problem,parts_used,eos_reload,date_repaired,final_test,status_comment,created_by,date_created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $devtype);
                $stmt->bindvalue(2, $device_serial);
                $stmt->bindvalue(3, $ptid);
                $stmt->bindvalue(4, $warranty);
                $stmt->bindvalue(5, $fault);
                $stmt->bindvalue(6, $gen_prob);
                $stmt->bindvalue(7, $parts_used);
                $stmt->bindvalue(8, $eos_reload);
                $stmt->bindvalue(9, $repaire_date);
                $stmt->bindvalue(10, $final_test);
                $stmt->bindvalue(11, $comment);
                $stmt->bindvalue(12, $_SESSION['person']);
                $stmt->bindvalue(13, date('Y-m-d H:i:s'));
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
        
    }

    $dev = new Devices();

    if(!empty($_POST['devtype']))
    {
        $devtype = $_POST['devtype'];
        $device_serial = $_POST['device_serial'];
        $warranty = ucwords($_POST['warranty']);
        $fault = ucwords($_POST['fault']);
        $gen_prob = ucwords($_POST['gen_prob']) ;
        $parts_used = ucwords($_POST['parts_used']);
        $eos_reload = $_POST['eos_reload'];
        $repaire_date = $_POST['repaire_date'];
        $final_test = ucwords($_POST['final_test']);
        $comment = ucwords($_POST['comment']);
        $ptid = $_POST['ptid'];
        $dev -> NewRepiaredDevice($devtype,$device_serial,$ptid,$warranty,$fault,$gen_prob,$parts_used,$eos_reload,$repaire_date,$final_test,$comment);
    }


?>