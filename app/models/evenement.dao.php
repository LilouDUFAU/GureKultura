<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';

/**
 * @brief Classe EvenementDao, permettant d'effectuer des requêtes sur la table evenement de la base de données.
 * @details Cette classe utilise le pattern DAO (Data Access Object).
 */
class EvenementDao
{

    /**
     * @brief Attribut permettant de stocker la connexion à la base de données
     * @details Cet attribut est privé et ne peut être modifié que par les méthodes de la classe
     * @var PDO
     */
    private ?PDO $pdo;


    /**
     * @brief Constructeur de la classe EvenementDao
     * @details Permet d'instancier un objet EvenementDao
     * @param mixed $pdo
     * @return void
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }


    /**
     * @brief Getter de l'attribut pdo
     * @details Permet de récupérer la connexion à la base de données
     * @return PDO
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }


    /**
     * @brief Setter de l'attribut pdo
     * @details Permet de modifier la connexion à la base de données        
     * @param PDO $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }


    /**
     * @brief Fonction permettant de récupérer un événement en base de données
     * @details Cette fonction permet de récupérer un événement en base de données en fonction de son identifiant
     * @param int $id
     * @return Evenement
     */
    public function find(?int $id): ?Evenement
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }


    /**
     * @brief Fonction permettant de récupérer tous les événements en base de données
     * @details Cette fonction permet de récupérer tous les événements en base de données
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
     * @brief Fonction permettant de récupérer les événements en cours en base de données
     * @details Cette fonction permet de récupérer les événements en cours en base de données
     * @param int|null $id
     * @return array
     */
    public function findEnCours(?int $id)
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE dateDebut = CURRENT_DATE AND cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }


    /**
     * @brief Fonction permettant de récupérer les événements à venir en base de données
     * @details Cette fonction permet de récupérer les événements à venir en base de données
     * @param int|null $id
     * @return array
     */
    public function findASuivre(?int $id)
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE dateDebut > CURRENT_DATE AND cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }


    /**
     * @brief Fonction permettant de récupérer les événements passés en base de données
     * @details Cette fonction permet de récupérer les événements passés en base de données
     * @param int|null $id
     * @return array
     */
    public function findPasser(?int $id)
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE dateDebut < CURRENT_DATE AND cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }


    /**
     * @brief Fonction permettant de récupérer tous les événements avec leur catégorie en base de données
     * @details Cette fonction permet de récupérer tous les événements avec leur catégorie en base de données
     * @return array
     */
    public function findAllWithCategorie(): array
    {
        $sql = "SELECT evt.evtId, evt.titre,evt.autorisation, evt.description, evt.email, evt.tel, evt.nomRep, evt.prenomRep, DATE(evt.dateDebut) AS dateDebut, DATE(evt.dateFin) AS dateFin, TIME(evt.heureDebut) AS heureDebut, TIME(evt.heureFin) AS heureFin, evt.lieu, evt.photo, cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId";

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $evenementTab = $pdoStatement->fetchAll();

        return $this->hydrateAllWithCategorie($evenementTab);
    }



    /**
     * @brief Fonction permettant de récupérer un événement avec sa catégorie en base de données
     * @details Cette fonction permet de récupérer un événement avec sa catégorie en base de données
     * @param int|null $id
     * @return Evenement|null
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
        $evenement->setPrenomRep($tab['prenomRep']);

        if (is_date($tab['dateDebut'])) {
            $tab['dateDebut'] = new DateTime($tab['dateDebut']);
            $evenement->setDateDebut($tab['dateDebut']);
        }
        if (is_date($tab['dateFin'])) {
            $tab['dateFin'] = new DateTime($tab['dateFin']);
            $evenement->setDateFin($tab['dateFin']);
        }
        if (is_time($tab['heureDebut'])) {
            $tab['heureDebut'] = new DateTime($tab['heureDebut']);
            $evenement->setHeureDebut($tab['heureDebut']);
        }
        if (is_time($tab['heureFin'])) {
            $tab['heureFin'] = new DateTime($tab['heureFin']);
            $evenement->setHeureFin($tab['heureFin']);
        }
        $evenement->setLieu($tab['lieu']);
        $evenement->setPhoto($tab['photo']);

        // On vérifie si la clé 'cateId' existe
        if (isset($tab['cateld'])) {
            $cateld = $tab['cateld'];
        } else {
            $cateld = null; // Ou une valeur par défaut
        }
        $evenement->setCateId($cateld);      
        $evenement->setNomCategorie($tab['nomCategorie']);

        // verifier si l'utilisateur est connecté
        if (isset($_SESSION['userId'])) {
            $evenement->setUserId($_SESSION['userId']);
            $evenement->setNomCategorie($tab['nomCategorie']);
        }

        return $evenement;
    }


    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets Evenement
     * @details Cette fonction permet de récupérer tous les événements avec leur catégorie en base de données
     * @param array $tab
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
     * @brief Fonction permettant de récupérer tous les événements avec leur catégorie en base de données
     * @details Cette fonction permet de récupérer tous les événements avec leur catégorie en base de données
     * @param array $tab
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
     * @brief Fonction permettant de récupérer le nom de la catégorie en base de données
     * @details Cette fonction permet de récupérer le nom de la catégorie en base de données
     * @return array
     */
    public function findNomCategorie(): array
    {
        $stmt = $this->pdo->prepare("SELECT nom FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    /**
     * @brief Fonction permettant d'inserer un événement en base de données
     * @details Cette fonction permet d'inserer un événement en base de données en fonction de son identifiant
     * @param int|null $id
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
            ':dateDebut' => $evenement->getDateDebut()->format('Y-m-d'),
            ':dateFin' => $evenement->getDateFin()->format('Y-m-d'),
            ':heureDebut' => $evenement->getHeureDebut()->format('H:i'),
            ':heureFin' => $evenement->getHeureFin()->format('H:i'),
            ':lieu' => $evenement->getLieu(),
            ':photo' => $evenement->getPhoto(),
            ':cateId' => $evenement->getCateId()
        ]);
    }
}