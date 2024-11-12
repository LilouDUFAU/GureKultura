<?php
namespace App\Model;

use PDO;

require_once '../../php/include.php';

class UserModel {

    public function findUser($identifiant) {
        // Requête SQL pour chercher un utilisateur par pseudo, email, ou numéro de téléphone
        $query = $conn->prepare("
            SELECT * FROM" . PREFIX_TABLE . "utilisateur 
            WHERE pseudo = :identifiant 
               OR email = :identifiant 
               OR telephone = :identifiant
        ");
        $query->execute(['identifiant' => $identifiant]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
