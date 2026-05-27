<?php

include "db.php";

// Validation du paramètre de recherche
$q = trim($_GET['q'] ?? '');

if (empty($q)) {
    echo json_encode(["posts" => [], "users" => []]);
    exit;
}

$like = "%" . $q . "%";

// Recherche dans les posts (titre et contenu)
$sql = "
SELECT posts.*, users.username
FROM posts
JOIN users ON posts.user_id = users.id
WHERE posts.title LIKE ? OR posts.content LIKE ?
ORDER BY posts.created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$like, $like]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recherche dans les utilisateurs (par pseudo)
$sql2 = "SELECT id, username FROM users WHERE username LIKE ?";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$like]);
$users = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["posts" => $posts, "users" => $users]);

?>
