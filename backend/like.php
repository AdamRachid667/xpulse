<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$post_id = (int) $data->post_id;
$user_id = (int) $data->user_id;

// Vérifie si le like existe déjà
$check = $pdo->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
$check->execute([$post_id, $user_id]);

if ($check->fetch()) {
    // Already liked → unlike
    $pdo->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?")->execute([$post_id, $user_id]);
    $pdo->prepare("UPDATE posts SET likes = GREATEST(likes - 1, 0) WHERE id = ?")->execute([$post_id]);
    echo json_encode(["message" => "Like retiré", "liked" => false]);
} else {
    // Not liked yet → like
    $pdo->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)")->execute([$post_id, $user_id]);
    $pdo->prepare("UPDATE posts SET likes = likes + 1 WHERE id = ?")->execute([$post_id]);
    echo json_encode(["message" => "Like ajouté", "liked" => true]);
}

?>
