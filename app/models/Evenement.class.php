<?php

// namespace App\Models;

//use DateTime;


/***
 * @brief Classe Evenement
 * 
 * @details Cette classe permet de gérer les événements
 * 
 * @details Cette classe contient les attributs de la table Evenement
 */
class Evenement
{

    /***
     * @brief ID de l'événement
     * 
     * @var int
     */
    private ?int $evtId;


    /***
     * @brief Titre de l'événement
     * 
     * @var string
     */
    private ?string $titre;


    /***
     * @brief Autorisation de l'événement
     * 
     * @var string
     */
    private ?string $autorisation;


    /***
     * @brief Email de l'événement
     * 
     * @var string
     */
    private ?string $email;


    /***
     * @brief Téléphone de l'événement
     * 
     * @var string
     */
    private ?string $tel;


    /***
     * @brief Nom du représentant
     * 
     * @var string
     */
    private ?string $nomRep;


    /***
     * @brief Prénom du représentant
     * 
     * @var string
     */
    private ?string $prenomRep;


    /***
     * @brief Description de l'événement
     * 
     * @var string
     */
    private ?string $description;


    /***
     * @brief Début de la date
     * 
     * @var DateTime
     */
    private ?DateTime $dateDebut;


    /***
     * @brief Fin de la date
     * 
     * @var DateTime
     */
    private ?DateTime $dateFin;


    /***
     * @brief Début de l'heure
     * 
     * @var DateTime
     */
    private ?DateTime $heureDebut;


    /***
     * @brief Fin de l'heure
     * 
     * @var DateTime
     */
    private ?DateTime $heureFin;



     /* @brief Lieu de l'événement
     * 
     * @var string
     */
    private ?string $lieu; 
     

     /* @brief Photo de l'événement
     * 
     * @var string
     */
    private ?string $photo; 
     

     /* @brief Photo de l'événement
     * 
     * @var string
     */
    private ?int $userId; 
     

     /* @brief Photo de l'événement
     * 
     * @var string
     */
    private ?int $cateId; 
     


    /***
     * @brief Constructeur de la classe Evenement
     * 
     * @param int $evtId, string $titre,string $autorisation, string $email, string $tel, string $nomRep, string $prenomRep, string $description, DateTime $debutDate, DateTime $finDate, DateTime $debutHeure, DateTime $finHeure, string $lieu, string $photo, Categorie $categorie, string $nomCategorie
     * 
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
    ?int $cateId=null)
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
    }

    // Getters

    /***
     * @brief Getter de l'ID
     * 
     * @return int
     */
    public function getEvtId(): ?int
    {
        return $this->evtId;
    }


    /***
     * @brief Getter du titre
     * 
     * @return string
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }


    /***
     * @brief Getter de l'autorisation
     * 
     * @return string
     */
    public function getAutorisation(): ?string
    {
        return $this->autorisation;
    }


    /***
     * @brief Getter de l'email
     * 
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /***
     * @brief Getter du téléphone
     * 
     * @return string
     */
    public function getTel(): ?string
    {
        return $this->tel;
    }


    /***
     * @brief Getter du nom du représentant
     * 
     * @return string
     */
    public function getNomRep(): ?string
    {
        return $this->nomRep;
    }


    /***
     * @brief Getter du prénom du représentant
     * 
     * @return string
     */
    public function getPrenomRep(): ?string
    {
        return $this->prenomRep;
    }


    /***
     * @brief Getter de la description
     * 
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /***
     * @brief Getter du début de la date
     * 
     * @return DateTime
     */
    public function getDateDebut(): ?DateTime
    {
        return $this->dateDebut;
    }


    /***
     * @brief Getter de la fin de la date
     * 
     * @return DateTime
     */
    public function getDateFin(): ?DateTime
    {
        return $this->dateFin;
    }


    /***
     * @brief Getter du début de l'heure
     * 
     * @return DateTime
     */
    public function getHeureDebut(): ?DateTime
    {
        return $this->heureDebut;
    }


    /***
     * @brief Getter de la fin de l'heure
     * 
     * @return DateTime
     */
    public function getHeureFin(): ?DateTime
    {
        return $this->heureFin;
    }


    /***
     * @brief Getter de la photo
     * 
     * @return string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /***
     * @brief Getter du lieu
     * 
     * @return string
     */
    public function getLieu(): ?string
    {
        return $this->lieu;
    }


    /***
     * @brief Getter de l'identifiant utilisateur
     * 
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /***
     * @brief Getter de l'identifiant de la catégorie
     * 
     * @return int
     */
    public function getCateId(): ?int
    {
        return $this->cateId;
    }

      
    // Setters

    /***
     * @brief Setter de l'ID
     * 
     * @param int $evtId
     * 
     * @return void
     */
    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }


    /***
     * @brief Setter du titre
     * 
     * @param string $titre
     * 
     * @return void
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }


    /***
     * @brief Setter de l'autorisation
     * 
     * @param string $autorisation
     * 
     * @return void
     */
    public function setAutorisation(?string $autorisation): void
    {
        $this->autorisation = $autorisation;
    }


    /***
     * @brief Setter de l'email
     * 
     * @param string $email
     * 
     * @return void
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }


    /***
     * @brief Setter du téléphone
     * 
     * @param string $tel
     * 
     * @return void
     */
    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }


    /***
     * @brief Setter du nom du représentant
     * 
     * @param string $nomRep
     * 
     * @return void
     */
    public function setNomRep(?string $nomRep): void
    {
        $this->nomRep = $nomRep;
    }


    /***
     * @brief Setter du prénom du représentant
     * 
     * @param string $prenomRep
     * 
     * @return void
     */
    public function setPrenomRep(?string $prenomRep): void
    {
        $this->prenomRep = $prenomRep;
    }


    /***
     * @brief Setter de la description
     * 
     * @param string $description
     * 
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }


    /***
     * @brief Setter du début de la date
     * 
     * @param DateTime $dateDebut
     * 
     * @return void
     */
    public function setDateDebut(?DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }


    /***
     * @brief Setter de la fin de la date
     * 
     * @param DateTime $dateFin
     * 
     * @return void
     */
    public function setDateFin(?DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }


    /***
     * @brief Setter du début de l'heure
     * 
     * @param DateTime $heureDebut
     * 
     * @return void
     */
    public function setHeureDebut(?DateTime $heureDebut): void
    {
        $this->heureDebut = $heureDebut;
    }


    /***
     * @brief Setter de la fin de l'heure
     * 
     * @param DateTime $heureFin
     * 
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
     * 
     * @param string $photo
     * 
     * @return void
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }


    /***
     * @brief Setter de l'identifiant de l'utilisateur
     * 
     * @param int $userId
     * 
     * @return void
     */
    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }    
    
    
    /***
    * @brief Setter de l'identifiant de la catégorie
    * 
    * @param int $cateId
    * 
    * @return void
    */
   public function setCateId(?int $cateId): void
   {
       $this->cateId = $cateId;
   }
}