<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class Categories extends Database
    {

        function NewSLA($client_sla_for,$start_time,$end_time,$wik_start_time,$wik_end_time)
        {
            try
            {
                $time_period = 'Week Days';
                $sql = "INSERT INTO atm_sla(client_sla_for,time_period,start_time,end_time,created_by,date_created) VALUES(?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $client_sla_for);
                $stmt->bindvalue(2, $time_period);
                $stmt->bindvalue(3, $start_time);
                $stmt->bindvalue(4, $end_time);
                $stmt->bindvalue(5, $_SESSION['person']);
                $stmt->bindvalue(6, date('Y-m-d H:i:s'));
                if($stmt->execute())
                {
                    $time_period = 'Weekends';
                    $sql = "INSERT INTO atm_sla(client_sla_for,time_period,start_time,end_time,created_by,date_created) VALUES(?,?,?,?,?,?);";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $client_sla_for);
                    $stmt->bindvalue(2, $time_period);
                    $stmt->bindvalue(3, $wik_start_time);
                    $stmt->bindvalue(4, $wik_end_time);
                    $stmt->bindvalue(5, $_SESSION['person']);
                    $stmt->bindvalue(6, date('Y-m-d H:i:s'));
                    if($stmt->execute())
                    {
                        echo "Success";
                    }
                    else
                    {
                        echo "Failed";
                    }
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }
        function UpdateSLA($start_time,$end_time,$wik_start_time,$wik_end_time,$client_sla_for)
        {
            try
            {
                $time_period = 'Week Days';
                $sql = "UPDATE atm_sla SET start_time=?,end_time=? WHERE client_sla_for=? AND time_period=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $start_time);
                $stmt->bindvalue(2, $end_time);
                $stmt->bindvalue(3, $client_sla_for);
                $stmt->bindvalue(4, $time_period);
                if($stmt->execute())
                {
                    $time_period = 'Weekends';
                    $sql2 = "UPDATE atm_sla SET start_time=?,end_time=? WHERE client_sla_for=? AND time_period=?;";
                    $stmt2 = $this->connect()->prepare($sql2);
                    $stmt2->bindvalue(1, $wik_start_time);
                    $stmt2->bindvalue(2, $wik_end_time);
                    $stmt2->bindvalue(3, $client_sla_for);
                    $stmt2->bindvalue(4, $time_period);
                    if($stmt2->execute())
                    {
                        echo "Success";
                    }
                    else
                    {
                        echo "Failed";
                    }
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }

        function DeleteSLA($client_sla_for)
        {
            try
            {
                $sql = "DELETE FROM atm_sla WHERE client_sla_for = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $client_sla_for);
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
            }
        }
    }

    $catig = new Categories();

    if(!empty($_POST['start_time']) && empty($_POST['slas_id']))
    {
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $wik_start_time = $_POST['wik_start_time'];
        $wik_end_time = $_POST['wik_end_time'];

        $client_sla_for = $_POST['client'];
        list($client_sla_for, $enc_iv) = explode("::", $client_sla_for);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($client_sla_for, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $client_sla_for = $token;

        $catig -> NewSLA($client_sla_for,$start_time,$end_time,$wik_start_time,$wik_end_time);
    }

    if(isset($_POST['start_time']) && !empty($_POST['slas_id']))
    {
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $wik_start_time = $_POST['wik_start_time'];
        $wik_end_time = $_POST['wik_end_time'];

        $sla_id = $_POST['slas_id'];
        list($sla_id, $enc_iv) = explode("::", $sla_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($sla_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $sla_id = $token;

        $sql1 = "SELECT client_sla_for FROM atm_sla WHERE sla_id=?;";
        $stmt1 = $object->connect()->prepare($sql1);
        $stmt1->bindvalue(1, $sla_id);
        $stmt1->execute();
        $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $client_sla_for = $rows1['client_sla_for'];

        $catig -> UpdateSLA($start_time,$end_time,$wik_start_time,$wik_end_time,$client_sla_for);
    }

    if(isset($_POST['deleteSLA']))
    {
        $sla_id = $_POST['deleteSLA'];
        list($sla_id, $enc_iv) = explode("::", $sla_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($sla_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $sla_id = $token;

        $sql1 = "SELECT client_sla_for FROM atm_sla WHERE sla_id=?;";
        $stmt1 = $object->connect()->prepare($sql1);
        $stmt1->bindvalue(1, $sla_id);
        $stmt1->execute();
        $rows = $stmt1->fetch();
        $client_sla_for = $rows['client_sla_for'];


        $catig -> DeleteSLA($client_sla_for);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['sla_id']))
    {
        $sla_id = $_POST['sla_id'];
        list($sla_id, $enc_iv) = explode("::", $sla_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($sla_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $sla_id = $token;
        //echo $sla_id;
        // SELECT * FROM atm_sla, clients WHERE client_id = client_sla_for AND client_sla_for = 1
        $sql1 = "SELECT client_sla_for FROM atm_sla WHERE sla_id=?;";
        $stmt1 = $object->connect()->prepare($sql1);
        $stmt1->bindvalue(1, $sla_id);
        $stmt1->execute();
        if($stmt1->rowCount())
        {
            $rows1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            //echo $rows1['client_sla_for'];
            $sql2 = "SELECT * FROM atm_sla, clients WHERE client_id = client_sla_for AND client_sla_for =? AND time_period = 'Week Days';";
            $stmt2 = $object->connect()->prepare($sql2);
            $stmt2->bindvalue(1, $rows1['client_sla_for']);
            $stmt2->execute();
            
            if($stmt2->rowCount())
            {
                $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                $start_time = $rows2['start_time'];
                $end_time = $rows2['end_time'];
                $sql3 = "SELECT * FROM atm_sla, clients WHERE client_id = client_sla_for AND client_sla_for =? AND time_period = 'Weekends';";
                $stmt3 = $object->connect()->prepare($sql3);
                $stmt3->bindvalue(1, $rows1['client_sla_for']);
                $stmt3->execute();
                $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                $wik_start_time = $row3['start_time'];
                $wik_end_time = $row3['end_time'];
                //echo $rows2['client_name'];
            }
            
            
            $json = array("client_name" => $rows2['client_name'].' ('.$rows2['client_name_abbr'].')',"start_time" => $start_time,"end_time" => $end_time,"wik_start_time" => $wik_start_time,"wik_end_time" => $wik_end_time);
            echo json_encode($json);
        }



        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

?>