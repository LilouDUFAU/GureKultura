<?php
try {
    $conn = new PDO('mysql:host='. DB_HOST .'; dbname='. DB_NAME, DB_USER, DB_PASS);
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
    die();
}
?>