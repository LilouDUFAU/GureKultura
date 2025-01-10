<?php 

/**
 * @brief Classe CategorieDao, permettant d'effectuer des requêtes sur la table categorie de la base de données.
 * @details Cette classe utilise le pattern DAO (Data Access Object).
 */
class CategorieDao {

    /**
     * @brief Attribut permettant de stocker la connexion à la base de données
     * @details Cet attribut est privé et ne peut être modifié que par les méthodes de la classe
     */
    private ?PDO $pdo;

    /**
     * @constructor CategorieDao
     * @brief Constructeur de la classe EvenementDao
     * @details Permet d'instancier un objet EvenementDao
     * @return void
     */
    public function __construct(?PDO $pdo=null) {
        $this->pdo = $pdo;
    }

    /**
     * @function getPDO
     * @brief Getter de l'attribut pdo
     * @details Permet de récupérer la connexion à la base de données
     * @return PDO
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }   

    /**
     * @function setPDO
     * @brief Setter de l'attribut pdo
     * @details Permet de modifier la connexion à la base de données        
     * @param PDO $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void {
        $this->pdo = $pdo;
    }

    /**
     * @function find
     * @brief Fonction permettant de récupérer une catégorie en base de données
     * @details Cette fonction permet de récupérer une catégorie en base de données en fonction de son identifiant
     * @param int $id
     * @return Categorie
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
     * @brief Fonction permettant de récupérer toutes les catégories en base de données
     * @details Cette fonction permet de récupérer toutes les catégories en base de données
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
     * @brief Fonction permettant de récupérer les catégories d'événements sportifs en base de données
     * @details Cette fonction permet de récupérer les catégories d'événements sportifs en base de données
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
     * @brief Fonction permettant de récupérer les catégories d'événements culturels en base de données
     * @details Cette fonction permet de récupérer les catégories d'événements culturels en base de données
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
     * @brief Fonction permettant de récupérer les catégories d'actualités sportives en base de données
     * @details Cette fonction permet de récupérer les catégories d'actualités sportives en base de données
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
     * @brief Fonction permettant de récupérer les catégories d'actualités culturelles en base de données
     * @details Cette fonction permet de récupérer les catégories d'actualités culturelles en base de données
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
     * @brief Fonction permettant d'hydrater une catégorie en base de données
     * @details Cette fonction permet d'hydrater une catégorie en base de données
     * @param int|null $id
     * @return Evenement|null
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
     * @brief Fonction permettant d'hydrater un tableau de données en objets Categorie
     * @details Cette fonction permet d'hydrater toutes les catégories
     * @param array $tab
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
     * @brief Fonction permettant de récupérer tout des catégories appartenant à la catégorie originale sport pour chaque evenement
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
     * @brief Fonction permettant de récupérer tout des catégories appartenant à la catégorie originale culture pour chaque evenement
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
     * @brief Fonction permettant de récupérer tout des catégories appartenant à la catégorie originale sport pour chaque actualité
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


    // récupere tout des catégories appartenant a la catégorie originale culture pour chaque actualité
    /**
     * function findCateOriCultureActu
     * @brief Fonction permettant de récupérer tout des catégories appartenant a la catégorie originale culture pour chaque actualité
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