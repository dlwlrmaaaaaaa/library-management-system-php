<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $borrow_id = $data['borrow_id'];
       try {
        $sql = 'DELETE FROM borrowing WHERE borrow_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $borrow_id]);        
    } catch (Throwable $th) {
        throw $th;
    }
?>