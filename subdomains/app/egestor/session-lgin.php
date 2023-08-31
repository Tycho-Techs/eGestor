<?php
        session_start(); 
        
        if(!isset($_SESSION['logged_in'])){
            header('Location: https://app.sweetadm.com.br/egestor/login.php'); 
            exit;
        }
    ?>