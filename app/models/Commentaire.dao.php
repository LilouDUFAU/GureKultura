<?php

//inclure la classe validator
require_once '../app/controllers/validator.class.php';

class CommentaireDao {
    private ?PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo): void {
        $this->pdo = $pdo;
    }

    public function findCommentairesByEventOrActu($id, $type) {
        // Initialisation de la requête SQL
        if ($type == "Evenements") {
            $sql = "SELECT c.contenu, c.datePubli, u.nom AS userNom 
                    FROM gk_commentaire c
                    JOIN gk_user u ON c.userId = u.userId
                    WHERE c.evtId = :id
                    ORDER BY c.datePubli DESC";
        } elseif ($type == "Actualites") {
            $sql = "SELECT c.contenu, c.datePubli, u.nom AS userNom 
                    FROM gk_commentaire c
                    JOIN gk_user u ON c.userId = u.userId
                    WHERE c.actuId = :id
                    ORDER BY c.datePubli DESC";
        } else {
            echo "Erreur : Type invalide.";
            return [];
        }

        // Exécution de la requête
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Récupérer les résultats sous forme d'objets Commentaire
        $commentaires = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convertir la date en objet DateTime
            $datePubli = new DateTime($row['datePubli']);
            $commentaires[] = new Commentaire($row['contenu'], $datePubli, $row['userNom']);
        }


        return $commentaires;
    }

    public function ajouterCommentaire($contenu, $evtId, $actuId, $userId) {
        $sql = "INSERT INTO gk_commentaire (contenu, datePubli, evtId, actuId, userId) 
                VALUES (:contenu, NOW(), :evtId, :actuId, :userId)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':contenu' => $contenu, 
            ':evtId' => $evtId, 
            ':actuId' => $actuId, 
            ':userId' => $userId
        ]);
    }
}
