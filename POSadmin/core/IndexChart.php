<?php
// HARDWARE
// $sql = "SELECT * FROM pos_categories;";
// $stmt = $object->connect()->prepare($sql);
// $stmt->execute();
// while ($rows = $stmt->fetch())
// {
    
// }

    // Retail Hardware
    $cate = '1';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rhardware FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rhard = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Hardware
    $cate = '1';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Fhardware FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fhard = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// SOFTWARE
    //Retail Software
    $cate = '2';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rsoftware FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rsoft = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Software
    $cate = '2';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Fsoftware FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fsoft = $stmte->fetch(PDO::FETCH_ASSOC);
    }

//INFRASTRUCTURE
    //Retail Infrastructure
    $cate = '3';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rinfra FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rinfra = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Infrastructure
    $cate = '3';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Finfra FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Finfra = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// INSTALLATION
    // Retail Installation
    $cate = '4';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rinstall FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rinstall = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Installation
    $cate = '4';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Finstall FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Finstall = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// STATIONARY
    // Retail Stationary
    $cate = '5';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rstation FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rstation = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Stationary
    $cate = '5';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Fstation FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fstation = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// CONNECTIVITY
    // Retail Connectivity
    $cate = '6';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Rconnect FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Retail' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Rconnect = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt Connectivity
    $cate = '6';
    $sqle = "SELECT COUNT(devcall_mechant_log_id_fk) AS Fconnect FROM pos_device_calls,mechants WHERE devcall_mechant_log_id_fk = mechant_log_id AND mechant_type = 'Forecourt' AND category_id_fk=? AND call_month=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fconnect = $stmte->fetch(PDO::FETCH_ASSOC);
    }
?>