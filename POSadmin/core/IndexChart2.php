<?php
// January
    // Retail
    $sqlRjan = "SELECT COUNT(pos_call_id) AS Rjan FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'January';";
    $stmtRjan = $object->connect()->prepare($sqlRjan);
    $stmtRjan->bindvalue(1,date('Y'));
    if($stmtRjan->execute())
    {
        $Rjan = $stmtRjan->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqlFjan = "SELECT COUNT(pos_call_id) AS Fjan FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'January';";
    $stmtFjan = $object->connect()->prepare($sqlFjan);
    $stmtFjan->bindvalue(1,date('Y'));
    if($stmtFjan->execute())
    {
        $Fjan = $stmtFjan->fetch(PDO::FETCH_ASSOC);
    }

// February
    // Retail
    $sqlRfeb = "SELECT COUNT(pos_call_id) AS Rfeb FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'February';";
    $stmtRfeb = $object->connect()->prepare($sqlRfeb);
    $stmtRfeb->bindvalue(1,date('Y'));
    if($stmtRfeb->execute())
    {
        $Rfeb = $stmtRfeb->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqlFfeb = "SELECT COUNT(pos_call_id) AS Ffeb FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'February';";
    $stmtFfeb = $object->connect()->prepare($sqlFfeb);
    $stmtFfeb->bindvalue(1,date('Y'));
    if($stmtFfeb->execute())
    {
        $Ffeb = $stmtFfeb->fetch(PDO::FETCH_ASSOC);
    }

// March
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rmar FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'March';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rmar = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fmar FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'March';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fmar = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// April
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rapr FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'April';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rapr = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fapr FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'April';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fapr = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// May
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rmay FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'May';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rmay = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fmay FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'May';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fmay = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// June
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rjun FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'June';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rjun = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fjun FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'June';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fjun = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// July
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rjul FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'July';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rjul = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fjul FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'July';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fjul = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// August
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Raug FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'August';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Raug = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Faug FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'August';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Faug = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// September
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rsep FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'September';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rsep = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fsep FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'September';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fsep = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// October
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Roct FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'October';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Roct = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Foct FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'October';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Foct = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// Novermber
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rnov FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'Novermber';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rnov = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fnov FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'Novermber';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fnov = $stmte->fetch(PDO::FETCH_ASSOC);
    }

// December
    // Retail
    $sqle = "SELECT COUNT(pos_call_id) AS Rdec FROM pos_calls WHERE mechant_type = 10 AND years = ? AND months = 'December';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Rdec = $stmte->fetch(PDO::FETCH_ASSOC);
    }

    // Forecourt
    $sqle = "SELECT COUNT(pos_call_id) AS Fdec FROM pos_calls WHERE mechant_type = 8 AND years = ? AND months = 'December';";
    $stmte = $object->connect()->prepare($sqle);
    $stmte->bindvalue(1,date('Y'));
    if($stmte->execute())
    {
        $Fdec = $stmte->fetch(PDO::FETCH_ASSOC);
    }


?>