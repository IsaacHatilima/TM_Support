<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class Categories extends Database
    {
        public $mechtype;
        public $mechname;
        public $mechID;
        public $mechprov;
        public $mechtown;

        function NewMechant($mechtype,$mechname,$mechID,$mechprov,$mechtown)
        {
            try
            {
                $sql = "INSERT INTO mechants(mechant_type,mechant_name,mechant_id,mechant_province,mechant_town,created_by,date_created) VALUES(?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $mechtype);
                $stmt->bindvalue(2, $mechname);
                $stmt->bindvalue(3, $mechID);
                $stmt->bindvalue(4, $mechprov);
                $stmt->bindvalue(5, $mechtown);
                $stmt->bindvalue(6, $_SESSION['person']);
                $stmt->bindvalue(7, date('Y-m-d H:i:s'));
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
        function UpdateMechant($mechtype,$mechname,$mechID,$mechprov,$mechtown,$mechSYSID)
        {
            try
            {
                $sql = "UPDATE mechants SET mechant_type=?,mechant_name=?,mechant_id=?,mechant_province=?,mechant_town=? WHERE mechant_log_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $mechtype);
                $stmt->bindvalue(2, $mechname);
                $stmt->bindvalue(3, $mechID);
                $stmt->bindvalue(4, $mechprov);
                $stmt->bindvalue(5, $mechtown);
                $stmt->bindvalue(6, $mechSYSID);
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

        function DeleteMechant($mechID)
        {
            try
            {
                $sql = "DELETE FROM mechants WHERE mechant_log_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $mechID);
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

    if(!empty($_POST['mechtype']))
    {
        $mechtype = $_POST['mechtype'];
        $mechname = $_POST['mechname'];
        $mechID = $_POST['mechID'];
        $mechprov = $_POST['prov'];
        $mechtown = $_POST['town'];
        $catig -> NewMechant($mechtype,$mechname,$mechID,$mechprov,$mechtown);
    }

    if(isset($_POST['MeachantID']) && empty($_POST['mechtype']))
    {
        $catez = $_POST['MeachantID'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $mechSYSID = $token;

        unset($token, $cipher_method, $enc_key, $enc_iv);
        $mechtype = $_POST['mechtype2'];
        $mechname = $_POST['mechname2'];
        $mechprov = $_POST['prov2'];
        $mechtown = $_POST['town2'];
        $mechID = $_POST['mechID2'];
        $catig -> UpdateMechant($mechtype,$mechname,$mechID,$mechprov,$mechtown,$mechSYSID);
    }

    if(isset($_POST['deleteMech']))
    {
        $catez = $_POST['deleteMech'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $mechID = $token;
        $catig -> DeleteMechant($mechID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

?>