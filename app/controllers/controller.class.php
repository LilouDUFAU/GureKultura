<?php

class Controller {
    private PDO $pdo;
    private \Twig\Loader\FileSystemLoader $loader;
    private \Twig\Environment $twig;
    private ?array $get = null;
    private ?array $post = null;

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

    public function call(?string $methode): mixed{
        if (!method_exists($this, $methode)) {
            throw new Exception("La méthode $methode n'existe pas dans le controller" . __CLASS__);
        }
        return $this->$methode();
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void{
        $this->pdo = $pdo;
    }

    public function getLoader(): \TWIG\Loader\FileSystemLoader {
        return $this->loader;
    }

    public function setLoader(\TWIG\Loader\FileSystemLoader $loader): void{
        $this->loader = $loader;
    }

    public function getTwig(): \TWIG\Environment {
        return $this->twig;
    }

    public function setTwig(\TWIG\Environment $twig): void{
        $this->twig = $twig;
    }

    public function getGet(): ?array {
        return $this->get;
    }

    public function setGet(?array $get): void{
        $this->get = $get;
    }

    public function getPost(): ?array {
        return $this->post;
    }

    public function setPost(?array $post): void{
        $this->post = $post;
    }

}