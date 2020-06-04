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
                $sql = "SELECT * FROM client_login WHERE emails = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $email);
                $stmt->execute();
                if($stmt->rowCount())
                {
                    $row = $stmt->fetch();
                    $DB_Password = $row['password'];
                    $FinalPassword = password_verify($password, $DB_Password);
                    if($FinalPassword === true)
                    {
                        $_SESSION['roles'] = $row['role'];
                        $_SESSION['id'] = $row['user_id'];
                        $_SESSION['person'] = $row['person_id'];
                        $_SESSION['timestamp'] = time(); 
                        $_SESSION['password'] = $row['password'];
                        if($row['status'] == "ACTIVE")
                        {
                            if ($row['changed_password'] != 0)
                            {
                                $dateTime = date('Y-m-d H:i:s');
                                $sql = "UPDATE client_login SET last_login= ? WHERE user_id = ?;";
                                $stmt = $this->connect()->prepare($sql);
                                $stmt->bindvalue(1, $dateTime);
                                $stmt->bindvalue(2, $_SESSION['id']);
                                $stmt->execute();
                                if(!$stmt)
                                {
                                    echo 'Yakana';
                                }
                                else
                                {
                                    if ($row['role'] == "POS Client")
                                    {
                                        echo 'POS-Client-User/pages';
                                    }
                                }
                            }
                            else
                            {
                                echo 'ChangePassword';
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
                $sql = "UPDATE client_login SET password = ?, changed_password = ? WHERE user_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $new_password);
                $stmt->bindvalue(2, $changed);
                $stmt->bindvalue(3, $_SESSION['id']);
                if($stmt->execute())
                {
                    unset($_SESSION['password']);
                    $_SESSION['password'] = null;
                    if ($_SESSION['roles'] == "POS Client")
                    {
                        echo "POS-Client-User/pages";
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
                $sql = "SELECT email,cell, client_user_first_name, client_user_last_name FROM client_users, client_login WHERE client_user_id = person_id AND emails = ?";
                $stmts = $this->connect()->prepare($sql);
                $stmts->bindvalue(1, $email);
                $stmts->execute();
                if($stmts->rowCount())
                {
                    $row = $stmts->fetch();
                    $email_id = $row['email'];
                    $first_name = $row['client_first_name'];
                    $last_name = $row['client_user_last_name'];
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
                        $sql = "UPDATE client_users SET password = ?, changed_password = ? WHERE emails = ?;";
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