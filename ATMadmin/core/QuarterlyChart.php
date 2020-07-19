<?php
// RETAIL
    // Q1
    $year = date('Y');
    $q1 = 1;
    $q3 = 3;
    $q2 = 2;
    $q4 = 4;
    $sqle1s = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Retail' AND device_qota = $q1;";
    $stmte1s = $object->connect()->prepare($sqle1s);
    if($stmte1s->execute())
    {
        $retail = $stmte1s->fetch(PDO::FETCH_ASSOC);
        $sqler = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Retail' AND delivery_qota = $q1;";
        $stmter = $object->connect()->prepare($sqler);
        $stmter->execute();
        $retail2 = $stmter->fetch(PDO::FETCH_ASSOC);
        $qota1 = $retail['total'] + $retail2['total'];
    }
    // Q2
    $sqle2s = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Retail' AND device_qota = $q2;";
    $stmte2s = $object->connect()->prepare($sqle2s);
    if($stmte2s->execute())
    {
        $retail = $stmte2s->fetch(PDO::FETCH_ASSOC);

        $sqler = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Retail' AND delivery_qota = $q2;";
        $stmter = $object->connect()->prepare($sqler);
        $stmter->execute();
        $retail2 = $stmter->fetch(PDO::FETCH_ASSOC);

        $qota2 = $retail['total'] + $retail2['total'];
    }
    // Q3
    $sqle3 = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Retail' AND device_qota = $q3;";
    $stmte3 = $object->connect()->prepare($sqle3);
    if($stmte3->execute())
    {
        $retail = $stmte3->fetch(PDO::FETCH_ASSOC);

        $sqler = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Retail' AND delivery_qota = $q3;";
        $stmter = $object->connect()->prepare($sqler);
        $stmter->execute();
        $retail2 = $stmter->fetch(PDO::FETCH_ASSOC);

        $qota3 = $retail['total'] + $retail2['total'];
    }
    // Q4
    $sqles = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Retail' AND device_qota = $q4;";
    $stmtes = $object->connect()->prepare($sqles);
    if($stmtes->execute())
    {
        $retail = $stmtes->fetch(PDO::FETCH_ASSOC);

        $sqler = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Retail' AND delivery_qota = $q4;";
        $stmter = $object->connect()->prepare($sqler);
        $stmter->execute();
        $retail2 = $stmter->fetch(PDO::FETCH_ASSOC);

        $qota4 = $retail['total'] + $retail2['total'];
    }

    // FORECOURT
    // Q1
    $sqlefore1 = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Forecourt' AND device_qota = $q1;";
    $stmtfore = $object->connect()->prepare($sqlefore1);
    if($stmtfore->execute())
    {
        $forec = $stmtfore->fetch(PDO::FETCH_ASSOC);
        $sqlfore2 = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Forecourt' AND delivery_qota = $q1;";
        $stmtfore2 = $object->connect()->prepare($sqlfore2);
        $stmtfore2->execute();
        $forecourt2 = $stmtfore2->fetch(PDO::FETCH_ASSOC);
        $fqota1 = $forec['total'] + $forecourt2['total'];
    }
    // Q2
    $sqleqfore2 = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Forecourt' AND device_qota = $q2;";
    $stmtfore2f = $object->connect()->prepare($sqleqfore2);
    if($stmtfore2f->execute())
    {
        $forec = $stmtfore2f->fetch(PDO::FETCH_ASSOC);
        $sqlfore2 = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Forecourt' AND delivery_qota = $q2;";
        $stmtfore2 = $object->connect()->prepare($sqlfore2);
        $stmtfore2->execute();
        $forecourt2 = $stmtfore2->fetch(PDO::FETCH_ASSOC);
        $fqota2 = $forec['total'] + $forecourt2['total'];
    }
    // Q3
    $sqleq3 = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Forecourt' AND device_qota = $q3;";
    $stmteq3 = $object->connect()->prepare($sqleq3);
    if($stmteq3->execute())
    {
        $forec = $stmteq3->fetch(PDO::FETCH_ASSOC);
        $sqlfore2 = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Forecourt' AND delivery_qota = $q3;";
        $stmtfore2 = $object->connect()->prepare($sqlfore2);
        $stmtfore2->execute();
        $forecourt2 = $stmtfore2->fetch(PDO::FETCH_ASSOC);
        $fqota3 = $forec['total'] + $forecourt2['total'];
    }
    // Q4
    $sqleq4 = "SELECT COUNT(ticket_number) AS total FROM pos_device_calls WHERE call_year = $year AND mecha_type = 'Forecourt' AND device_qota = $q4;";
    $stmteq4 = $object->connect()->prepare($sqleq4);
    if($stmteq4->execute())
    {
        $forec = $stmteq4->fetch(PDO::FETCH_ASSOC);
        $sqlfore2 = "SELECT COUNT(ticket_number) AS total FROM pos_delivery_calls WHERE delivery_call_year = $year AND mech_type = 'Forecourt' AND delivery_qota = $q3;";
        $stmtfore2 = $object->connect()->prepare($sqlfore2);
        $stmtfore2->execute();
        $forecourt2 = $stmtfore2->fetch(PDO::FETCH_ASSOC);
        $fqota4 = $forec['total'] + $forecourt2['total'];
    }
?>
