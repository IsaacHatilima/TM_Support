<?php
    ob_start();
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // include_once('../PHPMailer/src/Exception.php');
    // include_once('../PHPMailer/src/PHPMailer.php');
    // include_once('../PHPMailer/src/SMTP.php');
    include_once('../../PHPMailer/src/Exception.php');
    include_once('../../PHPMailer/src/PHPMailer.php');
    include_once('../../PHPMailer/src/SMTP.php');
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
                $sqltestu = "SELECT COUNT(user_id) FROM client_login WHERE emails = ?;";
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
                  $module = 'ATM';
                    $sql = "INSERT INTO client_users(client_user_first_name,client_user_last_name,email,cell,client_id_fk,contact_type,uuid,created_by,date_created, module) VALUES(?,?,?,?,?,?,?,?,?,?);";
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
                    $stmt->bindvalue(10, $module);
                    if($stmt->execute())
                    {
                        $sqlg = "SELECT client_user_id FROM client_users WHERE uuid = ?;";
                        $stmtg = $this->connect()->prepare($sqlg);
                        $stmtg->bindvalue(1, $uuid);
                        $stmtg->execute();
                        $row = $stmtg->fetch(PDO::FETCH_ASSOC);
                        $cliID = $row['client_user_id'];

                        $sql2 = "INSERT INTO client_login(person_id,emails,password,status,role,changed_password,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
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

                $sqlg = "SELECT COUNT(contact_type) AS kon FROM client_users WHERE contact_type = 'Primary' AND client_id_fk = ?;";
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
                // $count = $rows['available'];
                if($rows = $stmt->fetch())
                {
                    echo "<option value='Secondary'>Secondary</option>";
                }
                else
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
                $sql = "SELECT contact_type FROM client_users WHERE client_user_id=?;";
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
            $mail = new PHPMailer(true);
            $from = "User Creation";
            $message_subject = 'Account Creation';
            $bank_id="0";
            $statuse = 'SUCCESS';
            $count = '3';
            $message = '
            <!doctype html>
            <html>
            <head>
              <meta name="viewport" content="width=device-width">
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
              <title>S.M.S Account Creation Email</title>
              <style>
              @media only screen and (max-width: 620px) {
                table[class=body] h1 {
                  font-size: 28px !important;
                  margin-bottom: 10px !important;
                }
                table[class=body] p,
                      table[class=body] ul,
                      table[class=body] ol,
                      table[class=body] td,
                      table[class=body] span,
                      table[class=body] a {
                  font-size: 16px !important;
                }
                table[class=body] .wrapper,
                      table[class=body] .article {
                  padding: 10px !important;
                }
                table[class=body] .content {
                  padding: 0 !important;
                }
                table[class=body] .container {
                  padding: 0 !important;
                  width: 100% !important;
                }
                table[class=body] .main {
                  border-left-width: 0 !important;
                  border-radius: 0 !important;
                  border-right-width: 0 !important;
                }
                table[class=body] .btn table {
                  width: 100% !important;
                }
                table[class=body] .btn a {
                  width: 100% !important;
                }
                table[class=body] .img-responsive {
                  height: auto !important;
                  max-width: 100% !important;
                  width: auto !important;
                }
              }
              @media all {
                .ExternalClass {
                  width: 100%;
                }
                .ExternalClass,
                      .ExternalClass p,
                      .ExternalClass span,
                      .ExternalClass font,
                      .ExternalClass td,
                      .ExternalClass div {
                  line-height: 100%;
                }
                .apple-link a {
                  color: inherit !important;
                  font-family: inherit !important;
                  font-size: inherit !important;
                  font-weight: inherit !important;
                  line-height: inherit !important;
                  text-decoration: none !important;
                }
                #MessageViewBody a {
                  color: inherit;
                  text-decoration: none;
                  font-size: inherit;
                  font-family: inherit;
                  font-weight: inherit;
                  line-height: inherit;
                }
                .btn-primary table td:hover {
                  background-color: #34495e !important;
                }
                .btn-primary a:hover {
                  background-color: #34495e !important;
                  border-color: #34495e !important;
                }
              }
              </style>
            </head>
            <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
              <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                <tr>
                  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                  <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                    <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                      <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">TechMasters Support System Account Details</span>
                      <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                        <tr>
                          <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                              <tr>
                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi '.$first_name.' '.$last_name.'</p>
                                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">You account for Techmasters Support System has been created and you can login using the following details.</p>
                                  <p>Email: <b>'.$username.'</b></p>
                                  <p>Password: <b>'.$plain_password.'</b></p>
                                  <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                    <tbody>
                                      <tr>
                                        <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                            <tbody>
                                              <tr>
                                                <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="https://www.techmasters.co.zm/TechMasters_Support/" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Click here to login..</a> </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Happy Working! <br>Techmasters Team.</p>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                      </table>

                      <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                          <tr>
                            <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                              <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Techmasters Support System</span>
                            </td>
                          </tr>
                          <tr>
                            <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                              Powered by <a href="https://www.techmasters.co.zm" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">Techmasters</a>.
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </td>
                  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                </tr>
              </table>
            </body>
            </html>
            ';

            $mail->isSMTP();
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'support@techmasters.co.zm';
            $mail->Password   = 'Password123';
            $mail->SMTPSecure = 'TLS';
            $mail->Port       = 587;
            $mail->setFrom('support@techmasters.co.zm', 'Techmasters Support');
            $mail->addAddress($email);
            $mail->WordWrap = 70;
            $mail->isHTML(true);
            $mail->Subject = $message_subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;
            if ($mail->send())
            {
                $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,send_count,bankID) VALUES(?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $from);
                $stmt->bindvalue(2, $email);
                $stmt->bindvalue(3, $statuse);
                $stmt->bindvalue(4, $message_subject);
                $stmt->bindvalue(5, $message);
                $stmt->bindvalue(6, date('Y-m-d'));
                $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                $stmt->bindvalue(8, $count);
                $stmt->bindvalue(9, $bank_id);
                if($stmt->execute())
                {
                    //echo "Success";
                    self::logSMS($first_name,$last_name,$cell,$username,$plain_password);
                }
                else
                {
                    echo "Failed";
                }
            }
            else
            {
                echo "Email Not Sent";
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
                $sql = "SELECT * FROM client_users, clients WHERE client_id = client_id_fk AND client_user_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $person);
                if($stmt->execute())
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

                    $json = array("fname" => $rows['client_user_first_name'],"lname" => $rows['client_user_last_name'], "email" => $rows['email'], "cell" => $rows['cell'], "bankname" => $rows['client_name']." ($rows[client_name_abbr])");
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
                $sql = "UPDATE client_users SET client_user_first_name =?,client_user_last_name =?,cell =?,contact_type =?, modified_by =?, date_modified =?, modification_reason =? WHERE client_user_id = ?;";
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
                $sql = "DELETE FROM client_login WHERE person_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $userID);
                if($stmt->execute())
                {
                    $sql2 = "DELETE FROM client_users WHERE client_user_id = ?;";
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
        $role = 'ATM Client';
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
                $sqltestu = "SELECT COUNT(engineer_user_id) FROM engineer_login WHERE engineer_email = ?;";
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
                    $sql = "INSERT INTO engineers(engineer_first_name,engineer_last_name,email,cell,department,uuid,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
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

                        $sql2 = "INSERT INTO engineer_login(tech_id,engineer_email,engineer_passcode,engineer_status,engineer_role,changed_password,created_by,date_created) VALUES(?,?,?,?,?,?,?,?);";
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
            $mail = new PHPMailer(true);
            $from = "User Creation";
            $message_subject = 'Account Creation';
            $bank_id="0";
            $statuse = 'SUCCESS';
            $count = '3';
            $message = '
            <!doctype html>
            <html>
              <head>
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                <title>S.M.S Account Creation Email</title>
                <style>
                @media only screen and (max-width: 620px) {
                  table[class=body] h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important;
                  }
                  table[class=body] p,
                        table[class=body] ul,
                        table[class=body] ol,
                        table[class=body] td,
                        table[class=body] span,
                        table[class=body] a {
                    font-size: 16px !important;
                  }
                  table[class=body] .wrapper,
                        table[class=body] .article {
                    padding: 10px !important;
                  }
                  table[class=body] .content {
                    padding: 0 !important;
                  }
                  table[class=body] .container {
                    padding: 0 !important;
                    width: 100% !important;
                  }
                  table[class=body] .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important;
                  }
                  table[class=body] .btn table {
                    width: 100% !important;
                  }
                  table[class=body] .btn a {
                    width: 100% !important;
                  }
                  table[class=body] .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important;
                  }
                }
                @media all {
                  .ExternalClass {
                    width: 100%;
                  }
                  .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                    line-height: 100%;
                  }
                  .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important;
                  }
                  #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                  }
                  .btn-primary table td:hover {
                    background-color: #34495e !important;
                  }
                  .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important;
                  }
                }
                </style>
              </head>
              <body class="" style="background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
                  <tr>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                    <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                      <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                        <span class="preheader" style="color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;">TechMasters Support System Account Details</span>
                        <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;">

                          <tr>
                            <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
                              <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                <tr>
                                  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
                                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Hi '.$first_name.' '.$last_name.'</p>
                                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">You account for Techmasters Support System has been created and you can login using the following details.</p>
                                    <p>Email: <b>'.$username.'</b></p>
                                    <p>Password: <b>'.$plain_password.'</b></p>
                                    <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;">
                                      <tbody>
                                        <tr>
                                          <td align="left" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                              <tbody>
                                                <tr>
                                                  <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;"> <a href="https://www.techmasters.co.zm/TechMasters_Support/" target="_blank" style="display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;">Click here to login..</a> </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Happy Working! <br>Techmasters Team.</p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>

                        </table>

                        <div class="footer" style="clear: both; Margin-top: 10px; text-align: center; width: 100%;">
                          <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                            <tr>
                              <td class="content-block" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                <span class="apple-link" style="color: #999999; font-size: 12px; text-align: center;">Techmasters Support System</span>
                              </td>
                            </tr>
                            <tr>
                              <td class="content-block powered-by" style="font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;">
                                Powered by <a href="https://www.techmasters.co.zm" style="color: #999999; font-size: 12px; text-align: center; text-decoration: none;">Techmasters</a>.
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </td>
                    <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
                  </tr>
                </table>
              </body>
            </html>
            ';

            $mail->isSMTP();
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'support@techmasters.co.zm';
            $mail->Password   = 'Password123';
            $mail->SMTPSecure = 'TLS';
            $mail->Port       = 587;
            $mail->setFrom('support@techmasters.co.zm', 'Techmasters Support');
            $mail->addAddress($email);
            // foreach($output as $recipient){
            //     $mail->addCC($recipient['emailaddress']);
            //     //print_r($recipient['emailaddress']);
            // }
            $mail->WordWrap = 70;
            $mail->isHTML(true);
            $mail->Subject = $message_subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;
            if ($mail->send())
            {
                $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,send_count,bankID) VALUES(?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $from);
                $stmt->bindvalue(2, $email);
                $stmt->bindvalue(3, $statuse);
                $stmt->bindvalue(4, $message_subject);
                $stmt->bindvalue(5, $message);
                $stmt->bindvalue(6, date('Y-m-d'));
                $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                $stmt->bindvalue(8, $count);
                $stmt->bindvalue(9, $bank_id);
                if($stmt->execute())
                {
                    // echo "Success";
                    self::logSMS($first_name,$last_name,$cell,$username,$plain_password);
                }
                else
                {
                    echo "Failed";
                }
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

                    $json = array("fname" => $rows['engineer_first_name'],"lname" => $rows['engineer_last_name'], "email" => $rows['email'], "cell" => $rows['cell']);
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
                $sql = "UPDATE engineers SET engineer_first_name =?,engineer_last_name =?,cell =?, modified_by =?, date_modified =? WHERE engineer_id = ?;";
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
                $sql = "DELETE FROM engineer_login WHERE tech_id = ?;";
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
        $dept = "ATM Engineer";
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
