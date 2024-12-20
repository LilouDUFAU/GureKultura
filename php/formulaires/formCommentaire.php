<?php

//session_start();
//ob_start();
//require_once '../../apps/models/bd.class.php';
//require_once '../../config/constantes.php'

//$pdo = Bd::getInstance()->getPdo();

// if($_SERVER["REQUEST_METHOD"]=="POST"){
    $commentaire = $_POST['commentaire'];
// }




$messagesDErreur=[];

$commentaireValide = validerCommentaire($_POST['commentaire'], $messagesDErreur);
if($commentaireValide==true){
    var_dump($_POST);
}else{
    echo "<div class='alert alert-danger'>";
    echo "<h4>Erreurs de validation :</h4>";
    echo "<ul>";
    foreach($messagesDErreur as $erreur){
        echo "<li>$erreur</li>";
    }
    echo "</ul>";
    echo "</div>";
}

function validerCommentaire(string $contenu, array &$messagesDErreur){
    $valide = true;
    //CHAMPS OBLIGATOIRES
    if(empty($contenu)){
        $messagesDErreur[]="Impossible d'envoyer un commentaire vide";
        $valide = false;
    }
    //TYPEDE DONNEES - Ici une chaîne de caractères
    if(!is_string($contenu)){
        $messagesDErreur[]="Le commentaire doit être une chaîne de caractères";
        $valide = false;
    }
    //LONGUEUR DES DONNEES - Entre 1 et 500
    if(strlen($contenu) > 500){
        $messagesDErreur[]="Le commentaire doit être plus petit ou égal à 500 caractères";
        $valide = false;
    }
    //FORMAT DES DONNEES - non pertinent

    //PLAGE DES VALEURS - non pertinent

    //FICHIERS UPLOADES - non pertinent

    return $valide;
}