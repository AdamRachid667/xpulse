<?php

include "db.php";

$user_id = $_GET['user_id'];

$sql = "SELECT id, username, email, bio FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$sql2 = "
SELECT * FROM posts
WHERE user_id = ?
ORDER BY created_at DESC
";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$user_id]);
$posts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "user" => $user,
    "posts" => $posts
]);

?>
