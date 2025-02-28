<?php

require_once 'mail.class.php';

/**
 * @class ControllerNewsLetter
 * @extends parent <Controller>
 * @details Permet à l'utilisateur de s'inscrire à la newsletter
 */
class ControllerNewsLetter extends Controller {

    /**
     * @constructor ControllerNewsLetter
     * @details Constructeur de la classe ControllerNewsLetter
     * @param \Twig\Environment $twig
     * @param \Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "NewsLetter" de base
     * @uses Bd
     * @uses \Twig\Loader\FilesystemLoader
     * @uses \Twig\Environment
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());

        // Rendre le template Twig
        echo $this->getTwig()->render('newsLetter.html.twig', [
            'title' => 'NewsLetter',
        ]);
    }

    public function validerFormulaireNewsLetter() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Vérification de l'e-mail
            $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
            
            $news = isset($_POST["news"]) ? "oui" : "non";
            $event = isset($_POST["event"]) ? "oui" : "non";
            $actu = isset($_POST["actu"]) ? "oui" : "non";

            $mail = new Mail();
            $destinataire = $email;
            $objet = "GureKultura - NewsLetter";
            $corp = "Merci de vous être inscrit à notre newsletter. Vous recevrez les actualités suivantes : <br>
                    News : " . $news . "<br>
                    Evénements : " . $event . "<br>
                    Actualités : " . $actu . "<br>";
            $mail->envoieMail($destinataire, $objet, $corp);
        }

        $this->lister();
    }
}