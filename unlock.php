<?php
    
// Parameters:
//   l: A lock ID.
//   t: A target URL.

    require_once "scripts/db.php";
    require_once "scripts/ui.php";
    require_once "scripts/url.php";

    URL_CheckHttps();

    session_start();
    
    // Variable To Store Error Message
    $error = ''; 
    $db = DB_Open();

    if (isset($_POST['submit'])) 
    {
        if ($_POST['lockName'] === '' || $_POST['password'] === '') 
        {
            $error = "A lock name and a password is expected.";
        }
        else
        {
            $lockName = URL_PostParameter('lockName', DEFAULT_LOCK_NAME);
            $password = $_POST['password'];

            $lock = DB_GetLockByName($db, $lockName);
            
            // TODO: Zahešovat heslo a pak porovnávat.

            if ($password == $lock["Password"])
            {
                $_SESSION[$lockName] = "unlocked";

                header("location: " . URL_PostParameter("target", "index.php"));
            } 
            else 
            {
                $error = "The Code or the Password is invalid.";
            }
        }
    }

    include "templates/unlock.php";
?>