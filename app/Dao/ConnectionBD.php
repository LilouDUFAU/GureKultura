<?php
class ConnectionBD {
    /////////////////////////////////////////////
    /////////  Connexion à la BD en pdo /////////
    /////////////////////////////////////////////



    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // pour ceux qui sont sur citrix
            //$this->conn = new PDO('mysql:host=lakartxela;dbname=tlague_pro','root',''); 
        
            // pour ceux qui sont sur machine person (a condition d'avoir importe la BD et de l'avoir nomme gurekultura_bd)
            $this->conn = new PDO('mysql:host=localhost;dbname=gurekultura_bd','root','');
        echo"connection reussie";
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
