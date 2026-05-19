<?php

include "db.php";

$sql = "
SELECT posts.*, users.username
FROM posts
JOIN users ON posts.user_id = users.id
ORDER BY created_at DESC
";

$posts = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($posts);

?>