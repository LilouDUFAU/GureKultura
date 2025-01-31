<?php
// inclure la classe validator
require_once '../app/controllers/validator.class.php';


/**
 * @class ControllerModifActu
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "modifActu"
 */
class ControllerModifActu extends Controller
{

    /**
     * @constructor ControllerModifActu
     * @details Constructeur de la classe ControllerModifActu
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }


    /**
     * @function modifierActu
     * @details Fonction permettant de modifier une actualité
     * @uses ActualiteDao
     * @uses Bd
     * @uses update
     * @return void
     */
    public function lister()
    {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerCategorie = new CategorieDao($this->getPdo());
        $categories = $managerCategorie->findAll();

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findActuById($_POST['actuId']);
        $actuActuel = [];
        $actuActuel['id'] = $actualite[0]->getActuId();
        $actuActuel['titre'] = $actualite[0]->getTitre();
        $actuActuel['resume'] = $actualite[0]->getResume();
        $actuActuel['contenu'] = $actualite[0]->getContenu();
        $actuActuel['datePubli'] = $actualite[0]->getDatePubli();
        $actuActuel['img'] = $actualite[0]->getImg();
        $actuActuel['categorie'] = $actualite[0]->getNomCategorie();
        $actuActuel['categorieId'] = $actualite[0]->getCateId();

        $_SESSION['actuActuel'] = $actuActuel;

        // Rendre le template Twig
        echo $this->getTwig()->render('modifActu.html.twig', [
            'title' => 'Mes actualités',
            'actuActuel' => $actuActuel,
            'categories' => $categories,
        ]);
    }


    public function validerFormModifActu()
    {
        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
        
            // definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
            $regleValidation = [
                'titre' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 5,
                    'longueurMax' => 50,
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
                    'longueurMin' => 30,
                    'longueurMax' => 500,
                    'format' => '/^[a-zA-Z0-9\s]+$/'
                ],
                'contenu' => [
                    'obligatoire' => true,
                    'type' => 'string',
                    'longueurMin' => 30,
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

            // si l'id de la categorie n'est pas defini, alors on recupere celui de la variable de session actualiteActuel
            if (empty($donnees['cateId'])) {
                $donnees['cateId'] = $_SESSION['actuActuel']['categorieId'];
            }

            // boucle de nettoyage des donnees 
            foreach ($donnees as $key => $value) {
                $donnees[$key] = htmlentities($value);
            }
            $user = $_SESSION['user'];
            $donnees['userId'] = $user->getUserId();


            // validation des donnees du formulaire
            $donneesValides = $validator->valider($donnees);

            if (!$donneesValides) {
                var_dump($donneesValides);
                $messageErreurs = $validator->getMessageErreurs();
            }
            else{
                // verifier quel champ a ete modifie + recuperer la valeur du champ modifie avec un switch case
                if ($donnees['titre'] != $_SESSION['actuActuel']['titre']) {
                    $titreModifie = true;
                }
                else{
                    $titreModifie = false;
                }

                if ($donnees['resume'] != $_SESSION['actuActuel']['resume']) {
                    $resumeModifie = true;
                }
                else{
                    $resumeModifie = false;
                }

                if ($donnees['contenu'] != $_SESSION['actuActuel']['contenu']) {
                    $contenuModifie = true;
                }
                else{
                    $contenuModifie = false;
                }

                if ($donnees['img'] != $_SESSION['actuActuel']['img'] && $donnees['img'] != null) {
                    $imgModifie = true;
                }
                else{
                    $imgModifie = false;
                }

                if ($donnees['cateId'] != $_SESSION['actuActuel']['categorieId']) {
                    $categorieModifie = true;
                }
                else{
                    $categorieModifie = false;
                }

            }

            // recuperation des erreurs

            // Rendre le template Twig
            $pdo = Bd::getInstance()->getPdo();

            $loader = new \Twig\Loader\FilesystemLoader('../templates');
            $twig = new \Twig\Environment($loader);

            $managerCategorie = new CategorieDao($this->getPdo());
            $categories = $managerCategorie->findAll();

            $managerActualite = new ActualiteDao($this->getPdo());
            $actualite = $managerActualite->findActuById($_SESSION['actuActuel']['id']);

            if (!empty($messageErreurs)) {
                var_dump($messageErreurs);
                // Les données ne sont pas valides, affichez les erreurs
                echo $this->getTwig()->render('modifActu.html.twig', [
                    'title' => 'Proposition d\'événement',
                    'messageErreurs' => $messageErreurs,
                    'donnees' => htmlentities($donnees),
                    'actualites' => $actualite,
                    'categories' => $categories

                ]);
            } else {
                if ($titreModifie) {
                    $this->modifierDonneesDansLaBase($donnees['titre'], 'titre');
                }
                if ($resumeModifie) {
                    $this->modifierDonneesDansLaBase($donnees['resume'], 'resume');
                }
                if ($contenuModifie) {
                    $this->modifierDonneesDansLaBase($donnees['contenu'], 'contenu');
                }
                if ($imgModifie) {
                    $this->modifierDonneesDansLaBase($donnees['img'], 'img');
                }
                if ($categorieModifie) {
                    $this->modifierDonneesDansLaBase($donnees['cateId'], 'cateId');
                }

                $manager = new ActualiteDao($pdo);
                $actualite = $manager->findActuById($_SESSION['actuActuel']['id']);

                header('Location: index.php?controlleur=mesActu&methode=lister');
            }
        } else {
            header('Location: index.php?controlleur=connexion&methode=lister');
        }
    }

    public function modifierDonneesDansLaBase(string $donnees, string $champ){
        try{
            $pdo = Bd::getInstance()->getPdo();
            $managerActualite = new ActualiteDao($pdo);

            $managerActualite->update($donnees, $champ, $_SESSION['actuActuel']['id']);

            // redirection vers la page de l'événement
            // header('Location: index.php?controlleur=mesActu&methode=lister');:
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}