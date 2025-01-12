<?php

class Controller {
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @var \Twig\Loader\FileSystemLoader
     */
    private \Twig\Loader\FileSystemLoader $loader;

    /**
     * @var \Twig\Environment
     */
    private \Twig\Environment $twig;

    /**
     * @var array|null
     */
    private ?array $get = null;

    /**
     * @var array|null
     */
    private ?array $post = null;

    /**
     * @param \Twig\Environment $twig
     * @param \Twig\Loader\FileSystemLoader $loader
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader ) {
        $db = Bd::getInstance();
        $this->pdo = $db->getPdo();

        $this->twig = $twig;
        $this->loader = $loader;

        if (isset($_GET) && !empty($_GET)) {
            $this->get = $_GET;
        }

        if (isset($_POST) && !empty($_POST)) {
            $this->post = $_POST;
        }
    }

    /**
     * @param string|null $methode
     * @return mixed
     */
    public function call(?string $methode): mixed{
        if (!method_exists($this, $methode)) {
            throw new Exception("La méthode $methode n'existe pas dans le controller" . __CLASS__);
        }
        return $this->$methode();
    }

    /**
     * @return PDO|null
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    /**
     * @param PDO|null $pdo
     * @return void
     */
    public function setPdo(?PDO $pdo): void{
        $this->pdo = $pdo;
    }

    /**
     * @return \TWIG\Loader\FileSystemLoader
     */
    public function getLoader(): \TWIG\Loader\FileSystemLoader {
        return $this->loader;
    }

    /**
     * @param \TWIG\Loader\FileSystemLoader $loader
     * @return void
     */
    public function setLoader(\TWIG\Loader\FileSystemLoader $loader): void{
        $this->loader = $loader;
    }

    /**
     * @return \TWIG\Environment
     */
    public function getTwig(): \TWIG\Environment {
        return $this->twig;
    }

    /**
     * @param \TWIG\Environment $twig
     * @return void
     */
    public function setTwig(\TWIG\Environment $twig): void{
        $this->twig = $twig;
    }

    /**
     * @return array|null
     */
    public function getGet(): ?array {
        return $this->get;
    }

    /**
     * @param array|null $get
     * @return void
     */
    public function setGet(?array $get): void{
        $this->get = $get;
    }

    /**
     * @return array|null
     */
    public function getPost(): ?array {
        return $this->post;
    }

    /**
     * @param array|null $post
     * @return void
     */
    public function setPost(?array $post): void{
        $this->post = $post;
    }

}