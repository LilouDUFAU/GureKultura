<?php

// namespace App\Models;

use DateTime;

class Evenement
{
    private ?int $id;
    private ?string $titre;
    private ?string $description;
    private ?DateTime $date;
    private ?string $lieu;
    private ?bool $status;

    public function __construct(?int $id=null, ?string $titre=null, ?string $description=null, ?DateTime $date=null, ?string $lieu=null, ?bool $status=null)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->date = $date;
        $this->lieu = $lieu;
        $this->status = $status;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function getStatus()
    {
        return $this->status;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}
