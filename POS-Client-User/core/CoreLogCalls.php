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

        function deviceNewCall($call_priority,$mechant_log_id_fk,$call_device_serial,$category_id_fk,$sub_category_id_fk,$fault_details,$managers_name,$managers_cell,$date_loged,$mechtype,$clientID)
        {
            $sql = "SELECT ticket_number FROM ticket_numbers;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            $ticket_number = $rows['ticket_number'];
            $ticket_number = $ticket_number + 1;

            try
            {
                $month = date('F');
                if ($month == 'January' || $month == 'February' || $month == 'March')
                {
                    $qota = '1';
                }
                if ($month == 'April' || $month == 'May' || $month == 'June')
                {
                    $qota = '2';
                }
                if ($month == 'July' || $month == 'August' || $month == 'September')
                {
                    $qota = '3';
                }
                if ($month == 'October' || $month == 'November' || $month == 'December')
                {
                    $qota = '4';
                }
                $status = "New";
                $sql = "INSERT INTO pos_device_calls(ticket_number,call_priority,devcall_mechant_log_id_fk,call_device_serial,category_id_fk,sub_category_id_fk,fault_details,managers_name,managers_cell,logged_by,date_loged,device_call_status,call_month,call_year,mecha_type,device_qota,clientID) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ticket_number);
                $stmt->bindvalue(2, $call_priority);
                $stmt->bindvalue(3, $mechant_log_id_fk);
                $stmt->bindvalue(4, $call_device_serial);
                $stmt->bindvalue(5, $category_id_fk);
                $stmt->bindvalue(6, $sub_category_id_fk);
                $stmt->bindvalue(7, $fault_details);
                $stmt->bindvalue(8, $managers_name);
                $stmt->bindvalue(9, $managers_cell);
                $stmt->bindvalue(10, $_SESSION['person']);
                $stmt->bindvalue(11, $date_loged);
                $stmt->bindvalue(12, $status);
                $stmt->bindvalue(13, date('F'));
                $stmt->bindvalue(14, date('Y'));
                $stmt->bindvalue(15, $mechtype);
                $stmt->bindvalue(16, $qota);
                $stmt->bindvalue(17, $clientID);
                if($stmt->execute())
                {
                    $sql1 = "UPDATE ticket_numbers SET ticket_number = ?;";
                    $stmt1 = $this->connect()->prepare($sql1);
                    $stmt1->bindvalue(1, $ticket_number);
                    if($stmt1->execute())
                    {
                        //echo $ticket_number;
                        self::sendEmail($ticket_number);
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
                // .$e->getMessage()
            }
        }

        function sendEmail($ticket_number)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $_SESSION['person']);
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
                    // $sqltik = "SELECT COUNT(device_call_id) AS tikid FROM pos_device_calls;";
                    // $stmttik = $this->connect()->prepare($sqltik);
                    // $stmttik->execute();
                    // $rowtik = $stmttik->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    $message_subject = 'Ticket '.sprintf("%04d", $ticket_number).' Has Been Created';

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND ticket_number = ?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $ticket_number);
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
                        $simSerial = 'MTN('.$rowdets['mtn_sim_serial'].'/ Airtel('.$rowdets['airtel_sim_serial'].')';
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
                                            <td>'.sprintf("%04d", $ticket_number).'</td>
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

        function deliveryNewCall($delivery_call_priority,$delivery_mechant_log_id_fk,$delivery_category_id_fk,$delivery_sub_category_id_fk,$item_to_deliver,$delivery_managers_name,$delivery_managers_cell,$delivery_date_loged,$delivery_mechtype,$clientID)
        {
            $sql = "SELECT ticket_number FROM ticket_numbers;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            $ticket_number = $rows['ticket_number'];
            $ticket_number = $ticket_number + 1;
            try
            {
                $month = date('F');
                if ($month == 'January' || $month == 'February' || $month == 'March')
                {
                    $qota = '1';
                }
                if ($month == 'April' || $month == 'May' || $month == 'June')
                {
                    $qota = '2';
                }
                if ($month == 'July' || $month == 'August' || $month == 'September')
                {
                    $qota = '3';
                }
                if ($month == 'October' || $month == 'November' || $month == 'December')
                {
                    $qota = '4';
                }
                $delivery_status = "New";
                $sql = "INSERT INTO pos_delivery_calls(ticket_number,delivery_call_priority,delivery_mechant_log_id_fk,delivery_category_id_fk,delivery_sub_category_id_fk,item_to_deliver,delivery_managers_name,delivery_managers_cell,delivery_logged_by,delivery_date_loged,delivery_call_status,delivery_call_month,delivery_call_year,mech_type,delivery_qota,clientID) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ticket_number);
                $stmt->bindvalue(2, $delivery_call_priority);
                $stmt->bindvalue(3, $delivery_mechant_log_id_fk);
                $stmt->bindvalue(4, $delivery_category_id_fk);
                $stmt->bindvalue(5, $delivery_sub_category_id_fk);
                $stmt->bindvalue(6, $item_to_deliver);
                $stmt->bindvalue(7, $delivery_managers_name);
                $stmt->bindvalue(8, $delivery_managers_cell);
                $stmt->bindvalue(9, $_SESSION['person']);
                $stmt->bindvalue(10, $delivery_date_loged);
                $stmt->bindvalue(11, $delivery_status);
                $stmt->bindvalue(12, date('F'));
                $stmt->bindvalue(13, date('Y'));
                $stmt->bindvalue(14, $delivery_mechtype);
                $stmt->bindvalue(15, $qota);
                $stmt->bindvalue(16, $clientID);
                if($stmt->execute())
                {
                    $sql1 = "UPDATE ticket_numbers SET ticket_number = ?;";
                    $stmt1 = $this->connect()->prepare($sql1);
                    $stmt1->bindvalue(1, $ticket_number);
                    if($stmt1->execute())
                    {
                        //echo $ticket_number;
                        self::sendDeliveryEmail($ticket_number);
                    }
                    else
                    {
                        echo "Failed";
                    }
                    //echo "Success";
                    
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

        function sendDeliveryEmail($ticket_number)
        {
            $mail = new PHPMailer(true);
            try
            {
                    // Client ID
                    $sqlclientID = "SELECT client_id_fk,email FROM client_users WHERE client_user_id = ?;";
                    $stmtclientID = $this->connect()->prepare($sqlclientID);
                    $stmtclientID->bindvalue(1, $_SESSION['person']);
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
                    // $sqltik = "SELECT COUNT(delivery_call_id) AS tikid FROM pos_delivery_calls;";
                    // $stmttik = $this->connect()->prepare($sqltik);
                    // $stmttik->execute();
                    // $rowtik = $stmttik->fetch(PDO::FETCH_ASSOC);
                    $email = $rowclientID['email'];
                    $message_subject = 'Ticket '.sprintf("%04d", $ticket_number).' Has Been Created';

                    // Get Ticket Details
                    $sqldets = "SELECT * FROM pos_delivery_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE delivery_logged_by=client_user_id AND x.delivery_mechant_log_id_fk = mechant_log_id AND x.delivery_category_id_fk = category_id AND x.delivery_sub_category_id_fk = sub_category_id AND delivery_call_id = ?;";
                    $stmtdets = $this->connect()->prepare($sqldets);
                    $stmtdets->bindvalue(1, $ticket_number);
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
                                            <td>'.sprintf("%04d", $ticket_number).'</td>
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
        $mechtype = $_POST['mechtype'];

        
        $date_loged = date('Y-m-d H:i:s');

        $sqle1 = "SELECT client_id_fk FROM client_users WHERE client_user_id = ?;";
        $stmte1 = $object->connect()->prepare($sqle1);
        $stmte1->bindvalue(1,$_SESSION['person']);
        $stmte1->execute();
        $row = $stmte1->fetch(PDO::FETCH_ASSOC);
        $clientID = $row['client_id_fk'];

        $tikets -> deviceNewCall($call_priority,$mechant_log_id_fk,$call_device_serial,$category_id_fk,$sub_category_id_fk,$fault_details,$managers_name,$managers_cell,$date_loged,$mechtype,$clientID);
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
        $delivery_mechtype = $_POST['delivery_mechtype'];

        
        $delivery_date_loged = date('Y-m-d H:i:s');

        $sqle1 = "SELECT client_id_fk FROM client_users WHERE client_user_id = ?;";
        $stmte1 = $object->connect()->prepare($sqle1);
        $stmte1->bindvalue(1,$_SESSION['person']);
        $stmte1->execute();
        $row = $stmte1->fetch(PDO::FETCH_ASSOC);
        $clientID = $row['client_id_fk'];

        $tikets -> deliveryNewCall($delivery_call_priority,$delivery_mechant_log_id_fk,$delivery_category_id_fk,$delivery_sub_category_id_fk,$item_to_deliver,$delivery_managers_name,$delivery_managers_cell,$delivery_date_loged,$delivery_mechtype,$clientID);
    }
    

?>