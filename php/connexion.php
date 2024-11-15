<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';
$pdo = Bd::getInstance()->getPdo();
$managerActualite = new ActualiteDao($pdo);
$actualite = $managerActualite->findAll();

// appeler le controlleur controller_connexion.class.php
$controller = new ControllerConnexion($twig, $loader);
$controller->afficher($twig, $actualite);


// Rendre le template Twig
// echo $twig->render('connexion.html.twig', [
//     'title' => 'Connexion',
//     'actualites' => $actualite
// ]);
////////////////////////////////////