<?php
use Twig\Extra\Intl\IntlExtension;

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader,[
    'debug' => true,
]);

// s'il n'y a pas de session alors une session se creee
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $utilisateur = unserialize($_SESSION['user']);
    $twig->addGlobal('user', $utilisateur);
}
else {
    $twig->addGlobal('user', null);
}
