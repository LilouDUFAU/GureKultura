<?php 

// namespace App\Models;

class Categorie 
{
    private ?int $cateId;
    private ?string $nom;
    private ?int $categorieOriginale;
    private ?string $img;

    public function __construct(?int $cateId=null, ?string $nom=null, ?int $categorieOriginale=null, ?string $img=null)
    {
        $this->cateId = $cateId;
        $this->nom = $nom;
        $this->categorieOriginale = $categorieOriginale;
        $this->img = $img;
    }

    //getters

    public function getCateId(): ?int
    {
        return $this->cateId;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }   

    public function getCategorieOriginale(): ?int
    {
        return $this->categorieOriginale;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    //setters

    public function setCateId(?int $cateId): void
    {
        $this->cateId = $cateId;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function setCategorieOriginale(?int $categorieOriginale): void
    {
        $this->categorieOriginale = $categorieOriginale;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}