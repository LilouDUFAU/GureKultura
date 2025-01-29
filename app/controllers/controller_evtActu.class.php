<?php 

/**
 * @class ControllerEvtActu
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "evtActu"
 */
class ControllerEvtActu extends Controller {

    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "evtActu"
     */
    public function lister() {
        // Récupérer la connexion PDO
        $pdo = Bd::getInstance()->getPdo();
    
        // Vérification des données POST et GET
        // Si $type n'est pas spécifié, on lui assigne "Evenements" comme valeur par défaut
        $type = isset($_POST['type']) ? $_POST['type'] : (isset($_GET['type']) ? $_GET['type'] : 'Evenements');
        $nom = isset($_POST['nom']) ? htmlentities($_POST['nom']) : '';
        $id = isset($_POST['id']) ? htmlentities($_POST['id']) : (isset($_GET['id']) ? htmlentities($_GET['id']) : ''); 
    
        // Vérifier que $type est défini et correspond à un type valide
        if (empty($type)) {
            echo "Erreur : Type non spécifié.";
            return;
        }
    
        // Sélectionner le bon DAO en fonction du type
        if ($type == "Evenements") {
            $managerEvtActu = new EvenementDao($pdo);
        } elseif ($type == "Actualites") {
            $managerEvtActu = new ActualiteDao($pdo);
        } else {
            echo "Erreur : Type invalide.";
            return;
        }
    
        // Vérification que $managerEvtActu est bien initialisé
        if ($managerEvtActu) {
            // Récupérer l'événement ou l'actualité correspondant
            $evtActu = $managerEvtActu->find($id);
    
            // Vérifier si l'événement ou l'actualité existe
            if (!$evtActu) {
                echo "Erreur : L'événement ou l'actualité n'existe pas.";
                return;
            }
    
            // Récupérer les commentaires associés à l'événement
            $commentaires = $this->afficherCommentaires($id, $type);
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
    

    /**
     * @function ajouterCommentaire
     * @details Permet d'ajouter un commentaire
     */
    public function ajouterCommentaire()
{
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    
        // Si l'utilisateur est connecté, on traite le commentaire
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Récupérer les informations de l'utilisateur depuis la session
            $user = $_SESSION['user'];  // Récupérer l'objet utilisateur
            $userId = $user->getUserId(); // Utiliser le getter pour obtenir l'ID de l'utilisateur
            $evtId = isset($_POST['evtId']) ? $_POST['evtId'] : null;
            $actuId = isset($_POST['actuId']) ? $_POST['actuId'] : null;
            $contenu = htmlspecialchars($_POST['commentaire']); // Sécuriser le contenu du commentaire

            // Vérification si l'ID de l'événement ou de l'actualité est valide
            if (empty($evtId) && empty($actuId)) {
                echo "Erreur : L'ID de l'événement ou de l'actualité est invalide.";
                return;
            }

            // Insertion dans la base de données
            $pdo = Bd::getInstance()->getPdo();
            $sql = "INSERT INTO gk_commentaire (contenu, datePubli, evtId, actuId, userId) 
                    VALUES (:contenu, NOW(), :evtId, :actuId, :userId)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':contenu' => $contenu, 
                ':evtId' => $evtId, 
                ':actuId' => $actuId, 
                ':userId' => $userId
            ]);

            // Redirection vers la page correcte en fonction du type (événement ou actualité)
            if ($evtId) {
                // Si un événement est lié au commentaire, rediriger vers l'événement
                header("Location: index.php?controlleur=evtActu&methode=lister&id=" . $evtId . "&type=Evenements");
            } elseif ($actuId) {
                // Si une actualité est liée au commentaire, rediriger vers l'actualité
                header("Location: index.php?controlleur=evtActu&methode=lister&id=" . $actuId . "&type=Actualites");
            }
            exit();
        }
    } else {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        header("Location: index.php?controlleur=connexion&methode=lister");
        exit();
    }
}

    



    /**
     * @function afficherCommentaires
     * @details Permet de récupérer les commentaires associés à un événement ou une actualité
     */
    public function afficherCommentaires($id, $type) {
        $pdo = Bd::getInstance()->getPdo();
    
        // Vérifier si le type est "Evenement" ou "Actualite" et récupérer les commentaires correspondants
        if ($type == "Evenements") {
            // Requête pour récupérer les commentaires pour un événement
            $sql = "SELECT c.contenu, c.datePubli, u.nom AS userNom 
                    FROM gk_commentaire c 
                    JOIN gk_user u ON c.userId = u.userId 
                    WHERE c.evtId = :id 
                    ORDER BY c.datePubli DESC";
        } elseif ($type == "Actualites") {
            // Requête pour récupérer les commentaires pour une actualité
            $sql = "SELECT c.contenu, c.datePubli, u.nom AS userNom 
                    FROM gk_commentaire c 
                    JOIN gk_user u ON c.userId = u.userId 
                    WHERE c.actuId = :id 
                    ORDER BY c.datePubli DESC";
        } else {
            echo "Erreur : Type invalide.";
            return [];
        }
    
        // Exécuter la requête
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $commentaires;
    }
    

}


