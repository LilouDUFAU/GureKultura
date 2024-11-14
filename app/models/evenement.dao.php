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
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evt WHERE evtId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_CLASS);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }

    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evt";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetchAll();
        $evenement = $this->hydrateAll($EvenementTab);
        return $evenement;
    }

    public function hydrate(array $tab): Evenement {
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