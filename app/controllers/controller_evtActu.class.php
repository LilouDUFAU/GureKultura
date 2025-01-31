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
        $commentaires = $commentaireDao->findCommentairesByEventOrActu($id, $type);

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
            $evtId = htmlentities($_POST['evtId']);
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
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'estInscrit' => $estInscrit,
            'evtActus' => $evtActu 
        ]);
    }
    


    public function desinscrire() {
        $pdo = Bd::getInstance()->getPdo();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = htmlentities($_POST['nom']);
            $type = htmlentities($_POST['type']);
            $evtId = htmlentities($_POST['evtId']);
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
        echo $this->getTwig()->render('evtActu.html.twig', [
            'title' => $nom,
            'type' => $type,
            'actualites' => $actualite,
            'estInscrit' => $estInscrit,
            'evtActus' => $evtActu 
        ]);
    }
    
    public function ajouterCommentaire() {
        // Vérifier si l'utilisateur est connecté
        $pdo = Bd::getInstance()->getPdo();
        
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        
        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $user = $_SESSION['user'];
                $userId = $user->getUserId(); // Utiliser le getter pour obtenir l'ID de l'utilisateur
                $contenu = htmlspecialchars($_POST['commentaire']);
                $evtId = isset($_POST['evtId']) ? $_POST['evtId'] : null;
                $actuId = isset($_POST['actuId']) ? $_POST['actuId'] : null;

                if (empty($evtId) && empty($actuId)) {
                    echo "Erreur : L'ID de l'événement ou de l'actualité est invalide.";
                    return;
                }

                // Créer une instance de CommentaireDao pour ajouter un commentaire
                $commentaireDao = new CommentaireDao($pdo);
                $commentaireDao->ajouterCommentaire($contenu, $evtId, $actuId, $userId);

                // Redirection vers la page correcte en fonction du type
                if ($evtId) {
                    header("Location: index.php?controlleur=evtActu&methode=lister&id=" . $evtId . "&type=Evenements");
                } elseif ($actuId) {
                    header("Location: index.php?controlleur=evtActu&methode=lister&id=" . $actuId . "&type=Actualites");
                }
                exit();
            }
        } else {
            header("Location: index.php?controlleur=connexion&methode=lister");
            exit();
        }
    }
}
    

