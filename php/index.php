<?php

require_once 'include.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);


try {
    if (isset($_GET['controlleur'])) {
        $controlleurName = $_GET['controlleur'];
        $controlleurName = htmlentities($controlleurName);
    } else {
        $controlleurName = '';
    }

    if (isset($_GET['methode'])) {
        $methode = $_GET['methode'];
        $methode = htmlentities($methode);
    } else {
        $methode = '';
    }

    if ($controlleurName == '' && $methode == '') {
        $controlleurName = 'index';
        $methode = 'lister';
    }

    if ($controlleurName == '') {
        throw new Exception("Le controlleur n'est pas définis");
    }

    if ($methode == '') {
        throw new Exception("La méthode n'est pas définie");
    }
    

    $controlleur = ControllerFactory::getController($controlleurName, $loader, $twig);
    $controlleur->call($methode);

} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}