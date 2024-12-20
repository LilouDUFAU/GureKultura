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

    public function findEvtSport() {
        $sql="SELECT DISTINCT(gk_evenement.cateId), gk_categorie.nom, gk_categorie.cateId, gk_categorie.categorieOriginale, gk_categorie.img 
        FROM gk_evenement 
        JOIN gk_categorie ON gk_evenement.cateId = gk_categorie.cateId
        WHERE gk_categorie.categorieOriginale = 1";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetchAll();
        $categorie = $this->hydrateAll($CategorieTab);
        return $categorie;
    }
    public function findEvtCult() {
        $sql="SELECT DISTINCT(gk_evenement.cateId), gk_categorie.nom, gk_categorie.cateId, gk_categorie.categorieOriginale, gk_categorie.img 
        FROM gk_evenement 
        JOIN gk_categorie ON gk_evenement.cateId = gk_categorie.cateId
        WHERE gk_categorie.categorieOriginale = 2";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetchAll();
        $categorie = $this->hydrateAll($CategorieTab);
        return $categorie;
    }

    public function findActuSport() {
        $sql="SELECT DISTINCT(gk_actualite.cateId), gk_categorie.nom, gk_categorie.cateId, gk_categorie.categorieOriginale, gk_categorie.img
        FROM gk_actualite 
        JOIN gk_categorie ON gk_actualite.cateId = gk_categorie.cateId
        WHERE gk_categorie.categorieOriginale = 1";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetchAll();
        $categorie = $this->hydrateAll($CategorieTab);
        return $categorie;
    }
    public function findActuCult() {
        $sql="SELECT DISTINCT(gk_actualite.cateId), gk_categorie.nom, gk_categorie.cateId, gk_categorie.categorieOriginale, gk_categorie.img
        FROM gk_actualite 
        JOIN gk_categorie ON gk_actualite.cateId = gk_categorie.cateId
        WHERE gk_categorie.categorieOriginale = 2";
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
        $categorie->setCategorieOriginale($tab['categorieOriginale']);
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

    // recupere tout des categories appartenant a la categorie originale sport pour chaque evenement (pour la page categorie)
    public function findCateOriSportEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId AND " . PREFIX_TABLE . "categorie.categorieOriginale = 1");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale culture pour chaque evenement (pour la page categorie)
    public function findCateOriCultureEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId AND " . PREFIX_TABLE . "categorie.categorieOriginale = 2");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale sport pour chaque actualite (pour la page categorie)
    public function findCateOriSportActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId AND" . PREFIX_TABLE . "categorie.categorieOriginale = 1");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale culture pour chaque actualite (pour la page categorie)
    public function findCateOriCultureActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId AND" . PREFIX_TABLE . "categorie.categorieOriginale = 2");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }

}