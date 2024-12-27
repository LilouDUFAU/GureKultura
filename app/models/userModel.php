<?php
// namespace App\Model;

require_once '../../php/include.php';

class UserModel {

    // public function findUser($identifiant) {
    //     // Requête SQL pour chercher un utilisateur par pseudo, email, ou numéro de téléphone
    //     $query = $conn->prepare("
    //         SELECT * FROM" . PREFIX_TABLE . "utilisateur 
    //         WHERE pseudo = :identifiant 
    //            OR email = :identifiant 
    //            OR telephone = :identifiant
    //     ");
    //     $query->execute(['identifiant' => $identifiant]);

    //     return $query->fetch(PDO::FETCH_ASSOC);
    // }

    private ?PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    public function findUser(?int $id)
    {
        $sql = "
            SELECT * FROM" . PREFIX_TABLE . "utilisateur 
            WHERE pseudo = :identifiant 
               OR email = :identifiant 
               OR telephone = :identifiant
        ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute(array(':id' => $id));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $EvenementTab = $pdoStatement->fetch();
        $evenement = $this->hydrate($EvenementTab);
        return $evenement;
    }

    public function hydrate(array $donnees): User
    {
        $user = new User();
        $user->setId($donnees['id']);
        $user->setPseudo($donnees['pseudo']);
        $user->setEmail($donnees['email']);
        $user->setTelephone($donnees['telephone']);
        $user->setMotDePasse($donnees['motDePasse']);
        $user->setDateInscription(new DateTime($donnees['dateInscription']));
        $user->setRole($donnees['role']);
        return $user;
    }
}
