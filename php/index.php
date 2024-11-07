<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
require_once 'Breadcrumb.php';
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$breadcrumbs = Breadcrumb::generate();

// Rendre le template Twig
echo $twig->render('index.html.twig', [
    'breadcrumbs' => $breadcrumbs,
    'title' => 'Page d\'Accueil'
]);
////////////////////////////////////