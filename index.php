<?php

session_start();
session_regenerate_id();
include_once("controller/Controller.php");
$controller = new Controller($_REQUEST);
$controller->invoke($entityManager);
?>