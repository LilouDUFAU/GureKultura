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

        // Créer une instance de CommentaireDao
        $commentaireDao = new CommentaireDao($pdo);

        // Vérification des données POST et GET
        $type = isset($_POST['type']) ? $_POST['type'] : (isset($_GET['type']) ? $_GET['type'] : 'Evenements');
        $nom = isset($_POST['nom']) ? htmlentities($_POST['nom']) : '';
        $id = isset($_POST['id']) ? htmlentities($_POST['id']) : (isset($_GET['id']) ? htmlentities($_GET['id']) : '');

        // Sélectionner le bon DAO en fonction du type
        if ($type == "Evenements") {
            $managerEvtActu = new EvenementDao($pdo);
        } elseif ($type == "Actualites") {
            $managerEvtActu = new ActualiteDao($pdo);
        } else {
            echo "Erreur : Type invalide.";
        }

        if ($managerEvtActu) {
            // Récupérer l'événement ou l'actualité correspondant
            $evtActu = $managerEvtActu->find($id);
    
            // Vérifier si l'événement ou l'actualité existe
            if (!$evtActu) {
                echo "Erreur : L'événement ou l'actualité n'existe pas.";
            }
    
            // Récupérer les commentaires pour l'événement ou l'actualité
            $commentaires = $commentaireDao->findCommentairesByEventOrActu($id, $type);
    
            // Récupérer les actualités (si le type est "Actualites")
            $managerActualite = new ActualiteDao($pdo);
            $actualite = $managerActualite->findAllWithCategorie();
    
            // Rendre le template Twig
            echo $this->getTwig()->render('evtActu.html.twig', [
                'title' => $nom,
                'type' => $type,
                'actualites' => $actualite,
                'evtActus' => $evtActu,
                'commentaires' => $commentaires,
            ]);
    }
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
