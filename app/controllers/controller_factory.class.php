<?php

class ControllerFactory {
    /**
     * @param Controller $controlleur
     * @param \Twig\Loader\FileSystemLoader $loader
     * @param \Twig\Environment $twig
     * @return void
     */
    public static function getController($controlleur, \Twig\Loader\FileSystemLoader $loader, \Twig\Environment $twig) {
        $controllerName = 'Controller' . ucfirst($controlleur);
        if (!class_exists($controllerName)) {
            throw new Exception("Le controlleur $controllerName n'existe pas");
        }
        return new $controllerName($twig, $loader);
    }
}