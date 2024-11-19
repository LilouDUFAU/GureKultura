<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';
$pdo = Bd::getInstance()->getPdo();

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);



$managerActualite = new ActualiteDao($pdo);
$actualite = $managerActualite->findAll();
$managerEvenement = new EvenementDao($pdo);
$events = $managerEvenement->findAll();

// Rendre le template Twig
echo $twig->render('uneActualite.html.twig', [
    'title' => 'Actualité',
    // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
    'events' => $events,
    'actualites' => $actualite
]);
////////////////////////////////////