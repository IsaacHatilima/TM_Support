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
    class Calls extends Database
    {

        function getDevSerial($type)
        {
            try
            {
                $sql = "SELECT * FROM mechants,device_info WHERE  mechant_log_id = mechant_log_id_fk AND mechant_type=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$type);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    echo '<optgroup label="Available Mechants">';
                    while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<option value=".$rows['device_id'].">".$rows['device_serial']."</option>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function getSubCate($categ_id)
        {
            try
            {
                $sql = "SELECT * FROM pos_sub_categories WHERE  category_id_fk=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$categ_id);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    echo '<optgroup label="Available Categories">';
                    while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<option value=".$rows['sub_category_id'].">".$rows['sub_category']."</option>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function deviceNewCall($call_priority,$mechant_log_id_fk,$call_device_serial,$category_id_fk,$sub_category_id_fk,$fault_details,$managers_name,$managers_cell,$logged_by,$date_loged)
        {
            try
            {
                $status = "New";
                $sql = "INSERT INTO pos_device_calls(call_priority,devcall_mechant_log_id_fk,call_device_serial,category_id_fk,sub_category_id_fk,fault_details,managers_name,managers_cell,logged_by,date_loged,device_call_status,call_month,call_year) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $call_priority);
                $stmt->bindvalue(2, $mechant_log_id_fk);
                $stmt->bindvalue(3, $call_device_serial);
                $stmt->bindvalue(4, $category_id_fk);
                $stmt->bindvalue(5, $sub_category_id_fk);
                $stmt->bindvalue(6, $fault_details);
                $stmt->bindvalue(7, $managers_name);
                $stmt->bindvalue(8, $managers_cell);
                $stmt->bindvalue(9, $logged_by);
                $stmt->bindvalue(10, $date_loged);
                $stmt->bindvalue(11, $status);
                $stmt->bindvalue(12, date('F'));
                $stmt->bindvalue(13, date('Y'));
                if($stmt->execute())
                {
                     //echo "Success";
                    self::sendEmail($logged_by);
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
                // .$e->getMessage()
            }
        }

        function sendEmail($logged_by)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $logged_by);
                    $stmtclientID->execute();
                    $rowclientID = $stmtclientID->fetch(PDO::FETCH_ASSOC);
                    //echo $rowclientID['client_id_fk']; die();

                    // MDs
                    // $sqlmd = "SELECT emailID as emailaddress FROM email_list WHERE bank_id_fk = ?;";
                    // $stmtmd = $object->connect()->prepare($sqlmd);
                    // $stmtmd->bindvalue(1, $clientID['client_id_fk']);
                    // $stmtmd->execute();
                    // $listmds = array();
                    // $listmds = $rowmd = $stmtmd->fetchAll(PDO::FETCH_ASSOC);
                    // Clients
                    $sqlcl = "SELECT email as emailaddress FROM client_users WHERE client_id_fk = ? AND contact_type != 'Primary';";
                    $stmtcl = $this->connect()->prepare($sqlcl);
                    $stmtcl->bindvalue(1, $rowclientID['client_id_fk']);
                    $stmtcl->execute();
                    $listclients = array();
                    $listclients = $rowcl = $stmtcl->fetchAll(PDO::FETCH_ASSOC);
                    // Engineers
                    $sqle = "SELECT email as emailaddress FROM engineers WHERE department = 'POS Engineer';";
                    $stmte = $this->connect()->prepare($sqle);
                    $stmte->execute();
                    $liste = array();
                    $liste = $rowz = $stmte->fetchAll(PDO::FETCH_ASSOC);
                    //$output = array();
                    $output = array_merge( $listclients , $liste); //$listmds ,
                    //print_r($output);

                    // Ticket Number   
                    // Engineers
                    $sqltik = "SELECT COUNT(device_call_id) AS tikid FROM pos_device_calls;";
                    $stmttik = $this->connect()->prepare($sqltik);
                    $stmttik->execute();
                    $rowtik = $stmttik->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    $message_subject = 'Ticket '.sprintf("%04d", $rowtik['tikid']).' Has Been Created';

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND device_call_id = ?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $rowtik['tikid']);
                    $stmtdets->execute();
                    $rowdets = $stmtdets->fetch(PDO::FETCH_ASSOC);
                    //echo 'MTN '.$rowdets['mtn_sim_serial'].' Airtel '.$rowdets['airtel_sim_serial']; die();
                    if($rowdets['mtn_sim_serial'] == null)
                    {
                        $simSerial = $rowdets['airtel_sim_serial'];
                    }
                    if($rowdets['airtel_sim_serial'] == null)
                    {
                        $simSerial = $rowdets['mtn_sim_serial'];
                    }
                    if($rowdets['airtel_sim_serial'] != null && $rowdets['mtn_sim_serial'] != null)
                    {
                        $simSerial = $rowdets['mtn_sim_serial'];
                    }

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
                                    <br>
                                    Hello Team,<br><br><br>
                                    A call with the following details has been created.
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>'.sprintf("%04d", $rowtik['tikid']).'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Status</b></td>
                                            <td>New</td>
                                        </tr>
                                        <tr>
                                            <td><b>Mechant Name</b></td>
                                            <td>'.$rowdets['mechant_name'].' ('.$rowdets['mechant_type'].')</td>
                                        </tr>
                                        <tr>
                                            <td><b>Location</b></td>
                                            <td>'.$rowdets['mechant_province'].' ('.$rowdets['mechant_town'].')</td>
                                        </tr>
                                        <tr>
                                            <td><b>Device Serial</b></td>
                                            <td>'.$rowdets['device_serial'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>SIM Serial</b></td>
                                            <td>'.$simSerial.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact Name</b></td>
                                            <td>'.$rowdets['managers_name'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact Cell</b></td>
                                            <td>'.$rowdets['managers_cell'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Fault Details</b></td>
                                            <td>'.$rowdets['fault_details'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Logged BY</b></td>
                                            <td>'.$rowdets['client_user_first_name'].' '.$rowdets['client_user_last_name'].'</td>
                                        </tr>
                                    </table>

                                    <br><br>
                                    <br><br>
                                    Team TechMasters
                                    <br>
                                    web: www.techmasters.co.zm
                                    <br><br>
                                    <br><br>
                                    <br><br>
                                    <small>
                                    <i><b>Disclaimer</b></i>: Please do not reply to this email as it is system generated.<br> Furthermore. All contents of this email are strictly for the use of ticket notification, if you think you received this in error please send an email to support@techmasters.co.zm to have that rectified.
                                </small>
                                </div>
                            </div>
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
                    // if($rows['email_type'] == 'ATM Call' || $rows['email_type'] == 'POS Call' )
                    // {
                        // $mail->addAddress($email); 
                        foreach($output as $recipient){
                            $mail->addCC($recipient['emailaddress']);
                            //print_r($recipient['emailaddress']);
                        }
                    // }
                    $mail->WordWrap = 70;
                    $mail->isHTML(true);   
                    $mail->Subject = $message_subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    if($mail->send())
                    {
                        $statuse = 'SUCCESS';
                        $count = '3';
                        $from = 'POS Call';

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
                        $stmt->bindvalue(9, $rowclientID['client_id_fk']);
                        if($stmt->execute())
                        {
                            echo "Success";
                        }
                        else
                        {
                            echo "Failed";
                        }
                    }
            }
            catch(PDOException $e)
            {
                echo "Error";
                // .$e->getMessage()
            }
        }

        // Deliveries
        function getMechants($mechID)
        {
            try
            {
                $sql = "SELECT * FROM mechants WHERE mechant_type=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$mechID);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    echo '<optgroup label="Available Mechants">';
                    while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<option value=".$rows['mechant_log_id'].">".$rows['mechant_name']." (".$rows['mechant_id'].")</option>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function deliveryNewCall($delivery_call_priority,$delivery_mechant_log_id_fk,$delivery_category_id_fk,$delivery_sub_category_id_fk,$item_to_deliver,$delivery_managers_name,$delivery_managers_cell,$delivery_logged_by,$delivery_date_loged)
        {
            try
            {
                $delivery_status = "New";
                $sql = "INSERT INTO pos_delivery_calls(delivery_call_priority,delivery_mechant_log_id_fk,delivery_category_id_fk,delivery_sub_category_id_fk,item_to_deliver,delivery_managers_name,delivery_managers_cell,delivery_logged_by,delivery_date_loged,delivery_call_status,delivery_call_month,delivery_call_year) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $delivery_call_priority);
                $stmt->bindvalue(2, $delivery_mechant_log_id_fk);
                $stmt->bindvalue(3, $delivery_category_id_fk);
                $stmt->bindvalue(4, $delivery_sub_category_id_fk);
                $stmt->bindvalue(5, $item_to_deliver);
                $stmt->bindvalue(6, $delivery_managers_name);
                $stmt->bindvalue(7, $delivery_managers_cell);
                $stmt->bindvalue(8, $delivery_logged_by);
                $stmt->bindvalue(9, $delivery_date_loged);
                $stmt->bindvalue(10, $delivery_status);
                $stmt->bindvalue(11, date('F'));
                $stmt->bindvalue(12, date('Y'));
                if($stmt->execute())
                {
                    //echo "Success";
                    self::sendDeliveryEmail($delivery_logged_by);
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage();
                // .$e->getMessage()
            }
        }

        function sendDeliveryEmail($delivery_logged_by)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $delivery_logged_by);
                    $stmtclientID->execute();
                    $rowclientID = $stmtclientID->fetch(PDO::FETCH_ASSOC);
                    //echo $rowclientID['client_id_fk']; die();

                    // MDs
                    // $sqlmd = "SELECT emailID as emailaddress FROM email_list WHERE bank_id_fk = ?;";
                    // $stmtmd = $object->connect()->prepare($sqlmd);
                    // $stmtmd->bindvalue(1, $clientID['client_id_fk']);
                    // $stmtmd->execute();
                    // $listmds = array();
                    // $listmds = $rowmd = $stmtmd->fetchAll(PDO::FETCH_ASSOC);
                    // Clients
                    $sqlcl = "SELECT email as emailaddress FROM client_users WHERE client_id_fk = ? AND contact_type != 'Primary';";
                    $stmtcl = $this->connect()->prepare($sqlcl);
                    $stmtcl->bindvalue(1, $rowclientID['client_id_fk']);
                    $stmtcl->execute();
                    $listclients = array();
                    $listclients = $rowcl = $stmtcl->fetchAll(PDO::FETCH_ASSOC);
                    // Engineers
                    $sqle = "SELECT email as emailaddress FROM engineers WHERE department = 'POS Engineer';";
                    $stmte = $this->connect()->prepare($sqle);
                    $stmte->execute();
                    $liste = array();
                    $liste = $rowz = $stmte->fetchAll(PDO::FETCH_ASSOC);
                    //$output = array();
                    $output = array_merge( $listclients , $liste); //$listmds ,
                    //print_r($output);

                    // Ticket Number   
                    // Engineers
                    $sqltik = "SELECT COUNT(delivery_call_id) AS tikid FROM pos_delivery_calls;";
                    $stmttik = $this->connect()->prepare($sqltik);
                    $stmttik->execute();
                    $rowtik = $stmttik->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    $message_subject = 'Ticket '.sprintf("%04d", $rowtik['tikid']).' Has Been Created';

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_delivery_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE delivery_logged_by=client_user_id AND x.delivery_mechant_log_id_fk = mechant_log_id AND x.delivery_category_id_fk = category_id AND x.delivery_sub_category_id_fk = sub_category_id AND delivery_call_id = ?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $rowtik['tikid']);
                    $stmtdets->execute();
                    $rowdets = $stmtdets->fetch(PDO::FETCH_ASSOC);

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
                                    <br>
                                    Hello Team,<br><br><br>
                                    A call with the following details has been created.
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>'.sprintf("%04d", $rowtik['tikid']).'</td>
                                        </tr>
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Status</b></td>
                                            <td>New</td>
                                        </tr>
                                        <tr>
                                            <td><b>Mechant Name</b></td>
                                            <td>'.$rowdets['mechant_name'].' ('.$rowdets['mechant_type'].')</td>
                                        </tr>
                                        <tr>
                                            <td><b>Location</b></td>
                                            <td>'.$rowdets['mechant_province'].' ('.$rowdets['mechant_town'].')</td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact Name</b></td>
                                            <td>'.$rowdets['delivery_managers_name'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Contact Cell</b></td>
                                            <td>'.$rowdets['delivery_managers_cell'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Delivery Item</b></td>
                                            <td>'.$rowdets['item_to_deliver'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Logged BY</b></td>
                                            <td>'.$rowdets['client_user_first_name'].' '.$rowdets['client_user_last_name'].'</td>
                                        </tr>
                                    </table>

                                    <br><br>
                                    <br><br>
                                    Team TechMasters
                                    <br>
                                    web: www.techmasters.co.zm
                                    <br><br>
                                    <br><br>
                                    <br><br>
                                    <small>
                                    <i><b>Disclaimer</b></i>: Please do not reply to this email as it is system generated.<br> Furthermore. All contents of this email are strictly for the use of ticket notification, if you think you received this in error please send an email to support@techmasters.co.zm to have that rectified.
                                </small>
                                </div>
                            </div>
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
                    foreach($output as $recipient){
                        $mail->addCC($recipient['emailaddress']);
                        //print_r($recipient['emailaddress']);
                    }
                    $mail->WordWrap = 70;
                    $mail->isHTML(true);   
                    $mail->Subject = $message_subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    if ($mail->send())
                    {
                        $statuse = 'SUCCESS';
                        $count = '3';
                        $from = 'POS Call';

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
                        $stmt->bindvalue(9, $rowclientID['client_id_fk']);
                        if($stmt->execute())
                        {
                            echo "Success";
                        }
                        else
                        {
                            echo "Failed";
                        }
                    }

            }
            catch(PDOException $e)
            {
                echo "Error";
                // .$e->getMessage()
            }
        }


        // 
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

    }

    $tikets = new Calls();

    if(!empty($_POST['metype']))
    {
        $type = $_POST['metype'];
        $tikets -> getDevSerial($type);
    }

    if(!empty($_POST['catego']))
    {
        $categ_id = $_POST['catego'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;
        $tikets -> getSubCate($categ_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(!empty($_POST['dev_serial']))
    {
        $call_priority = $_POST['priority'];
        $device_id = $_POST['dev_serial'];

        // Get mechant ID
        $sqlmech = "SELECT mechant_log_id_fk,device_serial FROM device_info WHERE  device_id=?;";
        $stmtmech = $object->connect()->prepare($sqlmech);
        $stmtmech->bindvalue(1,$device_id);
        $stmtmech->execute();
        $rowsmech = $stmtmech->fetch();
        $mechant_log_id_fk = $rowsmech['mechant_log_id_fk'];
        $call_device_serial = $rowsmech['device_serial'];

        // get category ID
        $categ_id = $_POST['cate'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;
        $category_id_fk = $categ_id;
        unset($token, $cipher_method, $enc_key, $enc_iv);

        
        $sub_category_id_fk = $_POST['sub_cat'];
        $fault_details = ucwords($_POST['fault']);
        $managers_name = ucwords($_POST['manager_name']);
        $managers_cell = $_POST['manager_cell'];

        // get client user
        $user = $_POST['requester'];
        list($user, $enc_iv) = explode("::", $user);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($user, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $user = $token;

        $logged_by = $user;
        $date_loged = date('Y-m-d H:i:s');

        $tikets -> deviceNewCall($call_priority,$mechant_log_id_fk,$call_device_serial,$category_id_fk,$sub_category_id_fk,$fault_details,$managers_name,$managers_cell,$logged_by,$date_loged);
    }

    // Delivery
    if(!empty($_POST['mechID']))
    {
        $mechID = $_POST['mechID'];
        $tikets -> getMechants($mechID);
    }

    if(!empty($_POST['delivery_cate']) && empty($_POST['item']))
    {
        $categ_id = $_POST['delivery_cate'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;
        $tikets -> getSubCate($categ_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(!empty($_POST['mech_id']))
    {
        $delivery_call_priority = $_POST['delivery_priority'];
        $delivery_mechant_log_id_fk = $_POST['mech_id'];

        // get category ID
        $categ_id = $_POST['delivery_cate'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;
        $delivery_category_id_fk = $categ_id;
        unset($token, $cipher_method, $enc_key, $enc_iv);

        
        $delivery_sub_category_id_fk = $_POST['delivery_sub_cat'];
        $item_to_deliver = ucwords($_POST['item']);
        $delivery_managers_name = ucwords($_POST['delivery_manager_name']);
        $delivery_managers_cell = $_POST['delivery_manager_cell'];

        // get client user
        $user = $_POST['delivery_requester'];
        list($user, $enc_iv) = explode("::", $user);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($user, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $user = $token;

        $delivery_logged_by = $user;
        $delivery_date_loged = date('Y-m-d H:i:s');

        $tikets -> deliveryNewCall($delivery_call_priority,$delivery_mechant_log_id_fk,$delivery_category_id_fk,$delivery_sub_category_id_fk,$item_to_deliver,$delivery_managers_name,$delivery_managers_cell,$delivery_logged_by,$delivery_date_loged);
    }
    


    // if(!empty($_POST['mechID2']) && empty($_POST['mechID']))
    // {
    //     $catez = $_POST['devID'];
        // list($catez, $enc_iv) = explode("::", $catez);  
        // $cipher_method = 'aes-128-ctr';
        // $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        // $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        // $devID = $token;

    //     $mechant_id = $_POST['mechID2'];
    //     $device_type = $_POST['devtype2'];
    //     $terminal_id = $_POST['terminaID2'];
    //     $device_serial = $_POST['device_serial2'];
    //     $base_serial = $_POST['base_serial2'];
    //     $mtn_sim_serial = $_POST['mtn_sim_serial2'];
    //     $airtel_sim_serial = $_POST['airtel_sim_serial2'];
    //     $installation_date = $_POST['installation_date2'];
    //     $ip_address = $_POST['ip_address2'];
    //     $asset_code = $_POST['asset_code2'];
    //     $dev -> UpdateDevice($mechant_id,$device_type,$terminal_id,$device_serial,$base_serial,$mtn_sim_serial,$airtel_sim_serial,$installation_date,$ip_address,$asset_code,$devID);
    // }

    // if(isset($_POST['deletedev']))
    // {
    //     $catez = $_POST['deletedev'];
    //     list($catez, $enc_iv) = explode("::", $catez);  
    //     $cipher_method = 'aes-128-ctr';
    //     $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
    //     $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
    //     $deviceID = $token;
    //     $dev -> DeleteDevice($deviceID);
    //     unset($token, $cipher_method, $enc_key, $enc_iv);
    // }



?>