<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();

    class Clients extends Database
    {
        public $first_name;
        public $last_name;
        public $bank_id;
        public $username;
        public $email;
        public $cell;
        public $contact_type;
        public $user_id;
        public $status;
        public $uuid;
        public $chng_password;
        public $role;
        public $FinalPassword;
        public $plain_password;

        function addClientUser($first_name,$last_name,$email,$cell,$bank_id,$contact_type,$username,$status,$plain_password,$FinalPassword,$role,$chng_password,$uuid)
        {
            try
            {
                $sqltestu = "SELECT COUNT(user_id) FROM user_login WHERE username = ?;";
                $stmttestu = $this->connect()->prepare($sqltestu);
                $stmttestu->bindvalue(1, $username);
                $stmttestu->execute();
                $num = $stmttestu->fetchColumn();
                if($num > 0)
                {
                    //$rowl = $stmttestu->fetch(PDO::FETCH_ASSOC);
                    //$num = $stmttestu->rowCount();
                    //$usernamez = $username.$num;
                    echo "Username Taken";
                }
                else
                {
                    $sql = "INSERT INTO clients(client_first_name,client_last_name,email,cell,bank_id_fk,contact_type,uuid,created_by,date_created) VALUES(?,?,?,?,?,?,?,?,?);";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $first_name);
                    $stmt->bindvalue(2, $last_name);
                    $stmt->bindvalue(3, $email);
                    $stmt->bindvalue(4, $cell);
                    $stmt->bindvalue(5, $bank_id);
                    $stmt->bindvalue(6, $contact_type);
                    $stmt->bindvalue(7, $uuid);
                    $stmt->bindvalue(8, $_SESSION['person']);
                    $stmt->bindvalue(9, date('Y-m-d H:i:s'));
                    if($stmt->execute())
                    {
                        $sqlg = "SELECT client_id FROM clients WHERE uuid = ?;";
                        $stmtg = $this->connect()->prepare($sqlg);
                        $stmtg->bindvalue(1, $uuid);
                        $stmtg->execute();
                        $row = $stmtg->fetch(PDO::FETCH_ASSOC);
                        $cliID = $row['client_id'];
    
                        $sql2 = "INSERT INTO user_login(person_id,username,password,status,role,changed_password,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
                        $stmt = $this->connect()->prepare($sql2);
                        $stmt->bindvalue(1, $cliID);
                        $stmt->bindvalue(2, $username);
                        $stmt->bindvalue(3, $FinalPassword);
                        $stmt->bindvalue(4, $status);
                        $stmt->bindvalue(5, $role);
                        $stmt->bindvalue(6, $chng_password);
                        $stmt->bindvalue(7, $_SESSION['person']);
                        $stmt->bindvalue(8, date('Y-m-d H:i:s'));
                        if($stmt->execute())
                        {
                            self::logEmail($first_name,$last_name,$email,$username,$plain_password,$bank_id,$cell);
                            
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

            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }
        }

        function primaryCont($bank_id)
        {
            try
            {
                $num = "1";

                $sqlg = "SELECT COUNT(contact_type) AS kon FROM clients WHERE contact_type = 'Primary' AND bank_id_fk = ?;";
                $stmtg = $this->connect()->prepare($sqlg);
                $stmtg->bindvalue(1, $bank_id);
                $stmtg->execute();
                $row = $stmtg->fetch(PDO::FETCH_ASSOC);
                if($row['kon'] > 0 )
                {
                    // $row = $stmtg->fetch(PDO::FETCH_ASSOC);
                    // $cont = $row['contact_type'];
                    $sql = "INSERT INTO pos_primary_contact(available,banks) VALUES(?,?);";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $num);
                    $stmt->bindvalue(2, $bank_id);
                    $stmt->execute();
                }

            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }

        }

        function getContactType($bank_id)
        {
            try
            {
                $sql = "SELECT available FROM pos_primary_contact WHERE banks=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$bank_id);
                $stmt->execute();
                $rows = $stmt->fetch();
                $count = $rows['available'];
                if($count > 0)
                {
                    echo "<option value='Secondary'>Secondary</option>";
                }
                elseif($count <= 0)
                {
                    echo '<option value="Primary">Primary</option>';
                    echo '<option value="Secondary">Secondary</option>';
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function getContactType2($person)
        {
            try
            {
                $sql = "SELECT contact_type FROM clients WHERE client_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$person);
                $stmt->execute();
                $rows = $stmt->fetch();
                echo "<option selected value='$rows[contact_type]'>$rows[contact_type]</option>";
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function logEmail($first_name,$last_name,$email,$username,$plain_password,$bank_id,$cell)
        {
            $emailType = "User Creation";
            $sub = 'Account Creation';
            $status = 'PENDING';
            $message = '
            <html>
                <head>
                    <style>
                        .container {
                            padding: 2px 16px;
                        }
                        .tr,table,td
                        {
                            border:1px solid black;
                            border-collapse: collapse;
                        }
                    </style>
                </head>
                <body>
                    <div class="card">
                        <div class="container" style="font-size: 20px">
                        <br><br>
                            Dear '.$first_name.' '.$last_name.',<br><br>
                            Your TechMasters support system account has been created successfully.<br>
                            You can log in with the following details:<br>
                            Username <b>'.$username.'</b><br>
                            OTP <b>'.$plain_password.'</b><br>
                            You can sign in <b><a href="https://www.techmasters.co.zm/UAT2">here.</a></b><br><br><br>
            
                            Yours Sincerely<br>
                            TechMasters Support.<br>
                        </div>
                    </div>
                </body>
            </html>
            ';
            
            try
            {
                $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,bankID) VALUES(?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $emailType);
                $stmt->bindvalue(2, $email);
                $stmt->bindvalue(3, $status);
                $stmt->bindvalue(4, $sub);
                $stmt->bindvalue(5, $message);
                $stmt->bindvalue(6, date('Y-m-d'));
                $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                $stmt->bindvalue(8, $bank_id);

                if($stmt->execute())
                {
                    self::logSMS($first_name,$last_name,$cell,$username,$plain_password);
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }
        }

        function logSMS($first_name,$last_name,$cell,$username,$plain_password)
        {
            $message = "Dear $first_name $last_name, your TM Support System account has been created. Login using the Username $username and Password $plain_password.";
            
            try
            {
                $sql = "INSERT INTO sms_notifications(cell,text_message,local_date,logdate) VALUES(?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $cell);
                $stmt->bindvalue(2, $message);
                $stmt->bindvalue(3, date('Y-m-d'));
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
                echo 'Error'.$e->getMessage();
            }
        }

        function getperson($person)
        {
            try
            {
                // ,"contact" => $rows['contact_type']
                $sql = "SELECT * FROM clients, banks WHERE bank_id = bank_id_fk AND client_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $person);
                if($stmt->execute())
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $json = array("fname" => $rows['client_first_name'],"lname" => $rows['client_last_name'], "email" => $rows['email'], "cell" => $rows['cell'], "bankname" => $rows['bank_name']."($rows[bank_name_abbr])");
                    echo json_encode($json);
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

        function updateClientUser($first_name,$last_name,$cell,$contact_type,$user_id)
        {
            $reason = 'Details changed';
            try
            {
                $sql = "UPDATE clients SET client_first_name =?,client_last_name =?,cell =?,contact_type =?, modified_by =?, date_modified =?, modification_reason =? WHERE client_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $first_name);
                $stmt->bindvalue(2, $last_name);
                $stmt->bindvalue(3, $cell);
                $stmt->bindvalue(4, $contact_type);
                $stmt->bindvalue(5, $_SESSION['person']);
                $stmt->bindvalue(6, date('Y-m-d H:i:s'));
                $stmt->bindvalue(7, $reason);
                $stmt->bindvalue(8, $user_id);
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
                echo 'Error'.$e->getMessage();
            }
        }

        function deleteUser($userID)
        {
            try
            {
                $sql = "DELETE FROM user_login WHERE person_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $userID);
                if($stmt->execute())
                {
                    $sql2 = "DELETE FROM clients WHERE client_id = ?;";
                    $stmt2 = $this->connect()->prepare($sql2);
                    $stmt2->bindvalue(1, $userID);
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
                echo 'Error'.$e->getMessage();
            }
        }
    }

    $clis = new Clients();

    if(isset($_POST['firstName']) && !isset($_POST['idz']) && !isset($_POST['personID']))
    {
        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $email = $_POST['email'];
        $cell = $_POST['cell'];
        $id = $_POST['bankName'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $bank_id = $token;
        $contact_type = $_POST['cont_type'];
        $username = $_POST['email'];
        $status = 'ACTIVE';
        $plain_password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
        $FinalPassword = password_hash($plain_password, PASSWORD_BCRYPT);
        $role = 'Client POS';
        $chng_password = '0';
        $uuid = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);

        $clis->addClientUser($first_name,$last_name,$email,$cell,$bank_id,$contact_type,$username,$status,$plain_password,$FinalPassword,$role,$chng_password,$uuid);
        $clis->primaryCont($bank_id);
    }

    if(isset($_POST['conBank']))
    {
        $id = $_POST['conBank'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $bank_id = $token;
        $clis->getContactType($bank_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['geting']))
    {
        $id = $_POST['geting'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $person = $token;
        $clis->getperson($person);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }
    if(isset($_POST['conBank2']))
    {
        $id = $_POST['conBank2'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $person = $token;
        $clis->getContactType2($person);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['personID']))
    {
        $uuid = $_POST['personID'];
        list($uuid, $enc_iv) = explode("::", $uuid);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($uuid, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $user_id = $token;

        $first_name = $_POST['firstName'];
        $last_name = $_POST['lastName'];
        $cell = $_POST['cell'];
        $contact_type = $_POST['cont_type'];

        $clis->updateClientUser($first_name,$last_name,$cell,$contact_type,$user_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['deleteUser']))
    {
        $userID = $_POST['deleteUser'];
        list($userID, $enc_iv) = explode("::", $userID);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($userID, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $userID = $token;
        $clis -> deleteUser($userID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    class Engineers extends Database
    {
        public $first_name;
        public $last_name;
        public $username;
        public $email;
        public $cell;
        public $user_id;
        public $status;
        public $uuid;
        public $chng_password;
        public $role;
        public $FinalPassword;
        public $plain_password;

        function addEngUser($first_name,$last_name,$email,$cell,$dept,$username,$status,$plain_password,$FinalPassword,$role,$chng_password,$uuid)
        {
            try
            {
                $sqltestu = "SELECT COUNT(user_id) FROM user_login WHERE username = ?;";
                $stmttestu = $this->connect()->prepare($sqltestu);
                $stmttestu->bindvalue(1, $username);
                $stmttestu->execute();
                $num = $stmttestu->fetchColumn();
                if($num > 0)
                {
                    echo "Username Taken";
                }
                else
                {
                    $sql = "INSERT INTO engineers(engineers_first_name,engineers_last_name,email,cell,department,uuid,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $first_name);
                    $stmt->bindvalue(2, $last_name);
                    $stmt->bindvalue(3, $email);
                    $stmt->bindvalue(4, $cell);
                    $stmt->bindvalue(5, $dept);
                    $stmt->bindvalue(6, $uuid);
                    $stmt->bindvalue(7, $_SESSION['person']);
                    $stmt->bindvalue(8, date('Y-m-d H:i:s'));
                    if($stmt->execute())
                    {
                        $sqlg = "SELECT engineer_id FROM engineers WHERE uuid = ?;";
                        $stmtg = $this->connect()->prepare($sqlg);
                        $stmtg->bindvalue(1, $uuid);
                        $stmtg->execute();
                        $row = $stmtg->fetch(PDO::FETCH_ASSOC);
                        $cliID = $row['engineer_id'];
    
                        $sql2 = "INSERT INTO user_login(person_id,username,password,status,role,changed_password,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
                        $stmt = $this->connect()->prepare($sql2);
                        $stmt->bindvalue(1, $cliID);
                        $stmt->bindvalue(2, $username);
                        $stmt->bindvalue(3, $FinalPassword);
                        $stmt->bindvalue(4, $status);
                        $stmt->bindvalue(5, $role);
                        $stmt->bindvalue(6, $chng_password);
                        $stmt->bindvalue(7, $_SESSION['person']);
                        $stmt->bindvalue(8, date('Y-m-d H:i:s'));
                        if($stmt->execute())
                        {
                            self::logEmail($first_name,$last_name,$email,$username,$plain_password,$cell);
                            
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

            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }
        }

        function logEmail($first_name,$last_name,$email,$username,$plain_password,$cell)
        {
            $emailType = "User Creation";
            $sub = 'Account Creation';
            $status = 'PENDING';
            $bank_id="0";
            $message = '
            <html>
                <head>
                    <style>
                        .container {
                            padding: 2px 16px;
                        }
                        .tr,table,td
                        {
                            border:1px solid black;
                            border-collapse: collapse;
                        }
                    </style>
                </head>
                <body>
                    <div class="card">
                        <div class="container" style="font-size: 20px">
                        <br><br>
                            Dear '.$first_name.' '.$last_name.',<br><br>
                            Your TechMasters Support System account has been created successfully.<br>
                            You can log in with the following details:<br>
                            Username <b>'.$username.'</b><br>
                            OTP <b>'.$plain_password.'</b><br>
                            You can sign in <b><a href="https://www.techmasters.co.zm/UAT2">here.</a></b><br><br><br>
            
                            Yours Sincerely<br>
                            TechMasters Support.<br>
                        </div>
                    </div>
                </body>
            </html>
            ';
            
            try
            {
                $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,bankID) VALUES(?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $emailType);
                $stmt->bindvalue(2, $email);
                $stmt->bindvalue(3, $status);
                $stmt->bindvalue(4, $sub);
                $stmt->bindvalue(5, $message);
                $stmt->bindvalue(6, date('Y-m-d'));
                $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                $stmt->bindvalue(8, $bank_id);

                if($stmt->execute())
                {
                    self::logSMS($first_name,$last_name,$cell,$username,$plain_password);
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
            }
        }

        function logSMS($first_name,$last_name,$cell,$username,$plain_password)
        {
            $message = "Dear $first_name $last_name, your TM Support System account has been created. Login using the Username $username and Password $plain_password.";
            
            try
            {
                $sql = "INSERT INTO sms_notifications(cell,text_message,local_date,logdate) VALUES(?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $cell);
                $stmt->bindvalue(2, $message);
                $stmt->bindvalue(3, date('Y-m-d'));
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
                echo 'Error'.$e->getMessage();
            }
        }


        function getperson($person)
        {
            try
            {
                // ,"contact" => $rows['contact_type']
                $sql = "SELECT * FROM engineers WHERE engineer_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $person);
                if($stmt->execute())
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $json = array("fname" => $rows['engineers_first_name'],"lname" => $rows['engineers_last_name'], "email" => $rows['email'], "cell" => $rows['cell']);
                    echo json_encode($json);
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

        function updateEngineer($first_name,$last_name,$cell,$user_id)
        {
            try
            {
                $sql = "UPDATE engineers SET engineers_first_name =?,engineers_last_name =?,cell =?, modified_by =?, date_modified =? WHERE engineer_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $first_name);
                $stmt->bindvalue(2, $last_name);
                $stmt->bindvalue(3, $cell);
                $stmt->bindvalue(4, $_SESSION['person']);
                $stmt->bindvalue(5, date('Y-m-d H:i:s'));
                $stmt->bindvalue(6, $user_id);
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
                echo 'Error'.$e->getMessage();
            }
        }

        function deleteUser($userID)
        {
            try
            {
                $sql = "DELETE FROM user_login WHERE person_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $userID);
                if($stmt->execute())
                {
                    $sql2 = "DELETE FROM engineers WHERE engineer_id = ?;";
                    $stmt2 = $this->connect()->prepare($sql2);
                    $stmt2->bindvalue(1, $userID);
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
                echo 'Error'.$e->getMessage();
            }
        }
    }

    $eng = new Engineers();

    if(isset($_POST['EfirstName']) && !isset($_POST['EpersonID']))
    {
        $first_name = $_POST['EfirstName'];
        $last_name = $_POST['ElastName'];
        $email = $_POST['Eemail'];
        $cell = $_POST['Ecell'];
        $dept = "POS Engineer";
        $username = $_POST['Eemail'];
        $status = 'ACTIVE';
        $plain_password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
        $FinalPassword = password_hash($plain_password, PASSWORD_BCRYPT);
        $role = 'POS Engineer';
        $chng_password = '0';
        $uuid = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);

        $eng->addEngUser($first_name,$last_name,$email,$cell,$dept,$username,$status,$plain_password,$FinalPassword,$role,$chng_password,$uuid);
    }

    if(isset($_POST['getengineer']))
    {
        $id = $_POST['getengineer'];
        list($id, $enc_iv) = explode("::", $id);  
        $cipher_method = 'AES-256-CTR';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $person = $token;
        $eng->getperson($person);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['EpersonID']))
    {
        $uuid = $_POST['EpersonID'];
        list($uuid, $enc_iv) = explode("::", $uuid);  
        $cipher_method = 'AES-256-CTR';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($uuid, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $user_id = $token;

        $first_name = $_POST['EfirstName'];
        $last_name = $_POST['ElastName'];
        $cell = $_POST['Ecell'];

        $eng->updateEngineer($first_name,$last_name,$cell,$user_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['deleteEUser']))
    {
        $userID = $_POST['deleteEUser'];
        list($userID, $enc_iv) = explode("::", $userID);  
        $cipher_method = 'AES-256-CTR';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($userID, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $userID = $token;
        $eng -> deleteUser($userID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }
?>