<?php 

// Parameters:
//   id: A view ID.
//   gi: A gallery ID.
   
    require_once "scripts/db.php";
    require_once "scripts/ui.php";
    require_once "scripts/url.php";

    URL_CheckHttps();

    session_start();

    $db = DB_Open();
    
    $galleryId = URL_GetParameter("gi", 1);
    $viewId = URL_GetParameter("id", 1);
    
    // Testuje, jestli view spadá do předané galerie, a pokud ne, tak chyba (někdo nás hackuje).
    if (DB_IsViewFromGallery($db, $viewId, $galleryId) == false)
    {
        header('location: index.php');
    }

    $view = DB_GetViewFromGallery($db, $galleryId, $viewId);

    if (DB_IsViewLocked($db, $view))
    {
        header('location: unlock.php?t=view.php%3Fid=' . $view["Id"] . '%26gi=' . $galleryId . '&l=' . $view["LockId"]);
    }

    $gallery = DB_GetGallery($db, $galleryId);

    if (DB_IsGalleryLocked($db, $gallery))
    {
        header('location: unlock.php?t=view.php%3Fid=' . $view["Id"] . '%26gi=' . $gallery["Id"] . '&l=' . $gallery["LockId"]);
    }    

    $viewType = $view["ViewTypeId"];
    if ($viewType == 2)
    {
        include "templates/panorama.php";
    }
    else if ($viewType == 3)
    {
        /* 
            ratio = hratio / vratio
            width = 100vw
            max-width = ratio * 100 vh
            height = (1 / ratio) * 100 vw
            max-height = 100vh
        */

        $ratio = (double)$view['AspectRatio'] / 10000.0;
        $maxWidth = $ratio * 100.0;
        $height = (1.0 / $ratio) * 100.0;

        include "templates/image.php";
    }
    else
    {
        header('location: index.php');
    }
?>