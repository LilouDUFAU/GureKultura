<?php

class ActualiteDao {
    private ?PDO $pdo;

    public function __construct(?PDO $pdo=null) {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void {
        $this->pdo = $pdo;
    }

    public function find(?int $id): ?Actualite {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "actualite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Actualite');
        return $stmt->fetch();
    }

    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "actualite";
        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Actualite');
        return $stmt->fetchAll();
    }
}