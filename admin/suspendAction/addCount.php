<?php
    include('../../dbconfig.php');
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $id = $data['id'];

    try {
        $sql = "UPDATE penalty SET count = count + 1, suspension = DATE_ADD(penalty_deadline, INTERVAL 7 DAY) WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id
        ]);
    } catch (Throwable $th) {
        throw $th;
    }

?>