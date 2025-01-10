<?php 

// namespace App\Models;

/**
 * @brief Classe Categorie
 * @details Cette classe permet de gérer les catégories
 */
class Categorie 
{
    /**
     * @brief cateId
     * @details Identifiant de la catégorie
     */
    private ?int $cateId;

    /**
     * @brief nom
     * @details nom de la catégorie
     */
    private ?string $nom;

    /**
     * @brief categorieOriginale
     * @details Catégorie originale de la catégorie (si elle en possède une)
     */
    private ?int $categorieOriginale;

    /**
     * @brief img
     * @details Image représentant la catégorie
     */
    private ?string $img;

    /**
     * @constructor
     * @brief Constructeur de la classe Categorie
     * @details Ce constructeur permet de créer une nouvelle catégorie
     * @param int $cateId
     * @param string $nom
     * @param int $categorieOriginale
     * @param string $img
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
     * @brief Getter de l'ID
     * @details Cette fonction permet de récupérer l'identifiant de la catégorie
     * @return int
     */
    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    /**
     * @function getNom
     * @brief Getter du nom
     * @details Cette fonction permet de récupérer le nom de la catégorie
     * @return int
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }   

    /**
     * @function getCategorieOriginale
     * @brief Getter de la catégorie originale
     * @details Cette fonction permet de récupérer la catégorie originale de la catégorie
     * @return int
     */
    public function getCategorieOriginale(): ?int
    {
        return $this->categorieOriginale;
    }

    /**
     * @function getImg
     * @brief Getter de l'image
     * @details Cette fonction permet de récupérer l'image de la catégorie
     * @return int
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
     * @brief Setter de l'identifiant
     * @details Cette fonction permet de définir l'identifiant de la catégorie
     * @param int $cateId
     * @return void
     */
    public function setCateId(?int $cateId): void
    {
        $this->cateId = $cateId;
    }

    /**
     * @function setNom
     * @brief Setter du nom
     * @details Cette fonction permet de définir le nom de la catégorie
     * @param string $nom
     * @return void
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @function setCategorieOriginale
     * @brief Setter de la catégorie originale
     * @details Cette fonction permet de définir la catégorie originale de la catégorie
     * @param int $categorieOriginale
     * @return void
     */
    public function setCategorieOriginale(?int $categorieOriginale): void
    {
        $this->categorieOriginale = $categorieOriginale;
    }

    /**
     * @function setImg
     * @brief Setter de l'image
     * @details Cette fonction permet de définir l'image de la catégorie
     * @param string $img
     * @return void
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}