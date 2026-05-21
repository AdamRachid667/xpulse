<?php

include "db.php";

$q = $_GET['q'];
$like = "%" . $q . "%";

$sql = "
SELECT posts.*, users.username
FROM posts
JOIN users ON posts.user_id = users.id
WHERE posts.title LIKE ? OR posts.content LIKE ?
ORDER BY created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$like, $like]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT id, username FROM users WHERE username LIKE ?";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$like]);
$users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "posts" => $posts,
    "users" => $users
]);

?>
