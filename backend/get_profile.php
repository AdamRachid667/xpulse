<?php

include "db.php";

// Validation du paramètre GET
$user_id = (int) ($_GET['user_id'] ?? 0);

if ($user_id === 0) {
    echo json_encode(["error" => "Utilisateur introuvable."]);
    exit;
}

// Récupère les infos du profil (sans le mot de passe)
$sql = "SELECT id, username, email, bio FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["error" => "Utilisateur introuvable."]);
    exit;
}

// Récupère les posts de l'utilisateur, triés par date décroissante
$sql2 = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$user_id]);
$posts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["user" => $user, "posts" => $posts]);

?>
