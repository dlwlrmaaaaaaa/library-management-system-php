<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = $data['id'];
    $student_number = $data['student_number'];
    $blacklist = 'Blacklisted';
    try {
         $update = "UPDATE students SET status = :status WHERE id = :id";
        $stmtUpdate = $pdo->prepare($update);
        $stmtUpdate->execute([
            ":status" => $blacklist,
            ":id" => $id
        ]);
        // Delete from the borrowing table based on ID
        $deleteBorrowing = "DELETE FROM borrowing WHERE id = :id";
        $stmtDeleteBorrowing = $pdo->prepare($deleteBorrowing);
        $stmtDeleteBorrowing->execute([
            ":id" => $id
        ]);
        // Delete from the borrowed table based on ID
        $deleteBorrowed = "DELETE FROM borrowed WHERE id = :id";
        $stmtDeleteBorrowed = $pdo->prepare($deleteBorrowed);
        $stmtDeleteBorrowed->execute([
            ":id" => $id
        ]);
    } catch (Throwable $th) {
        throw $th;
    }
?>