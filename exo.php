<?php 

try{
	$bdd= new PDO('mysql:host=localhost;dbname=vincent;charset=utf8', 'root', '');	
}
catch(PDOException $e ){
	die('Erreur de connection à MySQL : '.$e->getMessage());
}

$bdd-> exec('CREATE TABLE `vincent`,`utilisateurs`(`id` INT NOT NULL AUTO_INCREMENT , `firstname` VARCHAR(255) NOT NULL , `lastname` VARCHAR(255), `email` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE =InnoDB;'  );




 ?>