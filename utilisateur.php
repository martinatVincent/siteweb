<?php include_once 'inc/header.php'; ?>
	
		<?php 
		$bdd = new PDO('mysql:host=localhost;dbname=my_blog;charset=utf8', 'root', '');
			// On séléctionne 5 articles (LIMIT) que l'on tri par date DESCendante (ORDER BY)
			$req = $bdd->prepare('SELECT * FROM users ');
			$req ->execute();
			$users = $req->fetchAll(PDO::FETCH_ASSOC);

			echo '<ul>';foreach ($users as $value) {
			
				echo '<li>'.$value['nickname'].' est inscrit depuis le '.$value['date_registered'].'</li>';
			}
				?>