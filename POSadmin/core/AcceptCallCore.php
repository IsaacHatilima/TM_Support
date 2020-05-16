<?php
    ob_start();
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include_once('../../PHPMailer/src/Exception.php');
    include_once('../../PHPMailer/src/PHPMailer.php');
    include_once('../../PHPMailer/src/SMTP.php');

    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class EditTickets extends Database
    {
        function getTicketDetails($ticket_id)
        {
            try
            {
                $sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories,engineers  WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND engineer_id = engineer_idz AND ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ticket_id);
                $stmt->execute();
                if($stmt->rowCount() < 1)
                {
                    $sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND ticket_number=?;";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $ticket_id);
                    $stmt->execute();
                    if($stmt->rowCount() < 1)
                    {
                        echo 'Nothing';
                    }
                    elseif($stmt->rowCount() > 0) 
                    {
                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                        $json = array("status" => $rows['device_call_status'],"priority" => $rows['call_priority'],"call_device_serial" => $rows['call_device_serial'],"category_id_fk" => $rows['category_id_fk'],"cate" => $rows['category'],"sub_category_id_fk" => $rows['sub_category_id_fk'],"sub_category" => $rows['sub_category'],"fault_details" => $rows['fault_details'],"managers_name" => $rows['managers_name'],"managers_cell" => $rows['managers_cell'],"names" => $rows['client_user_first_name'].' '.$rows['client_user_last_name'],"mech_name" => $rows['mechant_name'],"mech_id" => $rows['mechant_id'],"solution" => $rows['solution'],"logtime" => $rows['date_loged'],"closetime" => $rows['date_closed'],"repair_time" => $rows['repair_time']);
                        echo json_encode($json);
                    }
                }
                elseif($stmt->rowCount() > 0) 
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                    $json = array("status" => $rows['device_call_status'],"priority" => $rows['call_priority'],"call_device_serial" => $rows['call_device_serial'],"category_id_fk" => $rows['category_id_fk'],"cate" => $rows['category'],"sub_category_id_fk" => $rows['sub_category_id_fk'],"sub_category" => $rows['sub_category'],"fault_details" => $rows['fault_details'],"managers_name" => $rows['managers_name'],"managers_cell" => $rows['managers_cell'],"names" => $rows['client_user_first_name'].' '.$rows['client_user_last_name'],"mech_name" => $rows['mechant_name'],"mech_id" => $rows['mechant_id'],"eng_names" => $rows['engineer_first_name'].' '.$rows['engineer_last_name'],"solution" => $rows['solution'],"logtime" => $rows['date_loged'],"closetime" => $rows['date_closed'],"repair_time" => $rows['repair_time']);
                    echo json_encode($json);
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'; 
            }
        }

        function openCall($engineer,$ticket_num)
        {
            try
            {
                $status = 'Open';
                $sql = "UPDATE pos_device_calls SET device_call_status = ? , engineer_idz = ? WHERE ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$status);
                $stmt->bindvalue(2,$engineer);
                $stmt->bindvalue(3,$ticket_num);
                if($stmt->execute())
                {
                    self::sendOpenEmail($ticket_num);
                }
                else
                {
                    echo 'Failed';
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function sendOpenEmail($ticket_num)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // MDs
                    // $sqlmd = "SELECT emailID as emailaddress FROM email_list WHERE bank_id_fk = ?;";
                    // $stmtmd = $object->connect()->prepare($sqlmd);
                    // $stmtmd->bindvalue(1, $clientID['client_id_fk']);
                    // $stmtmd->execute();
                    // $listmds = array();
                    // $listmds = $rowmd = $stmtmd->fetchAll(PDO::FETCH_ASSOC);

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories, engineers WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND engineer_id=engineer_idz AND ticket_number=?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $ticket_num);
                    $stmtdets->execute();
                    $rowdets = $stmtdets->fetch(PDO::FETCH_ASSOC);

                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $rowdets['logged_by']);
                    $stmtclientID->execute();
                    $rowclientID = $stmtclientID->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    //Emails
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
                    //SIM Serial
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
                        $simSerial = 'MTN('.$rowdets['mtn_sim_serial'].'/ Airtel('.$rowdets['airtel_sim_serial'].')';
                    }

                    $message_subject = 'Ticket '.sprintf("%04d", $ticket_num).' Has Been Opened';

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
                                    The call with the following details has been acknowledged and an engineer has been assigned.
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>'.sprintf("%04d", $ticket_num).'</td>
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
                                        <tr>
                                        <td><b>Assigned Engineer</b></td>
                                        <td>'.$rowdets['engineer_first_name'].' '.$rowdets['engineer_last_name'].'</td>
                                    </tr>
                                    </table>

                                    <br><br>
                                    <br><br>
                                    Team TechMasters
                                    <br>
                                    web: www.techmasters.co.zm
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

        function closeCall($ticket_num,$solution,$resolution_time)
        {
            try
            {
                $status = 'Closed';
                $sql = "UPDATE pos_device_calls SET device_call_status = ?, solution = ?, closed_by=?,date_closed=?,repair_time=? WHERE ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$status);
                $stmt->bindvalue(2,$solution);
                $stmt->bindvalue(3,$_SESSION['person']);
                $stmt->bindvalue(4,date('Y-m-d H:i:s'));
                $stmt->bindvalue(5,$resolution_time);
                $stmt->bindvalue(6,$ticket_num);
                if($stmt->execute())
                {
                    self::sendCloseEmail($ticket_num,$solution);
                }
                else
                {
                    echo 'Failed';
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function sendCloseEmail($ticket_num,$solution)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // MDs
                    // $sqlmd = "SELECT emailID as emailaddress FROM email_list WHERE bank_id_fk = ?;";
                    // $stmtmd = $object->connect()->prepare($sqlmd);
                    // $stmtmd->bindvalue(1, $clientID['client_id_fk']);
                    // $stmtmd->execute();
                    // $listmds = array();
                    // $listmds = $rowmd = $stmtmd->fetchAll(PDO::FETCH_ASSOC);

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories, engineers WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND engineer_id=engineer_idz AND ticket_number=?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $ticket_num);
                    $stmtdets->execute();
                    $rowdets = $stmtdets->fetch(PDO::FETCH_ASSOC);

                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $rowdets['logged_by']);
                    $stmtclientID->execute();
                    $rowclientID = $stmtclientID->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    //Emails
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
                    //SIM Serial
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
                        $simSerial = 'MTN('.$rowdets['mtn_sim_serial'].'/ Airtel('.$rowdets['airtel_sim_serial'].')';
                    }

                    $message_subject = 'Ticket '.sprintf("%04d", $ticket_num).' Has Been Closed';

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
                                    The call with the following details has been resolved and closed.
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>'.sprintf("%04d", $ticket_num).'</td>
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
                                            <td><b>SIM Serial(s)</b></td>
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
                                        <tr>
                                            <td><b>Assigned Engineer</b></td>
                                            <td>'.$rowdets['engineer_first_name'].' '.$rowdets['engineer_last_name'].'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Solution</b></td>
                                            <td>'.$solution.'</td>
                                        </tr>
                                    </table>

                                    <br><br>
                                    <br><br>
                                    Team TechMasters
                                    <br>
                                    web: www.techmasters.co.zm
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
    }

    $deletes = new EditTickets();

    if(isset($_POST['tikid']) && empty($_POST['dev_serial']))
    {
        $ticket_id = $_POST['tikid'];
        $deletes -> getTicketDetails($ticket_id);
    }

    if(!empty($_POST['dev_serial'])&& empty($_POST['solution']))
    {
        $ticket_num = $_POST['ticket_number'];
        $engineer = $_POST['engineer'];
        list($engineer, $enc_iv) = explode("::", $engineer);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($engineer, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $engineer = $token;
        
        $deletes -> openCall($engineer,$ticket_num);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }
    if(!empty($_POST['dev_serial']) && !empty($_POST['solution']))
    {
        $ticket_num = $_POST['ticket_number'];

        $solution = $_POST['solution'];

        function format_interval(DateInterval $interval) {
            $result = "";
            if ($interval->y) { $result .= $interval->format("%y years "); }
            if ($interval->m) { $result .= $interval->format("%m months "); }
            if ($interval->d) { $result .= $interval->format("%d days "); }
            if ($interval->h) { $result .= $interval->format("%h hours "); }
            if ($interval->i) { $result .= $interval->format("%i minutes "); }
            if ($interval->s) { $result .= $interval->format("%s seconds "); }
        
            return $result;
        }
        $logs = $_POST['logtime'];
        $loggedTime = new DateTime(date($logs));
        $first_date = $loggedTime;
        $second_date = new DateTime(date("Y-m-d H:i:s"));
        
        $difference = $first_date->diff($second_date);
        
        $resolution_time = format_interval($difference);
        
        $deletes -> closeCall($ticket_num,$solution,$resolution_time);
    }

?>