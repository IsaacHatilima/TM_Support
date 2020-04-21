<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();

    class BankClass extends Database
    {
        public $bank_name;
        public $bank_abb;
        public $created_by;
        public $date_created;
        public $modified_by;
        public $date_modified;

        function addBank($bank_name,$bank_abb)
        {
            try
            {
                $sql = "INSERT INTO clients(client_name,client_name_abbr,created_by,date_created) VALUES(?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $bank_name);
                $stmt->bindvalue(2, $bank_abb);
                $stmt->bindvalue(3, $_SESSION['person']);
                $stmt->bindvalue(4, date('Y-m-d H:i:s'));
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
                //.$e->getMessage()
            }
        }

        function deleteBank($bank_id)
        {
            try
            {
                $sql = "DELETE FROM clients WHERE client_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $bank_id);
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

        function getBank($bank_id)
        {
            try
            {
                $sql = "SELECT * FROM clients WHERE client_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $bank_id);
                if($stmt->execute())
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $id = $rows['client_id'];

                    $token = $id;

                    $cipher_method = 'aes-128-ctr';
                    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);  
                    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));  
                    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

                    $json = array("bankname" => $rows['client_name'],"bankabbs" => $rows['client_name_abbr'], "IDBank" => $crypted_token);
                    echo json_encode($json);
                    unset($token, $cipher_method, $enc_key, $enc_iv);
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

        function updateBank($bank_name,$bank_abb,$bank_id)
        {
            try
            {
                $sql = "UPDATE clients SET client_name=?,client_name_abbr=?,modified_by=?,date_modified=? WHERE client_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $bank_name);
                $stmt->bindvalue(2, $bank_abb);
                $stmt->bindvalue(3, $_SESSION['person']);
                $stmt->bindvalue(4, date('Y-m-d H:i:s'));
                $stmt->bindvalue(5, $bank_id);
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

    $banks = new BankClass();

    if(isset($_POST['bankName']) && empty($_POST['bankID']))
    {
        $bank_name = $_POST['bankName'];
        $bank_abb = $_POST['bankNameAbb'];
        $banks -> addBank($bank_name, $bank_abb);
    }

    if(!empty($_POST['bankID']) && isset($_POST['bankName']))
    {
        $ticket_id = $_POST['bankID'];
        list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $bank_id = $token;
        $bank_name = $_POST['bankName'];
        $bank_abb = $_POST['bankNameAbb'];
        $banks -> updateBank($bank_name,$bank_abb,$bank_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['deleteBank']))
    {
        $ticket_id = $_POST['deleteBank'];
        list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $bank_id = $token;
        $banks -> deleteBank($bank_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['geting']))
    {
        $ticket_id = $_POST['geting'];
        list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $bank_id = $token;
        $banks -> getBank($bank_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

