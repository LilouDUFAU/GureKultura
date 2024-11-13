<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';
require_once 'prerequis.php';
// require_once '../routes.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$pdo = Bd::getInstance()->getPdo();

$managerActualite = new ActualiteDao($pdo);

$actualite = $managerActualite->findAll();

$managerEvenement = new EvenementDao($pdo);
$events = $managerEvenement->findAll();

$events = getData::getActiveEvents($conn);


// Rendre le template Twig
echo $twig->render('index.html.twig', [
    'breadcrumbs' => $breadcrumbs,
    'title' => 'Accueil',
    // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
    'events' => $events,
    'actualites' => $actualite
]);
////////////////////////////////////