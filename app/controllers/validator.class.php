<?php

class Validator
{
    private array $regleValidation; // Les règles de validation à vérifier 
    private array $messagesErreurs = []; // Les erreurs de validation rencontrées


    /**
     * @brief Constructeur de la classe Validator qui prend en parametre un tableau de regles de validation.
     * 
     * @param array $regles un tableau associatif definissant les regles de validation pour chaque champ.  
     */
    public function __construct(array $regleValidation)
    {
        $this->regleValidation = $regleValidation;
    }


    /**
     * @brief Methode qui permet de verifier si les donnees passees en parametre respectent les regles de validation definies.
     * 
     * @param array $donnees un tableau associatif contenant les donnees du formulaire a valider.
     * 
     * @return bool true si les donnees respectent les regles de validation, false sinon.
     */
    public function valider(array $donnees): bool
    {
        $valide = true;
        $this->messagesErreurs = []; // Réinitialisation des erreurs

        foreach ($this->regleValidation as $champ => $reglesChamp) {
            $valeur = $donnees[$champ] ?? null;

            if (!$this->validerChamp($champ, $valeur, $reglesChamp)) {
                $valide = false;
            }
        }
        return $valide;
    }


    /**
     * @function validerChamp
     * @brief Methode qui permet de valider un champ en fonction des regles de validation definies.
     * @param string $champ
     * @param mixed $valeur
     * @param array $regleValidation
     * @return bool
     */
    private function validerChamp(string $champ, mixed $valeur, array $regleValidation): bool
    {
        $estValide = true;

        // 1. Verification de la regle "obligatoire" avant toute autre validation
        if (isset($regleValidation['obligatoire']) && $regleValidation['obligatoire'] && empty($valeur)) {
            $this->messagesErreurs[$champ][] = "Le champ $champ est obligatoire.";
            return false; // Stop ici si le champ est vide et obligatoire
        }


        // 2. Si le champ est vide et non obligatoire, on ne fait pas les autres validations
        if (empty($valeur) && (!isset($regleValidation['obligatoire']) || !$regleValidation['obligatoire'])) {
            return true;
        }


        // 3. validation des autres regles de validation si le champ n'est pas vide
        foreach ($regleValidation as $regle => $parametre) {
            switch ($regle) {
                case 'type':
                    if ($parametre === 'string' && !is_string($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une chaîne de caractères.";
                        $estValide = false;
                    } elseif ($parametre === 'int' && !is_int($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être un entier.";
                        $estValide = false;
                    }elseif ($parametre === 'image' && !is_image($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une image.";
                        $estValide = false;
                    } elseif ($parametre === 'date' && !is_date($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une date valide (Y-m-d).";
                        $estValide = false;
                    } elseif ($parametre === 'time' && !is_time($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une heure valide (H:i).";
                        $estValide = false;
                    }
                    //  elseif ($parametre === 'file' && !$this->is_file($valeur)) {
                    //     $this->messagesErreurs[$champ][] = "Le champ $champ doit être un fichier.";
                    //     $estValide = false;
                    // }
                    break;
                case 'longueurMin':
                    if (strlen($valeur) < $parametre) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit contenir au moins $parametre caractères.";
                        $estValide = false;
                    }
                    break;
                case 'longueurMax':
                    if (strlen($valeur) > $parametre) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit contenir au maximum $parametre caractères.";
                        $estValide = false;
                    }
                    break;
                case 'longueurExacte':
                    if (strlen($valeur) !== $parametre) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit contenir exactement $parametre caractères.";
                        $estValide = false;
                    }
                    break;
                case 'email':
                    if (!filter_var($valeur, FILTER_VALIDATE_EMAIL)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une adresse email valide.";
                        $estValide = false;
                    }
                    break;
            }
        }
        return $estValide;
    }


    /**
     * @function getMessageErreurs
     * @brief Methode qui permet de retourner les messages d'erreurs de validation.
     * @return array
     */
    public function getMessageErreurs(): array
    {
        return $this->messagesErreurs;
    }


    /**
     * @function is_available
     * @details Cette fonction permet de vérifier si un enregistrement passé en paramettre est déjà enregistré en base de données dans la table user
     * @param string $champ
     * @return bool
     */
    public function is_available(?string $champ): bool {
        $pdo = Bd::getInstance()->getPdo();
        $sql = "SELECT * FROM " . PREFIX_TABLE . "user WHERE pseudo = :champ OR email = :champ";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(':champ' => $champ));
        $pdoStatement->setFetchMode(PDO::FETCH_ASSOC);
        $UserTab = $pdoStatement->fetch();
        if ($UserTab) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @function is_strong
     * @details Cette fonction permet de vérifier si un mot de passe passé en paramettre est assez robuste
     * @param string $password
     * @return bool
     */
    public function is_strong(string $password): bool {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

        // La fonction preg_match retourne 1 si une correspondance est trouvée.
        return preg_match($regex, $password) === 1;
    }

    /**
     * @function hash_password
     * @details Cette fonction permet de hasher un mot de passe passé en paramettre
     * @param string $password
     * @return string
     */
    public function hash_password(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @function identifiantExist
     * @details Cette fonction permet de vérifier si un email passé en paramettre existent dans la base de données
     * @param string $champ
     * @return bool
     */
    public function identifiantExist(string $champ): bool {
        $pdo = Bd::getInstance()->getPdo();
        $sql = "SELECT * FROM " . PREFIX_TABLE . "user WHERE email = :champ";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute(array(":champ"=> $champ));
        $row = $pdoStatement->fetch();
        if ($row) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function passwordExist
     * @details Cette fonction permet de vérifier si un mot de passe passé en paramettre existe dans la base de données
     * @param string $password
     * @return bool
     */
    public function passwordExist(string $password): bool {
        $hashedPassword = $this->hash_password($password);
        if (password_verify($password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }


    static public function is_image($valeur): bool
    {
        $extensions = array('.png', '.jpg', '.jpeg', '.svg');
        $extension = strrchr($valeur, '.');
        return in_array($extension, $extensions);
    }



    // function is_file($valeur): bool
    // {
    //     return file_exists($valeur);
    // }
}