<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

// Rendre le template Twig pour la réservation
echo $twig->render('reservation.html.twig', [
    'title' => 'Réservation de Place'
]);
////////////////////////////////////
