<?php
// bootstrap.php
require_once "vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;


// Create a simple "default" Doctrine ORM configuration for Attributes
$paths = array(__DIR__ . "/src");
$isDevMode = true;

$config = ORMSetup::createAnnotationMetadataConfiguration($paths, $isDevMode);


// configuring the database connection
$connection = DriverManager::getConnection([
    'dbname' => 'sae401thibault_1',
    'user' => '410306',
    'password' => '2710Th2004',
    'host' => 'mysql-sae401thibault.alwaysdata.net',
    'driver' => 'pdo_mysql',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);
