<?php
// demarrage de la session
session_start();

// stockage des valeurs du formulaire dans des variables de session
$_SESSION['titre'] = $_POST['titre'] ?? '';
$_SESSION['type'] = $_POST['type'] ?? '';
$_SESSION['autorisation'] = $_POST['autorisation'] ?? '';
$_SESSION['email'] = $_POST['email'] ?? '';
$_SESSION['tel'] = $_POST['tel'] ?? '';
$_SESSION['nomRep'] = $_POST['nomRep'] ?? '';
$_SESSION['prenomRep'] = $_POST['prenomRep'] ?? '';
$_SESSION['description'] = $_POST['description'] ?? '';
$_SESSION['debutDate'] = $_POST['debutDate'] ?? '';
$_SESSION['finDate'] = $_POST['finDate'] ?? '';
$_SESSION['debutHeure'] = $_POST['debutHeure'] ?? '';
$_SESSION['finHeure'] = $_POST['finHeure'] ?? '';
$_SESSION['lieu'] = $_POST['lieu'] ?? '';
$_SESSION['photo'] = $_POST['photo'] ?? '';

// inclusion du fichier contenant les constantes
require_once '../../config/constantes.php';

// inclusion du fichier contenant la classe de validation des donnees
require_once '../../app/controllers/validator.class.php';

// definition des regles de validations que l'on souhaite verifier pour chaque champs du formulaire
$regleValidation = [
    'titre' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 5,
        'longueurMax' => 30,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'type' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 4,
        'longueurMax' => 30,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'autorisation' => [
        'obligatoire' => false,
        'type' => '.pdf ,.jpg, .jpeg, .png',
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'email' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 10,
        'longueurMax' => 100,
        'format' => FILTER_VALIDATE_EMAIL
    ],
    'tel' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 10,
        'longueurMax' => 14,
        'format' => '^0\d(\s|-)?(\d{2}(\s|-)?){4}$'
    ],
    'nomRep' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 2,
        'longueurMax' => 100,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'prenomRep' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 2,
        'longueurMax' => 100,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'description' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 100,
        'longueurMax' => 500,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'debutDate' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurExacte' => 10,
        'format' => '/^\d{4}-\d{2}-\d{2}$/'
    ],
    'finDate' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurExacte' => 10,
        'format' => '/^\d{4}-\d{2}-\d{2}$/'
    ],
    'debutHeure' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurExacte' => 5,
        'format' => '/^\d{2}:\d{2}$/'
    ],
    'finHeure' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurExacte' => 5,
        'format' => '/^\d{2}:\d{2}$/'
    ],
    'lieu' => [
        'obligatoire' => true,
        'type' => 'string',
        'longueurMin' => 5,
        'longueurMax' => 100,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ],
    'photo' => [
        'obligatoire' => false,
        'type' => 'string',
        'longueurMin' => 5,
        'longueurMax' => 100,
        'format' => '/^[a-zA-Z0-9\s]+$/'
    ]
];

// instanciation de la classe de validation
$validator = new Validator($regleValidation);

// recuperation des donnees du formulaire
$donnees = $_POST;

// validation des donnees du formulaire
$donneesValides = $validator->valider($donnees);
$messageErreurs = $validator->getMessageErreurs();
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de l'événement</title>
    <link rel="stylesheet" href="../../css/output.css">
</head>

<body class="p-8 font-['Segoe UI']">
    <div class="container mt-5">
        <h2 class="text-center mb-4 font-bold text-2xl">Résultat de la proposition d'événement</h2>

        <ul class="list-none mb-8 border-solid border-2 border-gray-300 rounded-lg">
            <li class="p-2"><strong>Titre :</strong> <?=$_POST['titre']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Type :</strong> <?=$_POST['type']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Autorisation jointe :</strong> <?=$_POST['autorisation']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Email du responsable :</strong> <?=$_POST['email']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Téléphone du responsable :</strong> <?=$_POST['tel']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Nom du responsable :</strong> <?=$_POST['nomRep']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Prénom du responsable :</strong> <?=$_POST['prenomRep']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Description de l'événement :</strong> <?=$_POST['description']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Date de début :</strong> <?=$_POST['debutDate']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Date de fin :</strong> <?=$_POST['finDate']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Heure de début :</strong> <?=$_POST['debutHeure']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Heure de fin :</strong> <?=$_POST['finHeure']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Lieu de l'événement :</strong> <?=$_POST['lieu']?? '';?></li>
            <li class="p-2 border-t-2 border-t-solid border-gray-300"><strong>Image de l'événement :</strong> <?=$_POST['photo']?? '';?></li>
        </ul>
    </div>
<?php 
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    /* Répertoire de destination pour l'enregistrement du fichier 
    Attention : apache doit avoir des droits en écriture sur ce dossier */
    $uploadDir = '../asset/evenement/';
    /* Création d'un nom de fichier unique
    Utilisation de time() pour ajouter un timestamp au nom d'origine du fichier.
    Cela permet d'éviter les conflits lorsque plusieurs utilisateurs téléchargent des fichiers 
    ayant le même nom (par exemple, plusieurs fichiers nommés "profil.jpg").
    Sans un nom de fichier unique, chaque nouvel upload avec le même nom écraserait le fichier précédent, 
    ce qui entraînerait la perte de l'image de profil d'autres utilisateurs.
    Avec ce système, chaque fichier a un nom distinct basé sur le timestamp au moment du téléchargement. */
    $fileName = time() . '_' . basename($_FILES['photo']['titre']);
    /* Chemin complet de destination du fichier
    Concatène le répertoire de destination (`uploads/`) avec le nom de fichier unique généré.
    Cela crée le chemin complet où le fichier sera stocké sur le serveur.
    Exemple : "uploads/1633024800_profil.jpg" */
    $filePath = $uploadDir . $fileName;

    // Déplacement du fichier téléchargé vers le répertoire de destination
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
        echo "Le fichier est valide, et a été téléchargé avec succès.\n";
    } else {
        echo "<strong>Erreur : Le fichieer n'a pas été téléchargé.</strong>";
    }
} else {
    echo "<strong>Erreur : Aucune photo téléchargée ou erreur lors du téléchargement.</strong>";
}

// Affichage des erreurs de validation
if (!empty($messageErreurs)) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
    echo '<strong class="font-bold">Erreurs dans le formulaire :</strong>';
    echo '<ul>';
    foreach ($messageErreurs as $champ => $erreurs) {
        foreach ($erreurs as $erreur) {
            echo "<li>$erreur</li>";
        }
    }
    // envoie a la base de donnees
    // $sql = "INSERT INTO " . PREFIX_TABLE . "evt (titre, type, autorisation, email, tel, nomRep, prenomRep, description, debutDate, finDate, debutHeure, finHeure, lieu, photo) VALUES (:titre, :type, :autorisation, :email, :tel, :nomRep, :prenomRep, :description, :debutDate, :finDate, :debutHeure, :finHeure, :lieu, :photo)";
    // $stmt = $pdo->prepare($sql);
    echo '</ul>';
    echo '</div>';
}

echo '<div class="flex justify-center items-center mt-8">
<a href="../index.php?controlleur=propEv&methode=lister" class="border-2 border-solid border-gray-400 rounded-lg p-2">Retour à l\'édition de la proposition d\'événement</a>
<a href="../index.php?controlleur=index&methode=lister" class="border-2 border-solid border-gray-400 rounded-lg p-2">Valider</a>
</div>';
echo '</body>';
echo '</html>';

// fermeture de la session
session_destroy();
?>
