<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

// Validation des données côté serveur
$post_id = (int) ($data->post_id ?? 0);
$user_id = (int) ($data->user_id ?? 0);
$content = trim($data->content ?? '');

if ($post_id === 0 || $user_id === 0 || empty($content)) {
    echo json_encode(["error" => "Données manquantes."]);
    exit;
}

// Insertion du commentaire
$sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$post_id, $user_id, $content]);

// Mise à jour du compteur de commentaires sur le post
$sql2 = "UPDATE posts SET comments_count = comments_count + 1 WHERE id = ?";
$pdo->prepare($sql2)->execute([$post_id]);

echo json_encode(["message" => "Commentaire ajouté"]);

?>
