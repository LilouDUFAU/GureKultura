FR | [EN](README-en.md)

# GureKultura

Une application web de gestion événementielle centrée sur le Pays Basque.

# Table des matières

- [A propos](#a-propos)
- [Téléchargement](#téléchargement)
- [Installation](#installation)
- [Structure du projet](#structure-du-projet)
- [Installation de Wamp](#installation-de-wamp)

# A propos

GureKultura est un projet étudiant réaliser pendant une SAE (Situation d'apprentissage et d'évaluation). C'est une application qui permet de gérer des événements dans tous le Pays Basque. L'application à pour but de promouvoir la culture Basque ainsi que les activités à ne pas rater pour les étudiants ou jeunes venus travailler dans le Sud-Ouest de la France.
En plus de pouvoir créer ses propres événements, n'importe qui peut venir s'inscrire aux activités qui lui plait. 

# Téléchargement

Téléchargez ou clonez le repo sur votre machine. Puis ouvrez le fichier `php/index.php` dans votre navigateur.
Pour des informations plus détaillées sur l'installation, rendez-vous dans la rubrique [installation](#installation).

# Installation

Cette application fonctionne à partir d'une base de données. Pour l'instant nous ne possédons pas de base de données hébergée.

- Téléchargez GureKultura
	- Si vous travaillez sur Citrix, installez le projet sur votre Lakartxela.
	- Si vous travaillez sur votre propre machine, installez le projet à partir d'une solution d'hébergement. Nous recommandons d'utiliser [Wamp](https://www.wampserver.com/#wampserver-64-bits-php-5-6-25-php-7) pour cela. Pour plus une aide approfondie pour installer le projet sur _Wamp_, rendez-vous dans la section [Installation de Wamp](#installation-de-wamp).
-> dans un terminal :
- Cloner le repo
```sh
git clone https://github.com/LilouDUFAU/GureKultura
cd GureKultura
```

- Installer les dépendances
```sh
npm install
composer install
```

- Configurer l'application
Ouvrir le dossier `config` puis créer un fichier `constantes.yaml`, ensuite, suivre le modèle pour remplir ce fichier dans `modeleConstanteYml.md`.

**!! Veiller à bien vérifier les lignes relatives à la base de données pour qu'elles correspondent à votre configuration !!**

# Structure du projet

- **app/controllers**: Contient les controllers de l'application pour gérer les requêtes.
- **app/models**: Contient les modèles des classes pour gérer les interactions avec la base de données.
- **asset**: Contient les assets statiques comme les images ou icônes.
- **config**: Contient les fichiers de configuration.
- **css**: Contient les fichiers de styles CSS de l'application.
- **docs**: Contient toute la documentation des classes du projet.
- **js**: Contient tous les scripts JavaScript nécessaires.
- **templates**: Contient les templates qui sont rendus en tant que vues HTML.
- **vendor**: Contient des bibliothèques et des dépendances tierces.

# Installation de Wamp

- Télécharger [Wamp](https://www.wampserver.com/#wampserver-64-bits-php-5-6-25-php-7).
- Lancer Wamp, cela devrait prendre entre 1 à 2 minutes.
- Aller sur l'adresse [localhost](http://localhost/).
- Cliquer sur `Ajouter un VirtualHost`.
- Remplir les informations relatives au projet, e.g :
	- Nom du projet : gurekultura.
	- Spécifier le chemin du projet qui doit être dans le dossier `wamp64/www`.
	- Cocher la case `utiliser PHP en FCGI` et sélectionner `PHP : 8.1.31`.
- Redémarrer Wamp pour pouvoir terminer la configuration du VirtualHost.
