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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $id = $_POST['id'];
}

if ($type == "Evenements"){
    $managerEvtActu = new EvenementDao($pdo);
} if ($type == "Actualites"){
    $managerEvtActu = new ActualiteDao($pdo);
}
$evtActuEnCours = $managerEvtActu->findEnCours($id);
$evtActuASuivre = $managerEvtActu->findAsuivre($id);
$evtActuPasser = $managerEvtActu->findPasser($id);

// Rendre le template Twig
echo $twig->render('categorieEvtActu.html.twig', [
    'title' => $nom,
    'type' => $type,
    'actualites' => $actualite,
    'evtActusEnCours' => $evtActuEnCours,
    'evtActusASuivre' => $evtActuASuivre,
    'evtActusPasser' => $evtActuPasser,
]);
////////////////////////////////////
?>