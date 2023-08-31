<?php
    $host = 'srv889.hstgr.io';
    $dbname = 'u135086058_eGestor';
    $username = 'u135086058_gestor';
    $password = 'Q?X@!Js#@YG7o6y!';
    
        try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        //echo "Conectado a $dbname em $host com sucesso.";
        } catch (PDOException $pe) {
        die("Não foi possível se conectar ao banco de dados $dbname :" . $pe>getMessage());
        exit();
        }
?>