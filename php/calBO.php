<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';
require_once 'prerequis.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);


// Rendre le template Twig
echo $twig->render('calBO.html.twig', [
    'breadcrumbs' => $breadcrumbs,
    'title' => 'Calendrier Biarritz Olympique',
    'actualites' => $actualite
]);
////////////////////////////////////