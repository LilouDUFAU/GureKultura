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
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evt WHERE evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evt";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    public function findAllWithCategorie(): array
    {
        $sql = "SELECT evt.evtId, evt.titre, evt.descr, evt.dateEvt, evt.loc, evt.statutEvt, evt.img, cate.nom AS nomCategorie
            FROM gk_evt AS evt
            JOIN gk_cate AS cate ON evt.cateId = cate.cateId";

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
        $evenement->setDescr($tab['descr']);

        if (is_string($tab['dateEvt'])) {
            $tab['dateEvt'] = new DateTime($tab['dateEvt']);
        }
        $evenement->setDateEvt($tab['dateEvt']);
        $evenement->setLoc($tab['loc']);
        $evenement->setStatutEvt($tab['statutEvt']);
        $evenement->setImg($tab['img']);

        // Hydratation du nom de la catégorie
        if (isset($tab['nomCategorie'])) {
            $evenement->setNomCategorie($tab['nomCategorie']);
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
        $stmt = $this->pdo->prepare("SELECT nom FROM " . PREFIX_TABLE . "cate JOIN " . PREFIX_TABLE . "evt ON " . PREFIX_TABLE . "cate.cateId = " . PREFIX_TABLE . "evt.cateId WHERE " . PREFIX_TABLE . "evt.cateId = " . PREFIX_TABLE . "cate.cateId");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }
}