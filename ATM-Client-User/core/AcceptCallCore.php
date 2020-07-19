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
        function getATMName($site)
        {
            try
            {
                $sql = "SELECT * from atm_details WHERE client_id_fk = ? AND atm_site = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$_SESSION['clientID']);
                $stmt->bindvalue(2,$site);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    // echo '<option selected value="">Select ATM Name</option>';
                    while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<option value=".$rows['atm_id'].">".$rows['atm_name']."(".$rows['atm_model']."/".$rows['atm_type'].")</option>";
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }

        function getSubCate($cat_id)
        {
            try
            {
                $sql = "SELECT * from atm_sub_categories WHERE category_id_fk = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$cat_id);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    // echo '<option selected value="">Select Sub-Category</option>';
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

        function getTicketDetails($ticket_id)
        {
            try
            {
                $sql = "SELECT * FROM atm_calls x,atm_details,client_users,atm_categories,atm_sub_categories,engineers,clients WHERE x.client_id_fk = client_id AND logged_by=client_user_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND engineer_id = engineer_on_site AND department = 'ATM Engineer' AND call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ticket_id);
                $stmt->execute();
                if($stmt->rowCount() < 1)
                {
                    $sql = "SELECT * FROM atm_calls x,atm_details,client_users,atm_categories,atm_sub_categories,clients  WHERE x.client_id_fk = client_id AND logged_by=client_user_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND call_id=?;";
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
                        $json = array("status" => $rows['call_status'],"cate" => $rows['category'],"sub_category" => $rows['sub_category'],"fault_details" => $rows['fault_details'],"names" => $rows['client_user_first_name'].' '.$rows['client_user_last_name'],"solution" => $rows['solution'],"logtime" => $rows['time_logged'],"closetime" => $rows['close_time'],"repair_time" => $rows['resolution_time'], "client" => $rows['client_name'].' ('.$rows['client_name_abbr'].')', "atmSite" => $rows['atm_site'].' ('. $rows['province'].')', "atmName" => $rows['atm_name'].' ('. $rows['atm_model'].'/'.$rows['atm_type'].')');
                        echo json_encode($json);
                    }
                }
                elseif($stmt->rowCount() > 0) 
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                    $json = array("status" => $rows['call_status'],"cate" => $rows['category'],"sub_category" => $rows['sub_category'],"fault_details" => $rows['fault_details'],"names" => $rows['client_user_first_name'].' '.$rows['client_user_last_name'],"solution" => $rows['solution'],"logtime" => $rows['time_logged'],"closetime" => $rows['close_time'],"repair_time" => $rows['resolution_time'], "client" => $rows['client_name'].' ('.$rows['client_name_abbr'].')', "atmSite" => $rows['atm_site'].' ('. $rows['province'].')', "atmName" => $rows['atm_name'].' ('. $rows['atm_model'].'/'.$rows['atm_type'].')', "eng_names" =>$rows['engineer_first_name'].' '.$rows['engineer_last_name'],"custodian_sta" => $rows['custodian_status'],"reson_for_delay" => $rows['reson_for_delay']);
                    echo json_encode($json);
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'.$e->getMessage(); 
            }
        }

        function LogATMCall($atm_id, $category,$sub_category,$fault,$custodian_name,$custodian_cell)
        {
            $status = 'New';
            $month = date('F');
            if($month == 'January' || $month == 'February' || $month == 'March')
            {
                $quota = '1';
            }
            elseif($month == 'April' || $month == 'May' || $month == 'June')
            {
                $quota = '2';
            }
            elseif($month == 'July' || $month == 'August' || $month == 'September')
            {
                $quota = '3';
            }
            elseif($month == 'October' || $month == 'November' || $month == 'December')
            {
                $quota = '4';
            }
             
            try
            {
                $sql = "INSERT INTO atm_calls (client_id_fk,atm_id_fk,call_status,logged_by,time_logged,category_id_fk,sub_category_id_fk,fault_details,custodian_name,custodian_contact,log_month,log_year,call_quota) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $_SESSION['clientID']);
                $stmt->bindvalue(2, $atm_id);
                $stmt->bindvalue(3, $status);
                $stmt->bindvalue(4, $_SESSION['person']);
                $stmt->bindvalue(5, date('Y-m-d H:i:s'));
                $stmt->bindvalue(6, $category);
                $stmt->bindvalue(7, $sub_category);
                $stmt->bindvalue(8, $fault);
                $stmt->bindvalue(9, $custodian_name);
                $stmt->bindvalue(10, $custodian_cell);
                $stmt->bindvalue(11, date('F'));
                $stmt->bindvalue(12, date('Y'));
                $stmt->bindvalue(13, $quota);
                if($stmt->execute())
                {
                    // Ticket number
                    $sqlid = "SELECT COUNT(call_id) AS ticket_id FROM atm_calls;";
                    $stmtid = $this->connect()->prepare($sqlid);
                    $stmtid->execute();
                    $rollid = $stmtid->fetch(PDO::FETCH_ASSOC);
                    if($rollid['ticket_id'] == '0')
                    {
                        $ticket_num = $rollid['ticket_id'] + 1;
                    }
                    else
                    {
                        $ticket_num = $rollid['ticket_id'];
                    }
                    
                    // ATM Details
                    $sqlat = "SELECT * FROM atm_details WHERE atm_id = ?;";
                    $stmtat = $this->connect()->prepare($sqlat);
                    $stmtat->bindvalue(1,$atm_id);
                    $stmtat->execute();
                    $rollat = $stmtat->fetch(PDO::FETCH_ASSOC);
                    $atmName = $rollat['atm_name'];
                    $atmType = $rollat['atm_type'];
                    $atmmodel = $rollat['atm_model'];
                    $atmLocation = $rollat['atm_site'];
                    // Category
                    $sqlcat = "SELECT category FROM atm_categories WHERE category_id = ?;";
                    $stmtcat = $this->connect()->prepare($sqlcat);
                    $stmtcat->bindvalue(1,$category);
                    $stmtcat->execute();
                    $rowcat = $stmtcat->fetch(PDO::FETCH_ASSOC);
                    $cats = $rowcat['category'];
                    // Sub-Category
                    $sqlsub = "SELECT sub_category FROM atm_sub_categories WHERE sub_category_id = ?;";
                    $stmtsub = $this->connect()->prepare($sqlsub);
                    $stmtsub->bindvalue(1,$sub_category);
                    $stmtsub->execute();
                    $rollsub = $stmtsub->fetch(PDO::FETCH_ASSOC);
                    $subcat = $rollsub['sub_category'];

                    self::logATMEmail($ticket_num,$atmName,$atmType,$atmmodel,$atmLocation,$cats,$subcat,$fault,$custodian_name,$custodian_cell);
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

        function logATMEmail($ticket_num,$atmName,$atmType,$atmmodel,$atmLocation,$cats,$subcat,$fault,$custodian_name,$custodian_cell)
        {
            $mail = new PHPMailer(true);
            try
            {
                $sql = "SELECT client_id_fk FROM atm_calls WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$ticket_num);
                if($stmt->execute())
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $client_id_fk = $row['client_id_fk'];

                    // Logger Names
                    $sqlloger = "SELECT client_user_first_name, client_user_last_name FROM client_users WHERE client_user_id=?;";
                    $stmtloger = $this->connect()->prepare($sqlloger);
                    $stmtloger->bindvalue(1,$_SESSION['person']);
                    $stmtloger->execute();
                    $thenames = $stmtloger->fetch(PDO::FETCH_ASSOC);
                    $cliName = $thenames['client_user_first_name'].' '.$thenames['client_user_last_name'];
                    // Client Emails
                    $sqle21 = "SELECT email as emailaddress FROM client_users WHERE client_id_fk = ?;";
                    $stmte21 = $this->connect()->prepare($sqle21);
                    $stmte21->bindvalue(1,$client_id_fk);
                    $stmte21->execute();
                    $listclients = array();
                    $listclients  = $stmte21->fetchAll(PDO::FETCH_ASSOC);
                    // Engineers
                    $sqle2 = "SELECT email as emailaddress FROM engineers WHERE department = 'ATM Engineer';";
                    $stmte2 = $this->connect()->prepare($sqle2);
                    $stmte2->execute();
                    $liste = array();
                    $liste  = $stmte2->fetchAll(PDO::FETCH_ASSOC);
                    //$output = array();
                    $output = array_merge($liste,$listclients); //$listmds ,
                    foreach($output as $recipient){
                        $mail->addCC($recipient['emailaddress']);
                        //print_r($recipient['emailaddress']);
                    }

                    $statuse = 'New';
                    $count = '3';
                    $subject = 'Ticket #'.sprintf("%04d", $ticket_num).' Has Been Created.';
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
                                    <br><br><br>
                                    Hello Team,<br><br><br>
                                    Ticket number '.sprintf("%04d", $ticket_num).' has been opened and an engineer has been assigned.. 
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>TMS'.sprintf("%04d", $ticket_num).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Status</b></td>
                                            <td>'.$statuse.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>ATM Details</b></td>
                                            <td>ATM '.$atmName.'('.$atmType.'/'.$atmmodel.') '.$atmLocation.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Category</b></td>
                                            <td>'.$cats.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Sub-Category</b></td>
                                            <td>'.$subcat.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Fault Details</b></td>
                                            <td>'.$fault.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Logged BY</b></td>
                                            <td>'.$cliName.'</td>
                                        </tr>
                                    </table>
                    
                                    <br><br>Yours Sincerely<br>
                                    Techmasters Support Team.<br>
                                    <br><br>
                                    <small>
                                    <i><b>Disclaimer</b></i>: Please do not reply to this email as it is system generated.<br> Also note that contents of this email are strictly confidential.
                                </small>
                                </div>
                            </div>
                        </body>
                    </html>
                    
                    
                    ';
                    $email = 'isaac@techmasters.co.zm';
                    $from = 'ATM Call';

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
                            // print_r($recipient['emailaddress']);
                        }
                    // }
                    $mail->WordWrap = 70;
                    $mail->isHTML(true);   
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    if($mail->send())
                    {
                        $statuse = 'SUCCESS';
                        $count = '3';
                        $from = 'ATM Call';

                        $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,send_count,bankID) VALUES(?,?,?,?,?,?,?,?,?);";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $from);
                        $stmt->bindvalue(2, $email);
                        $stmt->bindvalue(3, $statuse);
                        $stmt->bindvalue(4, $subject);
                        $stmt->bindvalue(5, $message);
                        $stmt->bindvalue(6, date('Y-m-d'));
                        $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                        $stmt->bindvalue(8, $count);
                        $stmt->bindvalue(9, $client_id_fk);
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

            }
            catch(PDOException $e)
            {
                echo "Error".$e->getMessage();
            }
        }

        function openCall($engineer,$ticket_num)
        {
            try
            {
                $status = 'Open';
                $sql = "UPDATE atm_calls SET call_status = ? , engineer_on_site = ?, opened_by = ?, open_date = ? WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$status);
                $stmt->bindvalue(2,$engineer);
                $stmt->bindvalue(3,$_SESSION['person']);
                $stmt->bindvalue(4,date('Y-m-d H:i:s'));
                $stmt->bindvalue(5,$ticket_num);
                if($stmt->execute())
                {
                    // ATM Call Details
                    $sqltik = "SELECT * FROM atm_calls WHERE call_id = ?;";
                    $stmttik = $this->connect()->prepare($sqltik);
                    $stmttik->bindvalue(1,$ticket_num);
                    $stmttik->execute();
                    $rolltik = $stmttik->fetch(PDO::FETCH_ASSOC);
                    $fault = $rolltik['fault_details'];
                    // Engineer Details
                    $sqleng = "SELECT * FROM engineers WHERE engineer_id = ?;";
                    $stmteng = $this->connect()->prepare($sqleng);
                    $stmteng->bindvalue(1,$rolltik['engineer_on_site']);
                    $stmteng->execute();
                    $rolleng = $stmteng->fetch(PDO::FETCH_ASSOC);
                    $engName = $rolleng['engineer_first_name'].' '.$rolleng['engineer_last_name'];
                    // Client Details
                    $sqlcli = "SELECT * FROM client_users WHERE client_user_id = ?;";
                    $stmtcli = $this->connect()->prepare($sqlcli);
                    $stmtcli->bindvalue(1,$rolltik['logged_by']);
                    $stmtcli->execute();
                    $rollcli = $stmtcli->fetch(PDO::FETCH_ASSOC);
                    $cliName = $rollcli['client_user_first_name'].' '.$rollcli['client_user_last_name'];
                    // ATM Details
                    $sqlat = "SELECT * FROM atm_details WHERE atm_id = ?;";
                    $stmtat = $this->connect()->prepare($sqlat);
                    $stmtat->bindvalue(1,$rolltik['atm_id_fk']);
                    $stmtat->execute();
                    $rollat = $stmtat->fetch(PDO::FETCH_ASSOC);
                    $atmName = $rollat['atm_name'];
                    $atmType = $rollat['atm_type'];
                    $atmmodel = $rollat['atm_model'];
                    $atmLocation = $rollat['atm_site'];
                    // Category
                    $sqlcat = "SELECT category FROM atm_categories WHERE category_id = ?;";
                    $stmtcat = $this->connect()->prepare($sqlcat);
                    $stmtcat->bindvalue(1,$rolltik['category_id_fk']);
                    $stmtcat->execute();
                    $rowcat = $stmtcat->fetch(PDO::FETCH_ASSOC);
                    $cats = $rowcat['category'];
                    // Sub-Category
                    $sqlsub = "SELECT sub_category FROM atm_sub_categories WHERE sub_category_id = ?;";
                    $stmtsub = $this->connect()->prepare($sqlsub);
                    $stmtsub->bindvalue(1,$rolltik['sub_category_id_fk']);
                    $stmtsub->execute();
                    $rollsub = $stmtsub->fetch(PDO::FETCH_ASSOC);
                    $subcat = $rollsub['sub_category'];

                    self::SendFirstEmail($ticket_num,$atmName,$atmType,$atmmodel,$atmLocation,$cats,$subcat,$engName,$fault,$cliName,$status);
                    //echo 'Worked';
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

        function SendFirstEmail($ticket_num,$atmName,$atmType,$atmmodel,$atmLocation,$cats,$subcat,$engName,$fault,$cliName,$status)
        {
            $mail = new PHPMailer(true);
            try
            {
                $sql = "SELECT client_id_fk FROM atm_calls WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$ticket_num);
                if($stmt->execute())
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $client_id_fk = $row['client_id_fk'];
                    // Client Emails
                    $sqle = "SELECT email as emailaddress FROM client_users WHERE client_id_fk=?;";
                    $stmte = $this->connect()->prepare($sqle);
                    $stmte->bindvalue(1,$client_id_fk);
                    $stmte->execute();
                    $listclients = array();
                    $listclients = $stmte->fetch(PDO::FETCH_ASSOC);
                    // Engineers
                    $sqle2 = "SELECT email as emailaddress FROM engineers WHERE department = 'ATM Engineer';";
                    $stmte2 = $this->connect()->prepare($sqle2);
                    $stmte2->execute();
                    $liste = array();
                    $liste  = $stmte2->fetchAll(PDO::FETCH_ASSOC);
                    //$output = array();
                    $output = array_merge( $listclients , $liste); //$listmds ,

                    $statuse = 'Open';
                    $count = '3';
                    $subject = 'Ticket #'.sprintf("%04d", $ticket_num).' Has Been Opened.';
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
                                    <br><br><br>
                                    Hello Team,<br><br><br>
                                    Ticket number '.sprintf("%04d", $ticket_num).' has been opened and an engineer has been assigned.. 
                                    <br><br>
                                    <table style="font-size: 20px">
                                        <tr>
                                            <td style="padding-right: 10px"><b>Ticket Number</b></td>
                                            <td>TMS'.sprintf("%04d", $ticket_num).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>ATM Details</b></td>
                                            <td>ATM '.$atmName.'('.$atmType.'/'.$atmmodel.') '.$atmLocation.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Status</b></td>
                                            <td>'.$statuse.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Category</b></td>
                                            <td>'.$cats.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Sub-Category</b></td>
                                            <td>'.$subcat.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Fault Details</b></td>
                                            <td>'.$fault.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Logged BY</b></td>
                                            <td>'.$cliName.'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Assigned Engineer</b></td>
                                            <td>'.$engName.'</td>
                                        </tr>
                                    </table>
                    
                                    <br><br>Yours Sincerely<br>
                                    Techmasters Support Team.<br>
                                    <br><br>
                                    <small>
                                    <i><b>Disclaimer</b></i>: Please do not reply to this email as it is system generated.<br> Also note that contents of this email are strictly confidential.
                                </small>
                                </div>
                            </div>
                        </body>
                    </html>
                    ';
                    $email = 'paul@techmasters.co.zm';
                    $from = 'ATM Call';

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
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    if($mail->send())
                    {
                        $statuse = 'SUCCESS';
                        $count = '3';
                        $from = 'ATM Call';

                        $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,send_count,bankID) VALUES(?,?,?,?,?,?,?,?,?);";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $from);
                        $stmt->bindvalue(2, $email);
                        $stmt->bindvalue(3, $statuse);
                        $stmt->bindvalue(4, $subject);
                        $stmt->bindvalue(5, $message);
                        $stmt->bindvalue(6, date('Y-m-d'));
                        $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                        $stmt->bindvalue(8, $count);
                        $stmt->bindvalue(9, $client_id_fk);
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

            }
            catch(PDOException $e)
            {
                echo "Error".$e->getMessage();
            }
        }


        function closeCall($ticket_num,$solution,$resolution_time)
        {
            try
            {
                $status = 'Closed';
                $sql = "UPDATE atm_calls SET call_status = ?, solution = ?,close_time=?,resolution_time=? WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$status);
                $stmt->bindvalue(2,$solution);
                $stmt->bindvalue(3,date('Y-m-d H:i:s'));
                $stmt->bindvalue(4,$resolution_time);
                $stmt->bindvalue(5,$ticket_num);
                if($stmt->execute())
                {
                    // self::sendCloseEmail($ticket_num,$solution);
                    echo 'Worked';
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

        function sendCloseEmail($ticket_num)
        {
            $mail = new PHPMailer(true);
            try
            {
                $sql = "SELECT client_id_fk FROM atm_calls WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$ticket_num);
                if($stmt->execute())
                {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $client_id_fk = $row['client_id_fk'];
                    // Client Emails
                    $sqle = "SELECT email as emailaddress FROM client_users WHERE client_id_fk=?;";
                    $stmte = $this->connect()->prepare($sqle);
                    $stmte->bindvalue(1,$client_id_fk);
                    $stmte->execute();
                    $listclients = array();
                    $listclients = $stmte->fetch(PDO::FETCH_ASSOC);
                    // Engineers
                    $sqle2 = "SELECT email as emailaddress FROM engineers WHERE department = 'ATM Engineer';";
                    $stmte2 = $this->connect()->prepare($sqle2);
                    $stmte2->execute();
                    $liste = array();
                    $liste  = $stmte2->fetchAll(PDO::FETCH_ASSOC);
                    //$output = array();
                    $output = array_merge( $listclients , $liste); //$listmds ,

                    $statuse = 'Open';
                    $count = '3';
                    $subject = 'Ticket #'.sprintf("%04d", $ticket_num).' Has Been Closed.';
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
                                    <br><br><br>
                                    Hello Team,<br><br><br>
                                    Ticket number '.sprintf("%04d", $ticket_num).' has been closed successfully. 
                                    
                    
                                    <br><br>Yours Sincerely<br>
                                    Techmasters Support Team.<br>
                                    <br><br>
                                    <small>
                                    <i><b>Disclaimer</b></i>: Please do not reply to this email as it is system generated.<br> Also note that contents of this email are strictly confidential.
                                </small>
                                </div>
                            </div>
                        </body>
                    </html>
                    ';
                    $email = 'paul@techmasters.co.zm';
                    $from = 'ATM Call';

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
                    $mail->Subject = $subject;
                    $mail->Body    = $message;
                    $mail->AltBody = $message;
                    if($mail->send())
                    {
                        $statuse = 'SUCCESS';
                        $count = '3';
                        $from = 'ATM Call';

                        $sql = "INSERT INTO email_notifications(email_type,email_addres,email_status,email_subject,email_message,local_date,logdate,send_count,bankID) VALUES(?,?,?,?,?,?,?,?,?);";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $from);
                        $stmt->bindvalue(2, $email);
                        $stmt->bindvalue(3, $statuse);
                        $stmt->bindvalue(4, $subject);
                        $stmt->bindvalue(5, $message);
                        $stmt->bindvalue(6, date('Y-m-d'));
                        $stmt->bindvalue(7, date('Y-m-d H:i:s'));
                        $stmt->bindvalue(8, $count);
                        $stmt->bindvalue(9, $client_id_fk);
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

            }
            catch(PDOException $e)
            {
                echo "Error".$e->getMessage();
            }
        }

        function custodianState($stete,$ticket_num)
        {
            try
            {
                $sql = "UPDATE atm_calls SET custodian_status = ? WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$stete);
                $stmt->bindvalue(2,$ticket_num);
                if($stmt->execute())
                {
                    echo 'Worked';
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

        function Delay($delay,$ticket_num)
        {
            try
            {
                $sql = "UPDATE atm_calls SET reson_for_delay = ? WHERE call_id=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$delay);
                $stmt->bindvalue(2,$ticket_num);
                if($stmt->execute())
                {
                    echo 'Worked';
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
    }

    $deletes = new EditTickets();

    if(isset($_POST['atms_name']))
    {
        $site = $_POST['atms_name'];
        $deletes -> getATMName($site);
    }

    if(isset($_POST['cate_id']))
    {

        $ticket_id = $_POST['cate_id'];
        list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $cat_id = $token;
        $deletes -> getSubCate($cat_id);
    }

    if(isset($_POST['tikid']) && empty($_POST['dev_serial']) && empty($_POST['custo_ste']) && empty($_POST['Delays']))
    {
        $ticket_id = $_POST['tikid'];
        list($ticket_id, $enc_iv) = explode("::", $ticket_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $ticket_id = $token;

        $deletes -> getTicketDetails($ticket_id);
    }

    if(!empty($_POST['engineer'])&& empty($_POST['solution']))
    {
        $ticket_num = $_POST['ticket_number'];
        list($ticket_num, $enc_iv) = explode("::", $ticket_num);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_num, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $ticket_num = $token;

        $engineer = $_POST['engineer'];
        list($engineer, $enc_iv) = explode("::", $engineer);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($engineer, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $engineer = $token;
        
        $deletes -> openCall($engineer,$ticket_num);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }
    if(!empty($_POST['solution']))
    {
        $ticket_num = $_POST['ticket_number'];
        list($ticket_num, $enc_iv) = explode("::", $ticket_num);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($ticket_num, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $ticket_num = $token;

        $solution = $_POST['solution'];

        $logs = $_POST['logtime'];
        $datetime1 = new DateTime($logs);
        $datetime2 = new DateTime(date('Y-m-d H:i:s'));
        $interval = $datetime1->diff($datetime2);
        $resolution_time = $interval->format('%h')." Hours ".$interval->format('%i')." Minutes";
        
        $deletes -> closeCall($ticket_num,$solution,$resolution_time);

        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    if(isset($_POST['custodian_number']))
    {
        $atm_id = $_POST['atm_name'];

        $category = $_POST['category'];
        list($category, $enc_iv) = explode("::", $category);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($category, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $category = $token;

        $category = $category;
        $sub_category = $_POST['sub_category'];
        $fault = $_POST['fault'];
        $custodian_name = $_POST['custodian_name'];
        $custodian_cell = $_POST['custodian_number'];
        $deletes -> LogATMCall($atm_id, $category,$sub_category,$fault,$custodian_name,$custodian_cell);
    }


?>