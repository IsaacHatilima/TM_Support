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

        public function change_password($new_password)
        {
            try
            {
                $sql = "UPDATE engineer_login SET engineer_passcode = ? WHERE tech_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $new_password);
                $stmt->bindvalue(2, $_SESSION['person']);
                if($stmt->execute())
                {
                    echo 'Success';
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

    $go = new SignInClass;

    if(isset($_POST['newpassword']))
    {
        $pass1 = $_POST['newpassword'];
        $_SESSION['person'];
        $pass2 = $_POST['conpassword'];
        $new_password = password_hash($pass1, PASSWORD_BCRYPT);
        if($pass1 != $pass2)
        {
            echo "No Match";
        }
        else
        {
            $go -> change_password($new_password);
        }
        
        //$go -> change_password($new_password);
    }
?>