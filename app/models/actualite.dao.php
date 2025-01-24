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
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli,actu.userId, actu.img,actu.cateId, cate.nom AS nomCategorie
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
        $sql = "SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img, actu.cateId, actu.userId, cate.nom AS nomCategorie
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
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img,actu.userId,actu.cateId, cate.nom AS nomCategorie
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
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli, actu.img ,actu.userId,actu.cateId, cate.nom AS nomCategorie
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
        $sql="SELECT actu.actuId, actu.titre, actu.resume, actu.contenu, actu.datePubli,actu.userId,actu.cateId, actu.img, cate.nom AS nomCategorie
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
        $stmt = $this->pdo->prepare("SELECT userId,nom FROM " . PREFIX_TABLE . "categorie JOIN " . PREFIX_TABLE . "actualite ON " . PREFIX_TABLE . "categorie.cateId = " . PREFIX_TABLE . "actualite.cateId WHERE " . PREFIX_TABLE . "actualite.cateId = " . PREFIX_TABLE . "categorie.cateId");
        $stmt->execute();

        $nomCategories = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($nomCategories);
        return $nomCategories;
    }


    public function findActuByUser(?int $id){
        $sql = "SELECT A.actuId, A.titre, A.resume, A.contenu,DATE(A.datePubli) AS datePubli, A.img, A.userId, A.cateId, cate.nom AS nomCategorie
        FROM gk_actualite AS A
        JOIN gk_categorie AS cate
        ON A.cateId = cate.cateId
        WHERE A.userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateByUser($ActualiteTab);
        return $actualite;
    }

    public function hydrateByUser(array $tab){
        $actualites = [];
        foreach ($tab as $actualite) {
            $actualites[]=$this->hydrate($actualite);
        }
        return $actualites;
    }


    public function findActuById(?int $id){
        $sql = "SELECT A.actuId, A.titre, A.resume, A.contenu,DATE(A.datePubli) AS datePubli, A.img, A.userId, A.cateId, cate.nom AS nomCategorie
        FROM gk_actualite AS A
        JOIN gk_categorie AS cate
        ON A.cateId = cate.cateId
        WHERE A.actuId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $ActualiteTab = $pdoStatement->fetchAll();
        $actualite = $this->hydrateById($ActualiteTab);
        return $actualite;
    }

    public function hydrateById(array $tab){
        $actualites = [];
        foreach ($tab as $actualite) {
            $actualites[]=$this->hydrate($actualite);
        }
        return $actualites;
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
        $actualite->setDatePubli($tab['datePubli']);
        $actualite->setCateId($tab['cateId']);
        $actualite->setNomCategorie($tab['nomCategorie']);
        $actualite->setImg($tab['img']);
        $actualite->setUserId($tab['userId']);
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

    public function delete(Actualite $actualite){
        $sql = "DELETE FROM ".PREFIX_TABLE."actualite WHERE actuId = :actuId";
        $pdoStatement= $this->pdo->prepare($sql);
        $pdoStatement->execute([':actuId' => $actualite->getActuId()]);
    }

    public function update($donnees, $champ, $id){
        $sql = " UPDATE " . PREFIX_TABLE . "actualite SET $champ = :donnees WHERE actuId = :id";
        $pdoStatement= $this->pdo->prepare($sql);
        $pdoStatement->execute([':donnees' => $donnees, ':id'=>$id]);
    }
}