<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';

/**
 * @class EvenementDao
 * @details Permet de lier la base de données à la classe Evenement
 */
class EvenementDao
{
    /**
     * @var PDO
     */
    private ?PDO $pdo;

    /**
     * @constructor EvenementDao
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
     * @return Evenement|null
     */
    public function find(?int $id): ?Evenement
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide , cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }


    /**
     * @function findAll
     * @details Permet de trouver tous les événements
     * @uses hydrateAll
     * @return array
     */
    public function findAll()
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    /**
     * @function findEnCours
     * @details Permet de trouver les événements en cours
     * @param int|null $id
     * @uses hydrateAll
     * @return array
     */
    public function findEnCours(?int $id)
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo,evt.cateId, evt.userId, evt.is_valide , cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.dateDebut = CURRENT_DATE AND evt.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    /**
     * @function findASuivre
     * @details Permet de trouver les événements à suivre
     * @param int|null $id
     * @uses hydrateAll
     * @return array
     */
    public function findASuivre(?int $id)
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo,evt.cateId, evt.userId, evt.is_valide , cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.dateDebut > CURRENT_DATE AND evt.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    /**
     * @function findPasser
     * @details Permet de trouver les événements passés
     * @param int|null $id
     * @uses hydrateAll
     * @return array
     */
    public function findPasser(?int $id)
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide ,cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.dateDebut < CURRENT_DATE AND evt.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    /**
     * @function findAllWithCategorie
     * @details Permet de trouver tous les événements avec leur catégorie
     * @uses hydrateAllWithCategorie
     * @return array
     */
    public function findAllWithCategorie(): array
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide , cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId";

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $evenementTab = $pdoStatement->fetchAll();

        return $this->hydrateAllWithCategorie($evenementTab);
    }


    /**
     * @function findEventByUser
     * @details Permet de trouver les événements de l'utilisateur connecté
     * @param int|null $id
     * @uses hydrateAll
     * @return array
     */
    public function findEventByUser (?int $id)
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide, cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateByUser($EvenementTab);
        return $evenement;
    }


    /**
     * @function findEventById
     * @details Permet de trouver un événement par son id
     * @param int|null $id
     * @uses hydrateById
     * @return Evenement|null
     */
    public function findEventById (?int $id): array
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide, cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateById($EvenementTab);
        return $evenement;
    }
    
    /**
     * @function hydrate
     * @details Permet d'hydrater un tableau de données pour créer un objet Evenement
     * @param array $tab
     * @return Evenement
     */
    public function hydrate(array $tab): Evenement
    {
        $evenement = new Evenement();
        $evenement->setEvtId($tab['evtId']);
        $evenement->setTitre($tab['titre']);
        $evenement->setAutorisation($tab['autorisation']);
        $evenement->setDescription($tab['description']);
        $evenement->setEmail($tab['email']);
        $evenement->setTel($tab['tel']);
        $evenement->setNomRep($tab['nomRep']);
        $evenement->setPrenomRep($tab['prenomRep']);;
        $evenement->setDateDebut($tab['dateDebut']);
        $evenement->setDateFin($tab['dateFin']);
        $evenement->setHeureDebut($tab['heureDebut']);
        $evenement->setHeureFin($tab['heureFin']);
        $evenement->setLieu($tab['lieu']);
        $evenement->setPhoto($tab['photo']);
        $evenement->setCateId($tab['cateId']);     
        $evenement->setUserId($tab['userId']); 
        $evenement->setNomCategorie($tab['nomCategorie']);
        $evenement->setIsValide($tab['is_valide']);
        return $evenement;
    }

    /**
     * @function hydrateAll
     * @details Permet d'hydrater un tableau de données pour créer un tableau d'objets Evenement
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateAll(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }


    /**
     * @function hydrateAllWithCategorie
     * @details Permet d'hydrater un tableau de données pour créer un tableau d'objets Evenement avec leur catégorie
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateAllWithCategorie(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }

    /**
     * @function hydrateByUser
     * @details Permet d'hydrater un tableau de données pour créer un tableau d'objets Evenement
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateByUser(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }

    /**
     * @function hydrateById
     * @details Permet d'hydrater un tableau de données pour créer un objet Evenement
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateById(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }


    /**
     * @function insert
     * @details Permet d'insérer un événement dans la base de données
     * @param Evenement $evenement
     * @return void
     */
    public function insert(Evenement $evenement): void
    {
        $sql = "INSERT INTO " . PREFIX_TABLE . "evenement (userId, titre, autorisation, description, email, tel, nomRep, prenomRep, dateDebut, dateFin, heureDebut, heureFin, lieu, photo, cateId) 
            VALUES (:userId, :titre, :autorisation, :description, :email, :tel, :nomRep, :prenomRep, :dateDebut, :dateFin, :heureDebut, :heureFin, :lieu, :photo, :cateId)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':userId' => $evenement->getUserId(),
            ':titre' => $evenement->getTitre(),
            ':autorisation' => $evenement->getAutorisation(),
            ':description' => $evenement->getDescription(),
            ':email' => $evenement->getEmail(),
            ':tel' => $evenement->getTel(),
            ':nomRep' => $evenement->getNomRep(),
            ':prenomRep' => $evenement->getPrenomRep(),
            ':dateDebut' => $evenement->getDateDebut(),
            ':dateFin' => $evenement->getDateFin(),
            ':heureDebut' => $evenement->getHeureDebut(),
            ':heureFin' => $evenement->getHeureFin(),
            ':lieu' => $evenement->getLieu(),
            ':photo' => $evenement->getPhoto(),
            ':cateId' => $evenement->getCateId()
            
        ]);
    }

    /**
     * @function update
     * @details Permet de mettre à jour un événement dans la base de données
     * @param integer $id
     * @return void
     */
    public function update($donnees, $champ, $id){
        $sql = "UPDATE " . PREFIX_TABLE . "evenement SET $champ = :donnees WHERE evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':donnees' => $donnees, ':id' => $id]);
    }

    /**
     * @function updateValid
     * @details Permet de mettre à jour un événement dans la base de données
     * @param Evenement $evenement
     * @return void
     */
    public function updateValid(Evenement $evenement): void {
        $sql = "UPDATE " . PREFIX_TABLE . "evenement SET is_valide = :is_valide WHERE evtId = :evtId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':is_valide' => $evenement->getIsValide(), ':evtId' => $evenement->getEvtId()]);
    }

    /**
     * @brief Fonction permettant de supprimer un evenement en base de données
     * @details Cette fonction permet de supprimer un utilisateur en base de données si ce dernier sdouhaite supprimer son compte
     * @param Evenement $evenement
     * @return void
     */
    public function delete(Evenement $evenement): void {
        // cette fonction permet de supprimer un utilisateur en base en supprimant dabord ses commentaires puis ses actualités puis ses evenement puis l'utilisateur
        $sql = "DELETE FROM " . PREFIX_TABLE . "evenement WHERE evtId = :evtId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':evtId' => $evenement->getEvtId()]);       
    }

    public function findNotValid()
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide , cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId WHERE evt.is_valide = 0";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    public function inscrireUtilisateur($userId, $evtId) {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, evt.cateId, evt.userId, evt.is_valide, cate.nom AS nomCategorie FROM gk_evenement AS evt 
                JOIN gk_participer ON evt.evtId = gk_participer.evtId 
                JOIN gk_categorie AS cate ON evt.cateId = cate.cateId
                WHERE gk_participer.evtId = :evtId AND gk_participer.userId = :userId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':userId' => $userId , ':evtId' => $evtId]);
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();  
        $evenement = $this->hydrateById($EvenementTab);

        //$sql = "INSERT INTO participer (userId, evtId, dateInscr) VALUES (?, ?, NOW())";


        return $evenement;
    }

}