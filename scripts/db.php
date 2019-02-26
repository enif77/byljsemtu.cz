<?php 

require_once "constants.php";

// --- DB ---------------------------------------------------------------------

function DB_Open()
{
    return new SQLite3(SITE_DATABASE_PATH);
}


function DB_Close($db)
{
    $db->close();
}


function DB_GetLocks($db)
{
    $statement = $db->prepare('SELECT * FROM Locks;');

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        $result->finalize();

        return null;
    }

    return $result;
}


function DB_GetGalleries($db)
{
    $statement = $db->prepare('SELECT * FROM Galleries;');

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        $result->finalize();

        return null;
    }

    return $result;
}


function DB_GetGalleriesForIndex($db)
{
    $statement = $db->prepare('SELECT [Id], [LockId], [Description] FROM Galleries WHERE [Id] > 0 AND [IsHidden] = 0 ORDER BY [Order] ASC;');

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        $result->finalize();

        return null;
    }

    return $result;
}


function DB_GetViews($db)
{
    $statement = $db->prepare('SELECT * FROM Views WHERE [Id] > 0 AND [IsHidden] = 0;');

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        $result->finalize();

        return null;
    }

    return $result;
}


function DB_GetGalleryViews($db, $galleryId)
{
    $statement = $db->prepare('SELECT V.[Id], V.[ViewTypeId], V.[LockId], V.[Description], GxV.[Order] FROM GalleriesXViews AS GxV INNER JOIN Views AS V ON V.[Id] = GxV.[ViewId] WHERE GxV.[GalleryId] = :GalleryId AND V.[IsHidden] = 0 ORDER BY GxV.[Order] ASC;');
    $statement->bindValue(':GalleryId', $galleryId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        $result->finalize();

        return null;
    }

    return $result;
}


function DB_IsViewFromGallery($db, $viewId, $galleryId)
{
    // All views belongs to the default gallery.
    // The default view belongs to all galleries.
    if ($galleryId == 0 || $viewId == 0) return true;

    $statement = $db->prepare('SELECT GalleryId FROM GalleriesXViews AS GxV WHERE GxV.GalleryId = :GalleryId AND GxV.ViewId = :ViewId;');
    $statement->bindValue(':GalleryId', $galleryId);
    $statement->bindValue(':ViewId', $viewId);

    $result = $statement->execute();
    $haveData = $result->numColumns() && ($result->fetchArray())[0] != null;
    $result->finalize();
    
    return $haveData;
}


function DB_GetLock($db, $lockId)
{
    $statement = $db->prepare('SELECT * FROM Locks WHERE Id = :Id;');
    $statement->bindValue(':Id', $lockId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultLock();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetDefaultLock()
{
    return array(
            "Id" => 1, 
            "Name" => DEFAULT_LOCK_NAME, 
            "Description" => "Unlocked item.",
            "Password" => "");
}


function DB_GetLockByName($db, $lockName)
{
    $statement = $db->prepare('SELECT * FROM Locks WHERE Name = :LockName;');
    $statement->bindValue(':LockName', $lockName);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultLock();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetDefaultGallery()
{
    return array(
            "Id" => 0, 
            "Name" => DEFAULT_GALLERY_NAME, 
            "Path" => "", 
            "Title" => "Byl jsem tu!",
            "Description" => "Byl jsem tu!",
            "Lock" => "0");
}


function DB_GetGallery($db, $galleryId)
{
    $statement = $db->prepare('SELECT * FROM Galleries WHERE Id = :Id;');
    $statement->bindValue(':Id', $galleryId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultGallery();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetGalleryByName($db, $galleryName)
{
    $statement = $db->prepare('SELECT * FROM Galleries WHERE [Name] = :GalleryName;');
    $statement->bindValue(':GalleryName', $galleryName);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultGallery();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetView($db, $viewId)
{
    $statement = $db->prepare('SELECT * FROM Views WHERE Id = :Id;');
    $statement->bindValue(':Id', $viewId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultView();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetViewByName($db, $viewName)
{
    $statement = $db->prepare('SELECT * FROM Views WHERE [Id] = :ViewName;');
    $statement->bindValue(':ViewName', $viewName);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultView();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetViewFromGallery($db, $galleryId, $viewId)
{
    $statement = $db->prepare('SELECT V.*, GxV.[Order] AS ViewOrder FROM GalleriesXViews AS GxV INNER JOIN Views AS V ON V.[Id] = GxV.[ViewId] WHERE GxV.[GalleryId] = :GalleryId AND GxV.[ViewId] = :ViewId ORDER BY GxV.[Order];');
    $statement->bindValue(':GalleryId', $galleryId);
    $statement->bindValue(':ViewId', $viewId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return DB_GetDefaultView();
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetNextViewId($db, $galleryId, $thisViewOrder)
{
    $statement = $db->prepare('SELECT MIN(GxV.[Order]) AS ViewOrder, GxV.[ViewId] AS ViewId FROM GalleriesXViews AS GxV WHERE GxV.[Order] > :ViewOrder AND GxV.GalleryId = :GalleryId;');
    $statement->bindValue(':ViewOrder', $thisViewOrder);
    $statement->bindValue(':GalleryId', $galleryId);
    
    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return 0;
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data['ViewId'];
}


function DB_GetPreviousViewId($db, $galleryId, $thisViewOrder)
{
    $statement = $db->prepare('SELECT MAX(GxV.[Order]) AS ViewOrder, GxV.[ViewId] AS ViewId FROM GalleriesXViews AS GxV WHERE GxV.[Order] < :ViewOrder AND GxV.GalleryId = :GalleryId;');
    $statement->bindValue(':ViewOrder', $thisViewOrder);
    $statement->bindValue(':GalleryId', $galleryId);
    
    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return 0;
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data['ViewId'];
}


function DB_GetDefaultView()
{
    return array(
            "Id" => 0, 
            "ViewTypeId" => 0,
            "Name" => DEFAULT_VIEW_NAME, 
            "Title" => "Byl jsem tu!",
            "Description" => "Byl jsem tu!",
            "Path" => "", 
            "Date" => "", 
            "Gps" => "", 
            "Lock" => "0",
            "ViewOrder" => "0",
            "PreviousViewId" => "0",
            "NextViewId" => "0");
}


function DB_GetViewPath($db, $viewId)
{
    $statement = $db->prepare('SELECT Views.Path AS ViewPath FROM Views WHERE Views.Id = :Id;');
    $statement->bindValue(':Id', $viewId);

    $result = $statement->execute();
    if ($result->numColumns() == 0)
    {
        return '';
    }

    $data = $result->fetchArray();
    $result->finalize();

    return $data;
}


function DB_GetThumbnailUrl($db, $viewId)
{
    $url = DEFAULT_THUMBNAIL_PATH;
    $viewPath = DB_GetViewPath($db, $viewId);
    if (isset($viewPath) && isset($viewPath["ViewPath"]))
    {
        $turl = $viewPath["ViewPath"] . DEFAULT_THUMBNAIL_NAME;
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_GetImageUrl($db, $viewId)
{
    $url = DEFAULT_IMAGE_PATH;
    $viewPath = DB_GetViewPath($db, $viewId);
    if (isset($viewPath) && isset($viewPath["ViewPath"]))
    {
        $turl = $viewPath["ViewPath"] . DEFAULT_IMAGE_NAME;
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_GetDescriptionUrl($db, $viewId)
{
    $url = '';
    $viewPath = DB_GetViewPath($db, $viewId);
    if (isset($viewPath) && isset($viewPath["ViewPath"]))
    {
        $turl = $viewPath["ViewPath"] . DESCRIPTION_FILE_NAME;
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_GetGalleryThumbnailUrl($db, $galleryId)
{
    $url = DEFAULT_THUMBNAIL_PATH;
    $gallery = DB_GetGallery($db, $galleryId);
    if (isset($gallery) && isset($gallery["Path"]))
    {
        $turl = $gallery["Path"] . DEFAULT_THUMBNAIL_NAME;
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_GetGalleryBackgroundUrl($db, $galleryId)
{
    $url = DEFAULT_BACKGROUND_PATH;
    $gallery = DB_GetGallery($db, $galleryId);
    if (isset($gallery) && isset($gallery["Path"]))
    {
        $turl = $gallery["Path"] . DEFAULT_BACKGROUND_NAME;
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_GetSkyBoxTextureUrl($db, $viewId, $face, $resolution)
{
    $url = DEFAULT_FACE_PATH;
    $viewPath = DB_GetViewPath($db, $viewId);
    if (isset($viewPath) && isset($viewPath["ViewPath"]))
    {
        $turl = $viewPath["ViewPath"] . $resolution . "/" . $face . ".jpg";
        if (file_exists($turl))
        {
            $url = $turl;
        }
    }

    return $url;
}


function DB_IsGalleryLocked($db, $gallery)
{
    $lock = DB_GetLock($db, $gallery["LockId"]);
    if (isset($lock) && $lock["Id"] > 1)
    {
        // A lock on a gallery is set, but is not in the session yet.
        return isset($_SESSION[$lock["Name"]]) == false;
    }

    return false;
}


function DB_IsViewLocked($db, $view)
{
    $lock = DB_GetLock($db, $view["LockId"]);
    if (isset($lock) && $lock["Id"] > 1)
    {
        // A lock on a view is set, but is not in the session yet.
        return isset($_SESSION[$lock["Name"]]) == false;
    }

    return false;
}


function DB_IsViewPanorama($db, $view)
{
    return ($view['ViewTypeId'] == 2);
}


function DB_GetViewDescription($db, $view)
{
    $description = "<h2>" . $view["Title"] . "</h2>";

    $descriptionUrl = DB_GetDescriptionUrl($db, $view["Id"]);
    if (file_exists($descriptionUrl))
    {
        $description .= file_get_contents($descriptionUrl);
    }
    else
    {
        if (isset($view["Description"]) && $view["Description"] !== '')
        {
            $description .= $view["Description"];
        }
    }

    $description .= "<p>";

    if (isset($view["Gps"]) && $view["Gps"] !== '')
    {
        $description .= "GPS: " . $view["Gps"];
    }

    if (isset($view["Date"]) && $view["Date"] !== '')
    {
        $description .= "<br/>Datum: " . $view["Date"];
    }

    $description .= "</p>";

    return $description;
}

?>