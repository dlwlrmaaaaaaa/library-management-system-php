<?php
header('Content-Type: application/json');
include('../../dbconfig.php');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
    exit;
}

$user_id       = $data['id'];
$studentnumber = $data['studentnumber'];
$book_id       = $data['book_id'];
$title         = $data['title'];
$full_name     = $data['full_name'];
$borrow_id     = $data['borrow_id'];

try {
    $pdo->beginTransaction();

    // Insert into borrowed
    $insertBorrowed = "
        INSERT INTO borrowed (book_id, id, book_title, student_number, full_name)
        VALUES (:bid, :uid, :btitle, :sn, :fn)
    ";
    $stmt = $pdo->prepare($insertBorrowed);
    $stmt->execute([
        ":bid"    => $book_id,
        ":uid"    => $user_id,
        ":btitle" => $title,
        ":sn"     => $studentnumber,
        ":fn"     => $full_name
    ]);

    // Delete from borrowing
    $deleteBorrowing = "DELETE FROM borrowing WHERE borrow_id = :bid";
    $stmt = $pdo->prepare($deleteBorrowing);
    $stmt->execute([":bid" => $borrow_id]);

    // Update book copies (safe: don’t go below 0)
    $updateBookCopies = "
        UPDATE books 
        SET copies = copies - 1 
        WHERE book_id = :bid AND copies > 0
    ";
    $stmt = $pdo->prepare($updateBookCopies);
    $stmt->execute([":bid" => $book_id]);

    $pdo->commit();

    echo json_encode([
        "status" => "success",
        "message" => "Book issued successfully"
    ]);

} catch (Throwable $e) {
    $pdo->rollBack();
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
