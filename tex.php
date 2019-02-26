<?php 

// Parameters:
//   id: A view ID.
//   f:  A requested cube face name (px, nx, py, ny, pz, nz).
//   r:  A requested texture resolution (ex.: 1024).

require_once "scripts/url.php";
require_once "scripts/img.php";

URL_CheckHttps();

$db = DB_Open();
$imgUrl = DB_GetSkyBoxTextureUrl($db, URL_GetParameter("id", 1), URL_GetParameter("f", "pz"), URL_GetParameter("r", DEFAULT_TEXTURE_RESOLUTION));
DB_Close($db);

IMG_DownloadFile($imgUrl);

?>