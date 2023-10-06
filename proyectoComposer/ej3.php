<?php

include __DIR__.'/etc/conf.php';

$favoritos=[];

if (isset($_COOKIE['favoritosSerializado']) || isset($_COOKIE['hashFavoritosSerializado'])){
    
    if (hash('sha256',$_COOKIE['favoritosSerializado'])===$_COOKIE['hashFavoritosSerializado']){
        
        $sinRepetir = array_unique(unserialize($_COOKIE['favoritosSerializado']));
        $favoritos=$sinRepetir;

    }
    else{
        $errors[]="La verificación fallo, por lo que se borran las cookies";
        $favoritos=[];
        setcookie('favoritosSerializado','',time()-600);
        setcookie('hashFavoritosSerializado','',time()-600);
    } 
    
}
if ($_POST) {
    
    if(isset($_POST['op']) && isset($_POST['producto']) && array_key_exists($_POST['producto'], $productos)){
    
        if($_POST['op'] == "fav" ){

            $produc = $_POST['producto'];
            array_push($favoritos, $produc);

            setcookie('favoritosSerializado',serialize($favoritos),time()+600);
            setcookie('hashFavoritosSerializado',hash('sha256',serialize($favoritos)),time()+600);

        }else{

            $producPost = $_POST['producto'];
            $eliminarP = array_search($producPost, $favoritos);
            unset($favoritos[$eliminarP]);

            setcookie('favoritosSerializado',serialize($favoritos),time()+600);
            setcookie('hashFavoritosSerializado',hash('sha256',serialize($favoritos)),time()+600);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
</head>
<link rel="stylesheet" href="css/styles.css">
<link href="assets/fontawesome/css/all.min.css" rel="stylesheet"  type="text/css">
<body>
    <?php include __DIR__.'/extra/mensajes.php'; ?>
    <?php include __DIR__.'/extra/errors.php'; ?>
<table>
    <thead>
        <tr>
            <th>
                Favoritos
            </th>
            <th>
                Código producto
            </th>   
            <th>
                Descripción
            </th>   
            <th>
                Precio
            </th>   
        </tr>
    </thead>
    <tbody>
        <?php foreach($productos as $cod=>$datos): ?>
        <tr>
            <td style="text-align:center">
                <form action="" method="post">
                    <?php if(in_array($cod,$favoritos)): ?>
                        <button type="submit" class="flat"><i class="fa-solid fa-star fa-lg"></i></button>                        
                        <input type="hidden" name="op" value="unfav">
                    <?php else: ?>
                        <button type="submit" class="flat"><i class="fa-regular fa-star fa-lg"></i></button>                                              
                        <input type="hidden" name="op" value="fav">
                    <?php endif; ?>
                    <input type="hidden" name="producto" value="<?=$cod?>">
                </form>                
            </td>
            <td>
                <?=$cod?>
            </td>   
            <td>
                <?=$datos['descripcion']?>
            </td>   
            <td>
                <?=$datos['precio_unidad']?>
            </td>   
        </tr>        
        <?php endforeach; ?>
    </tbody>        
</table>

</body>
</html>
