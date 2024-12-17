<?php

class Validator
{
    private array $regleValidation; // Les règles de validation à vérifier 
    private array $erreurs = []; // Les erreurs de validation rencontrées

    public function __construct(array $regleValidation)
    {
        $this->regleValidation = $regleValidation;
    }

    public function is_image($valeur): bool
    {
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($valeur, '.');
        return in_array($extension, $extensions);
    }

    public function is_date($valeur): bool
    {
        $date = date_create_from_format('Y-m-d', $valeur);
        return $date !== false;
    }

    public function is_time($valeur): bool
    {
        $time = date_create_from_format('H:i', $valeur);
        return $time !== false;
    }

    public function is_file($valeur): bool
    {
        return file_exists($valeur);
    }

    public function valider(array $donnees): bool
    {
        $valide = true;
        $this->erreurs = []; // Réinitialisation des erreurs

        foreach ($this->regleValidation as $champ => $reglesChamp) {
            $valeur = $donnees[$champ] ?? null;

            if (!$this->validerChamp($champ, $valeur, $reglesChamp)) {
                $valide = false;
            }
        }
        return $valide;
    }

    private function validerChamp(string $champ, mixed $valeur, array $regleValidation): bool
    {
        $estValide = true;

        if (isset($regleValidation['obligatoire']) && $regleValidation['obligatoire'] && empty($valeur)) {
            $this->erreurs[$champ][] = "Le champ $champ est obligatoire.";
            return false; // Stop ici si le champ est vide et obligatoire
        }

        if (empty($valeur) && (!isset($regleValidation['obligatoire']) || !$regleValidation['obligatoire'])) {
            return true;
        }

        foreach ($regleValidation as $regle => $parametre) {
            switch ($regle) {
                case 'type':
                    if ($parametre === 'string' && !is_string($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être une chaîne de caractères.";
                        $estValide = false;
                    } elseif ($parametre === 'int' && !is_int($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être un entier.";
                        $estValide = false;
                    } elseif ($parametre === 'file' && !$this->is_file($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être un fichier.";
                        $estValide = false;
                    } elseif ($parametre === 'image' && !$this->is_image($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être une image.";
                        $estValide = false;
                    } elseif ($parametre === 'date' && !$this->is_date($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être une date valide (Y-m-d).";
                        $estValide = false;
                    } elseif ($parametre === 'time' && !$this->is_time($valeur)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être une heure valide (H:i).";
                        $estValide = false;
                    }
                    break;
                case 'longueurMin':
                    if (strlen($valeur) < $parametre) {
                        $this->erreurs[$champ][] = "Le champ $champ doit contenir au moins $parametre caractères.";
                        $estValide = false;
                    }
                    break;
                case 'longueurMax':
                    if (strlen($valeur) > $parametre) {
                        $this->erreurs[$champ][] = "Le champ $champ doit contenir au maximum $parametre caractères.";
                        $estValide = false;
                    }
                    break;
                case 'email':
                    if (!filter_var($valeur, FILTER_VALIDATE_EMAIL)) {
                        $this->erreurs[$champ][] = "Le champ $champ doit être une adresse email valide.";
                        $estValide = false;
                    }
                    break;
            }
        }
        return $estValide;
    }

    public function getMessageErreurs(): array
    {
        return $this->erreurs;
    }
}
