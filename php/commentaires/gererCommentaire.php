<?php
require_once 'gererCommentaire.php'; // Fichier pour établir la connexion PDO

class CommentManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un commentaire
    public function addComment($author, $text) {
        $query = 'INSERT INTO gk_commentaire (author, text, created_at) VALUES (:author, :text, NOW())';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':text', $text);
        return $stmt->execute();
    }

    // Récupérer les commentaires
    public function getComments() {
        $query = 'SELECT * FROM gk_commentaire ORDER BY created_at DESC';
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
