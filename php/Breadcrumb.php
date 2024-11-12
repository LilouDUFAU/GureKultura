<?php

// class Breadcrumb
// {
//     public static function generate()
//     {
//         $breadcrumbs = [];
//         $path = trim($_SERVER['REQUEST_URI'], '/'); // Récupère l'URL actuelle sans le slash initial et final
//         $segments = explode('/', $path);

//         $breadcrumbs[] = ['url' => '/', 'title' => 'Accueil'];

//         $currentPath = '';
//         foreach ($segments as $segment) { 
//             $currentPath .= '/' . $segment;
//             $breadcrumbs[] = [
//                 'url' => $currentPath,
//                 'title' => ucfirst(urldecode($segment))
//             ];
//         }

//         return $breadcrumbs;
//     }
// }



session_start(); // Démarrer la session pour gérer l'historique de navigation

class Breadcrumb
{
    // Ajoute une page au fil d'Ariane
    public static function add($pageTitle)
    {
        if (!isset($_SESSION['breadcrumbs'])) {
            $_SESSION['breadcrumbs'] = [];
        }

        // Ajouter la page actuelle si ce n'est pas la même que la dernière dans l'historique
        if (empty($_SESSION['breadcrumbs']) || end($_SESSION['breadcrumbs'])['title'] !== $pageTitle) {
            $_SESSION['breadcrumbs'][] = [
                'url' => $_SERVER['PHP_SELF'], // URL de la page actuelle
                'title' => $pageTitle
            ];
        }

        // Limiter l'historique à un certain nombre de pages, par exemple 5
        if (count($_SESSION['breadcrumbs']) > 5) {
            array_shift($_SESSION['breadcrumbs']); // Retirer la première page si la limite est dépassée
        }
    }

    // Génère le fil d'Ariane à partir de l'historique de session
    public static function generate()
    {
        if (!isset($_SESSION['breadcrumbs'])) {
            return []; // Pas d'historique, donc pas de fil d'Ariane
        }

        $breadcrumbs = [['url' => '/', 'title' => 'Accueil']]; // Point de départ

        // Ajouter toutes les pages de l'historique au fil d'Ariane
        foreach ($_SESSION['breadcrumbs'] as $breadcrumb) {
            $breadcrumbs[] = [
                'url' => $breadcrumb['url'],
                'title' => $breadcrumb['title']
            ];
        }

        return $breadcrumbs;
    }
}
?>

