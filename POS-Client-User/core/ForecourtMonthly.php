<?php
    if(isset($_GET['startdate']))
    {
        $start = $_GET['startdate'];
		$end = $_GET['enddate'];

        // PIE CHART 1
        // New Calls
        $state = 'New';
        $mech_type = 'Forecourt';
        $sqle = "SELECT COUNT(ticket_number) AS tota1 FROM pos_device_calls WHERE device_call_status = ?  AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$state);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $devnew = $stmte->fetch(PDO::FETCH_ASSOC);
            $sqle1 = "SELECT COUNT(ticket_number) AS totas1 FROM pos_delivery_calls WHERE delivery_call_status = ? AND clientID = ? AND mech_type = '$mech_type' AND delivery_date_loged BETWEEN  '$start%' AND '$end%';";
            $stmte1 = $object->connect()->prepare($sqle1);
            $stmte1->bindvalue(1,$state);
            $stmte1->bindvalue(2,$client_id);
            $stmte1->execute();
            $delinew = $stmte1->fetch(PDO::FETCH_ASSOC);
            $dum = $devnew['tota1'] + $delinew['totas1'];
            $new_calls = $dum / 360;
        }

        // Pending Calls
        $statepen = 'Open';
        $sqlpen = "SELECT COUNT(ticket_number) AS tota2 FROM pos_device_calls WHERE device_call_status = ?  AND clientID = ? AND mecha_type = '$mech_type'AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmtpen = $object->connect()->prepare($sqlpen);
        $stmtpen->bindvalue(1,$statepen);
        $stmtpen->bindvalue(2,$client_id);
        if($stmtpen->execute())
        {
            $devpen = $stmtpen->fetch(PDO::FETCH_ASSOC);
            $sqlpen1 = "SELECT COUNT(ticket_number) AS totas2 FROM pos_delivery_calls WHERE delivery_call_status = ? AND clientID = ? AND mech_type = '$mech_type' AND delivery_date_loged BETWEEN  '$start%' AND '$end%'";
            $stmtpen1 = $object->connect()->prepare($sqlpen1);
            $stmtpen1->bindvalue(1,$statepen);
            $stmtpen1->bindvalue(2,$client_id);
            $stmtpen1->execute();
            $delipen = $stmtpen1->fetch(PDO::FETCH_ASSOC);
            $dumm = $devpen['tota2'] + $delipen['totas2'];
            $pen_calls = $dumm / 360;
        }

        // Closed Calls
        $stateclo = 'Closed';
        $sqlclo = "SELECT COUNT(ticket_number) AS tota3 FROM pos_device_calls WHERE device_call_status = ?  AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$stateclo);
        $stmtclo->bindvalue(2,$client_id);
        if($stmtclo->execute())
        {
            $devclo = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS totas3 FROM pos_delivery_calls WHERE delivery_call_status = ? AND clientID = ? AND mech_type = '$mech_type' AND delivery_date_loged BETWEEN  '$start%' AND '$end%';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$stateclo);
            $stmtclo1->bindvalue(2,$client_id);
            $stmtclo1->execute();
            $deliclo = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $dummy = $devclo['tota3'] + $deliclo['totas3'];
            $clo_calls = $dummy / 360;
        }

        // PIE CHART 2
        // Hardware
        $cate = '1';
        $sqle = "SELECT COUNT(ticket_number) AS hardware FROM pos_device_calls WHERE  category_id_fk=? AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$cate);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $hard = $stmte->fetch(PDO::FETCH_ASSOC);
            $hards = $hard['hardware'];
            $hardware = $hard['hardware'] / 360;
        }

        //Software
        $cate = '2';
        $sqle = "SELECT COUNT(ticket_number) AS software FROM pos_device_calls WHERE  category_id_fk=? AND clientID = ? AND mecha_type = '$mech_type'  AND date_loged BETWEEN  '$start%' AND '$end%'";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$cate);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $soft = $stmte->fetch(PDO::FETCH_ASSOC);
            $softs = $soft['software'];
            $software = $soft['software'] / 360;
        }

        //Infrastructure
        $cate = '3';
        $sqle = "SELECT COUNT(ticket_number) AS infra FROM pos_device_calls WHERE  category_id_fk=? AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%'";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$cate);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $infra = $stmte->fetch(PDO::FETCH_ASSOC);
            $inf = $infra['infra'];
            $infrastructure = $infra['infra'] / 360;
        }

        // Installation
        $cate = '4';
        $sqle = "SELECT COUNT(ticket_number) AS install FROM pos_device_calls WHERE category_id_fk=? AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$cate);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $install = $stmte->fetch(PDO::FETCH_ASSOC);
            $inst = $install['install'];
            $installs = $install['install'] / 360;
        }

        // Stationary
        $cate = '5';
        $sqle = "SELECT COUNT(ticket_number) AS station FROM pos_delivery_calls WHERE  clientID = ? AND mech_type = '$mech_type' AND delivery_date_loged BETWEEN  '$start%' AND '$end%'";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$client_id);
        if($stmte->execute())
        {
            $station = $stmte->fetch(PDO::FETCH_ASSOC);
            $sta = $station['station'];
            $stations = $station['station'] / 360;
        }

        // Connectivity
        $cate = '6';
        $sqle = "SELECT COUNT(ticket_number) AS connects FROM pos_device_calls WHERE  category_id_fk=? AND clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%';";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$cate);
        $stmte->bindvalue(2,$client_id);
        if($stmte->execute())
        {
            $connect = $stmte->fetch(PDO::FETCH_ASSOC);
            $cone = $connect['connects'];
            $connects = $connect['connects'] / 360;
        }   
        
        // Pie 3 
        //Device Calls vs Deliveries
        // Delivery Calls
        $sqle = "SELECT COUNT(ticket_number) AS delitots FROM pos_delivery_calls WHERE clientID = ? AND mech_type = '$mech_type' AND delivery_date_loged BETWEEN  '$start%' AND '$end%';";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$client_id);
        if($stmte->execute())
        {
            $delivery = $stmte->fetch(PDO::FETCH_ASSOC);
            $delis = $delivery['delitots'] ;
            $deliveries = $delivery['delitots'] / 360;
        }

        // Device Calls
        $sqle = "SELECT COUNT(ticket_number) AS devcalls FROM pos_device_calls WHERE clientID = ? AND mecha_type = '$mech_type' AND date_loged BETWEEN  '$start%' AND '$end%'";
        $stmte = $object->connect()->prepare($sqle);
        $stmte->bindvalue(1,$client_id);
        if($stmte->execute())
        {
            $devco = $stmte->fetch(PDO::FETCH_ASSOC);
            $devs = $devco['devcalls'];
            $devices = $devco['devcalls'] / 360;
        }

        // Provincial Stats
        // Central
        $sqlclo = "SELECT COUNT(ticket_number) AS central FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Central';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $central = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS cent FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Central';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $cent = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $central_tickets = $central['central'] + $cent['cent'];
        }
        // Copperbelt
        $sqlclo = "SELECT COUNT(ticket_number) AS cb FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Copperbelt';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $cb = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS copala FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Copperbelt';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $copala = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $cb_tickets = $cb['cb'] + $copala['copala'];
        }
        // Copperbelt
        $sqlclo = "SELECT COUNT(ticket_number) AS east FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Eastern';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $east = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS eas FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Eastern';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $eas = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $east_tickets = $east['east'] + $eas['eas'];
        }
        // Luapula
        $sqlclo = "SELECT COUNT(ticket_number) AS lua FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Luapula';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $lua = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS luap FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Luapula';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $luap = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $luap_tickets = $lua['lua'] + $luap['luap'];
        }
        // Lusaka
        $sqlclo = "SELECT COUNT(ticket_number) AS lsk FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Lusaka';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $lsk = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS lusa FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Lusaka';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $lusa = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $lsk_tickets = $lsk['lsk'] + $lusa['lusa'];
        }
        // Muchinga
        $sqlclo = "SELECT COUNT(ticket_number) AS much FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Muchinga';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $much = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS muchi FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Muchinga';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $muchi = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $muchi_tickets = $much['much'] + $muchi['muchi'];
        }
        // Northern
        $sqlclo = "SELECT COUNT(ticket_number) AS north FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Northern';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $north = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS northern FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Northern';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $northern = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $north_tickets = $north['north'] + $northern['northern'];
        }
        // North-Westen
        $sqlclo = "SELECT COUNT(ticket_number) AS northwest FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'North-Westen';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $northwest = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS northernwes FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'North-Westen';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $northernwes = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $northwest_tickets = $northwest['northwest'] + $northernwes['northernwes'];
        }
        // Southern
        $sqlclo = "SELECT COUNT(ticket_number) AS south FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Southern';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $south = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS southern FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Southern';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $southern = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $south_tickets = $south['south'] + $southern['southern'];
        }
        // Western
        $sqlclo = "SELECT COUNT(ticket_number) AS west FROM pos_device_calls,mechants WHERE mechant_log_id=devcall_mechant_log_id_fk AND date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mecha_type = 'Forecourt' AND mechant_province = 'Western';";
        $stmtclo = $object->connect()->prepare($sqlclo);
        $stmtclo->bindvalue(1,$client_id);
        if($stmtclo->execute())
        {
            $west = $stmtclo->fetch(PDO::FETCH_ASSOC);
            $sqlclo1 = "SELECT COUNT(ticket_number) AS western FROM pos_delivery_calls,mechants WHERE mechant_log_id=delivery_mechant_log_id_fk AND delivery_date_loged BETWEEN  '$start%' AND '$end%' AND clientID = ? AND mech_type = 'Forecourt' AND mechant_province = 'Western';";
            $stmtclo1 = $object->connect()->prepare($sqlclo1);
            $stmtclo1->bindvalue(1,$client_id);
            $stmtclo1->execute();
            $western = $stmtclo1->fetch(PDO::FETCH_ASSOC);
            $west_tickets = $west['west'] + $western['western'];
        }

        
        unset($token, $cipher_method, $enc_key, $enc_iv);

    }

?>
