<?php 

// Parameters:

    require_once "scripts/db.php";
    require_once "scripts/ui.php";
    require_once "scripts/url.php";

    URL_CheckHttps();

    session_start();

    $db = DB_Open();

    include "templates/index.php";
?>