<?php

// namespace App\Models;

/**
 * @brief Classe Evenement
 * @details Cette classe permet de gérer les événements
 */
class Evenement
{
    /**
     * @brief Identifiant de l'événement
     * @details Cet identifiant est généré automatiquement par la base de données
     * @var int 
     */
    private ?int $evtId;


    /**
     * @brief Titre de l'événement
     * @details Ce titre est donné par l'utilisateur
     * @var string
     */
    private ?string $titre;


    /**
     * @brief Autorisation de l'événement
     * @details Cette autorisation est donnée par l'utilisateur
     * @var string
     */
    private ?string $autorisation;


    /**
     * @brief Email de l'événement
     * @details Cet email est donné par l'utilisateur
     * @var string
     */
    private ?string $email;


    /**
     * @brief Téléphone de l'événement
     * @details Ce téléphone est donné par l'utilisateur
     * @var string
     */
    private ?string $tel;


    /**
     * @brief Nom du représentant
     * @details Ce nom est donné par l'utilisateur
     * @var string
     */
    private ?string $nomRep;


    /**
     * @brief Prénom du représentant
     * @details Ce prénom est donné par l'utilisateur
     * @var string
     */
    private ?string $prenomRep;


    /**
     * @brief Description de l'événement
     * @details Cette description est donnée par l'utilisateur
     * @var string
     */
    private ?string $description;


    /**
     * @brief Début de la date
     * @details Cette date est donnée par l'utilisateur
     * @var DateTime
     */
    private ?DateTime $dateDebut;


    /**
     * @brief Fin de la date
     * @details Cette date est donnée par l'utilisateur
     * @var DateTime
     */
    private ?DateTime $dateFin;


    /**
     * @brief Début de l'heure
     * @details Cette heure est donnée par l'utilisateur
     * @var DateTime
     */
    private ?DateTime $heureDebut;


    /**
     * @brief Fin de l'heure
     * @details Cette heure est donnée par l'utilisateur
     * @var DateTime
     */
    private ?DateTime $heureFin;

    /**
     * @brief Lieu de l'événement
     * @details Ce lieu est donné par l'utilisateur
     * @var string
     */
    private ?string $lieu;

     /**
     * @brief Photo de l'événement
     * @details Cette photo est donnée par l'utilisateur
     * @var string
     */
    private ?string $photo; 
     

     /**
     * @brief Id de l'utilisateur qui propose l'evenement
     * @details Cet id est recuperer par la session
     * @var string
     */
    private ?int $userId; 
     

    /**
     * @brief Id de la catégorie de l'evenement
     * @details Cet id est recuperer par la session
     * @var string
     */
    private ?int $cateId; 
     

    /**
     * @brief Nom de la catégorie
     * @details Ce nom est selectionne par l'utilisateur
     * @var string 
     */
    private ?string $nomCategorie;


    /**
     * @brief Constructeur de la classe Evenement
     * @details Ce constructeur permet de créer un nouvel événement
     * @param int $evtId
     * @param string $titre
     * @param string $autorisation
     * @param string $email
     * @param string $tel
     * @param string $nomRep
     * @param string $prenomRep
     * @param string $description
     * @param DateTime $debutDate
     * @param DateTime $finDate
     * @param DateTime $debutHeure
     * @param DateTime $finHeure
     * @param string $lieu
     * @param string $photo
     * @param Categorie $categorie
     * @param string $nomCategorie
     * @return void
     */
    public function __construct(?int $evtId=null, 
    ?string $titre=null, 
    ?string $autorisation=null,
    ?string $description=null,
    ?string $email=null, 
    ?string $tel=null, 
    ?string $nomRep=null, 
    ?string $prenomRep=null, 
    ?DateTime $dateDebut=null, 
    ?DateTime $dateFin=null, 
    ?DateTime $heureDebut=null, 
    ?DateTime $heureFin=null,
    ?string $lieu=null,
    ?string $photo=null,
    ?int $userId=null,
    ?int $cateId=null,
    ?string $nomCategorie=null)
    {
        $this->evtId = $evtId;
        $this->titre = $titre;
        $this->autorisation = $autorisation;
        $this->description = $description;
        $this->email = $email;
        $this->tel = $tel;
        $this->nomRep = $nomRep;
        $this->prenomRep = $prenomRep;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->heureDebut = $heureDebut;
        $this->heureFin = $heureFin;
        $this->lieu = $lieu;
        $this->photo = $photo;
        $this->userId = $userId;
        $this->cateId = $cateId;
        $this->nomCategorie = $nomCategorie;
    }

    /////////////////////////////
    ////////// Getters //////////
    /////////////////////////////

    /**
     * @brief Getter de l'ID
     * @details Cette fonction permet de récupérer l'identifiant de l'événement
     * @return int
     */
    public function getEvtId(): ?int
    {
        return $this->evtId;
    }


    /**
     * @brief Getter du titre
     * @details Cette fonction permet de récupérer le titre de l'événement
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }


    /**
     * @brief Getter de l'autorisation
     * @details Cette fonction permet de récupérer l'autorisation de l'événement
     * @return string
     */
    public function getAutorisation(): ?string
    {
        return $this->autorisation;
    }


    /**
     * @brief Getter de l'email
     * @details Cette fonction permet de récupérer l'email de l'événement
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @brief Getter du téléphone
     * @details Cette fonction permet de récupérer le téléphone de l'événement
     * @return string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }


    /**
     * @brief Getter du nom du représentant
     * @details Cette fonction permet de récupérer le nom du représentant
     * @return string
     */
    public function getNomRep(): ?string
    {
        return $this->nomRep;
    }


    /**
     * @brief Getter du prénom du représentant
     * @details Cette fonction permet de récupérer le prénom du représentant
     * @return string
     */
    public function getPrenomRep(): ?string
    {
        return $this->prenomRep;
    }


    /**
     * @brief Getter de la description
     * @details Cette fonction permet de récupérer la description de l'événement
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @brief Getter du début de la date
     * @details Cette fonction permet de récupérer le début de la date de l'événement
     * @return DateTime
     */
    public function getDateDebut(): ?DateTime
    {
        return $this->dateDebut;
    }


    /**
     * @brief Getter de la fin de la date
     * @details Cette fonction permet de récupérer la fin de la date de l'événement
     * @return DateTime
     */
    public function getDateFin(): ?DateTime
    {
        return $this->dateFin;
    }


    /**
     * @brief Getter du début de l'heure
     * @details Cette fonction permet de récupérer le début de l'heure de l'événement
     * @return DateTime
     */
    public function getHeureDebut(): ?DateTime
    {
        return $this->heureDebut;
    }


    /**
     * @brief Getter de la fin de l'heure
     * @details Cette fonction permet de récupérer la fin de l'heure de l'événement
     * @return DateTime
     */
    public function getHeureFin(): ?DateTime
    {
        return $this->heureFin;
    } 
      
    /**
     * @brief Getter du lieu
     * @details Cette fonction permet de récupérer le lieu de l'événement
     * @return string
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }


    /**
     * @brief Getter de la photo
     * @details Cette fonction permet de récupérer la photo de l'événement
     * @return string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /***
     * @brief Getter de l'identifiant utilisateur
     * @details Cette fonction permet de récupérer l'identifiant de l'utilisateur
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @brief Getter de l'identifiant de la catégorie
     * @details Cette fonction permet de récupérer l'identifiant de la catégorie
     * @return int
     */
    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    /**
     * @brief Getter du nom de la catégorie
     * @details Cette fonction permet de récupérer le nom de la catégorie
     * @return string
     */
    public function getNomCategorie(): ?string 
    {
        return $this->nomCategorie;
    }

      
    /////////////////////////////
    ////////// Setters //////////
    /////////////////////////////

    /**
     * @brief Setter de l'ID
     * @details Cette fonction permet de définir l'identifiant de l'événement
     * @param int $evtId
     * @return void
     */
    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }


    /**
     * @brief Setter du titre
     * @details Cette fonction permet de définir le titre de l'événement
     * @param string $titre
     * @return void
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }


    /**
     * @brief Setter de l'autorisation
     * @details Cette fonction permet de définir l'autorisation de l'événement
     * @param string $autorisation
     * @return void
     */
    public function setAutorisation(?string $autorisation): void
    {
        $this->autorisation = $autorisation;
    }


    /**
     * @brief Setter de l'email
     * @details Cette fonction permet de définir l'email de l'événement
     * @param string $email
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


    /**
     * @brief Setter du téléphone
     * @details Cette fonction permet de définir le téléphone de l'événement
     * @param string $tel
     * @return void
     */
    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }


    /**
     * @brief Setter du nom du représentant
     * @details Cette fonction permet de définir le nom du représentant
     * @param string $nomRep
     * @return void
     */
    public function setNomRep(?string $nomRep): void
    {
        $this->nomRep = $nomRep;
    }


    /**
     * @brief Setter du prénom du représentant
     * @details Cette fonction permet de définir le prénom du représentant
     * @param string $prenomRep
     * @return void
     */
    public function setPrenomRep(?string $prenomRep): void
    {
        $this->prenomRep = $prenomRep;
    }


    /**
     * @brief Setter de la description
     * @details Cette fonction permet de définir la description de l'événement
     * @param string $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }


    /**
     * @brief Setter du début de la date
     * @details Cette fonction permet de définir le début de la date de l'événement
     * @param DateTime $dateDebut
     * @return void
     */
    public function setDateDebut(?DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }


    /**
     * @brief Setter de la fin de la date
     * @details Cette fonction permet de définir la fin de la date de l'événement
     * @param DateTime $dateFin
     * @return void
     */
    public function setDateFin(?DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }


    /**
     * @brief Setter du début de l'heure
     * @details Cette fonction permet de définir le début de l'heure de l'événement
     * @param DateTime $heureDebut
     * @return void
     */
    public function setHeureDebut(?DateTime $heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }


    /**
     * @brief Setter de la fin de l'heure
     * @details Cette fonction permet de définir la fin de l'heure de l'événement
     * @param DateTime $heureFin
     * @return void
     */
    public function setHeureFin(?DateTime $heureFin): void
    {
        $this->heureFin = $heureFin;
    }

    /***
     * @brief Setter du lieu
     * 
     * @param string $lieu
     * 
     * @return void
     */
    public function setLieu(?string $lieu): void
    {
        $this->lieu = $lieu;
    }


    /***
     * @brief Setter de la photo
     * @details Cette fonction permet de définir la photo de l'événement
     * @param string $photo
     * @return void
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }


    /**
     * @brief Setter de l'identifiant de l'utilisateur
     * @details Cette fonction permet de définir l'identifiant de l'utilisateur
     * @param int $userId
     * @return void
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }    
    
    
    /**
    * @brief Setter de l'identifiant de la catégorie
    * @details Cette fonction permet de définir l'identifiant de la catégorie
    * @param int $cateId
    * @return void
    */
   public function setCateId(?int $cateId): void
   {
       $this->cateId = $cateId;
   }


   /**
    * @brief Setter du nom de la catégorie
    * @details Cette fonction permet de définir le nom de la catégorie 
    * @param string $nomCategorie
    * @return void
    */
    public function setNomCategorie(?string $nomCategorie): void
    {
        $this->nomCategorie = $nomCategorie;
    }
}