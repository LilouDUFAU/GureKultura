<?php

/**
 * @class ControllerAdmin
 * @extends parent <Controller>
 * @details Permet aux modérateur de gérer les sauvegardes
 */
class ControllerAdmin extends Controller {

    /**
     * @constructor ControllerAdmin
     * @details Constructeur de la classe ControllerAdmin
     * @param \Twig\Environment $twig
     * @param \Twig\Loader\FileSystemLoader $loader
     * @return void
     */
    public function __construct(\Twig\Environment $twig, \Twig\Loader\FileSystemLoader $loader) {
        parent::__construct($twig, $loader);
    }

    /**
     * @function lister
     * @details Fonction permettant d'afficher la page "pannelAdmin" de base
     * @uses Bd
     * @uses \Twig\Loader\FilesystemLoader
     * @uses \Twig\Environment
     * @return void
     */
    public function lister() {
        $pdo = Bd::getInstance()->getPdo();

        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);

        // Rendre le template Twig
        echo $this->getTwig()->render('pannelAdmin.html.twig', [
            'title' => 'Pannel Administrateur',
        ]);
    }

    public function sauvegarde() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $saveBD = isset($_POST["bd"]) ? true : false;
            $saveFile = isset($_POST["file"]) ? true : false;
        }

        if ($saveBD && $saveFile) {
            $this->sauvegardeBD_Fichier();
        } elseif ($saveBD) {
            $this->sauvegardeBD();
        } elseif ($saveFile) {
            $this->sauvegardeFichier();
        }

        sleep(2);
        header('Location: index.php?controlleur=admin&methode=lister');
    }

    public function sauvegardeBD() {
        $pdo = Bd::getInstance()->getPdo();

        // Définition du dossier de sauvegarde
        $backupDir = '../save_restore/backups/';
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
            $rows = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows)) {
                fwrite($file, "-- Données de la table `$table` --\n");

                // Récupérer les colonnes une seule fois
                $columns = array_keys($rows[0]);
                $columnsList = "`" . implode("`, `", $columns) . "`";

                foreach ($rows as $row) {
                    $values = array_map(function ($value) use ($pdo) {
                        return is_null($value) ? "NULL" : $pdo->quote($value);
                    }, array_values($row));

                    $valuesList = implode(", ", $values);
                    $insertQuery = "INSERT INTO `$table` ($columnsList) VALUES ($valuesList);\n";
                    fwrite($file, $insertQuery);
                }
                fwrite($file, "\n");
            }
        }

        // Fermeture du fichier et de la connexion
        fclose($file);

        echo "✅ Sauvegarde terminée ! Fichier : $backupFile";

        header('Location: index.php?controlleur=admin&methode=lister');
    }

    public function restaurationBD() {
        $pdo = Bd::getInstance()->getPdo();

        // Définition du dossier contenant les sauvegardes
        $backupDir = '../save_restore/backups/';

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
                    $pdo->exec($query);
                }
            }
            
            // Réactiver les contraintes de clés étrangères
            $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
            
            echo "✅ Restauration terminée avec succès ! Fichier restauré : $backupFile";
        } catch (PDOException $e) {
            die("❌ Erreur lors de la restauration : " . $e->getMessage());
        }

    }

    public function sauvegardeFichier() {
        $projectDir = __DIR__ . '/..'; // Modifier si nécessaire
        $backupDir = '../save_restore/backups/';

        // Vérifier que le dossier de sauvegarde existe, sinon le créer
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        // Nom du fichier de sauvegarde
        $date = date("Y-m-d_H-i-s");
        $backupFile = "{$backupDir}backup_project_{$date}.zip";

        // Création de l'archive ZIP
        $zip = new ZipArchive();
        if ($zip->open($backupFile, ZipArchive::CREATE) !== true) {
            die("❌ Impossible de créer le fichier de sauvegarde.");
        }

        // Fonction récursive pour ajouter les fichiers au ZIP en ignorant certains dossiers
        function addFolderToZip($folder, $zip, $rootLength, $ignore = ['node_modules', 'vendor']) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || in_array($file, $ignore)) continue;
                $filePath = "$folder/$file";
                $relativePath = substr($filePath, $rootLength);
                
                if (is_dir($filePath)) {
                    $zip->addEmptyDir($relativePath);
                    addFolderToZip($filePath, $zip, $rootLength, $ignore);
                } else {
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        // Ajouter les fichiers du projet dans l'archive en ignorant certains dossiers
        addFolderToZip($projectDir, $zip, strlen($projectDir) + 1);

        // Fermer l'archive
        $zip->close();

        echo "✅ Sauvegarde terminée ! Fichier : $backupFile";

    }

    public function sauvegardeBD_Fichier() {
        $projectDir = __DIR__ . '/../..'; // Dossier du projet
        $backupDir = '../save_restore/backups/';

        // Vérifier et créer le dossier de sauvegarde
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        // Nom du fichier de sauvegarde
        $date = date("Y-m-d_H-i-s");
        $backupZip = "{$backupDir}backup_{$date}.zip";
        $dbBackupFile = "{$backupDir}backup_{$date}.sql";

        // 1️⃣ Sauvegarde de la base de données
        $pdo = Bd::getInstance()->getPdo();
        $file = fopen($dbBackupFile, 'w');
        if (!$file) {
            die("❌ Impossible de créer le fichier de sauvegarde.");
        }

        // Récupération des tables
        $tablesQuery = $pdo->query("SHOW TABLES");
        $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Structure de la table
            $createTableQuery = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
            $createTableSQL = $createTableQuery['Create Table'];

            fwrite($file, "-- Structure de la table `$table` --\n");
            fwrite($file, "DROP TABLE IF EXISTS `$table`;\n$createTableSQL;\n\n");

            // Export des données
            $dataQuery = $pdo->query("SELECT * FROM `$table`");
            $rows = $dataQuery->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows)) {
                fwrite($file, "-- Données de la table `$table` --\n");

                $columns = array_keys($rows[0]);
                $columnsList = "`" . implode("`, `", $columns) . "`";

                foreach ($rows as $row) {
                    $values = array_map(function ($value) use ($pdo) {
                        return is_null($value) ? "NULL" : $pdo->quote($value);
                    }, array_values($row));

                    $valuesList = implode(", ", $values);
                    fwrite($file, "INSERT INTO `$table` ($columnsList) VALUES ($valuesList);\n");
                }
                fwrite($file, "\n");
            }
        }
        fclose($file);

        // 2️⃣ Création de l'archive ZIP
        $zip = new ZipArchive();
        if ($zip->open($backupZip, ZipArchive::CREATE) !== true) {
            die("❌ Impossible de créer le fichier ZIP.");
        }

        // Ajouter la sauvegarde SQL sous le nom 'database.sql'
        $zip->addFile($dbBackupFile, 'database.sql');

        // Fonction pour ajouter les fichiers du projet dans le ZIP
        function addFolderToZip($folder, $zip, $rootLength, $ignore = ['node_modules', 'vendor', 'backups']) {
            $files = scandir($folder);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..' || in_array($file, $ignore)) continue;
                $filePath = "$folder/$file";
                $relativePath = 'project/' . substr($filePath, $rootLength);

                if (is_dir($filePath)) {
                    $zip->addEmptyDir($relativePath);
                    addFolderToZip($filePath, $zip, $rootLength, $ignore);
                } else {
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        // Ajouter les fichiers du projet sous un dossier "project/" dans le ZIP
        addFolderToZip($projectDir, $zip, strlen($projectDir) + 1);

        // Fermer l'archive
        $zip->close();

        // Supprimer le fichier SQL temporaire
        unlink($dbBackupFile);

        echo "✅ Sauvegarde complète ! Fichier ZIP : $backupZip";

    }
}