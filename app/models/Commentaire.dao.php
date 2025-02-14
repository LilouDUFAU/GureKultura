<?php

//inclure la classe validator
require_once '../app/controllers/validator.class.php';

class CommentaireDao {
    /**
     * @var PDO
     */
    private ?PDO $pdo;

    /**
     * @constructor CommentaireDao
     * @param PDO|null $pdo
     * @return void
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }


    /**
     * @function getPdo
     * @return PDO|null
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }


    /**
     * @function setPdo
     * @param PDO|null $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }


    /**
     * @function find
     * @details Permet de trouver un événement et par son id
     * @param int|null $id
     * @uses hydrate
     * @return Commentaire|null
     */
    public function find(?int $id): ?Commentaire
    {
        $sql = "SELECT c.commentaireId, c.datePubli, c.contenu, c.actuId, c.userId, c.evtId, u.pseudo 
                FROM gk_commentaire c
                JOIN gk_user u ON c.userId = u.userId
                WHERE c.evtId = :id
                ORDER BY c.datePubli DESC";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CommentaireTab = $pdoStatement->fetch();
        $commentaire = $this->hydrate($CommentaireTab);
        return $commentaire;
    }


    /**
     * @function findAll
     * @details Permet de trouver tous les événements
     * @uses hydrateAll
     * @return array
     */
    public function findAll()
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "commentaire";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CommentaireTab = $pdoStatement->fetchAll();
        $commentaire = $this->hydrateAll($CommentaireTab);
        return $commentaire;
    }

    public function findCommentairesByEvenement($id)
    {
        $sql = "SELECT c.commentaireId, c.datePubli, c.contenu, c.actuId, c.userId, c.evtId, u.pseudo 
                FROM gk_commentaire c
                JOIN gk_user u ON c.userId = u.userId
                WHERE c.evtId = :id
                ORDER BY c.datePubli DESC";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CommentaireTab = $pdoStatement->fetchAll();
        $commentaire = $this->hydrateAll($CommentaireTab);
        return $commentaire;
    }
    public function findCommentairesByActualite($id)
    {
        $sql = "SELECT c.commentaireId, c.datePubli, c.contenu, c.actuId, c.userId, c.evtId, u.pseudo 
                FROM gk_commentaire c
                JOIN gk_user u ON c.userId = u.userId
                WHERE c.actuId = :id
                ORDER BY c.datePubli DESC";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CommentaireTab = $pdoStatement->fetchAll();
        $commentaire = $this->hydrateAll($CommentaireTab);
        return $commentaire;
    }
    /**
     * @function hydrate
     * @details Permet d'hydrater un tableau de données pour créer un objet Commentaire
     * @param array $tab
     * @return Commentaire
     */
    public function hydrate(array $tab): Commentaire
    {
        $commentaire = new Commentaire();
        $commentaire->setCommentaireId($tab['commentaireId']);
        $commentaire->setDatePubli($tab['datePubli']);
        $commentaire->setContenu($tab['contenu']);
        $commentaire->setActuId($tab['actuId']);
        $commentaire->setUserId($tab['userId']);
        $commentaire->setEvtId($tab['evtId']);
        $commentaire->setPseudo($tab['pseudo']);
        return $commentaire;
    }

    /**
     * @function hydrateAll
     * @details Permet d'hydrater un tableau de données pour créer un tableau d'objets Commentaire
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateAll(array $tab): array
    {
        $commentaires = [];
        foreach ($tab as $commentaire) {
            $commentaires[] = $this->hydrate($commentaire);
        }
        return $commentaires;
    }


    /**
     * @function insert
     * @details Permet d'insérer un événement dans la base de données
     * @param Commentaire $commentaire
     * @return void
     */
    public function insert(Commentaire $commentaire): void
    {
        $sql = "INSERT INTO gk_commentaire (contenu, datePubli, evtId, actuId, userId) 
        VALUES (:contenu, NOW(), :evtId, :actuId, :userId)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':contenu' => $commentaire->getContenu(), 
            ':evtId' => $commentaire->getEvtId(), 
            ':actuId' => $commentaire->getActuId(),
            ':userId' => $commentaire->getUserId()
        ]);
    }
}
