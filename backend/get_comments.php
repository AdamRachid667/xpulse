<?php

include "db.php";

$post_id = $_GET['post_id'];

$sql = "
SELECT comments.*, users.username
FROM comments
JOIN users ON comments.user_id = users.id
WHERE comments.post_id = ?
ORDER BY comments.created_at ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$post_id]);

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($comments);

?>
