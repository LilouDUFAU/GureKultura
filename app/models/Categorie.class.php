<?php 

// namespace App\Models;

class Categorie 
{
    private ?int $cateId;
    private ?string $nom;
    private ?int $cateId_cateOri;
    private ?string $img;

    public function __construct(?int $cateId=null, ?string $nom=null, ?int $cateId_cateOri=null, ?string $img=null)
    {
        $this->cateId = $cateId;
        $this->nom = $nom;
        $this->cateId_cateOri = $cateId_cateOri;
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

    public function getCateId_cateOri(): ?int
    {
        return $this->cateId_cateOri;
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

    public function setCateId_cateOri(?int $cateId_cateOri): void
    {
        $this->cateId_cateOri = $cateId_cateOri;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}