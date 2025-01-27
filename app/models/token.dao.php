<?php 
//inclure la classe validator
require_once '../app/controllers/validator.class.php';

/**
 * @brief Classe TokenDao, permettant d'effectuer des requêtes sur la table token de la base de données
 * @details Cette classe utilise le pattern DAO (Data Access Object)
 */
class TokenDao {
    /**
     * @brief Attribut permettant de stocker la connexion à la base de données
     * @details Cet attribut est privé, il ne pourra être modifié que par les méthodes de la classe
     * @var PDO
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe TokenDao
     * @details Permet d'initialiser la connexion à la base de données
     * @param mixed $pdo
     * @return void
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * @brief getter de l'attribut pdo
     * @details Permet de récupérer la connexion à la base de données
     * @return PDO
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    /**
     * @brief setter de l'attribut pdo
     * @details Permet de modifier la connexion à la base de données
     * @param PDO $pdo
     * @return void
     */
    public function setPdo(PDO $pdo): void {
        $this->pdo = $pdo;
    }

    /**
     * @brief Fonction permettant de récupérer un token en base de données en fonction de son id
     * @details Cette fonction permet de récupérer un token en base de données en fonction de son id
     * @param int $id
     * @return Token|null
     */
    public function find(?string $token): ?Token {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "token WHERE token = :token";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':token' => $token));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $TokenTab = $pdoStatement->fetch();
        $token = $this->hydrate($TokenTab);
        return $token;
    }

    /**
     * @brief Fonction permettant de récupérer un token en base de données en fonction de son id
     * @details Cette fonction permet de récupérer un token en base de données en fonction de son id
     * @param int $id
     * @return Token|null
     */
    public function findUserId(?int $userId): ?Token {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "token WHERE userId = :userId";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':userId' => $userId));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $TokenTab = $pdoStatement->fetch();
        if($TokenTab == false) {
            return null;
        }else{
            $token = $this->hydrate($TokenTab);
            return $token;
        }
    }

    /**
     * @brief Fonction permettant de récupérer tout les token en base de données
     * @details Cette fonction permet de récupérer tout les token en base de données
     * @return Token|null
     */
    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "token";
        $pdoStatement = $this->pdo->query($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $TokenTab = $pdoStatement->fetchAll();
        $tokens = $this->hydrateAll($TokenTab);
        return $tokens;
    }

    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets Token
     * @details Cette fonction permet d'hydrater un tableau de données en objets Token
     * @param array $tab
     * @return array
     */
    public function hydrate(array $tab): ?Token {
        $token = new Token();
        $token->setTokenId($tab['tokenId']);
        $token->setUserId($tab['userId']);
        $token->setToken($tab['token']);
        if(is_string($tab['dateCreation'])) {
            $tab['dateCreation'] = new DateTime($tab['dateCreation']);
            $token->setDateCreation($tab['dateCreation']);
        }
        if(is_string($tab['dateExpiration'])) {
            $tab['dateExpiration'] = new DateTime($tab['dateExpiration']);
            $token->setdateExpiration($tab['dateExpiration']);
        }
        return $token;
    }

    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets Token
     * @details Cette fonction permet d'hydrater un tableau de données en objets Token
     * @param array $tab
     * @return array
     */
    public function hydrateAll(array $tab): array {
        $tokens = [];
        foreach ($tab as $token) {
            $tokens[] = $this->hydrate($token);
        }
        return $tokens;
    }

    /**
     * @brief Fonction permettant d'inserer un token en base de données
     * @details Cette fonction permet d'inserer un token en base de données en fonction de son identifiant
     * @param Token $token
     * @return void
     */
    public function insert(Token $token): void
    {
        $sql = "INSERT INTO " . PREFIX_TABLE . "token (userId, token, dateCreation, dateExpiration) VALUES (:userId, :token, :dateCreation, :dateExpiration)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':userId' => $token->getUserId(),
            ':token' => $token->getToken(),
            ':dateCreation' => $token->getDateCreation()->format('Y-m-d H:i:s'),
            ':dateExpiration' => $token->getDateExpiration()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * @brief Fonction permettant de supprimer un token en base de données
     * @details Cette fonction permet de supprimer un token en base de données en fonction de son identifiant
     * @param Token $token
     * @return void
     */
    public function delete(Token $token): void {
        $sql = "DELETE FROM " . PREFIX_TABLE . "token WHERE tokenId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':id' => $token->getTokenId()]);
        
    }
}