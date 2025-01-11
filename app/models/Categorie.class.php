<?php 

// namespace App\Models;

/**
 * @class Categorie
 * @details Cette classe permet de gérer les catégories
 */
class Categorie 
{
    /**
     * @brief cateId
     * @var int|null
     */
    private ?int $cateId;

    /**
     * @brief nom
     * @var string|null
     */
    private ?string $nom;

    /**
     * @brief categorieOriginale
     * @var int|null
     */
    private ?int $categorieOriginale;

    /**
     * @brief img
     * @var string|null
     */
    private ?string $img;

    /**
     * @constructor Categorie
     * @details Ce constructeur permet de créer une nouvelle catégorie
     * @param int|null $cateId
     * @param string|null $nom
     * @param int|null $categorieOriginale
     * @param string|null $img
     * @return void
     */
    public function __construct(?int $cateId=null, ?string $nom=null, ?int $categorieOriginale=null, ?string $img=null)
    {
        $this->cateId = $cateId;
        $this->nom = $nom;
        $this->categorieOriginale = $categorieOriginale;
        $this->img = $img;
    }

    /////////////////////////////
    ////////// Getters //////////
    /////////////////////////////

    /**
     * @function getCateId
     * @details Cette fonction permet de récupérer l'identifiant de la catégorie
     * @return int|null
     */
    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    /**
     * @function getNom
     * @details Cette fonction permet de récupérer le nom de la catégorie
     * @return int|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }   

    /**
     * @function getCategorieOriginale
     * @details Cette fonction permet de récupérer la catégorie originale de la catégorie
     * @return int|null
     */
    public function getCategorieOriginale(): ?int
    {
        return $this->categorieOriginale;
    }

    /**
     * @function getImg
     * @details Cette fonction permet de récupérer l'image de la catégorie
     * @return int|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /////////////////////////////
    ////////// Setters //////////
    /////////////////////////////

    /**
     * @function setCateId
     * @details Cette fonction permet de définir l'identifiant de la catégorie
     * @param int|null $cateId
     * @return void
     */
    public function setCateId(?int $cateId): void
    {
        $this->cateId = $cateId;
    }

    /**
     * @function setNom
     * @details Cette fonction permet de définir le nom de la catégorie
     * @param string|null $nom
     * @return void
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @function setCategorieOriginale
     * @details Cette fonction permet de définir la catégorie originale de la catégorie
     * @param int|null $categorieOriginale
     * @return void
     */
    public function setCategorieOriginale(?int $categorieOriginale): void
    {
        $this->categorieOriginale = $categorieOriginale;
    }

    /**
     * @function setImg
     * @details Cette fonction permet de définir l'image de la catégorie
     * @param string|null $img
     * @return void
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}