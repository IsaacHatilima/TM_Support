<?php
$year = date('Y');
// January
    // Retail
    $sqle = "SELECT SUM(rows) as Rjan FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'January' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'January') AS u;";
    $stmtRjan = $object->connect()->prepare($sqle);
    if($stmtRjan->execute())
    {
        $Rjan = $stmtRjan->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT SUM(rows) as Fjan FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'January' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'January') AS u;";
    $stmtFjan = $object->connect()->prepare($sqle);
    if($stmtFjan->execute())
    {
        $Fjan = $stmtFjan->fetch(PDO::FETCH_ASSOC);
    }

// February
    // Retail
    $sqle = "SELECT SUM(rows) as Rfeb FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'February' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'February') AS u;";
    $stmtRfeb = $object->connect()->prepare($sqle);
    if($stmtRfeb->execute())
    {
        $Rfeb = $stmtRfeb->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT SUM(rows) as Ffeb FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'February' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'February') AS u;";
    $stmtFfeb = $object->connect()->prepare($sqle);
    if($stmtFfeb->execute())
    {
        $Ffeb = $stmtFfeb->fetch(PDO::FETCH_ASSOC);
    }

// March
    // Retail
    $sqle = "SELECT SUM(rows) as Rmar FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'March' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'March') AS u;";
    $stmtem = $object->connect()->prepare($sqle);
    if($stmtem->execute())
    {
        $Rmar = $stmtem->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT SUM(rows) as Fmar FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'March' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'March') AS u;";
    $stmtema = $object->connect()->prepare($sqle);
    if($stmtema->execute())
    {
        $Fmar = $stmtema->fetch(PDO::FETCH_ASSOC);
    }

// April
    // Retail
    $sqle = "SELECT SUM(rows) as Rapr FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'April' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'April') AS u;";
    $stmt = $object->connect()->prepare($sqle);
    if($stmt->execute())
    {
        $Rapr = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT SUM(rows) as Fapr FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'April' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'April') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fapr = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// May
    // Retail
    $sqle = " SELECT SUM(rows) as Rmay FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'May' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'May') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rmay = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fmay FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'May' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'May') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fmay = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// June
    // Retail
    $sqle = "SELECT SUM(rows) as Rjun FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'June' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'June') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rjun = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fjun FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'June' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'June') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fjun = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// July
    // Retail
    $sqle = "SELECT SUM(rows) as Rjul FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'July' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'July') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rjul = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fjul FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'July' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'July') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fjul = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// August
    // Retail
    $sqle = "SELECT SUM(rows) as Raug FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'August' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'August') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Raug = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Faug FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'July' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'July') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Faug = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// September
    // Retail
    $sqle = "SELECT SUM(rows) as Rsep FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'September' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'September') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rsep = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fsep FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'September' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'September') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fsep = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// October
    // Retail
    $sqle = "SELECT SUM(rows) as Roct FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'October' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'October') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Roct = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Foct FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'October' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'October') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Foct = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// Novermber
    // Retail
    $sqle = "SELECT SUM(rows) as Rnov FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'Novermber' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'Novermber') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rnov = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fnov FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'Novermber' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'Novermber') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fnov = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// December
    // Retail
    $sqle = "SELECT SUM(rows) as Rdec FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Retail' AND call_year = $year AND call_month = 'December' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Retail' AND delivery_call_year = $year AND delivery_call_month = 'December') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Rdec = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = " SELECT SUM(rows) as Fdec FROM (SELECT COUNT(ticket_number) AS rows FROM pos_device_calls,mechants WHERE mechant_log_id = devcall_mechant_log_id_fk AND mechant_type = 'Forecourt' AND call_year = $year AND call_month = 'December' UNION ALL SELECT COUNT(ticket_number) AS rows FROM pos_delivery_calls,mechants WHERE mechant_log_id = delivery_mechant_log_id_fk AND mechant_log_id = delivery_mechant_log_id_fk AND mechant_type = 'Forecourt' AND delivery_call_year = $year AND delivery_call_month = 'December') AS u;";
    $stmte = $object->connect()->prepare($sqle);
    if($stmte->execute())
    {
        $Fdec = $stmte->fetch(PDO::FETCH_ASSOC);
    }


?>