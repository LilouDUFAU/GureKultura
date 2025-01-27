<?php

require_once '../vendor/phpmailer/phpmailer/src/Exception.php';
require_once '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once '../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private PHPMailer $mail;

    /**
     * @brief Constructeur de la classe Mail
     */
    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->Host = 'smtp.gmail.com';               //Adresse IP ou DNS du serveur SMTP
        $this->mail->Port = 465;                            //Port TCP du serveur SMTP
        $this->mail->SMTPAuth = true; 
        $this->mail->SMTPDebug = 0;                         //Utiliser l'identification
        $this->mail->CharSet = 'UTF-8';

        if($this->mail->SMTPAuth){
        $this->mail->SMTPSecure = 'ssl';                    //Protocole de sécurisation des échanges avec le SMTP
        $this->mail->Username = 'gurekultura@gmail.com';    //Adresse email à utiliser
        $this->mail->Password = 'ghkt guvs fbsr xkvm';      //Mot de passe de l'adresse email à utiliser
        }

        $this->mail->From = "gurekultura@gmail.com";        //L'email à afficher pour l'envoi
        $this->mail->FromName = "GureKultura";              //L'alias de l'email de l'emetteur

    }



    /**
     * @brief Methode qui permet d'envoyer un mail
     * 
     * @param string $destinataire l'adresse email du destinataire
     * @param string $objet l'objet du mail
     * @param string $corp le contenu du mail
     * 
     * @return bool true si le mail a été envoyé, false sinon.
     */
    public function envoieMail(string $destinataire, string $objet, string $corp): bool
    {
        $this->mail->AddAddress($destinataire); //Adresse du destinataire

        $this->mail->Subject = $objet;          //Le sujet du mail
        $this->mail->WordWrap = 50; 		    //Nombre de caracteres pour le retour a la ligne automatique
        $this->mail->IsHTML(true);              //Préciser qu'il faut utiliser le texte brut
        $this->mail->MsgHTML("Madame, Monsieur<br><br>".$corp."<br> Cordialement. <br> L'équipe GureKultura | Groupe 7 ");            //Forcer le contenu du body html pour ne pas avoir l'erreur "body is empty' même si on utilise l'email en contenu alternatif
        if (!$this->mail->send()) {
            echo $this->mail->ErrorInfo;
        } else{
            $mailEnvoyer = true;
        }
        return $mailEnvoyer;	
    }

}