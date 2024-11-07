<?php
require_once 'ConnectionBD.php';

class ActualiteDao {
    private $conn;

    public function __construct() {
        $database = new ConnectionBD();
        $this->conn = $database->getConnection();
    }

    // Méthode pour récupérer tous les enregistrements
    public function getAll() {
        $query = "SELECT * FROM Actualite";
        $actualite = $this->conn->prepare($query);
        $actualite->execute();

        return $actualite->fetchAll(PDO::FETCH_ASSOC);
        echo $actualite;
    }

    // Méthode pour mettre à jour un enregistrement
    public function update($id, $newData) {
        
    }

    // Méthode pour supprimer un enregistrement
    public function delete($id) {
        
    }
}
?>
