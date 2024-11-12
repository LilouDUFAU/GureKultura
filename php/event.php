<?php
class event {

    public static function getActiveEvents($pdo) {
        $query = "SELECT id, titre, description, date_evt, localisation, image FROM gk_evenement WHERE status_evt = 'actif'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>