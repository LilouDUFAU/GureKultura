<?php

class Bd {
    private static ?Bd $instance = null;

    private ?PDO $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host='. DB_HOST .'; dbname='. DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
            die();
        }
    }

    public static function getInstance(): Bd {
        if (self::$instance === null) {
            self::$instance = new Bd();
        }
        return self::$instance;
    }

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