<?php
require_once 'gererCommentaire.php'; // Fichier pour établir la connexion PDO

class CommentManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un commentaire
    public function addComment($contenu, $actuId = null, $evtId = null, $userId) {
        $query = 'INSERT INTO gk_commentaire (contenu, datePubli, actuId, evtId, userId) 
                  VALUES (:contenu, NOW(), :actuId, :evtId, :userId)';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':actuId', $actuId);
        $stmt->bindParam(':evtId', $evtId);
        $stmt->bindParam(':userId', $userId);

        return $stmt->execute();
    }

    // Récupérer les commentaires (optionnellement filtrés par actuId ou evtId)
    public function getComments($actuId = null, $evtId = null) {
        $query = 'SELECT commentaireId, contenu, datePubli, actuId, evtId, userId 
                  FROM gk_commentaire 
                  WHERE 1 = 1';

        if ($actuId) {
            $query .= ' AND actuId = :actuId';
        }
        if ($evtId) {
            $query .= ' AND evtId = :evtId';
        }

        $query .= ' ORDER BY datePubli DESC';
        $stmt = $this->pdo->prepare($query);

        if ($actuId) {
            $stmt->bindParam(':actuId', $actuId);
        }
        if ($evtId) {
            $stmt->bindParam(':evtId', $evtId);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}