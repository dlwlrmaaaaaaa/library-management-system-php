<?php
   session_start();
   $_SESSION['student_number'];
   $_SESSION['user_id'];
if (!isset($_SESSION['userloggedin'])) {     
        header('Location: ../index.php');
         
        exit;
}       
       
?>