<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class EditTickets extends Database
    {
        function getTicketDetails($ticket_id)
        {
            try
            {
                $sql = "SELECT * FROM pos_device_calls x,device_info,client_users,mechants,pos_categories,pos_sub_categories WHERE logged_by=client_user_id AND x.call_device_serial=device_serial AND x.devcall_mechant_log_id_fk = mechant_log_id AND x.category_id_fk = category_id AND x.sub_category_id_fk = sub_category_id AND ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $ticket_id);
                $stmt->execute();
                if($stmt->rowCount() < 1)
                {
                    echo "Nothing";
                }
                elseif($stmt->rowCount() > 0)
                {
                    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                    $json = array("priority" => $rows['call_priority'],"call_device_serial" => $rows['call_device_serial'],"category_id_fk" => $rows['category_id_fk'],"cate" => $rows['category'],"sub_category_id_fk" => $rows['sub_category_id_fk'],"sub_category" => $rows['sub_category'],"fault_details" => $rows['fault_details'],"managers_name" => $rows['managers_name'],"managers_cell" => $rows['managers_cell'],"names" => $rows['client_user_first_name'].' '.$rows['client_user_last_name'],"mech_name" => $rows['mechant_name'],"mech_id" => $rows['mechant_id']);
                    echo json_encode($json);
                }
            }
            catch(PDOException $e)
            {
                echo 'Error'; 
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

        function getSubCates($categ_id)
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

        function updateCall($call_priority,$categ_id,$sub_category_id_fk,$fault_details,$ticket_num)
        {
            try
            {
                $sql = "UPDATE pos_device_calls SET call_priority=?, category_id_fk=?, sub_category_id_fk=?, fault_details=? WHERE ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$call_priority);
                $stmt->bindvalue(2,$categ_id);
                $stmt->bindvalue(3,$sub_category_id_fk);
                $stmt->bindvalue(4,$fault_details);
                $stmt->bindvalue(5,$ticket_num);
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

    $edits = new EditTickets();

    if(isset($_POST['ticket_number']) && empty($_POST['dev_serial']))
    {
        $ticket_id = $_POST['ticket_number'];
        $edits -> getTicketDetails($ticket_id);
    }

    if(isset($_POST['catego']) && empty($_POST['dev_serial']))
    {
        echo $categ_id = $_POST['catego'];
        $edits -> getSubCate($categ_id);
    }

    if(!empty($_POST['dev_serial']))
    {
        $call_priority = $_POST['priority'];
        $ticket_num = $_POST['ticket_number'];

        //echo $categ_id = $_POST['cate']; die();
        $sub_category_id_fk = $_POST['sub_cat'];
        $fault_details = ucwords($_POST['fault']);

        $categ_id = $_POST['cate'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;


        $edits -> updateCall($call_priority,$categ_id,$sub_category_id_fk,$fault_details,$ticket_num);
    }

    if(!empty($_POST['categ']))
    {
        $categ_id = $_POST['categ'];
        list($categ_id, $enc_iv) = explode("::", $categ_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($categ_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categ_id = $token;
        $edits -> getSubCates($categ_id);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

?>