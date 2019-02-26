<?php 

require_once "constants.php";
require_once "db.php";

// --- UI ---------------------------------------------------------------------

function UI_NavigationButtons($db, $gallery, $view)
{
    echo '<div id="info"><a href="index.php"><img src="img/go-home.png" width="32" height="32" alt="Zpět domů" title="Zpět na titulní stránku"/></a> ';

    $prevId = DB_GetPreviousViewId($db, $gallery['Id'], $view['ViewOrder']);
    if (isset($prevId))
    {
        echo '<a href="view.php?id=', $prevId, '&gi=', $gallery['Id'], '"><img src="img/go-prev.png" width="32" height="32" alt="Předchozí lokace" title="Předchozí lokace"/></a> ';
    }
    else
    {
        echo '<a href="#"><img src="img/go-prev.png" width="32" height="32" alt="Předchozí lokace" title="Předchozí lokace"/></a> ';
    }
    
    echo '<a href="gallery.php?id=', $gallery['Id'], '"><img src="img/go-back.png" width="32" height="32" alt="Zpět do galerie" title="Zpět do galerie"/></a> ';
    
    $nextId = DB_GetNextViewId($db, $gallery['Id'], $view['ViewOrder']);
    if (isset($nextId))
    {
        echo '<a href="view.php?id=', $nextId, '&gi=', $gallery['Id'], '"><img src="img/go-next.png" width="32" height="32" alt="Následující lokace" title="Následující lokace"/></a> ';
    }
    else
    {
        echo '<a href="#"><img src="img/go-next.png" width="32" height="32" alt="Následující lokace" title="Následující lokace"/></a> ';
    }

    echo '<a href="#"><img id="description-icon" src="img/info.png" width="32" height="32" alt="Informace o lokaci" title="Zobrazit informace o lokaci"/></a></div>';
}


function UI_PageLogo()
{
    echo '<div id="logo"><a href="index.php"><img src="img/favicon.png" width="48" height="48" alt="Zpět domů" title="Zpět na titulní stránku"/></a></div>';
}


function UI_DescriptionBox($db, $view)
{
    echo '<div id="description">';
    echo DB_GetViewDescription($db, $view); 
    echo '</div>';
}


function UI_GalleryCardLink($db, $gallery)
{
    $galleryId = $gallery["Id"];

    echo '<div class="image-wrapper">';
    echo '<a href="gallery.php?id=', $galleryId, '"><img class="card lazy" data-src="thumbg.php?id=', $galleryId, '" alt="', $gallery["Description"], '"></a>';
    echo '<div class="card-icons-wrapper">';
    if (DB_IsGalleryLocked($db, $gallery))
    {
        echo '<img class="card-icon" src="img/lock.png" alt="Locked" width="32" height="32" />';
    }
    echo '</div>';
    if (isset($gallery["Description"]) && $gallery["Description"] != "") echo '<div class="image-description">', $gallery["Description"], '</div>';
    echo '</div>';
}


function UI_ViewCardLink($db, $view, $gallery)
{
    $viewId = $view["Id"];

    echo '<div class="image-wrapper">';
    echo '<a href="view.php?id=', $viewId, '&gi=', $gallery["Id"], '"><img class="card lazy" data-src="thumbv.php?id=', $viewId, '" alt="', $view["Description"], '"></a>';
    echo '<div class="card-icons-wrapper">';
    if (DB_IsViewLocked($db, $view) || DB_IsGalleryLocked($db, $gallery))
    {
        echo '<img class="card-icon" src="img/lock.png" alt="Locked" width="32" height="32" />';
    }
    if (DB_IsViewPanorama($db, $view))
    {
        echo '<img class="card-icon" src="img/panorama.png" alt="Panorama" width="32" height="32" />';
    }
    echo '</div>';
    if (isset($view["Description"]) && $view["Description"] != "") echo '<div class="image-description">', $view["Description"], '</div>';
    echo '</div>';
}


function UI_LazyCardLoader()
{
    echo '<script src="js/lazy.js"></script>';
}


function UI_BeginContent($link = null)
{
    echo '<div class="content">';
    echo '<div class="page-title"><div class="page-header"><a href="index.php"><img src="img/favicon.png" width="32" height="32">yl jsem tu!</a></div>';
    echo '<div class="top-menu"><a href="index.php">Domů</a> | <a href="news.php">Novinky</a> | <a href="index.php">Co tu najdete</a> | <a href="index.php">O nás</a> | <a href="index.php">Kontakty</a></div></div>';    
}


function UI_BeginContentGrid()
{
    echo '<div class="content-grid">';    
}


function UI_EndContentGrid()
{
    echo '</div>';
}


function UI_EndContent()
{
    echo '</div>';
}


function UI_Footer()
{
    echo '<footer><a href="lock.php">© Přemysl Fára, 2018 - 2019</a></footer>';
}

?>