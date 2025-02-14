<?php

class Commentaire {
    private ?int $commentaireId;
    private ?string $datePubli;
    private ?string $contenu;
    private ?int $actuId;
    private ?int $userId;
    private ?int $evtId;
    private ?string $pseudo;
    
    public function __construct(
        ?int $commentaireId=null,
        ?string $datePubli=null,
        ?string $contenu=null,
        ?int $actuId=null,
        ?int $userId=null,
        ?int $evtId=null,
        ?string $pseudo=null
    ) {
        $this->commentaireId = $commentaireId;
        $this->datePubli = $datePubli;
        $this->contenu = $contenu;
        $this->actuId = $actuId;
        $this->userId = $userId;
        $this->evtId = $evtId;
        $this->pseudo = $pseudo;
    }

    public function getCommentaireId(): ?int
    {
        return $this->commentaireId;
    }

    public function setCommentaireId(?int $commentaireId): void
    {
        $this->commentaireId = $commentaireId;
    }

    public function getDatePubli(): ?string
    {
        return $this->datePubli;
    }

    public function setDatePubli(?string $datePubli): void
    {
        $this->datePubli = $datePubli;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function getActuId(): ?int
    {
        return $this->actuId;
    }

    public function setActuId(?int $actuId): void
    {
        $this->actuId = $actuId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function getEvtId(): ?int
    {
        return $this->evtId;
    }

    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }
}
