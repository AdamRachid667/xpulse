<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($password, $user["password"])) {

    echo json_encode([
        "success" => true,
        "user" => $user
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}

?>