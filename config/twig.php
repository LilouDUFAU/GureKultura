<?php

// // s'il n'y a pas de session alors une session se creee
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }

// // 
// if (isset($_SESSION['utilisateur']) && !empty($_SESSION['utilisateur'])) {
//     $utilisateur = unserialize($_SESSION['utilisateur']);
//     $twig->addGlobal('utilisateur', $utilisateur);
// }
// else {
//     $twig->addGlobal('utilisateur', null);
// }

use Twig\Extra\Intl\IntlExtension;

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader,[
    'debug' => true,
]);
?>