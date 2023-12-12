<?php

    include('../../dbconfig.php');
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $date = new DateTime();

    $user_id = $data['id'];
    $student_number = $data['student_number'];
    $title = $data['title'];
    $msg = "Your book had expired! Title: " . $title;
    try {
    $send_message = "INSERT INTO messages (id, student_number, message) VALUES (:user_id, :sn, :msg)";
    $statement = $pdo->prepare($send_message);
    $statement->execute([
        ":user_id" => $user_id,
        ":sn" => $student_number,
        ":msg" => $msg
        ]);

        echo json_encode(["success" => true, "message" => "Message sent successfully"]);
    } catch (Throwable $th) {
        echo json_encode(["success" => false, "error" => $th->getMessage()]);
    }



?>