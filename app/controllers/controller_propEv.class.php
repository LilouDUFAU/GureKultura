<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';

class ControllerPropEv extends Controller
{

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }


    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAll();

        // Rendre le template Twig
        echo $this->getTwig()->render('propEv.html.twig', [
            'title' => 'Proposisition d\'événement',
            'actualites' => $actualite
        ]);
    }


    public function validerFormulaire()
    {
        // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
        $regleValidation = [
            'titre' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 5,
                'longueurMax' => 30,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'nomCategorie' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 4,
                'longueurMax' => 30,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'autorisation' => [
                'obligatoire' => false,
                'type' => '.pdf ,.jpg, .jpeg, .png',
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'email' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 10,
                'longueurMax' => 100,
                'format' => FILTER_VALIDATE_EMAIL
            ],
            'tel' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 10,
                'longueurMax' => 14,
                'format' => '^0\d(\s|-)?(\d{2}(\s|-)?){4}$'
            ],
            'nomRep' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 2,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'prenomRep' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 2,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'description' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 100,
                'longueurMax' => 500,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'debutDate' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurExacte' => 10,
                'format' => '/^\d{4}-\d{2}-\d{2}$/'
            ],
            'finDate' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurExacte' => 10,
                'format' => '/^\d{4}-\d{2}-\d{2}$/'
            ],
            'debutHeure' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurExacte' => 5,
                'format' => '/^\d{2}:\d{2}$/'
            ],
            'finHeure' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurExacte' => 5,
                'format' => '/^\d{2}:\d{2}$/'
            ],
            'lieu' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 5,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'photo' => [
                'obligatoire' => false,
                'type' => 'string',
                'longueurMin' => 5,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ]
        ];

        // instanciation de la classe de validation
        $validator = new Validator($regleValidation);

        // recuperation des donnees du formulaire
        $donnees = $_POST;

        // validation des donnees du formulaire
        $donneesValides = $validator->valider($donnees);
        $messageErreurs = $validator->getMessageErreurs();


        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            /* Répertoire de destination pour l'enregistrement du fichier 
            Attention : apache doit avoir des droits en écriture sur ce dossier */
            $uploadDir = '../asset/evenement/';
            /* Création d'un nom de fichier unique
            Utilisation de time() pour ajouter un timestamp au nom d'origine du fichier.
            Cela permet d'éviter les conflits lorsque plusieurs utilisateurs téléchargent des fichiers 
            ayant le même nom (par exemple, plusieurs fichiers nommés "profil.jpg").
            Sans un nom de fichier unique, chaque nouvel upload avec le même nom écraserait le fichier précédent, 
            ce qui entraînerait la perte de l'image de profil d'autres utilisateurs.
            Avec ce système, chaque fichier a un nom distinct basé sur le timestamp au moment du téléchargement. */
            $fileName = time() . '_' . basename($_FILES['photo']['titre']);
            /* Chemin complet de destination du fichier
            Concatène le répertoire de destination (`uploads/`) avec le nom de fichier unique généré.
            Cela crée le chemin complet où le fichier sera stocké sur le serveur.
            Exemple : "uploads/1633024800_profil.jpg" */
            $filePath = $uploadDir . $fileName;

            // Déplacement du fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                echo "Le fichier est valide, et a été téléchargé avec succès.\n";
            } else {
                echo "<strong>Erreur : Le fichieer n'a pas été téléchargé.</strong>";
            }
        } else {
            // echo "<strong>Attention : Aucune photo téléchargée ou erreur lors du téléchargement.</strong>";
        }

        //Récupérer les données du formulaire
        $titre = $_POST['titre'];
        $autorisation = $_POST['autorisation'] ?? '';
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $nomRep = $_POST['nomRep'];
        $prenomRep = $_POST['prenomRep'];
        $description = $_POST['description'];
        $debutDate = $_POST['debutDate'];
        $finDate = $_POST['finDate'];
        $debutHeure = $_POST['debutHeure'];
        $finHeure = $_POST['finHeure'];
        $lieu = $_POST['lieu'];
        $photo = $_POST['photo'] ?? '';

        // Rendre le template Twig
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAll();

        

        if (!empty($messageErreurs)) {
            $dataForm = $_POST;
            // var_dump($messageErreurs);
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposisition d\'événement',
                'actualites' => $actualite,
                'titre' => $titre,
                'description' => $description,
                'messageErreurs' => $messageErreurs
            ]);
        } else {
            $managerEvenement = new EvenementDao($this->getPdo());
            $events = $managerEvenement->findAll();
            $events = $managerEvenement->findAllWithCategorie();
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposisition d\'événement',
                // 'description' => 'un site de gestion evenementielle au Pays Basque du Groupe 7'
                'events' => $events,
                'actualites' => $actualite
            ]);

            // gestion d'envoie a la bd

        }

    }
}
