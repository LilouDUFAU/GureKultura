<?php

/**
 * @brief Classe Token
 * @details Cette classe permet de gérer les tokens
 */

class Token {
    /**
     * @brief Identifiant du token
     * @details cet identifiant est générer automatiquement par la base de données
     * @var int
     */
    private ?int $tokenId;

    /**
     * @brief Identifiant de l'utilisateur
     * @details identifiant de l'utilisateur ayant oublier sont mot de passe
     * @var string
     */
    private ?int $userId;

    /**
     * @brief token 
     * @details token pour oublie de mot de passe
     * @var string
     */
    private ?string $token;

    /**
     * @brief Date de création du token
     * @details date de création du token
     * @var string
     */
    private ?DateTime $dateCreation;

    /**
     * @brief Date d'expiration du token
     * @details date d'expiration du token
     */
    private ?DateTime $dateExpiration;

    /**
     * @brief Constructeur de la classe Token
     *  @param int $tokenId
     * @param int $userId
     * @param string $token
     * @param DateTime $dateCreation
     * @param DateTime $dateExpiration
     * @return void
     */
    public function __construct(
    ?int $tokenId = null,
    ?int $userId = null,
    ?string $token = null,
    ?DateTime $dateCreation = null,
    ?DateTime $dateExpiration = null
    ) {
        $this->tokenId = $tokenId;
        $this->userId = $userId;
        $this->token = $token;
        $this->dateCreation = $dateCreation;
        $this->dateExpiration = $dateExpiration;
    }

    ///////////GETTERS///////////

    /**
     * @brief Getter de l'id
     * @details Permet de récupérer l'id du token
     * @return int
     */
    public function getTokenId(): ?int {
        return $this->tokenId;
    }

    /**
     * @brief Getter de l'id
     * @details Permet de récupérer l'id de l'utilisateur
     * @return int
     */
    public function getUserId(): ?int {
        return $this->userId;
    }

    /**
     * @brief Getter du token
     * @details Permet de récupérer le token
     * @return string
     */
    public function getToken(): ?string {
        return $this->token;
    }

    /**
     * @brief Getter de la date de création
     * @details Permet de récupérer la date de création du token
     * @return DateTime 
     */
    public function getDateCreation(): ?DateTime {
        return $this->dateCreation;
    }

    /**
     * @brief Getter de la date d'expiration
     * @details Permet de récupérer la date d'expiration du token
     * @return DateTime
     */
    public function getDateExpiration(): ?DateTime {
        return $this->dateExpiration;
    }

    ///////////SETTERS///////////

    /**
     * @brief Setter de l'id
     * @details Permet de modifier l'id du token
     * @param int $tokenId
     * @return void
     */
    public function setTokenId(?int $tokenId): void {
        $this->tokenId = $tokenId;
    }

    /**
     * @brief Setter de l'id
     * @details Permet de modifier l'id de l'utilisateur
     * @param int $userId
     * @return void
     */
    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    /**
     * @brief Setter du token
     * @details Permet de modifier le token
     * @param string $token
     * @return void
     */
    public function setToken(?string $token): void {
        $this->token = $token;
    }

    /**
     * @brief Setter de la date de création
     * @details Permet de modifier la date de création du token
     * @param DateTime $dateCreation
     * @return void
     */
    public function setDateCreation(?DateTime $dateCreation): void {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @brief Setter de la date d'expiration
     * @details Permet de modifier la date d'expiration du token
     * @param DateTime $dateExpiration
     * @return void
     */
    public function setDateExpiration(?DateTime $dateExpiration): void {
        $this->dateExpiration = $dateExpiration;
    }

}