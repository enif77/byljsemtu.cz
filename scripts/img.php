<?php 

require_once "db.php";

// --- IMG --------------------------------------------------------------------

// http://php.net/manual/en/function.readfile.php
function IMG_DownloadFile($path)
{
    $filename = realpath($path);

    $file_extension = strtolower(substr(strrchr($path, "."), 1));

    switch ($file_extension) 
    {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpe": 
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        default: $ctype="application/force-download";
    }

    if (!file_exists($filename)) 
    {
        die("File not found.");
    }

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: $ctype");
    header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\";");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . @filesize($filename));

    // Not supported by WEDOS.
    //set_time_limit(0);

    //@readfile("$filename") or die("File not found.");
    _IMG_ReadfileChunked($filename);
}

// http://php.net/manual/en/function.readfile.php
function _IMG_ReadfileChunked($filename, $retbytes = true) 
{
    $chunksize = 16 * (1024 * 1024); // How many bytes per chunk.
    $buffer = '';
    $cnt = 0;

    $handle = fopen($filename, 'rb');
    if ($handle === false) 
    {
        return false;
    }

    while (!feof($handle)) 
    {
        $buffer = fread($handle, $chunksize);
        echo $buffer;
        ob_flush();
        flush();
        if ($retbytes) 
        {
            $cnt += strlen($buffer);
        }
    }

    $status = fclose($handle);
    if ($retbytes && $status) 
    {
        return $cnt; // Return num. bytes delivered like readfile() does.
    }

    return $status;
} 

?>