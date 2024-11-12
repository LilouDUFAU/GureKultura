<?php
require_once 'ConnectionBD.php';

class EvenementDao {
    private $conn;

    public function __construct() {
        $database = new ConnectionBD();
        $this->conn = $database->getConnection();
    }

    // Méthode pour récupérer tous les enregistrements
    public function getAll() {
        $query = "SELECT * FROM Evenement";
        $evenement = $this->conn->prepare($query);
        $evenement->execute();

        return $evenement->fetchAll(PDO::FETCH_ASSOC);
        echo $evenement;
    }

    // Méthode pour mettre à jour un enregistrement
    public function update($id, $newData) {
        
    }

    // Méthode pour supprimer un enregistrement
    public function delete($id) {
        
    }
}
