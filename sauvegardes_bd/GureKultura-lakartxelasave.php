<?php
require_once '../php/include.php';

// Récupérer l'instance PDO via le singleton
$pdo = Bd::getInstance()->getPdo();

// Définition du dossier de sauvegarde
$backupDir = __DIR__ . '/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Nom du fichier de sauvegarde
$date = date("Y-m-d_H-i-s");
$dbName = DB_NAME;
$backupFile = "{$backupDir}backup_{$dbName}_{$date}.sql";

// Ouverture du fichier en écriture
$file = fopen($backupFile, 'w');
if (!$file) {
    die("Impossible de créer le fichier de sauvegarde.");
}

// Récupération de la structure des tables
$tablesQuery = $pdo->query("SHOW TABLES");
$tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    // Récupérer la structure de la table
    $createTableQuery = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
    $createTableSQL = $createTableQuery['Create Table'];

    fwrite($file, "-- Structure de la table `$table` --\n");
    fwrite($file, "DROP TABLE IF EXISTS `$table`;\n$createTableSQL;\n\n");

    // Exporter les données
    $dataQuery = $pdo->query("SELECT * FROM `$table`");
    $rows = $dataQuery->fetchAll();

    if (!empty($rows)) {
        fwrite($file, "-- Données de la table `$table` --\n");

        foreach ($rows as $row) {
            $values = array_map(function ($value) use ($pdo) {
                return is_null($value) ? "NULL" : "'" . $pdo->quote($value) . "'";
            }, array_values($row));

            $insertQuery = "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n";
            fwrite($file, $insertQuery);
        }
        fwrite($file, "\n");
    }
}

// Fermeture du fichier et de la connexion
fclose($file);

echo "✅ Sauvegarde terminée ! Fichier : $backupFile";
?>