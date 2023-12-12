<?php
    include('../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $user_id = $data['id'];
    $studentnumber = $data['studentnumber'];
    $book_id = $data['book_id'];
    $title = $data['title'];
   $full_name = $data['full_name'];
    $borrow_id = $data['borrow_id'];
 

    //Insert from issued
    try {
        $sql = 'INSERT INTO borrowed (book_id, id, book_title, student_number, full_name) VALUES (:bid, :id, :btitle, :sn, :fn)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":bid" => $book_id,
        ":id" => $user_id,
         ":btitle" => $title,
          ":sn" => $studentnumber,
        ":fn" => $full_name    
    ]);        
    } catch (Throwable $th) {
        throw $th;
    }
    //Delete from table
    try {
        $sql = 'DELETE FROM borrowing WHERE borrow_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $borrow_id]);        
    } catch (Throwable $th) {
        throw $th;
    }

    //Babawasan ng copies after ma issue
    try {
        $updateBook = 'UPDATE books SET copies = copies - 1 WHERE book_id = :id';
        $stmt = $pdo->prepare($updateBook);
        $stmt->execute([":id" => $book_id]);
    } catch (Throwable $th) {
            throw $th;
    }



?>