<?php

// namespace App\Models;

/**
 * @brief Classe Actualite
 * @details Permet de définir les attributs et méthodes de la classe Actualite
 */
class Actualite
{
    /**
     * @brief identifiant de l'actualité
     * @details Cet identifiant est généré automatiquement par la base de données
     * @var int|null
     */
    private ?int $actuId;

    /**
     * @brief titre de l'actualité
     * @details Ce titre est saisi par le moderateur
     * @var string|null
     */
    private ?string $titre;

    /**
     * @brief résumé de l'actualité
     * @details Ce résumé est saisi par le moderateur
     * @var string|null
     */
    private ?string $resume;

    /**
     * @brief contenu de l'actualité
     * @details Ce contenu est saisi par le moderateur
     * @var string|null
     */
    private ?string $contenu;

    /**
     * @brief date de publication de l'actualité
     * @details Cette date est générée automatiquement par la base de données
     * @var DateTime|null
     */
    private ?DateTime $datePubli;


    /**
     * @brief image de l'actualité
     * @details Cette image est saisi par le moderateur
     * @var string|null
     */
    private ?string $img;

     /**
     * @brief Id de l'utilisateur qui propose l'evenement
     * @details Cet id est recuperer par la session
     * @var string
     */
    private ?int $userId;


    /**
     * @brief identifiant de la catégorie de l'actualité
     * @details Cet identifiant est généré automatiquement par la base de données
     * @var int|null
     */
    private ?int $cateId;

    /**
     * @brief nom de la catégorie de l'actualité
     * @details Ce nom est selectionne par le moderateur
     * @var string|null
     */
    private ?string $nomCategorie;



    /**
     * @brief Constructeur de la classe Actualite
     * @details Permet d'instancier un objet de la classe Actualite
     * Summary of __construct
     * @param mixed $actuId
     * @param mixed $titre
     * @param mixed $resume
     * @param mixed $contenu
     * @param mixed $datePubli
     * @param mixed $img
     * @param mixed $userId
     * @param mixed $cateId
     * @param mixed $nomCategorie
     * @return void
     */
    public function __construct(?int $actuId=null,
    ?string $titre=null,
    ?string $resume=null, 
    ?string $contenu=null, 
    ?DateTime $datePubli=null, 
    ?string $img=null,
    ?int $userId=null, 
    ?int $cateId=null, 
    string $nomCategorie=null)
    {
        $this->actuId = $actuId;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->contenu = $contenu;
        $this->datePubli = $datePubli;
        $this->img = $img;
        $this->userId = $userId;
        $this->cateId = $cateId;
        $this->nomCategorie = $nomCategorie;
    }

    //getters
    public function getActuId(): ?int
    {
        return $this->actuId;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function getDatePubli(): ?DateTime
    {
        return $this->datePubli;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    //setters
    public function setActuId(?int $actuId): void
    {
        $this->actuId = $actuId;
    }

    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    public function setResume(?string $resume): void
    {
        $this->resume = $resume;
    }

    public function setContenu(?string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function setDatePubli(?DateTime $datePubli): void
    {
        $this->datePubli = $datePubli;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function setCateId(?int $cateId): void
    {
        $this->cateId = $cateId;
    }

    public function setNomCategorie(?string $nomCategorie): void
    {
        $this->nomCategorie = $nomCategorie;
    }

    public function dateActuelle(): string {
        $date = date("Y-m-d");
        return $date;
    }
}