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

        function deleteCall($ticket_num)
        {
            try
            {
                $sql = "DELETE FROM pos_device_calls WHERE ticket_number=?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1,$ticket_num);
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

    $deletes = new EditTickets();

    if(isset($_POST['ticket_number']) && empty($_POST['dev_serial']))
    {
        $ticket_id = $_POST['ticket_number'];
        $deletes -> getTicketDetails($ticket_id);
    }

    if(!empty($_POST['dev_serial']))
    {
        $ticket_num = $_POST['ticket_number'];
        $deletes -> deleteCall($ticket_num);
    }

?>