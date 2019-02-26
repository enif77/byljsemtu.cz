<?php

    require_once "scripts/db.php";
    require_once "scripts/url.php";

    URL_CheckHttps();

    session_start();

    $db = DB_Open();

    $results = DB_GetLocks($db);
    if (isset($results))
    {
        while ($row = $results->fetchArray()) 
        {
            unset($_SESSION[$row["Name"]]); 
        }
    }

    DB_Close($db);

    header('Refresh: 2; URL = index.php');

    echo 'All is locked now...';

?>