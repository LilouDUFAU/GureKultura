<?php

namespace App\Models;

use DateTime;

class Actualite
{
    private ?int $id;
    private ?string $type;
    private ?string $titre;
    private ?string $resume;
    private ?DateTime $date_publication;
    private ?string $image;

    public function __construct(?int $id, ?string $type, ?string $titre, ?string $resume, ?DateTime $date_publication, ?string $image)
    {
        $this->id = $id;
        $this->type = $type;
        $this->titre = $titre;
        $this->resume = $resume;
        $this->date_publication = $date_publication;
        $this->image = $image;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getType()
    {
        return $this->type;
    }
    public function getTitre()
    {
        return $this->titre;
    }
    public function getResume()
    {
        return $this->resume;
    }
    public function getDatePublication()
    {
        return $this->date_publication;
    }
    public function getImage()
    {
        return $this->image;
    }

    // Setters
    public function setType($type)
    {
        $this->type = $type;
    }
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }
    public function setResume($resume)
    {
        $this->resume = $resume;
    }
    public function setDatePublication($date_publication)
    {
        $this->date_publication = $date_publication;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }

}
