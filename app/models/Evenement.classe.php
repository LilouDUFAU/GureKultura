<?php

// namespace App\Models;

use DateTime;

class Evenement
{
    private ?int $evtId;
    private ?string $titre;
    private ?string $descr;
    private ?DateTime $dateEvt;
    private ?string $loc;
    private ?bool $statutEvt;
    private ?string $img;

    public function __construct(?int $evtId=null, ?string $titre=null, ?string $descr=null, ?DateTime $dateEvt=null, ?string $loc=null, ?bool $statutEvt=null, ?string $img=null)
    {
        $this->evtId = $evtId;
        $this->titre = $titre;
        $this->descr = $descr;
        $this->dateEvt = $dateEvt;
        $this->loc = $loc;
        $this->statutEvt = $statutEvt;
        $this->img = $img;
    }

    // Getters
    public function getEvtId(): ?int
    {
        return $this->evtId;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function getDateEvt(): ?DateTime
    {
        return $this->dateEvt;
    }

    public function getLoc(): ?string
    {
        return $this->loc;
    }

    public function getStatutEvt(): ?bool
    {
        return $this->statutEvt;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    // Setters
    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }

    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    public function setDescr(?string $descr): void
    {
        $this->descr = $descr;
    }

    public function setDateEvt(?DateTime $dateEvt): void
    {
        $this->dateEvt = $dateEvt;
    }

    public function setLoc(?string $loc): void
    {
        $this->loc = $loc;
    }

    public function setStatutEvt(?bool $statutEvt): void
    {
        $this->statutEvt = $statutEvt;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }
}
