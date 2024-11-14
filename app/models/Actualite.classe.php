<?php

// namespace App\Models;

use DateTime;

class Actualite
{
    private ?int $actuId;
    private ?string $titre;
    private ?string $ficResume;
    private ?string $ficContenu;
    private ?DateTime $datePubli;
    private ?string $img;

    public function __construct(?int $actuId=null, ?string $titre=null, ?string $ficResume=null, ?string $ficContenu=null, ?DateTime $datePubli=null, ?string $img=null)
    {
        $this->actuId = $actuId;
        $this->titre = $titre;
        $this->ficResume = $ficResume;
        $this->ficContenu = $ficContenu;
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

    public function getFicResume(): ?string
    {
        return $this->ficResume;
    }

    public function getFicContenu(): ?string
    {
        return $this->ficContenu;
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

    public function setFicResume(?string $ficResume): void
    {
        $this->ficResume = $ficResume;
    }

    public function setFicContenu(?string $ficContenu): void
    {
        $this->ficContenu = $ficContenu;
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
