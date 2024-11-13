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
        $sql="SELECT * FROM " . PREFIX_TABLE . "actualite WHERE id_actualite = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetch();
        $actualite = $this->hydrate($ActualiteTab);
        return $actualite;
    }

    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "actualite";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }

    public function hydrate(array $tab): Actualite {
        $actualite = new Actualite();
        $actualite->setId($tab['id_actualite']);
        $actualite->setType($tab['type']);
        $actualite->setTitre($tab['titre']);
        $actualite->setResume($tab['resume']);
        if (is_string($tab['date_publication'])) {
            $tab['date_publication'] = new DateTime($tab['date_publication']);
        }
        $actualite->setDatePublication($tab['date_publication']);
        $actualite->setImage($tab['image']);
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