<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();

    class ATMs extends Database
    {

        function addATM($atm_name,$atm_site,$atm_type,$atm_model,$client_id,$province)
        {
            try
            {
                $sql = "INSERT INTO atm_details(atm_name,atm_site,atm_type,atm_model,client_id_fk,province,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $atm_name);
                $stmt->bindvalue(2, $atm_site);
                $stmt->bindvalue(3, $atm_type);
                $stmt->bindvalue(4, $atm_model);
                $stmt->bindvalue(5, $client_id);
                $stmt->bindvalue(6, $province);
                $stmt->bindvalue(7, $_SESSION['id']);
                $stmt->bindvalue(8, date('Y-m-d H:i:s'));
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
                echo "Error".$e->getMessage();
            }
        }

        function updateATM($atm_name,$atm_site,$atm_type,$atm_model,$province,$atm_id)
        {
            try
            {
                $sql = "UPDATE atm_details SET atm_name=?,atm_site=?,atm_type=?,atm_model=?,province=? WHERE atm_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $atm_name);
                $stmt->bindvalue(2, $atm_site);
                $stmt->bindvalue(3, $atm_type);
                $stmt->bindvalue(4, $atm_model);
                $stmt->bindvalue(5, $province);
                $stmt->bindvalue(6, $atm_id);
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
                echo "Error".$e->getMessage();
            }
        }

        function deleteATM($atm_id)
        {
            try
            {
                $sql = "DELETE FROM atm_details WHERE atm_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $atm_id);
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
                echo "Error";
            }
        }
    }

    $atmadd = new ATMs();

    if(isset($_POST['atm_name']))
    {
        $atm_name = $_POST['atm_name'];
        $atm_site = $_POST['site'];
        $atm_type = $_POST['atm_type'];
        $atm_model = $_POST['model'];
        $id = $_POST['client'];
        $province = $_POST['prov'];
        
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $client_id = $token;

        $atmadd -> addATM($atm_name,$atm_site,$atm_type,$atm_model,$client_id,$province);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['deletedev']))
    {
        $id = $_POST['deletedev'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $atm_id = $token;
        $atmadd -> deleteATM($atm_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(!empty($_POST['atmID2']))
    {
        $atm_name = $_POST['atm_name2'];
        $atm_site = $_POST['site2'];
        $atm_type = $_POST['atm_type2'];
        $atm_model = $_POST['model2'];
        $atm_id = $_POST['atmID2'];
        $province = $_POST['prov2'];
        //$id = $_POST['deleteIDs'];
        // atm id
        list($atm_id, $enc_iv) = explode("::", $atm_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($atm_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $atm_id = $token;

        $atmadd -> updateATM($atm_name,$atm_site,$atm_type,$atm_model,$province,$atm_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
        
    }
?>