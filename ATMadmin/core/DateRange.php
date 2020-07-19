<?php
    if(isset($_GET['client']))
    {
        //$year = date('Y');

        $start = $_GET['start_date'];
        $end = $_GET['end_date'];
        
        $client_id = $_GET['client'];
        list($client_id, $enc_iv) = explode("::", $client_id);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($client_id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $client_id = $token;
        // PIE CHART 1
        // New Calls
        if($start == $end )
        {
            $sqle1 = "SELECT COUNT(call_id) AS totas1 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND time_logged LIKE '$start%';";
        }
        else
        {
            $sqle1 = "SELECT COUNT(call_id) AS totas1 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND CAST(time_logged as DATE) BETWEEN '$start%'  AND '$end%' ;";
        }
        $state = 'New';
        $stmte1 = $object->connect()->prepare($sqle1);
        $stmte1->bindvalue(1,$state);
        $stmte1->bindvalue(2,$client_id);
        $stmte1->execute();
        $delinew = $stmte1->fetch(PDO::FETCH_ASSOC);
        $dum = $delinew['totas1'];
        $new_calls = $dum / 360;

        // Pending Calls
        $statepen = 'Open';
        if($start == $end )
        {
            $sqlpen1 = "SELECT COUNT(call_id) AS totas2 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND time_logged LIKE '$start%';";
        }
        else
        {
            $sqlpen1 = "SELECT COUNT(call_id) AS totas2 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND CAST(time_logged as DATE) BETWEEN '$start%'  AND '$end%' ;";
        }
        // $sqlpen1 = "SELECT COUNT(call_id) AS totas2 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND time_logged BETWEEN '$start%'  AND '$end%'";
        $stmtpen1 = $object->connect()->prepare($sqlpen1);
        $stmtpen1->bindvalue(1,$statepen);
        $stmtpen1->bindvalue(2,$client_id);
        $stmtpen1->execute();
        $delipen = $stmtpen1->fetch(PDO::FETCH_ASSOC);
        $dumm = $delipen['totas2'];
        $pen_calls = $dumm / 360;

        // Closed Calls
        if($start == $end )
        {
            $sqlclo1 = "SELECT COUNT(call_id) AS totas3 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND time_logged LIKE '$start%'";
        }
        else
        {
            $sqlclo1 = "SELECT COUNT(call_id) AS totas3 FROM atm_calls WHERE call_status = ? AND client_id_fk=? AND CAST(time_logged as DATE) BETWEEN '$start%'  AND '$end%'";
        }
        $stateclo = 'Closed';
        $stmtclo1 = $object->connect()->prepare($sqlclo1);
        $stmtclo1->bindvalue(1,$stateclo);
        $stmtclo1->bindvalue(2,$client_id);
        $stmtclo1->execute();
        $deliclo = $stmtclo1->fetch(PDO::FETCH_ASSOC);
        $dummy = $deliclo['totas3'];
        $clo_calls = $dummy / 360;

        // PIE CHART 2
        // Hardware
        if($start == $end )
        {
            $sqle = "SELECT COUNT(call_id) AS hardware FROM atm_calls,atm_categories WHERE category_id=category_id_fk AND  category LIKE '%Hardware' AND client_id_fk = ? AND time_logged LIKE '$start%';";
        }
        else
        {
            $sqle = "SELECT COUNT(call_id) AS hardware FROM atm_calls,atm_categories WHERE category_id=category_id_fk AND  category LIKE '%Hardware' AND client_id_fk = ? AND CAST(time_logged as DATE) BETWEEN '$start%'  AND '$end%';";
        }

        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$client_id);
        if($stmte->execute())
        {
            $hard = $stmte->fetch(PDO::FETCH_ASSOC);
            $hards = $hard['hardware'];
            $hardware = $hard['hardware'] / 360;
        }

        //Software
        if($start == $end )
        {
            $sqle = "SELECT COUNT(call_id) AS software FROM atm_calls,atm_categories WHERE category_id=category_id_fk AND  category LIKE '%Software' AND client_id_fk = ? AND time_logged LIKE '$start%';";
        }
        else
        {
            $sqle = "SELECT COUNT(call_id) AS software FROM atm_calls,atm_categories WHERE category_id=category_id_fk AND  category LIKE '%Software' AND client_id_fk = ? AND CAST(time_logged as DATE) BETWEEN '$start%'  AND '$end%';";
        }
        
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$client_id);
        if($stmte->execute())
        {
            $soft = $stmte->fetch(PDO::FETCH_ASSOC);
            $softs = $soft['software'];
            $software = $soft['software']/360;
        } 
    }

?>
