<?php

include "db.php";

$data = json_decode(file_get_contents("php://input"));

$user_id = $data->user_id;
$bio = $data->bio;

$sql = "UPDATE users SET bio = ? WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$bio, $user_id]);

echo json_encode([
    "message" => "Bio mise à jour"
]);

?>
