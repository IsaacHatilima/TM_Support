<?php
    $page = basename($_SERVER['PHP_SELF']);
    if ($page == "index.php")
    {
        $index = "active";
    }
    if ($page == "AddClientUser.php" || $page == "ViewClientUsers.php" || $page == "UpdateClientUser.php" || $page == "AddEngineer.php" || $page == "ViewEngineers.php"  || $page == "UpdateEngineer.php")
    {
        $users = "active";
    }
    if ($page == "AddClientUser.php")
    {
        $addClient = "active";
    }
    if ($page == "ViewClientUsers.php")
    {
        $viewClient = "active";
    }
    if ($page == "UpdateClientUser.php")
    {
        $viewClient = "active";
    }
    if ($page == "AddEngineer.php")
    {
        $addEng = "active";
    }
    if ($page == "ViewEngineers.php")
    {
        $viewEng = "active";
    }
    if ($page == "UpdateEngineer.php")
    {
        $viewEng = "active";
    }
    if ($page == "AddClient.php" || $page == "ViewClient.php" || $page == "UpdateClients.php")
    {
        $cli = "active";
    }
    if ($page == "AddClient.php")
    {
        $addBank = "active";
    }
    if ($page == "ViewClient.php")
    {
        $viewBank = "active";
    }
    if ($page == "UpdateClients.php")
    {
        $viewBank = "active";
    }
    if ($page == "Categories.php" || $page == "SubCategory.php")
    {
        $categos = "active";
    }
    if ($page == "Categories.php")
    {
        $cate = "active";
    }
    if ($page == "SubCategory.php")
    {
        $subcate = "active";
    }
    if ($page == "Mechants.php" || $page == "UpdateMech.php" || $page == "Devices.php" || $page == "UpdateDeviceInfo.php" || $page == "RepairedDevices.php")
    {
        $mechdev = "active";
    }
    if ($page == "Mechants.php")
    {
        $mech = "active";
    }
    if ($page == "UpdateMech.php")
    {
        $mech = "active";
    }
    if ($page == "Devices.php")
    {
        $dev = "active";
    }
    if ($page == "UpdateDeviceInfo.php")
    {
        $dev = "active";
    }
    if ($page == "RepairedDevices.php")
    {
        $repdev = "active";
    }
    if ($page == "CreateTicket.php" || $page == "EditTicket.php" || $page == "DeleteTicket.php" || $page == "POSCalls.php" || $page == "POSTicketDetails.php" || $page == "DeliveryTicketDetails.php")
    {
        $ticks = "active";
    }
    if ($page == "CreateTicket.php")
    {
        $newtick = "active";
    }
    if ($page == "EditTicket.php")
    {
        $edittick = "active";
    }
    if ($page == "DeleteTicket.php")
    {
        $deltick = "active";
    }
    if ($page == "POSCalls.php")
    {
        $ocals = "active";
    }

    if ($page == "MonthlyForecourt.php" || $page == "MonthlyRetail.php")
    {
        $reports = "active";
    }
    if ($page == "MonthlyForecourt.php")
    {
        $monthfor = "active";
    }
    if ($page == "MonthlyRetail.php")
    {
        $monthret = "active";
    }
    if ($page == "EODForecourt.php" || $page == "EODRetail.php")
    {
        $reports3 = "active";
    }
    if ($page == "EODRetail.php")
    {
        $eodret = "active";
    }
    if ($page == "EODForecourt.php")
    {
        $eodfor = "active";
    }
    if ($page == "AnualForecourt.php" || $page == "AnualRetail.php")
    {
        $reports1 = "active";
    }
    if ($page == "AnualRetail.php")
    {
        $yearret = "active";
    }
    if ($page == "AnualForecourt.php")
    {
        $yearfor = "active";
    }
?>
