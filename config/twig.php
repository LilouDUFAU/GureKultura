<?php
use Twig\Extra\Intl\IntlExtension;

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader,[
    'debug' => true,
]);
?>