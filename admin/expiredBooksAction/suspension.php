<?php
    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $id = $data['id'];
    $student_number = $data['student_number'];
    $count = 1;
    try {
        try {
            $penalty = "INSERT INTO penalty (id, student_number, count)
            VALUES (:id, :sn, :count)
            ON DUPLICATE KEY UPDATE count = count + 1";
            $stmt = $pdo->prepare($penalty);
            $stmt->execute([
                ":id" => $id,
                ":sn" => $student_number,
                ":count" => $count
            ]);
        } catch (Throwable $t) {
            throw $t;
        }
        try {
           
            $sendMessage = "INSERT INTO messages (id, student_number, msg) VALUES (:id, :student_number, :msg)";
            $stmt = $pdo->prepare($sendMessage);
            $stmt->execute([
                ":id" => $id,
                ":student_number" => $student_number,
                ":msg" => "You have been suspended!"
            ]);
        } catch (Throwable $ta) {
            throw $ta;
        }

        echo json_encode(["success" => true, "message" => "Penalty Applied Success!"]);
    } catch (Throwable $th) {
        echo json_encode(["success" => false, "error" => $th->getMessage()]);
    }

   


?>