<?php
    global $db;
    $config = [
        $dbname="mysql:host=localhost;dbname=ancientwarriorslicenta;",
        $login="root",
        $password="",
    ];
    try{
        $db = new PDO(...$config);
    } catch (Exception $ex) {
        throw new Exception("Nu s-a putut conecta la baza de date"); 
    }

?>