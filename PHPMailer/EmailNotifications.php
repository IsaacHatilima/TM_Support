<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// include_once('../PHPMailer/src/Exception.php');
// include_once('../PHPMailer/src/PHPMailer.php');
// include_once('../PHPMailer/src/SMTP.php');
include_once('src/Exception.php');
include_once('src/PHPMailer.php');
include_once('src/SMTP.php');

$mail = new PHPMailer(true);

class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    public function connect()
    {
        $this->servername = "localhost";
        $this->username = "hatilima_admin";
        $this->password = "TechPassword123$$";
        $this->dbname = "hatilima_uat";
        $this->charset = "utf8mb4";

        try
        {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
            // $dsn = "sqlsrv:SERVER=".$this->servername.";DATABASE=".$this->dbname;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        catch(PDOException $e)
        {
            echo "Connection Failed: ". $e->getMessage();
        }
    }
}
$object = new Database();
$object->connect();


    try
    {
        $limiter = 3;
        $status1 = "SUCCESS";
        $status2 = "LIMIT REACHED";
        $pen = "PENDING";
        $sqlGetNotifications = "SELECT * FROM email_notifications WHERE email_status = ?;";
        $stmts = $object->connect()->prepare($sqlGetNotifications);
        $stmts->bindvalue(1, $pen);
        $stmts->execute();  
        if ($stmts->rowCount())
        {
            while ($rows = $stmts->fetch())
            {
                // MDs
                $sqlmd = "SELECT emailID as emailaddress FROM email_list WHERE bank_id_fk = ?;";
                $stmtmd = $object->connect()->prepare($sqlmd);
                $stmtmd->bindvalue(1, $rows['bankID']);
                $stmtmd->execute();
                $listmds = array();
                $listmds = $rowmd = $stmtmd->fetchAll(PDO::FETCH_ASSOC);
                // Clients
                $sqlcl = "SELECT email as emailaddress FROM clients WHERE bank_id_fk = ? AND contact_type != 'Primary';";
                $stmtcl = $object->connect()->prepare($sqlcl);
                $stmtcl->bindvalue(1, $rows['bankID']);
                $stmtcl->execute();
                $listclients = array();
                $listclients = $rowcl = $stmtcl->fetchAll(PDO::FETCH_ASSOC);
                // Engineers
                $sqle = "SELECT email as emailaddress FROM engineers;";
                $stmte = $object->connect()->prepare($sqle);
                $stmte->execute();
                $liste = array();
                $liste = $rowz = $stmte->fetchAll(PDO::FETCH_ASSOC);
                //$output = array();
                $output = array_merge($listmds , $listclients , $liste);
                //print_r($output);

                $email = $rows['email_addres'];
                $message_subject = $rows['email_subject'];
                $message = $rows['email_message'];
                $id = $rows['notification_id'];

                $mail->isSMTP(); 
                $mail->SMTPDebug = 2;
                $mail->Debugoutput = 'html';                                           
                $mail->Host       = 'smtp.office365.com';  
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'support@techmasters.co.zm';                     
                $mail->Password   = 'Techmasters123$$';                             
                $mail->SMTPSecure = 'TLS'; 
                $mail->Port       = 587;                                    
                $mail->setFrom('support@techmasters.co.zm', 'Techmasters Support');
                $mail->addAddress($email);
                if($rows['email_type'] != 'User Creation')
                {
                    foreach($output as $recipient){
                        $mail->addCC($recipient['emailaddress']);
                        //print_r($recipient['emailaddress']);
                    }
                }
                $mail->WordWrap = 70;
                $mail->isHTML(true);   
                $mail->Subject = $message_subject;
                $mail->Body    = $message;
                $mail->AltBody = $message;
                if($mail->send())
                {
                    $sqlUpdateNotifications = "UPDATE email_notifications SET email_status =? WHERE notification_id = ?;";
                    $stmtz = $object->connect()->prepare($sqlUpdateNotifications);
                    $stmtz->bindvalue(1, $status1);
                    $stmtz->bindvalue(2, $id);
                    if ($stmtz->execute())
                    {
                        echo"========= Email Sent Successfully To $email =========\n";
                    }
                }
                else
                {
                    echo"========= Unable to send Email. =========\n";
                }
            }
        }
        else
        {
            echo"========= No Pending Emails To Be Sent =========\n";
        }
    }
    catch(PDOException $e)
    {
        echo "Error".$e->getMessage();
    }
?>