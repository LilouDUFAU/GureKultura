<?php
require_once '../php/include.php';

$pdo = Bd::getInstance()->getPdo();

// Définition du dossier contenant les sauvegardes
$backupDir = __DIR__ . '/backups/';

// Trouver le fichier de sauvegarde le plus récent
$files = glob($backupDir . 'backup_gurekultura_bd_*.sql');
if (empty($files)) {
    die("❌ Aucun fichier de sauvegarde trouvé.");
}

usort($files, function ($a, $b) {
    return filemtime($b) - filemtime($a);
});

$backupFile = $files[0]; // Dernier fichier sauvegardé

// Lire le contenu du fichier SQL
$sql = file_get_contents($backupFile);
if ($sql === false) {
    die("❌ Impossible de lire le fichier de sauvegarde.");
}

try {
    // Désactiver temporairement les contraintes de clés étrangères
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
    
    // Supprimer toutes les tables existantes
    $tablesQuery = $pdo->query("SHOW TABLES");
    $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $pdo->exec("DROP TABLE IF EXISTS `$table`;");
    }
    
    // Exécuter les requêtes SQL une par une
    $queries = explode(";\n", $sql);
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            echo "Exécution de la requête : $query\n <br> <br>"; // Affiche la requête SQL
            $pdo->exec($query);
        }
    }
    
    // Réactiver les contraintes de clés étrangères
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
    
    echo "✅ Restauration terminée avec succès ! Fichier restauré : $backupFile";
} catch (PDOException $e) {
    die("❌ Erreur lors de la restauration : " . $e->getMessage());
}
