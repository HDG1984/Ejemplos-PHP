<?php

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
    
