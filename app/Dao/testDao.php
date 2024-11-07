<?php
require_once "ActualiteDao.php";
require_once "EvenementDao.php";

$actu = new ActualiteDao();
$even = new EvenementDao();

$array = $actu->getAll();
$array2 = $even->getAll();

foreach ($array as $key => $value) {
    if (is_array($value)) {
        echo $key . ': ' . implode(', ', $value) . '<br>';
    } else {
        echo $key . ': ' . $value . '<br>';
    }
}

foreach ($array2 as $key => $value) {
    if (is_array($value)) {
        echo $key . ': ' . implode(', ', $value) . '<br>';
    } else {
        echo $key . ': ' . $value . '<br>';
    }
}

?>