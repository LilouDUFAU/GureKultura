<?php 


require_once '../app/controllers/mail.class.php';

/**
 * @class ControllerMdpOublie
 * @extends parent<Controller>
 * @details Permet de gérer les actions liées à la page "mdpOublie"
 */
class ControllerMdpOublie extends Controller {

    /**
     * @constructor ControllerMdpOublie
     * @details Constructeur de la classe ControllerMdpOublie
     * @param Twig\Environment $twig
     * @param Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "Mot de passe oublié"
     * @uses ActualiteDao
     * @uses Bd
     * @uses findAllWithCategorie
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        $managerActualite = new ActualiteDao($this->getPdo());
        $actualite = $managerActualite->findAllWithCategorie();

        $managerToken = new TokenDao($this->getPdo());

        $managerUser = new UserDao($this->getPdo());

        $mailEnvoyer = false;
        $destinataire = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST != null){
                $destinataire = htmlentities($_POST['email_to']);
            }
        }
        
        if ($destinataire != null) {

            $user = $managerUser->findWithEmail($destinataire);
            if($user != null){
                
                $token = $this->generateToken(32);
                //$token = hash('sha256', $token);
                $dateActuelle = new DateTime('now');
                $dateExpiration = new DateTime('now');
                $dateActuelle->format('Y-m-d H:i:s');
                $dateExpiration->format('Y-m-d H:i:s');
                $dateExpiration->add(new DateInterval('PT15M'));
                $newToken = new Token(
                    null,
                    $user->getUserId(), 
                    $token,
                    $dateActuelle,
                    $dateExpiration
                );
                $tokenExist = $managerToken->findUserId($user->getUserId());
                if($tokenExist == null  || $tokenExist == false){
                    $managerToken->insert($newToken);
                }
                else{
                    $managerToken->delete($tokenExist);
                    $managerToken->insert($newToken);
                }
                $mail = new Mail();
                $objet = "changement de mot de passe";
                $corp = "<h1> Lien pour réinitialiser le mot de passe : </h1>
                <a href='http://127.0.0.1/GureKultura/php/index.php?controlleur=mdpReinitialisation&methode=lister&tok=$token'>
                Cliquez ici</a>";
                $mailEnvoyer = $mail->envoieMail($destinataire, $objet, $corp);   
            }
        }

        // Rendre le template Twig
        echo $this->getTwig()->render('mdpOublie.html.twig', [
            'title' => 'Mot de passe oublie',
            'actualites' => $actualite,
            'emailSend' => $mailEnvoyer
        ]);
    }
    public function generateToken($length)
	{
		if (!function_exists('random_bytes')) die('The random_bytes() function is required (PHP 7.0).');
		$result = '';
		$remainingLength = $length;
		do
		{
			$binaryLength = (int)($remainingLength * 3 / 4 + 1);
			$binaryString = random_bytes($binaryLength);
			$base64String = base64_encode($binaryString);
			
			$base62String = str_replace(array('+', '/', '='), '', $base64String);
			$result .= $base62String;
			
			$remainingLength = $length - strlen($result);
		} while ($remainingLength > 0);
		return substr($result, 0, $length);
	}
}
