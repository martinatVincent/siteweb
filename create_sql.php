<?php 
require_once 'inc/connection.php';

$bdd->exec('CREATE TABLE `my_blog`,`test`(`id` INT NOT NULL ,PRIMARY KEY (`id`))')

// $bdd-> exec retournera le nombre de ligne affecté en base de donnees.
// La création de table retournera 0 (même si la table est bien créée)
// Retournera false en cas d'erreur (exemple : la table existe déjà)

$bdd->exec('')


var_dump($sql); 

