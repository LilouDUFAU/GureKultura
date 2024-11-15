<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';
$pdo = Bd::getInstance()->getPdo();
$managerActualite = new ActualiteDao($pdo);
$actualite = $managerActualite->findAll();

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

// appeler le controlleur controller_inscription.class.php
$controller = new ControllerInscription($twig, $loader);
$controller->afficher($twig, $actualite);


// Rendre le template Twig
// echo $twig->render('inscription.html.twig', [
//     'title' => 'Inscription',
//     'actualites' => $actualite
// ]);
////////////////////////////////////