<?php
class Participer
{
    private ?int $userId;

    private ?int $evtId;

    private ?DateTime $dateInscr;

    public function __construct(?int $userId=null,
    ?int $evtId=null,
    ?DateTime $dateInscr=null)
    {
        $this->userId = $userId;
        $this->evtId = $evtId;
        $this->dateInscr = $dateInscr;
    }

    /////////////////////////////
    ////////// Getters //////////
    /////////////////////////////

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getEvtId(): ?int
    {
        return $this->evtId;
    }

    public function getDateInscr(): ?DateTime
    {
        return $this->dateInscr;
    }

    /////////////////////////////
    ////////// Setters //////////
    /////////////////////////////

    public function setUserId(?int $userId): void
    {
        $this->userId = $userId;
    }

    public function setEvtId(?int $evtId): void
    {
        $this->evtId = $evtId;
    }

    public function setDateInscr(?DateTime $dateInscr): void
    {
        $this->dateInscr = $dateInscr;
    }
}