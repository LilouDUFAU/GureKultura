<?php

// namespace App\Models;

use DateTime;

class Actualite
{
    private ?int $actuId;
    private ?string $titre;
    private ?string $resume;
    private ?string $contenu;
    private ?DateTime $datePubli;
    private ?string $img;

    public function __construct(?int $actuId=null, ?string $titre=null, ?string $resume=null, ?string $contenu=null, ?DateTime $datePubli=null, ?string $img=null)
    {
        $this->actuId = $actuId;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->contenu = $contenu;
        $this->datePubli = $datePubli;
        $this->img = $img;
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
        return $this->Contenu;
    }

    public function getDatePubli(): ?DateTime
    {
        return $this->datePubli;
    }

    public function getImg(): ?string
    {
        return $this->img;
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

    public function setContenu(?string $Contenu): void
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
}
