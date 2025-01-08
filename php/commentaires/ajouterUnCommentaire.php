<?php
require_once 'ajouterUnCommentaire.php';

header('Content-Type: application/json'); // Retourner du JSON
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $contenu = $data['contenu'] ?? '';
    $actuId = $data['actuId'] ?? null; // Peut être null
    $evtId = $data['evtId'] ?? null; // Peut être null
    $userId = $_SESSION['userId'] ?? null; // Assure que l'utilisateur est connecté

    if ($userId && !empty($contenu)) {
        $db = new PDO('mysql:host=lakartxela;dbname=ldufau007_pro', 'ldufau007_pro', 'ldufau007_pro');
        $commentManager = new CommentManager($db);

        if ($commentManager->addComment($contenu, $actuId, $evtId, $userId)) {
            echo json_encode(['success' => true, 'message' => 'Commentaire ajouté avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l’ajout du commentaire.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Contenu ou utilisateur invalide.']);
    }
    exit;
}
