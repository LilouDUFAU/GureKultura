<?php 
//inclure la classe validator
require_once '../app/controllers/validator.class.php';

/**
 * @brief Classe UserDao, permettant d'effectuer des requêtes sur la table user de la base de données
 * @details Cette classe utilise le pattern DAO (Data Access Object)
 */
class UserDao {
    /**
     * @brief Attribut permettant de stocker la connexion à la base de données
     * @details Cet attribut est privé, il ne pourra être modifié que par les méthodes de la classe
     * @var PDO
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe UserDao
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
     * @brief Fonction perlmettant de récupérer un utilisateur en base de données
     * @details Cette fonction permet de récupérer un utilisateur en base de données
     * @param int $id
     * @return User
     */
    public function find(?int $id): ?User {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "user WHERE userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $UserTab = $pdoStatement->fetch();
        $user = $this->hydrate($UserTab);
        return $user;
    }

    /**
     * @brief Fonction permettant de récupérer tous les utilisateurs en base de données
     * @details Cette fonction permet de récupérer tous les utilisateurs en base de données
     * @return array
     */
    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "user";
        $pdoStatement = $this->pdo->query($sql);
        $pdoStatement->execute();
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $UserTab = $pdoStatement->fetchAll();
        $users = $this->hydrateAll($UserTab);
        return $users;
    }

    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets User
     * @details Cette fonction permet d'hydrater un tableau de données en objets User
     * @param array $tab
     * @return array
     */
    public function hydrate(array $tab): ?User {
        $user = new User();
        $user->setUserId($tab['userId']);
        $user->setNom($tab['nom']);
        $user->setPseudo($tab['pseudo']);
        $user->setEmail($tab['email']);
        $user->setMdp($tab['mdp']);
        if(is_date($tab['dateInscr'])) {
            $tab['dateInscr'] = new DateTime($tab['dateInscr']);
            $user->setDateInscr($tab['dateInscr']);
        }
        $user->setBio($tab['bio']);
        $user->setPfp($tab['pfp']);
        $user->setEstAdmin($tab['estAdmin']);
        return $user;
    }

    /**
     * @brief Fonction permettant d'hydrater un tableau de données en objets User
     * @details Cette fonction permet d'hydrater un tableau de données en objets User
     * @param array $tab
     * @return array
     */
    public function hydrateAll(array $tab): array {
        $users = [];
        foreach ($tab as $user) {
            $users[] = $this->hydrate($user);
        }
        return $users;
    }

    /**
     * @brief Fonction permettant d'inserer un utilisateur en base de données
     * @details Cette fonction permet d'inserer un utilisateur en base de données en fonction de son identifiant
     * @param User $user
     * @return void
     */
    public function insert(User $user): void
    {
        $sql = "INSERT INTO " . PREFIX_TABLE . "user (nom, pseudo, email, mdp, dateInscr, bio, pfp) VALUES (:nom, :pseudo, :email, :mdp, :dateInscr, :bio, :pfp)";
        $pdoStatement = $this->pdo->prepare($sql);
        var_dump($user->dateActuelle());
        $pdoStatement->execute([
            ':nom' => $user->getNom(),
            ':pseudo' => $user->getPseudo(),
            ':email' => $user->getEmail(),
            ':mdp'=> $user->getMdp(),
            ':dateInscr' => $user->dateActuelle(),
            ':bio' => $user->getBio(),
            ':pfp' => $user->getPfp()
        ]);
    }

    /**
     * @brief Fonction permettant de récupérer l'id de l'utilisateur actuel
     * @details Cette fonction permet de récupérer l'id de l'utilisateur actuel
     * @param string|null $pseudo
     * @return integer
     */
    public function getActualUserId(?string $pseudo): int {
        $sql = "SELECT userId FROM " . PREFIX_TABLE . "user WHERE pseudo = :pseudo";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':pseudo' => $pseudo]);
        $row = $pdoStatement->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['userId'];
    }

    public function findWithEmail(string $email): ?User {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "user WHERE email = :email";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':email' => $email]);
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $UserTab = $pdoStatement->fetch();
        $user = $this->hydrate($UserTab);
        return $user;
    }

    /**
     * @brief Fonction permettant de supprimer un utilisateur en base de données
     * @details Cette fonction permet de supprimer un utilisateur en base de données si ce dernier sdouhaite supprimer son compte
     * @param User $user
     * @return void
     */
    public function delete(User $user): void {
        $sql = "DELETE FROM " . PREFIX_TABLE . "user WHERE userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([':id' => $user->getUserId()]);
    }

    public function modify(string $donnees, string $champ, string $userId): void
    {
        $sql = "UPDATE " . PREFIX_TABLE . "user SET $champ = :valeur WHERE userId = :id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            ':valeur' => $donnees,
            ':id' => $userId
        ]);
    }
}