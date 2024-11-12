<?php
////////////////////////////////////
// BLOC A METTRE DANS UN CONTROLLEUR
// Ajout du code commun à toutes les pages
require_once 'include.php';


// Rendre le template Twig
echo $twig->render('connexion.html.twig', [
    'breadcrumbs' => $breadcrumbs,
    'title' => 'Connexion'
]);
////////////////////////////////////