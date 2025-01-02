<?php

/**
 * @brief Methode qui permet de verifier si une valeur est une image.
 * 
 * @param string $valeur la valeur a verifier.
 * 
 * @return bool true si la valeur est une image, false sinon.
 */
function is_image($valeur): bool
{
    $extensions = array('.png', '.jpg', '.jpeg', '.svg');
    $extension = strrchr($valeur, '.');
    return in_array($extension, $extensions);
}

/**
 * @brief Methode qui permet de verifier si une valeur est une date.
 * 
 * @param string $valeur la valeur a verifier.
 * 
 * @return bool true si la valeur est une date, false sinon.
 */
function is_date($valeur): bool
{
    $date = date_create_from_format('Y-m-d', $valeur);
    return $date !== false;
}


/**
 * @brief Methode qui permet de verifier si une valeur est une heure.
 * 
 * @param string $valeur la valeur a verifier.
 * 
 * @return bool true si la valeur est une heure, false sinon.
 */
function is_time($valeur): bool
{
    $time = date_create_from_format('H:i', $valeur);
    return $time !== false;
}


/**
 * @brief Methode qui permet de verifier si une valeur est un fichier.
 * 
 * @param string $valeur la valeur a verifier.
 * 
 * @return bool true si la valeur est un fichier, false sinon.
 */
// function is_file($valeur): bool
// {
//     return file_exists($valeur);
// }




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
     * @brief Methode qui permet de verifier si une valeur respecte les regles de validation definies pour un champ.
     *
     * @param string $champ le nom du champ a valider.
     * @param mixed $valeur la valeur du champ a valider.
     * @param array $regles les regles de validation a verifier pour le champ.
     *
     * @return bool true si la valeur respecte les regles de validation, false sinon.
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
                    } elseif ($parametre === 'file' && !$this->is_file($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être un fichier.";
                        $estValide = false;
                    } elseif ($parametre === 'image' && !$this->is_image($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une image.";
                        $estValide = false;
                    } elseif ($parametre === 'date' && !$this->is_date($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une date valide (Y-m-d).";
                        $estValide = false;
                    } elseif ($parametre === 'time' && !$this->is_time($valeur)) {
                        $this->messagesErreurs[$champ][] = "Le champ $champ doit être une heure valide (H:i).";
                        $estValide = false;
                    }
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


    /***
     * @brief Methode qui permet de recuperer les erreurs de validation rencontrees lors de la derniere validation.
     * 
     * @return array un tableau associatif contenant les erreurs de validation rencontrees.
     */
    public function getMessageErreurs(): array
    {
        return $this->messagesErreurs;
    }
}
