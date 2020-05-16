<?php
    // PIE CHART 1
    // New Calls
    $state = 'New';
    $sqle = "SELECT COUNT(ticket_number) AS tota1 FROM pos_device_calls WHERE device_call_status = ? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$state);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $devnew = $stmte->fetch(PDO::FETCH_ASSOC);
        $sqle1 = "SELECT COUNT(ticket_number) AS totas1 FROM pos_delivery_calls WHERE delivery_call_status = ? AND delivery_call_year = ?;";
        $stmte1 = $object->connect()->prepare($sqle1);
        $stmte1->bindvalue(1,$state);
        $stmte1->bindvalue(2,date('Y'));
        $stmte1->execute();
        $delinew = $stmte->fetch(PDO::FETCH_ASSOC);
        $dum = $devnew['tota1'] + $delinew['totas1'];
        $new_calls = $dum / 360;
    }

    // Pending Calls
    $statepen = 'Open';
    $sqlpen = "SELECT COUNT(ticket_number) AS tota2 FROM pos_device_calls WHERE device_call_status = ? AND call_year = ?;";
    $stmtpen = $object->connect()->prepare($sqlpen);
    $stmtpen->bindvalue(1,$statepen);
    $stmtpen->bindvalue(2,date('Y'));
    if($stmtpen->execute())
    {
        $devpen = $stmtpen->fetch(PDO::FETCH_ASSOC);
        $sqlpen1 = "SELECT COUNT(ticket_number) AS totas2 FROM pos_delivery_calls WHERE delivery_call_status = ? AND delivery_call_year = ?;";
        $stmtpen1 = $object->connect()->prepare($sqlpen1);
        $stmtpen1->bindvalue(1,$statepen);
        $stmtpen1->bindvalue(2,date('Y'));
        $stmtpen1->execute();
        $delipen = $stmtpen1->fetch(PDO::FETCH_ASSOC);
        $dumm = $devpen['tota2'] + $delipen['totas2'];
        $pen_calls = $dumm / 360;
    }

    // Closed Calls
    $stateclo = 'Closed';
    $sqlclo = "SELECT COUNT(ticket_number) AS tota3 FROM pos_device_calls WHERE device_call_status = ? AND call_year = ?;";
    $stmtclo = $object->connect()->prepare($sqlclo);
    $stmtclo->bindvalue(1,$stateclo);
    $stmtclo->bindvalue(2,date('Y'));
    if($stmtclo->execute())
    {
        $devclo = $stmtclo->fetch(PDO::FETCH_ASSOC);
        $sqlclo1 = "SELECT COUNT(ticket_number) AS totas3 FROM pos_delivery_calls WHERE delivery_call_status = ? AND delivery_call_year = ?;";
        $stmtclo1 = $object->connect()->prepare($sqlclo1);
        $stmtclo1->bindvalue(1,$stateclo);
        $stmtclo1->bindvalue(2,date('Y'));
        $stmtclo1->execute();
        $deliclo = $stmtclo1->fetch(PDO::FETCH_ASSOC);
        $dummy = $devclo['tota3'] + $deliclo['totas3'];
        $clo_calls = $dummy / 360;
    }

    // PIE CHART 2
    // Hardware
    $cate = '1';
    $sqle = "SELECT COUNT(ticket_number) AS hardware FROM pos_device_calls WHERE  category_id_fk=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $hard = $stmte->fetch(PDO::FETCH_ASSOC);
        $hardware = $hard['hardware'] / 360;
    }


// SOFTWARE
    //Software
    $cate = '2';
    $sqle = "SELECT COUNT(ticket_number) AS software FROM pos_device_calls WHERE  category_id_fk=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $soft = $stmte->fetch(PDO::FETCH_ASSOC);
        $software = $soft['software'] / 360;
    }

//INFRASTRUCTURE
    //Infrastructure
    $cate = '3';
    $sqle = "SELECT COUNT(ticket_number) AS infra FROM pos_device_calls WHERE  category_id_fk=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $infra = $stmte->fetch(PDO::FETCH_ASSOC);
        $infrastructure = $infra['infra'] / 360;
    }

// INSTALLATION
    // Installation
    $cate = '4';
    $sqle = "SELECT COUNT(ticket_number) AS install FROM pos_device_calls WHERE  category_id_fk=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $install = $stmte->fetch(PDO::FETCH_ASSOC);
        $installs = $install['install'] / 360;
    }

// STATIONARY
    // Stationary
    $cate = '5';
    $sqle = "SELECT COUNT(ticket_number) AS station FROM pos_delivery_calls WHERE  delivery_category_id_fk=? AND  delivery_call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $station = $stmte->fetch(PDO::FETCH_ASSOC);
        $stations = $station['station'] / 360;
    }

// CONNECTIVITY
    // Connectivity
    $cate = '6';
    $sqle = "SELECT COUNT(ticket_number) AS connects FROM pos_device_calls WHERE  category_id_fk=? AND call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,$cate);
    $stmte->bindvalue(2,date('Y'));
    if($stmte->execute())
    {
        $connect = $stmte->fetch(PDO::FETCH_ASSOC);
        $connects = $connect['connects'] / 360;
    }

    // Device Calls vs Deliveries
    // Delivery Calls
    $sqle = "SELECT COUNT(ticket_number) AS delitots FROM pos_delivery_calls WHERE delivery_call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $delivery = $stmte->fetch(PDO::FETCH_ASSOC);
        $deliveries = $delivery['delitots'] / 360;
    }

// Device Calls
    $sqle = "SELECT COUNT(ticket_number) AS devcalls FROM pos_device_calls WHERE call_year = ?;";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $devco = $stmte->fetch(PDO::FETCH_ASSOC);
        $devices = $devco['devcalls'] / 360;
    }

?>
