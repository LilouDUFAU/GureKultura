<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = 'smtp.hostinger.com';               //Adresse IP ou DNS du serveur SMTP
$mail->Port = 465;                          //Port TCP du serveur SMTP
$mail->SMTPAuth = 1;                        //Utiliser l'identification
$mail->CharSet = 'UTF-8';

if($mail->SMTPAuth){
   $mail->SMTPSecure = 'ssl';               //Protocole de sécurisation des échanges avec le SMTP
   $mail->Username   =  'contact@kyllianmorance.fr';    //Adresse email à utiliser
   $mail->Password   =  '&GtiPY8hqYq?7La@cKo!enYHnz9#8JC&x676#HCr';         //Mot de passe de l'adresse email à utiliser
}

$mail->From       = "contact@kyllianmorance.fr";               //L'email à afficher pour l'envoi
$mail->FromName   = "GureKultura";         //L'alias de l'email de l'emetteur

$mail->AddAddress(trim($_POST["email_to"]));

$mail->Subject    =  "changement de mot de passe";                      //Le sujet du mail
$mail->WordWrap   = 50; 			       //Nombre de caracteres pour le retour a la ligne automatique
$mail->AltBody = "ceci est un messages brut de test !"; 	       //Texte brut
$mail->IsHTML(false);                                  //Préciser qu'il faut utiliser le texte brut
$mail->MsgHTML("<h1> CECI EST UN MESSAGES DE TEST HTML </h1>");            //Forcer le contenu du body html pour ne pas avoir l'erreur "body is empty' même si on utilise l'email en contenu alternatif

if (!$mail->send()) {
      echo $mail->ErrorInfo;
} else{
      echo 'Message bien envoyé';
}
?>