<?php

include "db.php";

// Récupère les données envoyées via FormData
$title   = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$user_id = (int) ($_POST['user_id'] ?? 0);

// Validation des données côté serveur
if (empty($title) || empty($content) || $user_id === 0) {
    echo json_encode(["error" => "Données manquantes."]);
    exit;
}

if (strlen($title) > 100) {
    echo json_encode(["error" => "Titre trop long (max 100 caractères)."]);
    exit;
}

// Gestion de l'image optionnelle
$imagePath = null;

if (!empty($_FILES['image']['name'])) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mime    = mime_content_type($_FILES['image']['tmp_name']);

    if (!in_array($mime, $allowed)) {
        echo json_encode(["error" => "Format d'image non supporté."]);
        exit;
    }

    // Dossier uploads à la racine du backend
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $ext       = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename  = uniqid('img_', true) . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);
    $imagePath = 'uploads/' . $filename;
}

// Insertion en base de données
$sql = "INSERT INTO posts (user_id, title, content, image) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $title, $content, $imagePath]);

echo json_encode(["message" => "Post créé"]);

?>
