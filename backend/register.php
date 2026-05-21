<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_DEFAULT);

// Vérifier si l'email est déjà utilisé
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->fetch()) {
    echo json_encode(["error" => "Cet email est déjà utilisé."]);
    exit;
}

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
