<?php

    define('HOST','127.0.0.1');
    define('PUERTO',6379);
    define('BD',0);
    
    try{
        $redis = new Redis();           // instancia Redis
        $redis->connect(HOST, PUERTO);  // se conecta al servidor
        $redis->select(BD);             // se conecta a la base de datos    
    }catch(Exception $e){
        die('ERROR '.$e->getCode().': '.$e->getMessage());
    }
?>
