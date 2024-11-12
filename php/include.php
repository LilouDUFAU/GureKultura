<?php

//Ajout de l'autoloadd de Composer
require_once '../vendor/autoload.php';
require_once 'Breadcrumb.php';

//Ajout du fichier constantes qui permet de configurer le site
require_once '../config/constantes.php';

//Ajout du code pour initialiser Twig
require_once '../config/twig.php';

//Ajout du code pour initialiser la connexion à la base de données
require_once '../config/connexionBD.php';

//Ajout des modèles 
require_once '../Models/Actualite.classe.php';
require_once '../Models/Evenement.classe.php';
