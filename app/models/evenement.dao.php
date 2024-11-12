<?php

class EvenementDao {
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

    public function find(?int $id): ?Evenement {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
        return $stmt->fetch();
    }

    public function findAll() {
        $sql = "SELECT * FROM " . PREFIX_TABLE . "evenement";
        $stmt = $this->pdo->query($sql);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Evenement');
        return $stmt->fetchAll();
    }
}