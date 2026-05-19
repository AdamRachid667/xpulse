<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$sql = "
UPDATE posts
SET likes = likes + 1
WHERE id = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$id]);

echo json_encode([
    "message" => "Like ajouté"
]);

?>