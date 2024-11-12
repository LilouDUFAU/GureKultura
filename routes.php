<?php
use app\controllers\LoginController;

// Obtenez le chemin de la requête
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Initialisez le contrôleur de connexion
$loginController = new LoginController();

switch ($requestUri) {
    case '/connexion':
        $loginController->showLoginForm();
        break;

    case '/connexion-submit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginController->login();
        }
        break;

    case '/dashboard':
        // code pour le tableau de bord
        break;

    default:
        // Page 404 si la route n'existe pas
        echo "Page non trouvée";
        break;
}
