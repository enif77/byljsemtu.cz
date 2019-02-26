<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Byl jsem tu!</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="styles/view.css">
        <link rel="icon" href="img/favicon.png">

        <script src="js/three.min.js"></script>
        <script src="js/controls/OrbitControls.js"></script>
        <script src="js/view.js"></script>
        <script src="js/description.js"></script>

        <style>
            html, body {
                cursor: all-scroll;
            }
        </style>
    </head>
    
    <body>
        <div id="container"></div>
        <?php 
            UI_NavigationButtons($db, $gallery, $view); 
            UI_DescriptionBox($db, $view); 
            UI_PageLogo();
        ?>
        
        <script>
            // https://github.com/mrdoob/stats.js
            //(function(){var script=document.createElement('script');script.onload=function(){var stats=new Stats();document.body.appendChild(stats.dom);requestAnimationFrame(function loop(){stats.update();requestAnimationFrame(loop)});};script.src='//rawgit.com/mrdoob/stats.js/master/build/stats.min.js';document.head.appendChild(script);})()

<?php 

    echo "document.title = document.title + ' - ' + '", $view["Title"], "';";
    echo "view_id = '", $view["Id"], "';";
    echo "view_resolution = '", DEFAULT_TEXTURE_RESOLUTION, "';"; // TODO: Predavat skybox resolution jako parametrstranky.

    DB_Close($db);
?>

            view_Init();
            description_Init();
            
            view_Animate();
        </script>
    </body>
</html>