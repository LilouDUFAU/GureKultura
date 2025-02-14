<?php

class ControllerEvtActu extends Controller {

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    public function lister() {
        // Récupérer la connexion PDO
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $id = htmlentities($_POST['id']);
        }
        // Créer une instance de CommentaireDao
        $commentaireDao = new CommentaireDao($pdo);
        // Récupérer les commentaires pour l'événement ou l'actualité
        if($type == 'Evenements'){
            $commentaires = $commentaireDao->findCommentairesByEvenement($id);
        } else if($type == 'Actualites'){
            $commentaires = $commentaireDao->findCommentairesByActualite($id);
        }

        $managerActualite = new ActualiteDao($pdo);

        $estInscrit = false;

        if ($type == "Evenements"){
            $managerEvtActu = new EvenementDao($pdo);

            $user = $_SESSION['user'];
            $managerParticiper = new ParticiperDAO($pdo);
            $participerExist = $managerParticiper->findUserEvt($user->getUserId(), $id);
            if($participerExist == null  || $participerExist == false){
                $estInscrit = false;
            }
            else{
                $estInscrit = true;
            }
        } if ($type == "Actualites"){
            $managerEvtActu = new ActualiteDao($pdo);
        } 

        $evtActu = $managerEvtActu->find($id);
        $actualite = $managerActualite->findAllWithCategorie(); 
        // Rendre le template Twig
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'evtActus' => $evtActu,
            'estInscrit' => $estInscrit,
            'commentaires' => $commentaires
        ]);
    }   



    public function inscrire() {
        $pdo = Bd::getInstance()->getPdo();
        
        $user = $_SESSION['user'];
        $userId = $user->getUserId();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $evtId = htmlentities($_POST['id']);
        }

        $evt = new Evenement();
        $evt->setEvtId($evtId);
        $managerEvenement = new EvenementDao($pdo);
        $evtActu = $managerEvenement->find($evtId);
        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        $managerParticiper = new ParticiperDAO($pdo);
        $estInscrit = true;
        $participerExist = $managerParticiper->findUserEvt($userId, $evtId);


        if ($participerExist == null || $participerExist == false) {
            $dateActuelle = new DateTime('now');
            $dateActuelle->format('Y-m-d H:i:s');
            $participer = new Participer(
                $userId,
                $evtId,
                $dateActuelle
            );

            $managerParticiper->insert($participer);
            $estInscrit = true;  
        }
        
    
        // Rendre le template Twig
        $this->lister($_SERVER);
    }
    


    public function desinscrire() {
        $pdo = Bd::getInstance()->getPdo();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $evtId = htmlentities($_POST['id']);
        }

        $user = $_SESSION['user'];
        $userId = $user->getUserId();

        $managerEvenement = new EvenementDao($pdo);
        $evtActu = $managerEvenement->find($evtId);
        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();    

        $managerParticiper = new ParticiperDAO($pdo);
        $participerExist = $managerParticiper->findUserEvt($userId, $evtId);
        
        if ($participerExist != null) {
            $managerParticiper->delete($participerExist);
            $estInscrit = false;
        } else {
            $estInscrit = true;
        }
    
        // Rendre le template Twig
        $this->lister($_SERVER);
    }
    
    public function ajouterCommentaire() {
        // Vérifier si l'utilisateur est connecté
        $pdo = Bd::getInstance()->getPdo();
        
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nom = htmlentities($_POST['nom']);
                $type = htmlentities($_POST['type']);
                $evtId = htmlentities($_POST['id']);
                $contenu = htmlspecialchars($_POST['commentaire']);
            }
            $datetime = new DateTime('now');
                // Créer une instance de CommentaireDao pour ajouter un commentaire
                $commentaireDao = new CommentaireDao($pdo);
                if($type == 'Actualites'){
                    $commentaire = new Commentaire(
                        null,
                        date_format($datetime, 'Y-m-d H:i:s'),
                        $contenu,
                        $evtId,
                        $_SESSION['user']->getUserId(),
                        null,
                        $_SESSION['user']->getPseudo()
                    );
                } else if($type == 'Evenements'){
                    $commentaire = new Commentaire(
                        null,
                        date_format($datetime, 'Y-m-d H:i:s'),
                        $contenu,
                        null,
                        $_SESSION['user']->getUserId(),
                        $evtId,
                        $_SESSION['user']->getPseudo()
                    );
                }
                
                $commentaireDao->insert($commentaire);

        }         
        $this->lister($_SERVER);
    }
}
    

