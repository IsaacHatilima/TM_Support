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
    if ($page == "ATMDetails.php" )
    {
        $atm = "active";
    }
    if ($page == "ATMCalls.php" )
    {
        $atmcall = "active";
    }

    if ($page == "AnualReports.php")
    {
        $reports = "active";
        $year = "active";
    }
    if ($page == "DateRange.php")
    {
        $reports = "active";
        $range = "active";
    }
    if ($page == "SLATimes.php" )
    {
        $sla = "active";
    }
?>
