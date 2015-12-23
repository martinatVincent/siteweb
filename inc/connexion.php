<?php

try{
	$bdd = new PDO('mysql:host=localhost;dbname=my_blog;charset=utf8', 'root', '');	
}
catch(PDOException $e) {
	die('Erreur de connexion à MySQL : '.$e->getMessage());
}
