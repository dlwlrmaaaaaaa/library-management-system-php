<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $book_id = $data['book_id'];
    $borrow_id = $data['borrow_id'];
    try {
        $delete = "DELETE FROM borrowed WHERE issued_id = :borrow_id";
        $deleteStmt = $pdo->prepare($delete);
        $deleteStmt->execute([
            ":borrow_id" => $borrow_id
        ]);

        $update = "UPDATE books SET copies = copies + 1 WHERE book_id = :book_id";
        $updateStmt = $pdo->prepare($update);
        $updateStmt->execute([
            ":book_id" => $book_id
        ]);    
        echo "Book returned successfully!";
    } catch (Throwable $th) {
        echo "irro: " . $th->getMessage();
    }
?>