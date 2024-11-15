<?php

//Ajout de l'autoloadd de Composer
require_once '../vendor/autoload.php';

//Ajout du fichier constantes qui permet de configurer le site
require_once '../config/constantes.php';

//Ajout du code pour initialiser Twig
require_once '../config/twig.php';

//Ajout du model qui gère la connexion mysql
require_once '../app/models/bd.class.php';

//Ajout des controllers
require_once '../app/controllers/controller.class.php';
require_once '../app/controllers/controller_factory.class.php';
require_once '../app/controllers/controller_inscription.class.php';
require_once '../app/controllers/controller_connexion.class.php';
require_once '../app/controllers/controller_index.class.php';

//Ajout des modèles 
require_once '../app/models/actualite.classe.php';
require_once '../app/models/actualite.dao.php';
require_once '../app/models/evenement.classe.php';
require_once '../app/models/evenement.dao.php';


