<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = $data['id'];
    $student_number = $data['student_number'];
    $book_id = $data['book_id'];
    $borrow_id = $data['borrow_id'];
    try {
        $penalty = "INSERT INTO penalty (id, student_number, count, suspension)
            VALUES (:id, :sn, :count, DATE_ADD(NOW(), INTERVAL 15 DAY))
            ON DUPLICATE KEY UPDATE count = count + 1, suspension = DATE_ADD(suspension, INTERVAL 15 DAY)";
            $stmt = $pdo->prepare($penalty);
            $stmt->execute([
                ":id" => $id,
                ":sn" => $student_number,
                ":count" => 1
            ]);
        $selectCount = "SELECT count FROM penalty WHERE id = :id";
        $countStmt = $pdo->prepare($selectCount);
        $countStmt->execute([
            ":id" => $id
        ]);
        $row = $countStmt->fetch(PDO::FETCH_OBJ);
        $count;
        if($row){
            $count = $row->count;
        }
        if($count >= 3){
            $blacklist = "UPDATE students SET status = :status WHERE id = :id";
            $blacklistStmt = $pdo->prepare($blacklist);
            $blacklistStmt->execute([
                ":status" => "Blacklisted",
                ":id" => $id
            ]);
            $deleteBorrowing = "DELETE FROM borrowing WHERE book_id = :book_id";
            $stmtDeleteBorrowing = $pdo->prepare($deleteBorrowing);
            $stmtDeleteBorrowing->execute([
                ":book_id" => $id
            ]);
            // Delete from the borrowed table based on ID
            $deleteBorrowed = "DELETE FROM borrowed WHERE id = :id";
            $stmtDeleteBorrowed = $pdo->prepare($deleteBorrowed);
            $stmtDeleteBorrowed->execute([
                ":id" => $book_id
            ]);
            
        }
        $delete = "DELETE FROM borrowed WHERE issued_id = :borrow_id";
        $deleteStmt = $pdo->prepare($delete);
        $deleteStmt->execute([
            ":borrow_id" => $borrow_id
        ]);

        $deleteRequest = "DELETE FROM borrowing WHERE id = :id";
        $requestStmt = $pdo->prepare($deleteRequest);
        $requestStmt->execute([
            ":id" => $id
        ]);
    
    } catch (Throwable $th) {
        echo "lost.php : " . $th->getMessage();
    }
?>