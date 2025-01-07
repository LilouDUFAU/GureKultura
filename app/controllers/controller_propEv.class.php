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

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        // Rendre le template Twig
        echo $this->getTwig()->render('propEv.html.twig', [
            'title' => 'Proposisition d\'événement',
            'actualites' => $actualite,
            'categories' => $categories
        ]);
    }


    public function validerFormulairePropEv()
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
            'cateId' => [
                'obligatoire' => true,
                'type' => 'integer',
                'longueurMin' => 1,
                'longueurMax' => 100,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'autorisation' => [
                'obligatoire' => false,
                'type' => '.pdf ,.jpg, .jpeg, .png',
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'email' => [
                'obligatoire' => true,
                'type' => 'email',
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

        if(!$donneesValides){
            $messageErreurs = $validator->getMessageErreurs();
        }

        // recuperation des erreurs

        // Rendre le template Twig
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAll();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        if (!empty($messageErreurs)) {
            // Les données ne sont pas valides, affichez les erreurs
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposition d\'événement',
                'messageErreurs' => $messageErreurs,
                'donnees' => $donnees,
                'actualites' => $actualite,
                'categories' => $categories

            ]);
        } else {
            echo $this->getTwig()->render('propEv.html.twig', [
                'title' => 'Proposition d\'événement',
                'donnees' => $donnees,
                'actualites' => $actualite,
                'categories' => $categories
                
            ]);
            echo"pendant le test s'il n'y a pas d'erreurs";

            
            // Les données sont valides, insérez-les dans la base de données
            $this->insererDonneesDansLaBase($donnees);
            
            echo"apres envoie a la bd";
        }
    }

    private function insererDonneesDansLaBase(array $donnees)
    {
        try {
            $pdo = Bd::getInstance()->getPdo();
            $managerEvenement = new EvenementDao($pdo);
    
            // Créez un nouvel objet Evenement avec les données du formulaire
            $evenement = new Evenement(
                null,
                $donnees['titre'],
                $donnees['autorisation'] ?? null,
                $donnees['description'],
                $donnees['email'],
                $donnees['tel'],
                $donnees['nomRep'],
                $donnees['prenomRep'],
                new DateTime($donnees['debutDate']),
                new DateTime($donnees['finDate']),
                new DateTime($donnees['debutHeure']),
                new DateTime($donnees['finHeure']),
                $donnees['lieu'],
                $donnees['photo'] ?? null,
                $_SESSION['userId'] ?? null,
                $donnees['cateId']
            );
    
            // Log the event data for debugging
            error_log(print_r($evenement, true));
    
            // Insérez l'événement dans la base de données
            $managerEvenement->insert($evenement);
        } catch (Exception $e) {
            // Log the error message
            error_log("Error inserting event: " . $e->getMessage());
            throw $e; // Re-throw the exception if needed
        }
    }
}