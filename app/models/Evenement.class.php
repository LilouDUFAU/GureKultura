<?php

// namespace App\Models;


/**
 * @class Evenement
 * @details Permet de gérer les événements
 */
class Evenement
{

    /**
     * @brief id de l'événement
     * @var int|null
     */
    private ?int $evtId;

    /**
     * @brief titre de l'événement
     * @var string|null
     */
    private ?string $titre;

    /**
     * @brief autorisation de l'événement
     * @var string|null
     */
    private ?string $autorisation;

    /**
     * @brief email du responsable de l'événement
     * @var string|null
     */
    private ?string $email;

    /**
     * @brief téléphone du responsable de l'événement
     * @var string|null
     */
    private ?string $tel;

    /**
     * @brief nom du responsable de l'événement
     * @var string|null
     */
    private ?string $nomRep;

    /**
     * @brief prénom du responsable de l'événement
     * @var string|null
     */
    private ?string $prenomRep;

    /**
     * @brief description de l'événement
     * @var string|null
     */
    private ?string $description;

    /**
     * @brief date de début de l'événement
     * @var DateTime|null
     */
    private ?DateTime $dateDebut;

    /**
     * @brief date de fin de l'événement
     * @var DateTime|null
     */
    private ?DateTime $dateFin;

    /**
     * @brief heure de début de l'événement
     * @var DateTime|null
     */
    private ?DateTime $heureDebut;

    /**
     * @brief heure de fin de l'événement
     * @var DateTime|null
     */
    private ?DateTime $heureFin;

    /**
     * @brief lieu de l'événement
     * @var string|null
     */
    private ?string $lieu;

    /**
     * @brief photo de l'événement
     * @var string|null
     */
    private ?string $photo; 

    /**
     * @brief validation de l'evenement
     * @var bool|null
     */
    private ?bool $is_valide;

    /**
     * @brief id de l'utilisateur ajoutant l'evenement
     * @var int|null
     */
    private ?int $userId; 

    /**
     * @brief id de la catégorie de l'événement
     * @var int|null
     */
    private ?int $cateId; 

    /**
     * @brief nom de la catégorie de l'événement
     * @var string|null
     */
    private ?string $nomCategorie;


    /**
     * @constructor Evenement
     * @details Constructeur de la classe Evenement
     * @param int|null $evtId
     * @param string|null $titre
     * @param string|null $autorisation
     * @param string|null $description
     * @param string|null $email
     * @param string|null $tel
     * @param string|null $nomRep
     * @param string|null $prenomRep
     * @param DateTime|null $dateDebut
     * @param DateTime|null $dateFin
     * @param DateTime|null $heureDebut
     * @param DateTime|null $heureFin
     * @param string|null $lieu
     * @param string|null $photo
     * @param bool|null $is_valide
     * @param int|null $userId
     * @param int|null $cateId
     * @param string|null $nomCategorie
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
    ?bool $is_valide=null,
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
        $this->is_valide = $is_valide;
        $this->userId = $userId;
        $this->cateId = $cateId;
        $this->nomCategorie = $nomCategorie;
    }

    /////////////////////////////
    ////////// Getters //////////
    /////////////////////////////


    /**
     * @function getEvtId
     * @details Cette fonction permet de récupérer l'id de l'événement
     * @return int|null
     */
    public function getEvtId(): ?int
    {
        return $this->evtId;
    }

    /**
     * @function getTitre
     * @details Cette fonction permet de récupérer le titre de l'événement
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @function getAutorisation
     * @details Cette fonction permet de récupérer l'autorisation de l'événement
     * @return string|null
     */
    public function getAutorisation(): ?string
    {
        return $this->autorisation;
    }

    /**
     * @function getEmail
     * @details Cette fonction permet de récupérer l'email du responsable de l'événement
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @function getTel
     * @details Cette fonction permet de récupérer le téléphone du responsable de l'événement
     * @return string|null
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }

    /**
     * @function getNomRep
     * @details Cette fonction permet de récupérer le nom du responsable de l'événement
     * @return string|null
     */
    public function getNomRep(): ?string
    {
        return $this->nomRep;
    }

    /**
     * @function getPrenomRep
     * @details Cette fonction permet de récupérer le prénom du responsable de l'événement
     * @return string|null
     */
    public function getPrenomRep(): ?string
    {
        return $this->prenomRep;
    }

    /**
     * @function getDescription
     * @details Cette fonction permet de récupérer la description de l'événement
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @function getDateDebut
     * @details Cette fonction permet de récupérer la date de début de l'événement
     * @return DateTime|null
     */
    public function getDateDebut(): ?DateTime
    {
        return $this->dateDebut;
    }

    /**
     * @function getDateFin
     * @details Cette fonction permet de récupérer la date de fin de l'événement
     * @return DateTime|null
     */
    public function getDateFin(): ?DateTime
    {
        return $this->dateFin;
    }

    /**
     * @function getHeureDebut
     * @details Cette fonction permet de récupérer l'heure de début de l'événement
     * @return DateTime|null
     */
    public function getHeureDebut(): ?DateTime
    {
        return $this->heureDebut;
    }

    /**
     * @function getHeureFin
     * @details Cette fonction permet de récupérer l'heure de fin de l'événement
     * @return DateTime|null
     */
    public function getHeureFin(): ?DateTime
    {
        return $this->heureFin;
    } 

    /**
     * @function getLieu
     * @details Cette fonction permet de récupérer le lieu de l'événement
     * @return string|null
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    /**
     * @function getPhoto
     * @details Cette fonction permet de récupérer la photo de l'événement
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @function getIsValide
     * @details Cette fonction permet de récupérer la validation de l'evenement
     * @return bool|null
     */
    public function getIsValide(): ?bool
    {
        return $this->is_valide;
    }

    /**
     * @function getUserId
     * @details Cette fonction permet de récupérer l'id de l'utilisateur ajoutant l'evenement
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @function getCateId
     * @details Cette fonction permet de récupérer l'id de la catégorie de l'événement
     * @return int|null
     */
    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    /**
     * @function getNomCategorie
     * @details Cette fonction permet de récupérer le nom de la catégorie de l'événement
     * @return string|null
     */
    public function getNomCategorie(): ?string 
    {
        return $this->nomCategorie;
    }

      
    /////////////////////////////
    ////////// Setters //////////
    /////////////////////////////


    /**
     * @function setEvtId
     * @details Cette fonction permet de définir l'id de l'événement
     * @param int|null $evtId
     * @return void
     */
    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }

    /**
     * @function setTitre
     * @details Cette fonction permet de définir le titre de l'événement
     * @param string|null $titre
     * @return void
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @function setAutorisation
     * @details Cette fonction permet de définir l'autorisation de l'événement
     * @param string|null $autorisation
     * @return void
     */
    public function setAutorisation(?string $autorisation): void
    {
        $this->autorisation = $autorisation;
    }

    /**
     * @function setEmail
     * @details Cette fonction permet de définir l'email du responsable de l'événement
     * @param string|null $email
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @function setTel
     * @details Cette fonction permet de définir le téléphone du responsable de l'événement
     * @param string|null $tel
     * @return void
     */
    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @function setNomRep
     * @details Cette fonction permet de définir le nom du responsable de l'événement
     * @param string|null $nomRep
     * @return void
     */
    public function setNomRep(?string $nomRep): void
    {
        $this->nomRep = $nomRep;
    }

    /**
     * @function setPrenomRep
     * @details Cette fonction permet de définir le prénom du responsable de l'événement
     * @param string|null $prenomRep
     * @return void
     */
    public function setPrenomRep(?string $prenomRep): void
    {
        $this->prenomRep = $prenomRep;
    }

    /**
     * @function setDescription
     * @details Cette fonction permet de définir la description de l'événement
     * @param string|null $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @function setDateDebut
     * @details Cette fonction permet de définir la date de début de l'événement
     * @param DateTime|null $dateDebut
     * @return void
     */
    public function setDateDebut(?DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @function setDateFin
     * @details Cette fonction permet de définir la date de fin de l'événement
     * @param DateTime|null $dateFin
     * @return void
     */
    public function setDateFin(?DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @function setHeureDebut
     * @details Cette fonction permet de définir l'heure de début de l'événement
     * @param DateTime|null $heureDebut
     * @return void
     */
    public function setHeureDebut(?DateTime $heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }

    /**
     * @function setHeureFin
     * @details Cette fonction permet de définir l'heure de fin de l'événement
     * @param DateTime|null $heureFin
     * @return void
     */
    public function setHeureFin(?DateTime $heureFin): void
    {
        $this->heureFin = $heureFin;
    }

    /**
     * @function setLieu
     * @details Cette fonction permet de définir le lieu de l'événement
     * @param string|null $lieu
     * @return void
     */
    public function setLieu(?string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @function setPhoto
     * @details Cette fonction permet de définir la photo de l'événement
     * @param string|null $photo
     * @return void
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @function setIsValide
     * @details Cette fonction permet de définir la validation de l'evenement
     * @param bool|null $is_valide
     * @return void
     */
    public function setIsValide(?bool $is_valide): void
    {
        $this->is_valide = $is_valide;
    }

    /**
     * @function setUserId
     * @details Cette fonction permet de définir l'id de l'utilisateur ajoutant l'evenement
     * @param int|null $userId
     * @return void
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    } 

    /**
     * @function setCateId
     * @details Cette fonction permet de définir l'id de la catégorie de l'événement
     * @param int|null $cateId
     * @return void
     */
   public function setCateId(?int $cateId): void
   {
       $this->cateId = $cateId;
   }

    /**
     * @function setNomCategorie
     * @details Cette fonction permet de définir le nom de la catégorie de l'événement
     * @param string|null $nomCategorie
     * @return void
     */
    public function setNomCategorie(?string $nomCategorie): void
    {
        $this->nomCategorie = $nomCategorie;
    }
}