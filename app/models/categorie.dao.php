<?php 

/**
 * @Class CategorieDao
 * @details Classe CategorieDao, permettant d'effectuer des requêtes sur la table categorie de la base de données. Utilise le pattern DAO (Data Access Object).
 */
class CategorieDao {

    /**
     * @var PDO
     */
    private ?PDO $pdo;

    /**
     * @constructor CategorieDao
     * @param PDO|null $pdo
     * @return void
     */
    public function __construct(?PDO $pdo=null) {
        $this->pdo = $pdo;
    }

    /**
     * @function getPDO
     * @return PDO|null
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }   

    /**
     * @function setPDO     
     * @param PDO|null $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void {
        $this->pdo = $pdo;
    }

    /**
     * @function find
     * @details Cette fonction permet de récupérer une catégorie en base de données en fonction de son identifiant
     * @param int|null $id
     * @uses hydrate
     * @return Categorie|null
     */
    public function find(?int $id): ?Categorie {
        $sql="SELECT * FROM " . PREFIX_TABLE . "categorie WHERE cateId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetch();
        $categorie = $this->hydrate($CategorieTab);
        return $categorie;
    }

    /**
     * @function findAll
     * @details Cette fonction permet de récupérer toutes les catégories en base de données
     * @uses hydrateAll
     * @return array
     */
    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "categorie";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $CategorieTab = $pdoStatement->fetchAll();
        $categorie = $this->hydrateAll($CategorieTab);
        return $categorie;
    }

    /**
     * @function findEvtSport
     * @details Cette fonction permet de récupérer les catégories d'événements sportifs en base de données
     * @uses hydrateAll
     * @return array
     */
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

    /**
     * @function findEvtCult
     * @details Cette fonction permet de récupérer les catégories d'événements culturels en base de données
     * @uses hydrateAll
     * @return array
     */
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

    /**
     * @function findActuSport
     * @details Cette fonction permet de récupérer les catégories d'actualités sportives en base de données
     * @uses hydrateAll
     * @return array
     */
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

    /**
     * @function findActuCult
     * @details Cette fonction permet de récupérer les catégories d'actualités culturelles en base de données
     * @uses hydrateAll
     * @return array
     */
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

    /**
     * @function hydrate
     * @details Cette fonction permet d'hydrater une catégorie en base de données
     * @param array $tab
     * @return Evenement
     */
    public function hydrate(array $tab): Categorie {
        $categorie = new Categorie();
        $categorie->setCateId($tab['cateId']);
        $categorie->setNom($tab['nom']);
        $categorie->setCategorieOriginale($tab['categorieOriginale']);
        $categorie->setImg($tab['img']);
        return $categorie;
    }

    /**
     * function hydrateAll
     * @details Cette fonction permettant d'hydrater un tableau de données en objets Categorie
     * @param array $tab
     * @uses hydrate
     * @return array
     */
    public function hydrateAll(array $tab): array {
        $categories = [];
        foreach ($tab as $categorie) {
            $categories[] = $this->hydrate($categorie);
        }
        return $categories;
    } 

    /**
     * function findCateOriSportEvt
     * @details Cette fonction permet de récupérer tout des catégories appartenant à la catégorie originale sport pour chaque evenement
     * @return array
     */
    public function findCateOriSportEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId AND " . PREFIX_TABLE . "categorie.categorieOriginale = 1");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    /**
     * function findCateOriCultureEvt
     * @details Cette fonction permet de récupérer tout des catégories appartenant à la catégorie originale culture pour chaque evenement
     * @return array
     */
    public function findCateOriCultureEvt(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "evenement ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "evenement.cateId WHERE " . PREFIX_TABLE . "evenement.cateId = " . PREFIX_TABLE . "categorie.cateId AND " . PREFIX_TABLE . "categorie.categorieOriginale = 2");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    /**
     * function findCateOriSportActu
     * @details Cette fonction permet de récupérer tout des catégories appartenant à la catégorie originale sport pour chaque actualité
     * @return array
     */
    public function findCateOriSportActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId AND" . PREFIX_TABLE . "categorie.categorieOriginale = 1");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    /**
     * function findCateOriCultureActu
     * @details Cette fonction permet de récupérer tout des catégories appartenant a la catégorie originale culture pour chaque actualité
     * @return array
     */
    public function findCateOriCultureActu(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId AND" . PREFIX_TABLE . "categorie.categorieOriginale = 2");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }

}