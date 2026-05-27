<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

// Validation des données côté serveur
$user_id = (int) ($data->user_id ?? 0);
$bio     = trim($data->bio ?? '');

if ($user_id === 0) {
    echo json_encode(["error" => "Utilisateur invalide."]);
    exit;
}

if (strlen($bio) > 300) {
    echo json_encode(["error" => "Bio trop longue (max 300 caractères)."]);
    exit;
}

// Mise à jour de la bio
$sql = "UPDATE users SET bio = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$bio, $user_id]);

echo json_encode(["message" => "Bio mise à jour"]);

?>
