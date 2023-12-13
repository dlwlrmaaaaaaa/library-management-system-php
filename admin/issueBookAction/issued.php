<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    $user_id = $data['id'];
    $studentnumber = $data['studentnumber'];
    $book_id = $data['book_id'];
    $title = $data['title'];
   $full_name = $data['full_name'];
    $borrow_id = $data['borrow_id'];
 

    try {
    // Begin transaction
    $pdo->beginTransaction();

    // Insert into borrowed
    $insertBorrowed = 'INSERT INTO borrowed (book_id, id, book_title, student_number, full_name) VALUES (:bid, :id, :btitle, :sn, :fn)';
    $stmt = $pdo->prepare($insertBorrowed);
    $stmt->execute([
        ":bid" => $book_id,
        ":id" => $user_id,
        ":btitle" => $title,
        ":sn" => $studentnumber,
        ":fn" => $full_name
    ]);

    // Delete from borrowing
    $deleteBorrowing = 'DELETE FROM borrowing WHERE borrow_id = :id';
    $stmt = $pdo->prepare($deleteBorrowing);
    $stmt->execute([":id" => $borrow_id]);

    // Update book copies
    $updateBookCopies = 'UPDATE books SET copies = copies - 1 WHERE book_id = :id';
    $stmt = $pdo->prepare($updateBookCopies);
    $stmt->execute([":id" => $book_id]);

    // Commit the transaction
    $pdo->commit();

    // Return success JSON response
    echo json_encode(["success" => true, "message" => "Book issued successfully"]);
} catch (Throwable $th) {
    // Rollback the transaction on error
    $pdo->rollBack();
    // Log the error or handle it appropriately
    echo json_encode(["success" => false, "error" => $th->getMessage()]);
}



