<?php

class Bd {
    /**
     * @var Bd|null
     */
    private static ?Bd $instance = null;

    /**
     * @var PDO|null
     */
    private ?PDO $pdo;

    /**
     * @constructor EvenementDao
     * @return void
     */
    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host='. DB_HOST .'; dbname='. DB_NAME, DB_USER, DB_PASS);
            $this->pdo->exec("set names utf8mb4");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }
    }

    /**
     * @return Bd
     */
    public static function getInstance(): Bd {
        if (self::$instance === null) {
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    /**
     * @return PDO|null
     */
    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    //empecher de cloner l'objet
    public function __clone() {

    }

    //empecher de deserialiser l'objet
    public function __wakeup() {
        throw new Exception("Un singleton ne doit pas être désérialisé");
    }
}