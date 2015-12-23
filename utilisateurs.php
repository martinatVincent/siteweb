
<?php include_once 'inc/header.php'; ?>
	
		<?php 
		$bdd = new PDO('mysql:host=localhost;dbname=my_blog;charset=utf8', 'root', '');

           $erreurs= array();
			if(empty($_GET['search'])){
				$erreurs[] = 'Veuillez recommencer votre recherche ';
			}
			else {
				$recherche = trim($_GET['search']);
				$reqrecherche= $bdd ->prepare('SELECT * FROM users WHERE nickname LIKE :pseudo');
				$reqrecherche->bindValue (':pseudo','%'.$recherche.'%', PDO::PARAM_STR);
				$reqrecherche->execute() 
				$users = $req->fetchAll(PDO::FETCH_ASSOC);
			
        ?>