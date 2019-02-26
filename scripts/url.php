<?php 

// --- URL --------------------------------------------------------------------

function URL_CheckHttps()
{
    // TODO: Parametr, který umožní vypnutí vynucení HTTPS.

    $httpsURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // TODO: Toto mi nedovolí POST v unlock.php.
    // if (isset($_POST) && count($_POST) > 0)
    // {
    //     exit('This page should be accessed via HTTPS only, but a POST submission has been sent here. Adjust the form to point to ' . $httpsURL);
    // }
    
    // If the HTTPS is not found to be "on"
    if(!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on")
    {
        if (!headers_sent())
        {
            header('Location: ' . $httpsURL, true, 301);

            exit();
        }
        else 
        {
            exit('<script type="javascript">document.location.href="' . $httpsURL . '";</script>');
        }
    }
    
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
    {
        header('Strict-Transport-Security: max-age=31536000');
    }
}


function URL_GetParameter($name, $defaultValue)
{
    if (isset($_GET) && isset($_GET[$name]))
    {
        return $_GET[$name];
    }

    return $defaultValue;
}


function URL_PostParameter($name, $defaultValue)
{
    if (isset($_POST) && isset($_POST[$name]))
    {
        return $_POST[$name];
    }

    return $defaultValue;
}

?>