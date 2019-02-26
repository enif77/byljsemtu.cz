<?php 
 
// Parameters:
//   id: A gallery ID.
//   name: A gallery Name.

require_once "scripts/db.php";
require_once "scripts/ui.php";
require_once "scripts/url.php";

URL_CheckHttps();

session_start();

$db = DB_Open();

// id or name = which gallery to display.
$galleryId = URL_GetParameter("id", 0);
if ($galleryId > 0)
{
    $gallery = DB_GetGallery($db, $galleryId);
}
else
{
    $galleryName = URL_GetParameter("name", null);
    if (isset($galleryName) == false)
    {
        // Do not freak out from a bad or missing gallery Id or Name.
        header('location: index.php');
    }
    else
    {
        $gallery = DB_GetGalleryByName($db, $galleryName);
    }
}

if (isset($gallery) == false || $gallery["Id"] < 1)
{
    // Do not freak out from a nonexistent gallery.
    header('location: index.php');
}

// Unlock locked gallery.
if (DB_IsGalleryLocked($db, $gallery))
{
    header('location: unlock.php?t=gallery.php%3Fid=' . $gallery["Id"] . '%26p=' . $page . '&l=' . $gallery["LockId"]);
}

include "templates/gallery.php";

?>