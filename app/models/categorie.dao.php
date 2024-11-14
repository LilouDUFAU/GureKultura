<?php 

class CategorieDao {

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

    public function find(?int $id): ?Categorie {
        $sql="SELECT * FROM " . PREFIX_TABLE . "categorie WHERE cateId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetch();
        $categorie = $this->hydrate($CategorieTab);
        return $categorie;
    }

    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "categorie";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetchAll();
        $categorie = $this->hydrateAll($CategorieTab);
        return $categorie;
    }

    public function hydrate(array $tab): Categorie {
        $categorie = new Categorie();
        $categorie->setCateId($tab['cateId']);
        $categorie->setNom($tab['nom']);
        $categorie->setCateId_cateOri($tab['cateId_cateOri']);
        $categorie->setImg($tab['img']);
        return $categorie;
    }

    public function hydrateAll(array $tab): array {
        $categories = [];
        foreach ($tab as $categorie) {
            $categories[] = $this->hydrate($categorie);
        }
        return $categories;
    }
}