<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';

class ActualiteDao {
    /**
     * @var PDO|null
     */
    private ?PDO $pdo;

    /**
     * @param PDO|null $pdo
     */
    public function __construct(?PDO $pdo=null) {
        $this->pdo = $pdo;
    }

    /**
     * @return PDO|null
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    /**
     * @param PDO|null $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void {
        $this->pdo = $pdo;
    }

    /**
     * @param integer|null $id
     * @return Actualite|null
     */
    public function find(?int $id): ?Actualite {
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, cate.nom AS nomCategorie
            FROM gk_actualite AS actu
            JOIN gk_categorie AS cate ON actu.cateId = cate.cateId WHERE actu.actuId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetch();
        $actualite = $this->hydrate($ActualiteTab);
        return $actualite;
    }

    /**
     * @return void
     */
    public function findAll() {
        $sql="SELECT * FROM " . PREFIX_TABLE . "actualite";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }

    /**
     * @return array
     */
    public function findAllWithCategorie(): array
    {
        $sql = "SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, cate.nom AS nomCategorie
            FROM gk_actualite AS actu
            JOIN gk_categorie AS cate ON actu.cateId = cate.cateId";

        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $actualiteTab = $pdoStatement->fetchAll();

        return $this->hydrateAllWithCategorie($actualiteTab);
    }
    
    /**
     * @param integer|null $id
     * @return void
     */
    public function findEnCours(?int $id) {
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, cate.nom AS nomCategorie
            FROM gk_actualite AS actu
            JOIN gk_categorie AS cate ON actu.cateId = cate.cateId WHERE actu.datePubli = CURRENT_DATE AND actu.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }
    
    /**
     * @param integer|null $id
     * @return void
     */
    public function findASuivre(?int $id) {
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, cate.nom AS nomCategorie
            FROM gk_actualite AS actu
            JOIN gk_categorie AS cate ON actu.cateId = cate.cateId WHERE actu.datePubli > CURRENT_DATE AND actu.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }
    
    /**
     * @param integer|null $id
     * @return void
     */
    public function findPasser(?int $id) {
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, cate.nom AS nomCategorie
            FROM gk_actualite AS actu
            JOIN gk_categorie AS cate ON actu.cateId = cate.cateId WHERE actu.datePubli < CURRENT_DATE AND actu.cateId =:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateAll($ActualiteTab);
        return $actualite;
    }

    /**
     * @brief Fonction permettant de récupérer le nom de la catégorie en base de données
     * @details Cette fonction permet de récupérer le nom de la catégorie en base de données
     * @return array
     */
    public function findNomCategorie(): array
    {
        $stmt = $this->pdo->prepare("SELECT nom FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }

    /**
     * @param array $tab
     * @return Actualite
     */
    public function hydrate(array $tab): Actualite {
        $actualite = new Actualite();
        $actualite->setActuId($tab['actuId']);
        $actualite->setTitre($tab['titre']);
        $actualite->setResume($tab['resume']);        
        $actualite->setContenu($tab['contenu']);
        if (is_string($tab['datePubli'])) {
            $tab['datePubli'] = new DateTime($tab['datePubli']);
        }

        // if(is_date($tab['datePubli'])) {
        //     $tab['dateInscr'] = new DateTime($tab['datePubli']);
            $actualite->setDatePubli($tab['datePubli']);
        // }
        
        $actualite->setImg($tab['img']);


        // On vérifie si la clé 'cateId' existe
        if (isset($tab['cateld'])) {
            $cateld = $tab['cateld'];
        } else {
            $cateld = null; // Ou une valeur par défaut
        }
        $actualite->setCateId($cateld); 
        $actualite->setNomCategorie($tab['nomCategorie']);
        // verifier si l'utilisateur est connecté
        if (isset($_SESSION['userId'])) {
            $actualite->setUserId($_SESSION['userId']);
            $actualite->setNomCategorie($tab['nomCategorie']);
        }
        return $actualite;
    }

    /**
     * @param array $tab
     * @return array
     */
    public function hydrateAll(array $tab): array {
        $actualites = [];
        foreach ($tab as $actualite) {
            $actualites[] = $this->hydrate($actualite);
        }
        return $actualites;
    }

    /**
     * @param array $tab
     * @return array
     */
    public function hydrateAllWithCategorie(array $tab): array {
        $actualites = [];
        foreach ($tab as $actualite) {
            $actualites[] = $this->hydrate($actualite);
        }
        return $actualites;
    }

    /**
     * @param Actualite $actualite
     * @return void
     */
    public function insert(Actualite $actualite): void
    {
        $sql = "INSERT INTO " . PREFIX_TABLE . "actualite (titre, resume, contenu, datePubli, img, cateId, userId)
            VALUES (:titre, :resume, :contenu, :datePubli, :img, :cateId, :userId)"; 
            $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':titre' => $actualite->getTitre(),
            ':resume' => $actualite->getResume(),
            ':contenu' => $actualite->getContenu(),
            ':datePubli' => $actualite->dateActuelle(),
            ':img' => $actualite->getImg() ?? null,
            ':cateId' => $actualite->getCateId(),
            ':userId' => $actualite->getUserId()
        ]);
    }
}