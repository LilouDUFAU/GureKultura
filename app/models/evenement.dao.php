<?php

class EvenementDao {
    private ?PDO $pdo;

    public function __construct(?PDO $pdo=null) {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void {
        $this->pdo = $pdo;
    }

    public function find(?int $id): ?Evenement {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE id = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }

    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    public function hydrate(array $tab): Evenement {
        $evenement = new Evenement();
        $evenement->setId($tab['Id']);
        $evenement->setTitre($tab['titre']);
        $evenement->setDescription($tab['description']);
        if (is_string($tab['date_evt'])) {
            $tab['date_evt'] = new DateTime($tab['date_evt']);
        }
        $evenement->setDate($tab['date_evt']);
        $evenement->setLieu($tab['localisation']);
        $evenement->setStatus($tab['status_evt']);
        return $evenement;
    }

    public function hydrateAll(array $tab): array {
        $evenements = [];
        foreach ($tab as $evenement) {
            $evenements[] = $this->hydrate($evenement);
        }
        return $evenements;
    }
}