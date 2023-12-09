<?php
   session_start();
if (!isset($_SESSION['userloggedin'])) {     
        header('Location: ../index.php');
        exit;
}
       
?>