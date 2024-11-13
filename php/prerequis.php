<?php
$breadcrumbs = Breadcrumb::generate();

$conn = Bd::getInstance()->getPdo();

$actualite = getData::getActualite($conn);