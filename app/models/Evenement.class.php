<?php

// namespace App\Models;

use DateTime;


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
    private ?DateTime $debutDate;


    /***
     * @brief Fin de la date
     * 
     * @var DateTime
     */
    private ?DateTime $finDate;


    /***
     * @brief Début de l'heure
     * 
     * @var DateTime
     */
    private ?DateTime $debutHeure;


    /***
     * @brief Fin de l'heure
     * 
     * @var DateTime
     */
    private ?DateTime $finHeure;


    /***
     * @brief Photo de l'événement
     * 
     * @var string
     */
    private ?string $photo; 
     

    /***
     * @brief Catégorie de l'événement
     * 
     * @var Categorie
     */
    private ?Categorie $categorie;


    /***
     * @brief Nom de la catégorie
     * 
     * @var string
     */
    private ?string $nomCategorie;


    /***
     * @brief Constructeur de la classe Evenement
     * 
     * @param int $evtId, string $titre,string $autorisation, string $email, string $tel, string $nomRep, string $prenomRep, string $description, DateTime $debutDate, DateTime $finDate, DateTime $debutHeure, DateTime $finHeure, string $photo, Categorie $categorie, string $nomCategorie
     * 
     * @return void
     */
    public function __construct(?int $evtId=null, ?string $titre=null, ?string $autorisation=null,?string $email=null, ?string $tel=null, ?string $nomRep=null, ?string $prenomRep=null, ?string $description=null, ?DateTime $debutDate=null, ?DateTime $finDate=null, ?DateTime $debutHeure=null, ?DateTime $finHeure=null, ?string $photo=null, ?Categorie $categorie=null, ?string $nomCategorie=null)
    {
        $this->evtId = $evtId;
        $this->titre = $titre;
        $this->autorisation = $autorisation;
        $this->email = $email;
        $this->tel = $tel;
        $this->nomRep = $nomRep;
        $this->prenomRep = $prenomRep;
        $this->description = $description;
        $this->debutDate = $debutDate;
        $this->finDate = $finDate;
        $this->debutHeure = $debutHeure;
        $this->finHeure = $finHeure;
        $this->photo = $photo;
        $this->categorie = $categorie;
        $this->nomCategorie = $nomCategorie;
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
    public function getDebutDate(): ?DateTime
    {
        return $this->debutDate;
    }


    /***
     * @brief Getter de la fin de la date
     * 
     * @return DateTime
     */
    public function getFinDate(): ?DateTime
    {
        return $this->finDate;
    }


    /***
     * @brief Getter du début de l'heure
     * 
     * @return DateTime
     */
    public function getDebutHeure(): ?DateTime
    {
        return $this->debutHeure;
    }


    /***
     * @brief Getter de la fin de l'heure
     * 
     * @return DateTime
     */
    public function getFinHeure(): ?DateTime
    {
        return $this->finHeure;
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
     * @brief Getter de la catégorie
     * 
     * @return Categorie
     */
    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }


    /***
     * @brief Getter du nom de la catégorie
     * 
     * @return string
     */
    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
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
     * @param DateTime $debutDate
     * 
     * @return void
     */
    public function setDebutDate(?DateTime $debutDate): void
    {
        $this->debutDate = $debutDate;
    }


    /***
     * @brief Setter de la fin de la date
     * 
     * @param DateTime $finDate
     * 
     * @return void
     */
    public function setFinDate(?DateTime $finDate): void
    {
        $this->finDate = $finDate;
    }


    /***
     * @brief Setter du début de l'heure
     * 
     * @param DateTime $debutHeure
     * 
     * @return void
     */
    public function setDebutHeure(?DateTime $debutHeure): void
    {
        $this->debutHeure = $debutHeure;
    }


    /***
     * @brief Setter de la fin de l'heure
     * 
     * @param DateTime $finHeure
     * 
     * @return void
     */
    public function setFinHeure(?DateTime $finHeure): void
    {
        $this->finHeure = $finHeure;
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
     * @brief Setter de la catégorie
     * 
     * @param Categorie $categorie
     * 
     * @return void
     */
    public function setCategorie(?Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    /***
     * @brief Setter du nom de la catégorie
     * 
     * @param string $nomCategorie
     * 
     * @return void
     */
    public function setNomCategorie(?string $nomCategorie): void
    {
        $this->nomCategorie = $nomCategorie;
    }
}