<?php 

// Parameters:
//   id: A gallery ID.

require_once "scripts/url.php";
require_once "scripts/img.php";

URL_CheckHttps();

$db = DB_Open();
$imgUrl = DB_GetGalleryBackgroundUrl($db, URL_GetParameter("id", 1));
DB_Close($db);

IMG_DownloadFile($imgUrl);

?>