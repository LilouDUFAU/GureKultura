<?php

class EvenementDao
{
    private ?PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

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
    
    public function findAllWithCategorie(): array
    {
        $sql = "SELECT evt.evtId, evt.titre, evt.descr, evt.dateEvt, evt.loc, evt.statutEvt, evt.img, cate.nom AS nomCategorie
            FROM gk_evenement AS evt
            JOIN gk_categorie AS cate ON evt.cateId = cate.cateId";

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $evenementTab = $pdoStatement->fetchAll();

        return $this->hydrateAllWithCategorie($evenementTab);
    }


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

        if (is_string($tab['dateDebut'])) {
            $tab['dateDebut'] = new DateTime($tab['dateDebut']);
        }
        if (is_string($tab['dateFin'])) {
            $tab['dateFin'] = new DateTime($tab['dateFin']);
        }
        if (is_string($tab['heureDebut'])) {
            $tab['heureDebut'] = new DateTime($tab['heureDebut']);
        }
        if (is_string($tab['heureFin'])) {
            $tab['heureFin'] = new DateTime($tab['heureFin']);
        }
        $evenement->setPhoto($tab['photo']);

        // Hydratation du nom de la catégorie
        if (isset($tab['userId'])) {
            $evenement->setUserId($tab['userId']);
        }        
        if (isset($tab['cateId'])) {
            $evenement->setCateId($tab['cateId']);
        }

        return $evenement;
    }


    public function hydrateAll(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }

    public function hydrateAllWithCategorie(array $tab): array
    {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }



    // recuperer le nom de categorie associe a chaque evenement (pour la page d'accueil)
    public function findNomCategorie(): array
    {
        $stmt = $this->pdo->prepare("SELECT nom FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }
}