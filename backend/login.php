<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

// Validation des données côté serveur
$email    = trim($data->email ?? '');
$password = $data->password ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(["success" => false, "error" => "Champs manquants."]);
    exit;
}

// Recherche de l'utilisateur par email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification du mot de passe hashé
if ($user && password_verify($password, $user['password'])) {
    // Ne jamais renvoyer le mot de passe au frontend
    unset($user['password']);
    echo json_encode(["success" => true, "user" => $user]);
} else {
    echo json_encode(["success" => false]);
}

?>
