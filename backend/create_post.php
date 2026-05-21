<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$title = $data->title;
$content = $data->content;
$user_id = $data->user_id;

$sql = "
INSERT INTO posts(user_id, title, content)
VALUES (?, ?, ?)
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $user_id,
    $title,
    $content
]);

echo json_encode([
    "message" => "Post créé"
]);

?>
