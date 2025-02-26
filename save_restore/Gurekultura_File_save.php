<?php
// Définition du dossier à sauvegarder (le dossier du projet)
$projectDir = __DIR__ . '/..'; // Modifier si nécessaire
$backupDir = __DIR__ . '/backups/';

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
