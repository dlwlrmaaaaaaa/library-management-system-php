<?php
include('../../dbconfig.php');
$json = file_get_contents('php://input');
$data = json_decode($json, true);
$id = $data['id'];
    try {   
        $deleteBook = "DELETE FROM books WHERE book_id = :id";
        $stmtDelete = $pdo->prepare($deleteBook);
        $stmtDelete->execute([":id" => $id]);       
        echo $th->getMessage();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>