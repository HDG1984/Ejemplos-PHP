<!DOCTYPE html>

<html>
    <head>
        <title>Comerciales</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--  
        Primero la di estilo en el mismo archivo para ir haciendo pruebas, cuando lo pase al archivo css no me hacia los 
        cambios y mirando por internet encontré que era un problema con la cache del navegador que conservaba la forma antigua y aunque hiciera 
        control f5 en el navegador no me actualizaba los estilos de la pagina, así que encontre esta solución pasandole fecha y hora actuales 
        con minutos y segundos para que el valor siempre sea diferente y así no daba fallos.     hrefCSS.css??php echo date('Y-m-d H:i:s'); ?>
        -->
        <link rel="stylesheet" href="CSS.css?<?php echo date('Y-m-d H:i:s'); ?>" type="text/css">
    </head>
    <body>
        <?php

        include_once 'etc/conf.php';

        include 'amigo.php';
  
        ?>
        <div style="text-align: center">
            <?php if(!isset($_GET['comercial'])): ?>
                
                <h2><b>Nuestros comerciales</b></h2>
                <hr>
                - <a href="?comercial=<?= urlencode(COMERCIAL1) ?>">Fernando Martínez</a>
                - <a href="?comercial=<?= urlencode(COMERCIAL2) ?>">Rafael García</a>
                - <a href="?comercial=<?= urlencode(COMERCIAL3) ?>">Laura Fernández</a>
                - <a href="?comercial=<?= urlencode(COMERCIAL4) ?>">Maribel Díaz</a>
                <hr>
                
            <?php else: ?>
               
                <?php if($_GET['comercial'] == COMERCIAL1): ?>
               
                    <?php readfile("frag/comercial1.html"); ?>
                
                    <p>Haz clic a continuación en otros comerciales para obtener su información</p>
                    
                    - <a href="?comercial=<?= urlencode(COMERCIAL2) ?>">Rafael García</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL3) ?>">Laura Fernández</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL4) ?>">Maribel Díaz</a>
                    
                <?php elseif($_GET['comercial'] == COMERCIAL2): ?>
 
                    <?php readfile("frag/comercial2.html"); ?> 
                    
                    <p>Haz clic a continuación en otros comerciales para obtener su información</p>
                    
                    - <a href="?comercial=<?= urlencode(COMERCIAL1) ?>">Fernando Martínez</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL3) ?>">Laura Fernández</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL4) ?>">Maribel Díaz</a>
                    
                <?php elseif($_GET['comercial'] == COMERCIAL3): ?>
                    
                    <?php readfile("frag/comercial3.html"); ?>
                    
                    <p>Haz clic a continuación en otros comerciales para obtener su información</p>
                    
                    - <a href="?comercial=<?= urlencode(COMERCIAL1) ?>">Fernando Martínez</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL2) ?>">Rafael García</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL4) ?>">Maribel Díaz</a>
                    
                <?php elseif($_GET['comercial'] == COMERCIAL4): ?>
                    
                    <?php readfile("frag/comercial4.html"); ?>
                    
                    <p>Haz clic a continuación en otros comerciales para obtener su información</p>

                    - <a href="?comercial=<?= urlencode(COMERCIAL1) ?>">Fernando Martínez</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL2) ?>">Rafael García</a>
                    - <a href="?comercial=<?= urlencode(COMERCIAL3) ?>">Laura Fernández</a>
                    
                <?php else: ?>
                    <p>Comercial no encontrado</p>
                <?php endif ?>
            <?php endif ?>
        </div>
        <?php
        include 'amigo.php';
        ?>
    </body>
</html>