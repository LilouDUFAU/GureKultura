<?php

class ControllerFactory {
    public static function getController($controlleur, \Twig\Loader\FileSystemLoader $loader, \Twig\Environment $twig) {
        $controllerName = 'Controller' . ucfirst($controlleur);
        if (!class_exists($controllerName)) {
            throw new Exception("Le controlleur $controllerName n'existe pas");
        }
        return new $controllerName($twig, $loader);
    }
}