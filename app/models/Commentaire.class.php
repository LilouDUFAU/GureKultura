<?php

class Commentaire {
    private ?string $contenu;
    private ?DateTime $datePubli;
    private ?string $userNom;
    
    public function __construct(?string $contenu, ?DateTime $datePubli, ?string $userNom) {
        $this->contenu = $contenu;
        $this->datePubli = $datePubli;
        $this->userNom = $userNom;
    }

    public function getContenu(): ?string {
        return $this->contenu;
    }

    public function getDatePubli(): ?DateTime {
        return $this->datePubli;
    }

    public function getUserNom(): ?string {
        return $this->userNom;
    }

    public function setContenu(?string $contenu): void {
        $this->contenu = $contenu;
    }

    public function setDatePubli(?DateTime $datePubli): void {
        $this->datePubli = $datePubli;
    }

    public function setUserNom(?string $userNom): void {
        $this->userNom = $userNom;
    }
}
