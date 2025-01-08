<?php
require_once 'ajouterUnCommentaire.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = htmlspecialchars($_POST['author']); // Empêche les failles XSS
    $text = htmlspecialchars($_POST['comment']); // Empêche les failles XSS

    if (!empty($author) && !empty($text)) {
        $db = new PDO('mysql:host=lakartxela;dbname=ldufau007_pro', 'ldufau007_pro', 'ldufau007_pro');
        $commentManager = new CommentManager($db);

        if ($commentManager->addComment($author, $text)) {
            $_SESSION['message'] = 'Commentaire ajouté avec succès.';
        } else {
            $_SESSION['error'] = 'Erreur lors de l’ajout du commentaire.';
        }
    } else {
        $_SESSION['error'] = 'Veuillez remplir tous les champs.';
    }

    header('Location: page.php'); // Redirige vers la page des commentaires
    exit;
}
