<?php

/**
* @brief Classe User
* @details Classe permettant de gérer les utilisateurs
*/

class User {
    /**
     * @brief Identifiant de l'utilisateur
     * @details cet identifiant est générer automatiquement par la base de données
     * @var int
     */
    private ?int $userId;

    /**
     * @brief Nom de l'utilisateur
     * @details ce nom est renseigné par l'utilisateur
     * @var string
     */
    private ?string $nom;

    /**
     * @brief Pseudo de l'utilisateur
     * @details ce pseudo est renseigné par l'utilisateur
     * @var string
     */
    private ?string $pseudo;

    /**
     * @brief Email de l'utilisateur
     * @details cet email est renseigné par l'utilisateur
     * @var string
     */
    private ?string $email;

    /**
     * @brief Mot de passe de l'utilisateur
     * @details ce mot de passe est renseigné par l'utilisateur
     * @var string
     */
    private ?string $mdp;

    /**
     * @brief Date d'inscription de l'utilisateur
     * @details cette date est générer automatiquement par la base de données
     * @var DateTime
     */
    private ?DateTime $dateInscr;

    /**
     * @brief biographie de l'utilisateur
     * @details cette biographie est renseigné par l'utilisateur
     * @var string
     */
    private ?string $bio;

    /**
     * @brief photo de profil de l'utilisateur
     * @details seul le chemin de la photo est stocké dans la base de données
     * @var string
     */
    private ?string $pfp;

    /**
     * @brief Savoir si le rôle de l'utilisateur est administrateur ou non
     * @details cette information est renseigné par l'administrateur, prend la valeur 1 si l'utilisateur est administrateur et 0 sinon
     * @var bool
     */
    private ?bool $estAdmin;

    /**
     * @brief Constructeur de la classe User
     * @details Permet de créer un nouvel utilisateur
     * @param int $userId Identifiant de l'utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $pseudo Pseudo de l'utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $mdp Mot de passe de l'utilisateur
     * @param string $dateInscr Date d'inscription de l'utilisateur
     * @param string $bio Biographie de l'utilisateur
     * @param string $pfp Photo de profil de l'utilisateur
     * @param bool $estAdmin Savoir si l'utilisateur est administrateur ou non
     * @return void
     */
    public function __construct(?int $userId=null,
    ?string $nom = null,
    ?string $pseudo = null,
    ?string $email = null,
    ?string $mdp = null,
    ?DateTime $dateInscr = null,
    ?string $bio = null,
    ?string $pfp = null,
    bool $estAdmin = false)
    {
        $this->userId = $userId;
        $this->nom = $nom;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->dateInscr = $dateInscr;
        $this->bio = $bio;
        $this->pfp = $pfp;
        $this->estAdmin = $estAdmin;
    }

    ///////////GETTERS///////////

    /**
     * @brief Getter de l'id
     * @details Permet de récupérer l'id de l'utilisateur
     * @return int
     */
    public function getUserId(): ?int {
        return $this->userId;
    }

    /**
     * @brief Getter du nom
     * @details Permet de récupérer le nom de l'utilisateur
     * @return string
     */
    public function getNom(): ?string {
        return $this->nom;
    }

    /**
     * @brief Getter du pseudo
     * @details Permet de récupérer le pseudo de l'utilisateur
     * @return string
     */
    public function getPseudo(): ?string {
        return $this->pseudo;
    }

    /**
     * @brief Getter de l'email
     * @details Permet de récupérer l'email de l'utilisateur
     * @return string
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * @brief Getter du mot de passe
     * @details Permet de récupérer le mot de passe de l'utilisateur
     * @return string
     */
    public function getMdp(): ?string {
        return $this->mdp;
    }

    /**
     * @brief Getter de la date d'inscription
     * @details Permet de récupérer la date d'inscription de l'utilisateur
     * @return string
     */
    public function getDateInscr(): ?DateTime {
        return $this->dateInscr;
    }

    /**
     * @brief Getter de la biographie
     * @details Permet de récupérer la biographie de l'utilisateur
     * @return string
     */
    public function getBio(): ?string {
        return $this->bio;
    }

    /**
     * @brief Getter de la photo de profil
     * @details Permet de récupérer la photo de profil de l'utilisateur
     * @return string
     */
    public function getPfp(): ?string {
        return $this->pfp;
    }

    /**
     * @brief Getter du rôle
     * @details Permet de récupérer le rôle de l'utilisateur
     * @return bool
     */
    public function getEstAdmin(): bool {
        return $this->estAdmin;
    }

    ///////////SETTERS///////////

    /**
     * @brief Setter de l'id
     * @details Permet de modifier l'id de l'utilisateur
     * @param int $userId
     * @return void
     */
    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    /**
     * @biref Setter du nom
     * @details Permet de modifier le nom de l'utilisateur
     * @param string $nom
     * @return void
     */
    public function setNom(?string $nom): void {
        $this->nom = $nom;
    }

    /**
     * @brief Setter du pseudo
     * @details Permet de modifier le pseudo de l'utilisateur
     * @param string $pseudo
     * @return void
     */
    public function setPseudo(?string $pseudo): void {
        $this->pseudo = $pseudo;
    }

    /**
     * @brief Setter de l'email
     * @details Permet de modifier l'email de l'utilisateur
     * @param string $email
     * @return void
     */
    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    /**
     * @brief Setter du mot de passe
     * @details Permet de modifier le mot de passe de l'utilisateur
     * @param string $mdp
     * @return void
     */
    public function setMdp(?string $mdp): void {
        $this->mdp = $mdp;
    }

    /**
     * @brief Setter de la date d'inscription
     * @details Permet de modifier la date d'inscription de l'utilisateur
     * @param string $dateInscr
     * @return void
     */
    public function setDateInscr(?DateTime $dateInscr): void {
        $this->dateInscr = $dateInscr;
    }

    /**
     * @brief Setter de la biographie
     * @details Permet de modifier la biographie de l'utilisateur
     * @param string $bio
     * @return void
     */
    public function setBio(?string $bio): void {
        $this->bio = $bio;
    }

    /**
     * @brief Setter de la photo de profil
     * @details Permet de modifier la photo de profil de l'utilisateur
     * @param string $pfp
     * @return void
     */
    public function setPfp(?string $pfp): void {
        $this->pfp = $pfp;
    }

    /**
     * @brief Setter du rôle
     * @details Permet de modifier le rôle de l'utilisateur
     * @param bool $estAdmin
     */
    public function setEstAdmin(bool $estAdmin): void {
        $this->estAdmin = $estAdmin;
    }

    public function dateActuelle(): string {
        $date = date("Y-m-d");
        return $date;
    }
    
}