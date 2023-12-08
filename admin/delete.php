<?php
    include('../dbconfig.php');
    try {   
        $id = $_GET['id'];
        $sql = "DELETE FROM students WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        if($stmt->rowCount() > 0){
          echo "<script>
            alert('Deleted Account Succesfull')
          window.location.href = 'manageStudent.php'</script>
        }";
    }
    } catch (PDOException $th) {
        echo $th->getMessage();
    }
?>