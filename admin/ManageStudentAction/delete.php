<?php
include('../includes/authenticate.php');
include('../../dbconfig.php');
    try {   
        $id = $_GET['id'];

        $deleteBorrowed = "DELETE FROM borrowed WHERE id = :id";
        $stmtBorrowed = $pdo->prepare($deleteBorrowed);
        $stmtBorrowed->execute([":id" => $id]);       


         $deletePenalty = "DELETE FROM penalty WHERE id = :id";
        $stmtPenalty = $pdo->prepare($deletePenalty);
        $stmtPenalty->execute([":id" => $id]);
        
         $deleteMessage = "DELETE FROM messages WHERE id = :id";
        $stmtMessage = $pdo->prepare($deleteMessage);
        $stmtMessage->execute([":id" => $id]);

        $deleteStudent = "DELETE FROM students WHERE id = :id";
        $stmtStudent = $pdo->prepare($deleteStudent);
        $stmtStudent->execute([":id" => $id]);
       echo "<script>
               window.location.href = '../manageStudent.php';
       </script>";
        
       
    
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
?>