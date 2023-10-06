<?php

define ('DB_DSN','mysql:host=localhost;dbname=pedidos');
define ('DB_USER','root');
define ('DB_PASSWD',''); 


    function connect()
    {
        try{
            $pdo=new PDO(DB_DSN,DB_USER,DB_PASSWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $pdo=false;
        }
        return $pdo;
    }

define("ROOTPATH", './DWES04/');
define("TEMPLATE_DIR", './templates/');
define("TEMPLATE_C_DIR", './template_c/');
define("CACHE_DIR", './cache/');
