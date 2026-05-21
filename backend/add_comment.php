<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$post_id = $data->post_id;
$user_id = $data->user_id;
$content = $data->content;

$sql = "
INSERT INTO comments(post_id, user_id, content)
VALUES (?, ?, ?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $post_id,
    $user_id,
    $content
]);

// Update comments_count on the post
$sql2 = "
UPDATE posts
SET comments_count = comments_count + 1
WHERE id = ?
";

$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$post_id]);

echo json_encode([
    "message" => "Commentaire ajouté"
]);

?>
