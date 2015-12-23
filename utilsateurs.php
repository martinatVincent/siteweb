
<?php include_once 'inc/header.php'; ?>
	
		<?php 
		$bdd = new PDO('mysql:host=localhost;dbname=my_blog;charset=utf8', 'root', '');
			// On séléctionne 5 articles (LIMIT) que l'on tri par date DESCendante (ORDER BY)
			$req = $bdd->prepare('SELECT * FROM users ');
			$req ->execute();
			$users = $req->fetchAll(PDO::FETCH_ASSOC);

			echo '<ul>';
			foreach ($users as $value) {
			
				echo '<li>'.$value['nickname'].' est inscrit depuis le '.$value['date_registered'].'</li>';
			}
				?>
			
			



			<?php  $erreurs= array();
			if(empty($_GET['search'])){
				$erreurs[] = 'Veuillez recommencer votre recherche ';
			}
			else {
				$recherche = trim($_GET['search']);
				$reqrecherche= $bdd ->prepare('SELECT * FROM users WHERE nickname LIKE :pseudo');
				$reqrecherche->bindValue (':pseudo','%'.$recherche.'%', PDO::PARAM_STR);
				$reqrecherche->execute(); 
				$users = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			
?>
<main>

			<form method="get">
			

			<label for="pseudo">entrer le pseudo rechercher</label>
			<input type="text" name="recherche" placeholder="Votre recherche de pseudo">

		

			<button type="submit">Envoyer</button>
			</form>
			<?php 
			if (isset($users) && !empty($users)): 		
					foreach($users as $value): 
			?>
					<p><strong>Date d'enregistrement :</strong><?php echo date('d/m/Y à H:i ',strtotime($value['date_registered'])); ?></p>
			  	</main>	
		  	<?php
				endforeach;
			endif;

			?>
	  		

	
<?php include_once 'inc/footer.php'; ?>