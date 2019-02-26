<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Byl jsem tu!</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="styles/view.css">
        <link rel="icon" href="img/favicon.png">
        <script src="js/description.js"></script>
        <style>
            div.stretchy-wrapper
            {
                width: 100vw; 
                max-width: <?php echo $maxWidth; ?>vh;
                height: <?php echo $height; ?>vw;
                max-height: 100vh;

                background: url("img.php?id=<?php echo $view["Id"]; ?>"); 
                background-position: top center;
                background-repeat: no-repeat;
                background-size: cover; 

                margin: auto;
                position: absolute;
                top:0;bottom:0; /* vertical center */
                left:0;right:0; /* horizontal center */
                z-index: 5;
            }
        </style>
    </head>
    
    <body>
        <?php 
            UI_NavigationButtons($db, $gallery, $view);
            UI_DescriptionBox($db, $view); 
        ?>
        <div class="stretchy-wrapper"><?php UI_PageLogo(); ?></div>

        <script>
            description_Init();
        </script>
    </body>
</html>