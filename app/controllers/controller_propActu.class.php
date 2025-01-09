<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';


class ControllerPropActu extends Controller
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
        $actualite = $managerActualite->findAllWithCategorie();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        // Rendre le template Twig
        echo $this->getTwig()->render('propActu.html.twig', [
            'title' => 'Proposisition d\'actualité',
            'actualites' => $actualite,
            'categories' => $categories
        ]);
    }


    public function validerFormulairePropActu()
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
            'resume' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 100,
                'longueurMax' => 500,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'contenu' => [
                'obligatoire' => true,
                'type' => 'string',
                'longueurMin' => 100,
                'longueurMax' => 500,
                'format' => '/^[a-zA-Z0-9\s]+$/'
            ],
            'image' => [
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
        $actualite = $managerActualite->findAllWithCategorie();

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        if (!empty($messageErreurs)) {
            // Les données ne sont pas valides, affichez les erreurs
            echo $this->getTwig()->render('propActu.html.twig', [
                'title' => 'Proposition d\'actualité',
                'messageErreurs' => $messageErreurs,
                'donnees' => $donnees,
                'actualites' => $actualite,
                'categories' => $categories
            ]);
            echo 'ya des erreurs';
        } else {
            echo $this->getTwig()->render('propActu.html.twig', [
                'title' => 'Proposition d\'actualité',
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
            $managerActualite = new ActualiteDao($pdo);
    
            // Créez un nouvel objet Evenement avec les données du formulaire
            $actualite = new Actualite(
                null,
                $donnees['titre'],
                $donnees['autorisation'] ?? null,
                $donnees['description'],
                $donnees['email'],
                // $_SESSION['userId'],
                $donnees['cateId']
            );
    
            // Log the event data for debugging
            error_log(print_r($actualite, true));
    
            echo 'avant insertion en bd';
            // Insérez l'événement dans la base de données
            $managerActualite->insert($actualite);
        } catch (Exception $e) {
            // Log the error message
            error_log("Error inserting event: " . $e->getMessage());
            throw $e; // Re-throw the exception if needed
        }
    }
}