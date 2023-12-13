<?php
include('../includes/authenticate.php');
include('../../dbconfig.php');
    try {   
        $id = $_GET['id'];

        $deleteBorrowed = "DELETE FROM borrowed WHERE id = :id";
        $stmtBorrowed = $pdo->prepare($deleteBorrowed);
        $stmtBorrowed->execute([":id" => $id]);       


        $deleteStudent = "DELETE FROM students WHERE id = :id";
        $stmtStudent = $pdo->prepare($deleteStudent);
        $stmtStudent->execute([":id" => $id]);

        $deletePenalty = "DELETE FROM penalty WHERE id = :id";
        $stmtPenalty = $pdo->prepare($deletePenalty);
        $stmtPenalty->execute([":id" => $id]);
        if ($stmtPenalty->rowCount() > 0) {
            echo "<script>
                swal('Success!', 'Deleted Successfully!!', 'success'); 
                window.location.href = 'manageStudent.php'
            </script>";
        }
    
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
?>