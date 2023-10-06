<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
       
        date_default_timezone_set('Europe/Madrid');
        
        $fechaActual = date('Y-m-d');
        $fechaFinal = date('2022-12-11'); 
       
        if($fechaActual <= $fechaFinal){
           print "<h3>Trae a tu amigo o amiga hasta el 11/12/2022 y consigue un 30% de descuento de por vida</h3>";
        }

        ?>
    </body>
</html>
