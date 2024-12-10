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
        $sql="SELECT * FROM " . PREFIX_TABLE . "cate WHERE cateId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetch();
        $categorie = $this->hydrate($CategorieTab);
        return $categorie;
    }

    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "cate";
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

    // recupere tout des categories appartenant a la categorie originale sport pour chaque evenement (pour la page categorie)
    public function findCateOriSportEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "cate JOIN " . PREFIX_TABLE . "evt ON " . PREFIX_TABLE . "cate.cateId = " . PREFIX_TABLE . "evt.cateId WHERE " . PREFIX_TABLE . "evt.cateId = " . PREFIX_TABLE . "cate.cateId AND" . PREFIX_TABLE . "cate.cateId_cateOri = 'sport'");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale culture pour chaque evenement (pour la page categorie)
    public function findCateOriCultureEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "cate JOIN " . PREFIX_TABLE . "evt ON " . PREFIX_TABLE . "cate.cateId = " . PREFIX_TABLE . "evt.cateId WHERE " . PREFIX_TABLE . "evt.cateId = " . PREFIX_TABLE . "cate.cateId AND" . PREFIX_TABLE . "cate.cateId_cateOri = 'culture'");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale sport pour chaque actualite (pour la page categorie)
    public function findCateOriSportActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "cate JOIN " . PREFIX_TABLE . "actu ON " . PREFIX_TABLE . "cate.cateId = " . PREFIX_TABLE . "actu.cateId WHERE " . PREFIX_TABLE . "actu.cateId = " . PREFIX_TABLE . "cate.cateId AND" . PREFIX_TABLE . "cate.cateId_cateOri = 'sport'");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    // recupere tout des categories appartenant a la categorie originale culture pour chaque actualite (pour la page categorie)
    public function findCateOriCultureActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "cate JOIN " . PREFIX_TABLE . "actu ON " . PREFIX_TABLE . "cate.cateId = " . PREFIX_TABLE . "actu.cateId WHERE " . PREFIX_TABLE . "actu.cateId = " . PREFIX_TABLE . "cate.cateId AND" . PREFIX_TABLE . "cate.cateId_cateOri = 'culture'");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }

}