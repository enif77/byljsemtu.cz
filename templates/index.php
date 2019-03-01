<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Byl jsem tu!</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php UI_PageDescription(); ?>
        <link rel="stylesheet" href="styles/list-top.css">
        <link rel="icon" href="img/favicon.png">
        <style>
        </style>
    </head>
    <body><?php
  
UI_BeginContent();
UI_BeginContentGrid();

$count = 0;
$results = DB_GetGalleriesForIndex($db);
if (isset($results))
{
    while ($gallery = $results->fetchArray()) 
    {
        UI_GalleryCardLink($db, $gallery);

        $count++;
    }

    $results->finalize();
}

UI_EndContentGrid(); 
UI_EndContent(); 
UI_Footer();
UI_LazyCardLoader();
UI_SideMenuControl();

DB_Close($db);

?></body>
</html>