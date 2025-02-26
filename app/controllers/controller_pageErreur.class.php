<?php

/**
 * @class ControllerPageErreur
 * @extends parent<Controller>
 * @details Permet de gérer les erreurs et afficher une page d'erreur avec un message dynamique.
 */
class ControllerPageErreur extends Controller
{
    /**
     * @constructor ControllerPageErreur
     * @details Constructeur de la classe ControllerPageErreur
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader)
    {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page d'erreur avec un message personnalisé.
     * @param string|null $errorMessage Message d'erreur à afficher (optionnel).
     * @return void
     */
    public function lister() {
        $e->getMessage();
        echo $this->getTwig()->render('pageErreur.html.twig', [
            'title' => 'Accueil',
            'error_message' => $e
        ]);
    }    

    public function messageErreur(string $e){
        error_log("Error inserting event: " . $e);
        echo $this->getTwig()->render('pageErreur.html.twig', [
            'title' => 'Accueil',
            'error_message' => $e
        ]);
    }

    public function mailErreur(string $e){
        $mail = new Mail();
        $objet = "Confirmation d'inscription";
        $corp = "
<div style='margin: 0; padding: 0; background-color: #FDF6EE; font-family: 'Sen', sans-serif; color: #2C3E50;'>
    <table width='100%' cellpadding='0' cellspacing='0' border='0' align='center'>
        <tr>
            <td align='center' bgcolor='#F26B3A' style='padding: 20px;'>
                <h1 style='color: #FDF6EE; margin: 0;'>🎉 Bienvenue chez GureKultura ! </h1>
            </td>
        </tr>
        <tr>
            <td align='center' style='padding: 40px 20px;'>
                <p style='font-size: 18px; line-height: 1.5; max-width: 600px;'>Nous sommes ravis de vous accueillir dans notre communauté dédiée à la culture basque ! Préparez-vous à découvrir des événements passionnants, des ateliers enrichissants et bien plus encore.</p>
                <p style='font-size: 18px;'>🎭 Événements | 🎶 Musique | 🍷 Gastronomie | 🏕️ Découvertes</p>
                <a href='#' style='display: inline-block; padding: 15px 25px; background-color: #D6453D; color: #FDF6EE; text-decoration: none; font-size: 18px; border-radius: 5px; margin-top: 20px;'>Découvrir nos activités</a>
            </td>
        </tr>
        <tr>
            <td align='center' bgcolor='#F26B3A' style='padding: 20px; color: #FDF6EE;'>
                <p style='margin: 0;'>Suivez-nous sur nos réseaux sociaux :</p>
                <p style='margin: 10px 0;'>
                    <a href='#' style='color: #FDF6EE; text-decoration: none; margin: 0 10px;'>Facebook</a> |
                    <a href='#' style='color: #FDF6EE; text-decoration: none; margin: 0 10px;'>Instagram</a> |
                    <a href='#' style='color: #FDF6EE; text-decoration: none; margin: 0 10px;'>Twitter</a>
                </p>
            </td>
        </tr>
    </table>
</div>";

        $mailEnvoyer = $mail->envoieMail($donnees['email'], $objet, $corp);
    }
}
