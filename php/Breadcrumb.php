<?php

class Breadcrumb
{
    public static function generate()
    {
        $breadcrumbs = [];
        $path = trim($_SERVER['REQUEST_URI'], '/'); // Récupère l'URL actuelle sans le slash initial et final
        $segments = explode('/', $path);

        $breadcrumbs[] = ['url' => '/', 'title' => 'Accueil'];

        $currentPath = '';
        foreach ($segments as $segment) { 
            $currentPath .= '/' . $segment;
            $breadcrumbs[] = [
                'url' => $currentPath,
                'title' => ucfirst(urldecode($segment)) 
            ];
        }

        return $breadcrumbs;
    }
}
