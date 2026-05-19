<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_DEFAULT);

$sql = "
INSERT INTO users(username, email, password)
VALUES (?, ?, ?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $username,
    $email,
    $password
]);

echo json_encode([
    "message" => "Compte créé"
]);

?>