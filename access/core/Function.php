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
                $sql = "SELECT * FROM user_login WHERE username = ?;";
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
                                $sql = "UPDATE user_login SET last_login= ? WHERE user_id = ?;";
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
                                    if ($row['role'] == "POS Admin")
                                    {
                                        echo 'POSadmin/pages';
                                        // $location = "admin-console/pages";
                                    }
                                    if ($row['role'] == "Super Admin POS")
                                    {
                                        $location = "pos-admin-console/pages";
                                    }
                                    if ($row['role'] == "Client ATM")
                                    {
                                        // $sql = "SELECT * FROM clients WHERE client_id = ?;";
                                        // $stmt = $this->connect()->prepare($sql);
                                        // $stmt->bindvalue(1, $row['person_id']);
                                        // $stmt->execute();
                                        // $rows = $stmt->fetch();
                                        // $_SESSION['client_id'] = $rows['client_id'];
                                        // $_SESSION['bankID'] = $rows['bank_id_fk'];
    
                                        $location = "client-consoleATM/pages";
                                    }
                                    if ($row['role'] == "Client POS")
                                    {
                                        // $sql = "SELECT * FROM clients WHERE client_id = ?;";
                                        // $stmt = $this->connect()->prepare($sql);
                                        // $stmt->bindvalue(1, $row['person_id']);
                                        // $stmt->execute();
                                        // $rows = $stmt->fetch();
                                        // $_SESSION['client_id'] = $rows['client_id'];
                                        // $_SESSION['bankID'] = $rows['bank_id_fk'];
    
                                        $location = "pos-client-console/pages";
                                    }
                                    if ($row['role'] == "Engineer")
                                    {
    
                                        $location = "engineer-console/pages";
                                    }
                                    // self::redirect($location);
                                }
                            }
                            else
                            {
                                echo 'ChangePassword';
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
                $sql = "UPDATE user_login SET password = ?, changed_password = ? WHERE user_id = ?;";
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
                    // if ($_SESSION['roles'] == "Client ATM")
                    // {
                    //     $location = "client-consoleATM/pages";
                    // }
                    // if ($_SESSION['roles'] == "Client POS")
                    // {
                    //     $location = "client-console/pages";
                    // }
                    // if ($_SESSION['roles'] == "Engineer")
                    // {
                    //     $location = "engineer-console/pages";
                    // }
                    
                }
            }
            catch(PDOException $e)
            {
                echo "Error";
            }
            
        }

        public function update_password($FinalPassword, $username, $password)
        {
            try
            {
                $sql = "SELECT email,cell, client_first_name, client_first_name FROM clients, user_login WHERE client_id = person_id AND username = ?";
                $stmts = $this->connect()->prepare($sql);
                $stmts->bindvalue(1, $username);
                $stmts->execute();
                if($stmts->rowCount())
                {
                    $row = $stmts->fetch();
                    $email_id = $row['email'];
                    $first_name = $row['client_first_name'];
                    $last_name = $row['client_first_name'];
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
                        $sql = "UPDATE user_login SET password = ?, changed_password = ? WHERE username = ?;";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $FinalPassword);
                        $stmt->bindvalue(2, $ischange);
                        $stmt->bindvalue(3, $username);
                        if($stmt->execute())
                        {
                            echo 'Back';
                        }
                    }
                }
                else
                {
                    $sql = "SELECT email,cell, engineers_first_name, engineers_last_name FROM engineers, user_login WHERE engineer_id = person_id AND username = ?";
                    $stmts = $this->connect()->prepare($sql);
                    $stmts->bindvalue(1, $username);
                    $stmt->execute();
                    if($stmt->rowCount())
                    {
                        $row = $stmt->fetch();
                        $email_id = $row['email'];
                        $first_name = $row['engineers_first_name'];
                        $last_name = $row['engineers_last_name'];
                        $date = date('Y-m-d H:i:s');
                        $log_date = date('Y-m-d');
                        $status = "PENDING";
                        $email_message = "Dear $first_name $last_name,<br> You requested for a password reset on $date. Your new tempral password is <b>$password</b>,if you did not intiate a password reset, please change your password.<br><br><br>Yours Sincerely,<br>TechMasters Team.";
    
                        $sql = "INSERT INTO email_notifications (email_address, email, date_logged, status) VALUES (?,?,?,?)";
                        $stmt = $this->connect()->prepare($sql);
                        $stmt->bindvalue(1, $email_id);
                        $stmt->bindvalue(2, $email_message);
                        $stmt->bindvalue(3, $log_date);
                        $stmt->bindvalue(4, $status);
                        if($stmt->execute())
                        {
                            $sql = "UPDATE user_login SET password = ?, changed_password = ? WHERE username = ?;";
                            $stmt = $this->connect()->prepare($sql);
                            $stmt->bindvalue(1, $FinalPassword);
                            $stmt->bindvalue(2, $ischange);
                            $stmt->bindvalue(3, $username);
                            if($stmt->execute())
                            {
                                echo 'Back';
                            }
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
        $username = $_POST['emailz'];
        $password = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 7);
        $FinalPassword = password_hash($password, PASSWORD_BCRYPT);
        $go -> update_password($FinalPassword, $username, $password);
    }
?>