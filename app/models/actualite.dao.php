<?php

class ActualiteDao {
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

    public function find(?int $id): ?Actualite {
        $sql="SELECT * FROM " . PREFIX_TABLE . "actu WHERE actuId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetch();
        $actualite = $this->hydrate($ActualiteTab);
        return $actualite;
    }

    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "actu";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }

    public function hydrate(array $tab): Actualite {
        $actualite = new Actualite();
        $actualite->setActuId($tab['actuId']);
        $actualite->setTitre($tab['titre']);
        $actualite->setFicResume($tab['ficResume']);
        $actualite->setFicContenu($tab['ficContenu']);
        if (is_string($tab['datePubli'])) {
            $tab['datePubli'] = new DateTime($tab['datePubli']);
        }
        $actualite->setDatePubli($tab['datePubli']);
        $actualite->setImg($tab['img']);
        return $actualite;
    }

    public function hydrateAll(array $tab): array {
        $actualites = [];
        foreach ($tab as $actualite) {
            $actualites[] = $this->hydrate($actualite);
        }
        return $actualites;
    }
}