<?php 

require_once "constants.php";
require_once "db.php";

// --- UI ---------------------------------------------------------------------

function UI_NavigationButtons($db, $gallery, $view)
{
    echo '<nav><div id="info"><a href="index.php"><img src="img/go-home.png" width="32" height="32" alt="Zpět domů" title="Zpět na titulní stránku"/></a> ';

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

    echo '<a href="#"><img id="description-icon" src="img/info.png" width="32" height="32" alt="Informace o lokaci" title="Zobrazit informace o lokaci"/></a></div></nav>';
}


function UI_PageLogo()
{
    echo '<div id="logo"><a href="index.php"><img src="img/favicon.png" alt="byljsemtu.cz page logo." width="48" height="48" alt="Zpět domů" title="Zpět na titulní stránku"/></a></div>';
}


function UI_PageDescription()
{
    echo '<meta name="Description" content="Author: Premysl Fara, Category: Blogs">';
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
    $galleryTitle = $gallery["Title"];
    if (isset($galleryTitle) == false || $galleryTitle === "")
    {
        $galleryTitle = $gallery["Name"];
    }

    echo '<div class="image-wrapper">';
    echo '<a href="gallery.php?id=', $galleryId, '"><img class="card lazy" data-src="thumbg.php?id=', $galleryId, '" alt="', $galleryTitle, '"></a>';
    echo '<div class="card-icons-wrapper">';
    if (DB_IsGalleryLocked($db, $gallery))
    {
        echo '<img class="card-icon" src="img/lock.png" alt="Locked" width="32" height="32" />';
    }
    echo '</div>';
    echo '<div class="image-description">', $galleryTitle, '</div>';
    echo '</div>';
}


function UI_ViewCardLink($db, $view, $gallery)
{
    $viewId = $view["Id"];

    echo '<div class="image-wrapper">';
    echo '<a href="view.php?id=', $viewId, '&gi=', $gallery["Id"], '"><img class="card lazy" data-src="thumbv.php?id=', $viewId, '" alt="', $view["Title"], '"></a>';
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
    if (isset($view["Title"]) && $view["Title"] != "") echo '<div class="image-description">', $view["Title"], '</div>';
    echo '</div>';
}


function UI_LazyCardLoader()
{
    echo '<script src="js/lazy.js"></script>';
}


function UI_BeginContent($link = null)
{
    echo '<div class="content">';
    echo '<header><div class="page-header"><a href="index.php"><img src="img/favicon.png" alt="Page logo." width="32" height="32">yl jsem tu!</a></div>';
        
    // <a href="#javascript:void(0)"  -> Zabraňuje skrolování stránky nahoru po rozbalení/sbalení side menu.
    // https://stackoverflow.com/questions/14038713/change-display-property-scrolls-the-page-to-its-top

    // Menu button.
    echo '<nav class="top-menu">'; 
    echo '<span class="open-slide">';
    echo '<a href="#javascript:void(0)" onclick="openSlideMenu()">';
    echo '<img src="img/menu_20x20.png" alt="Top menu." width="20" height="20">';
    echo '</a></span>';
    
    // Top menu.
    echo '<span class="top-menu-nav"><a href="index.php">Domů</a> | ';    
    echo '<a href="news.php">Novinky</a> | ';    
    echo '<a href="index.php">Co tu najdete</a> | ';    
    echo '<a href="index.php">O nás</a></span>';    
    echo '</nav>';    

    // Side menu.
    echo '<div id="side-menu" class="side-nav">';
    echo '<a href="#javascript:void(0)" class="btn-close" onclick="closeSlideMenu()">&times;</a>';
    echo '<a href="index.php">Domů</a>';
    echo '<a href="news.php">Novinky</a>';
    echo '<a href="index.php">Co tu najdete</a>';
    echo '<a href="index.php">O nás</a>';
    echo '</div>';

    echo '</header><main id="main">';    
}


function UI_SideMenuControl()
{
    echo '<script>';
    echo 'function openSlideMenu() { document.getElementById(\'side-menu\').style.display = \'block\'; }';
    echo 'function closeSlideMenu() { document.getElementById(\'side-menu\').style.display = \'none\'; }';
    echo '</script>';
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
    echo '</main></div>';
}


function UI_Footer()
{
    echo '<footer><a href="lock.php">© Přemysl Fára, 2018 - 2019</a></footer>';
}

?>