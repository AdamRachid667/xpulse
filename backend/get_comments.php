<?php

include "db.php";

// Validation du paramètre GET
$post_id = (int) ($_GET['post_id'] ?? 0);

if ($post_id === 0) {
    echo json_encode([]);
    exit;
}

// Récupère les commentaires avec le nom d'utilisateur, triés par date croissante
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
