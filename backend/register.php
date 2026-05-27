<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

// Validation des données côté serveur
$username = trim($data->username ?? '');
$email    = trim($data->email ?? '');
$password = $data->password ?? '';

if (empty($username) || empty($email) || empty($password)) {
    echo json_encode(["error" => "Tous les champs sont obligatoires."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Email invalide."]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(["error" => "Le mot de passe doit faire au moins 6 caractères."]);
    exit;
}

// Vérifie si l'email est déjà utilisé
$check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$check->execute([$email]);

if ($check->fetch()) {
    echo json_encode(["error" => "Cet email est déjà utilisé."]);
    exit;
}

// Hashage du mot de passe et insertion
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$username, $email, $hashedPassword]);

echo json_encode(["message" => "Compte créé"]);

?>
