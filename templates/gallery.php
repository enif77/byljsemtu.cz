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

// TODO: Toto do boxu pod menu, nebo do hlavičky.
//echo '<h2>', $gallery["Title"], '</h2>';

UI_BeginContentGrid();

$count = 0;
$results = DB_GetGalleryViews($db, $gallery["Id"]);
if (isset($results))
{
    while ($view = $results->fetchArray()) 
    {
        UI_ViewCardLink($db, $view, $gallery);

        $count++;
    }

    $results->finalize();
}

UI_EndContentGrid(); 
UI_EndContent();
UI_Footer();
UI_LazyCardLoader();

DB_Close($db);

?></body>
</html>