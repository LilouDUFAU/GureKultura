<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$breadcrumbs = Breadcrumb::generate();

// Rendre le template Twig
echo $twig->render('index.html.twig', [
    'breadcrumbs' => $breadcrumbs,
    'title' => 'Accueil',
    // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
]);
////////////////////////////////////