<?php
    include('../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $user_id = $data['id'];
    $studentnumber = $data['studentnumber'];
    $book_id = $data['book_id'];
    $title = $data['title'];
    $borrow_id = $data['borrow_id'];

    try {
        $sql = 'INSERT INTO borrowed (book_id, id, book_title, student_number) VALUES (:bid, :id, :btitle, :sn)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":bid" => $book_id,
        ":id" => $user_id,
         ":btitle" => $title,
          ":sn" => $studentnumber]);        
    } catch (Throwable $th) {
        throw $th;
    }
    try {
        $sql = 'DELETE FROM borrowing WHERE borrow_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $borrow_id]);        
    } catch (Throwable $th) {
        throw $th;
    }

?>