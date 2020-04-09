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

        function NewDevice($mechant_log_id_fk,$device_type,$terminal_id,$device_serial,$base_serial,$mtn_sim_serial,$airtel_sim_serial,$installation_date,$ip_address,$asset_code)
        {
            try
            {
                $sql = "INSERT INTO device_info(mechant_log_id_fk,device_type,terminal_id,device_serial,base_serial,mtn_sim_serial,airtel_sim_serial,installation_date,ip_address,fnb_asset_code,created_by,date_created) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $mechant_log_id_fk);
                $stmt->bindvalue(2, $device_type);
                $stmt->bindvalue(3, $terminal_id);
                $stmt->bindvalue(4, $device_serial);
                $stmt->bindvalue(5, $base_serial);
                $stmt->bindvalue(6, $mtn_sim_serial);
                $stmt->bindvalue(7, $airtel_sim_serial);
                $stmt->bindvalue(8, $installation_date);
                $stmt->bindvalue(9, $ip_address);
                $stmt->bindvalue(10, $asset_code);
                $stmt->bindvalue(11, $_SESSION['person']);
                $stmt->bindvalue(12, date('Y-m-d H:i:s'));
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
        function UpdateDevice($mechant_id,$device_type,$terminal_id,$device_serial,$base_serial,$mtn_sim_serial,$airtel_sim_serial,$installation_date,$ip_address,$asset_code,$devID)
        {
            try
            {
                $sql1 = "SELECT mechant_log_id from mechants WHERE mechant_id = ?;";
                $stmt1 = $this->connect()->prepare($sql1);
                $stmt1->bindvalue(1,$mechant_id);
                $stmt1->execute();
                $rows = $stmt1->fetch(PDO::FETCH_ASSOC);

                $sql = "UPDATE device_info SET mechant_log_id_fk =?,device_type=?,terminal_id=?,device_serial=?,base_serial=?,mtn_sim_serial=?,airtel_sim_serial=?,installation_date=?,ip_address=?,fnb_asset_code=? WHERE device_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $rows['mechant_log_id']);
                $stmt->bindvalue(2, $device_type);
                $stmt->bindvalue(3, $terminal_id);
                $stmt->bindvalue(4, $device_serial);
                $stmt->bindvalue(5, $base_serial);
                $stmt->bindvalue(6, $mtn_sim_serial);
                $stmt->bindvalue(7, $airtel_sim_serial);
                $stmt->bindvalue(8, $installation_date);
                $stmt->bindvalue(9, $ip_address);
                $stmt->bindvalue(10, $asset_code);
                $stmt->bindvalue(11, $devID);
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

        function DeleteDevice($deviceID)
        {
            try
            {
                $sql = "DELETE FROM device_info WHERE device_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $deviceID);
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

        function getMechID($type)
        {
            try
            {
                $sql = "SELECT * from mechants WHERE mechant_type = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$type);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    echo '<optgroup label="Available Mechants">';
                    while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<option value=".$rows['mechant_log_id'].">".$rows['mechant_id']."</option>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }
    }

    $dev = new Devices();

    if(!empty($_POST['mechID']))
    {
        $mechant_log_id_fk = $_POST['mechID'];
        $device_type = $_POST['devtype'];
        $terminal_id = $_POST['terminaID'];
        $device_serial = $_POST['device_serial'];
        $base_serial = $_POST['base_serial'];
        $mtn_sim_serial = $_POST['mtn_sim_serial'];
        $airtel_sim_serial = $_POST['airtel_sim_serial'];
        $installation_date = $_POST['installation_date'];
        $ip_address = $_POST['ip_address'];
        $asset_code = $_POST['asset_code'];
        $dev -> NewDevice($mechant_log_id_fk,$device_type,$terminal_id,$device_serial,$base_serial,$mtn_sim_serial,$airtel_sim_serial,$installation_date,$ip_address,$asset_code);
    }

    if(isset($_POST['metype']))
    {

        $type = $_POST['metype'];
        $dev -> getMechID($type);
    }

    if(!empty($_POST['mechID2']) && empty($_POST['mechID']))
    {
        $catez = $_POST['devID'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $devID = $token;

        $mechant_id = $_POST['mechID2'];
        $device_type = $_POST['devtype2'];
        $terminal_id = $_POST['terminaID2'];
        $device_serial = $_POST['device_serial2'];
        $base_serial = $_POST['base_serial2'];
        $mtn_sim_serial = $_POST['mtn_sim_serial2'];
        $airtel_sim_serial = $_POST['airtel_sim_serial2'];
        $installation_date = $_POST['installation_date2'];
        $ip_address = $_POST['ip_address2'];
        $asset_code = $_POST['asset_code2'];
        $dev -> UpdateDevice($mechant_id,$device_type,$terminal_id,$device_serial,$base_serial,$mtn_sim_serial,$airtel_sim_serial,$installation_date,$ip_address,$asset_code,$devID);
    }

    if(isset($_POST['deletedev']))
    {
        $catez = $_POST['deletedev'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $deviceID = $token;
        $dev -> DeleteDevice($deviceID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }



?>