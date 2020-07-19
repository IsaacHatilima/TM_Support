<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();

    // login
    class SignInClass extends Database
    {
        public $email; 
        public $password;

        public function redirect($location)
        {
            return header("Location: {$location}");
        }

        public function login($email, $password)
        {
            try
            {
                $sql = "SELECT * FROM engineer_login WHERE engineer_email = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $email);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    $row = $stmt->fetch();
                    $DB_Password = $row['engineer_passcode'];
                    $FinalPassword = password_verify($password, $DB_Password);
                    if($FinalPassword === true)
                    {
                        $_SESSION['roles'] = $row['engineer_passcode'];
                        $_SESSION['id'] = $row['engineer_user_id'];
                        $_SESSION['person'] = $row['tech_id'];
                        $_SESSION['timestamp'] = time(); 
                        $_SESSION['password'] = $row['engineer_passcode'];
                        if($row['engineer_status'] == "ACTIVE")
                        {
                            if ($row['changed_password'] != 0)
                            {
                                $dateTime = date('Y-m-d H:i:s');
                                $sql = "UPDATE engineer_login SET engineer_last_login= ? WHERE engineer_user_id = ?;";
                                $stmt = $this->connect()->prepare($sql);
                                $stmt->bindvalue(1, $dateTime);
                                $stmt->bindvalue(2, $_SESSION['id']);
                                $stmt->execute();
                                if(!$stmt)
                                {
                                    echo 'Yakana';
                                    // "Login Failed. Try again or contact System Administrator.";
                                }
                                else
                                {
                                    if ($row['engineer_role'] == "POS Admin")
                                    {
                                        echo 'POSadmin/pages';
                                        // $location = "admin-console/pages";
                                    }
                                    if ($row['engineer_role'] == "ATM Admin")
                                    {
                                        echo 'ATMadmin/pages';
                                        // $location = "admin-console/pages";
                                    }
                                    if ($row['engineer_role'] == "POS Engineer")
                                    {
    
                                        $location = "POSEngineer/pages";
                                    }
                                    // self::redirect($location);
                                }
                            }
                            else
                            {
                                echo 'ChangePasswords';
                                // $location = "../../POSadmin/pages"; POSadmin/pages
                                // self::redirect($location);
                            }
                        }
                        else
                        {
                            echo 'No Access';
                        }
                    }
                    else
                    {
                        echo 'Wala';
                    }
                }
                else
                {
                    echo 'Non Existing';
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
        }
        public function change_password($new_password, $changed)
        {
            try
            {
                $sql = "UPDATE engineer_login SET engineer_passcode = ?, changed_password = ? WHERE engineer_user_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $new_password);
                $stmt->bindvalue(2, $changed);
                $stmt->bindvalue(3, $_SESSION['id']);
                if($stmt->execute())
                {
                    unset($_SESSION['password']);
                    $_SESSION['password'] = null;
                    if ($_SESSION['roles'] == "POS Admin")
                    {
                        echo "POSadmin/pages";
                    }
                    
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
            
        }

        public function update_password($FinalPassword, $email, $password)
        {
            try
            {
                $sql = "SELECT email,cell, engineer_first_name, engineer_last_name FROM engineers, engineer_login WHERE client_user_id = person_id AND engineer_email = ?";
                $stmts = $this->connect()->prepare($sql);
                $stmts->bindvalue(1, $email);
                $stmts->execute();
                if($stmts->rowCount())
                {
                    $row = $stmts->fetch();
                    $email_id = $row['email'];
                    $first_name = $row['engineer_first_name'];
                    $last_name = $row['engineer_last_name'];
                    $date = date('Y-m-d H:i:s');
                    $log_date = date('Y-m-d');
                    $status = "PENDING";
                    $ischange = '0';
                    $emailty = 'Passowrd Reset';
                    $email_subject = 'Password Change';
                    $email_message = "Dear $first_name $last_name,<br> You requested for a password reset on $date. Your new tempral password is <b>$password</b>,if you did not intiate a password reset, please change your password.<br><br><br>Yours Sincerely,<br>TechMasters Team.";

                    $sql = "INSERT INTO email_notifications (email_type,email_addres, email_status,email_subject,email_message, local_date, logdate) VALUES (?,?,?,?,?,?,?)";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $emailty);
                    $stmt->bindvalue(2, $email_id);
                    $stmt->bindvalue(3, $status);
                    $stmt->bindvalue(4, $email_subject);
                    $stmt->bindvalue(5, $email_message);
                    $stmt->bindvalue(6, $log_date);
                    $stmt->bindvalue(7, $date);
                    if($stmt->execute())
                    {
                        $sql = "UPDATE engineer_login SET engineer_passcode = ?, changed_password = ? WHERE engineer_email = ?;";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $FinalPassword);
                        $stmt->bindvalue(2, $ischange);
                        $stmt->bindvalue(3, $email);
                        if($stmt->execute())
                        {
                            echo 'Back';
                        }
                    }
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            } 

        }
    }

    $go = new SignInClass;

    if(isset($_POST['password']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $go->login($email, $password);
    }

    if(isset($_POST['newpassword']))
    {
        $changed = "1";
        $_SESSION['password'];
        $current = $_POST['OGpassword'];
        $password_checker = password_verify($current, $_SESSION['password']);
        $pass1 = $_POST['newpassword'];
        $pass2 = $_POST['conpassword'];
        $new_password = password_hash($pass1, PASSWORD_BCRYPT);
        if($password_checker === false)
        {
            echo 'Invalid';
        }
        else
        {
            if($pass1 != $pass2)
            {
                echo "No Match";
            }
            else
            {
                //echo $new_password;
                $go -> change_password($new_password, $changed);
            }
        }
    }

    if(isset($_POST['emailz']))
    {
        $email = $_POST['emailz'];
        $password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
        $FinalPassword = password_hash($password, PASSWORD_BCRYPT);
        $go -> update_password($FinalPassword, $email, $password);
    }
?>