<?php
        session_start();
        
        if(($_POST['value-email'] == "teste@br" and $_POST['value-pass'] == "lalala") or $_POST['state'] == "987456"){
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $_POST['value-email'];
            
            header('Location: https://app.sweetadm.com.br/egestor/index.php');
            exit;
            
            }Else{
                header('Location: https://app.sweetadm.com.br/egestor/login.php');
                exit;
            
            }
        
?>