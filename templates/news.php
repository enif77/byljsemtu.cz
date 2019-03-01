<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Byl jsem tu! - Novinky</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php UI_PageDescription(); ?>
        <link rel="stylesheet" href="styles/list-top.css">
        <link rel="icon" href="img/favicon.png">
        <style>
            .content-left {
                text-align: left;
                background-color: rgb(200, 200, 200);
                opacity: 0.75;
                margin-top:0px;
                padding:10px;  /* Removes the top border. */
            }
        </style>
    </head>

    <body><?php

UI_BeginContent();

?><div class="content-left">
<h2>2019-02-26</h2>
<p>Lighthouse od Googlu říká, že dobrý. (Opravy chyb.)</p>

<h2>2019-02-25</h2>
<p>Lazy-loading pro obrázky.</p>

<h2>2019-02-24</h2>
<p>Přidal jsem galerii z <a href="gallery.php?name=201807_ZooTabor">táborské zoo</a>.</p>

<h2>2019-02-21</h2>
<p>Dal jsem pryč celostránkové obrázky na pozadí a stránkování v seznamu galerií a v galeriích. 
Až přidám lazy-loading pro obrázky, tak bude svět zase o trošku lepší místo pro život.</p>

<p>Nový vzhled seznamů obrázků a galerií by se dal také prohlásit za zlepšení stavu.</p>

<h2>2019-02-13</h2>
<p>Přidal jsem galerii z mé pracovní návštěvy švýcarského <a href="gallery.php?name=201703_Zug">Zugu</a>.</p>

<h2>2019-02-10</h2>
<p>Dnes sem konečně zase něco na svých stránkách udělal... :-)</p>
</div><?php

UI_EndContent(); 
UI_Footer();
UI_SideMenuControl();

?></body>
</html>