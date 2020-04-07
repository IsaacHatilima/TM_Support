<?php
// HARDWARE
    // Retail Hardware
    $cate = '1';
    $sqle = "SELECT COUNT(pos_call_id) AS Rhardware FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Fhardware FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fhard = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// SOFTWARE
    // Retail Software
    $cate = '2';
    $sqle = "SELECT COUNT(pos_call_id) AS Rsoftware FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Fsoftware FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fsoft = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// INFRASTRUCTURE
    // Retail Infrastructure
    $cate = '3';
    $sqle = "SELECT COUNT(pos_call_id) AS Rinfra FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Finfra FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Rinstall FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Finstall FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Rstation FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Fstation FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Rconnect FROM pos_calls WHERE mechant_type = 10 AND category_id_fk=? AND months=? AND years = ?;";
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
    $sqle = "SELECT COUNT(pos_call_id) AS Fconnect FROM pos_calls WHERE mechant_type = 8 AND category_id_fk=? AND months=? AND years = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('F'));
    $stmte->bindvalue(3,date('Y'));
    if($stmte->execute())
    {
        $Fconnect = $stmte->fetch(PDO::FETCH_ASSOC);
    }
?>