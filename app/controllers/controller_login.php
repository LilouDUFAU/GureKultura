<?php
namespace app\controllers;

use app\models\userModel;

require_once 'include.php';
require_once 'prerequis.php';

class LoginController {
    public function showLoginForm() {
        return $this->twig->render('connexion.html.twig');
    }

    public function login() {
        $identifiant = $_POST['identifiant'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($identifiant && $password) {
            // Instancier le modèle utilisateur pour accéder à la base de données
            $userModel = new UserModel();
            $user = $userModel->findUser($identifiant);

            // Vérifiez si un utilisateur a été trouvé et si le mot de passe est correct
            if ($user && password_verify($password, $user['passwd'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['pseudo'];
                // Redirige vers la page d'accueil ou tableau de bord
                header("Location: ../../php/index.php");
                exit();
            } else {
                return $this->twig->render('connexion.html.twig', [
                    'error' => 'Identifiant ou mot de passe incorrect',
                    'breadcrumbs' => $breadcrumbs,
                    'title' => 'Connexion',
                    'actualites' => $actualite
                ]);
            }
        } else {
            return $this->twig->render('connexion.html.twig', [
                'error' => 'Veuillez remplir tous les champs',
                'breadcrumbs' => $breadcrumbs,
                'title' => 'Connexion',
                'actualites' => $actualite
            ]);
        }
    }
}
