<?php
use Twig\Extra\Intl\IntlExtension;

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader,[
    'debug' => true,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

var_dump($_SESSION);
$twig->addGlobal('user', $_SESSION['user'] ?? null);
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $utilisateur = unserialize($_SESSION['user']);
    $twig->addGlobal('user', $utilisateur);
}
else {
    $twig->addGlobal('user', null);
}
