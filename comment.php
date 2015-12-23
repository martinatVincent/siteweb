<?php
include_once 'inc/connexion.php'; 

$post = array();
$error = array();

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(empty($post['id_article']) && !is_numeric($post['id_article'])){
		$error[] = 'Aucun ID d\'article fourni ou celui-ci est incorrect';
	}

	if(empty($post['pseudo'])){
		$error[] = 'Le pseudo ne peut être vide';
	}
	if(empty($post['commentaire'])){
		$error[] = 'Le commentaire ne peut être vide';
	}

	if(count($error) > 0){
		$errorShow = true;
	}
	else {
		//Je selection un utilisateur afin de verifier son existence
		$checkUser= $bdd->prepare('SELECT id FROM users WHERE nickname= :pseudo');
		$checkUser->bindValue(':pseudo', $post['pseudo'], PDO::PARAM_STR);
		$checkUser->execute()

		$user= $checkUser-> fetch(PDO::FETCH_ASSOC);
		// Recupere l'ID utilisateur
		if(isset($user['id'] && !empty($user['id'])){
			$user_id =$user['id'];
		}
		else{
		$insertUser = $bdd->prepare('INSERT INTO users (nickname, date_registered) VALUES (:pseudo, NOW())');
		$insertUser->bindValue(':pseudo', $post['pseudo'], PDO::PARAM_STR);

		$insertUser->execute();
		$user_id = $bdd->lastInsertId();
		} 
		// Récupère le dernièr ID insérer de la dernière requête

		if(!empty($user_id)){

			$insertCom = $bdd->prepare('INSERT INTO comments (comment, id_article, id_user, date) VALUES (:comment, :id_article, :id_user, NOW())');
			$insertCom->bindValue(':comment', $post['commentaire'], PDO::PARAM_STR);
			$insertCom->bindValue(':id_article', $post['id_article'], PDO::PARAM_INT);
			$insertCom->bindValue(':id_user', $user_id, PDO::PARAM_INT);

			if($insertCom->execute()){
				// Retourne le nombre de lignes affectés par la derniere requete $insertCom->rowCount
				$nbInsertion= $insertCom->rowCount();
				$formSuccess = true;
			}

		}
		else {
			$errorShow = true;
			$error[] = 'Une erreur est survenue...!';
		}

	}


}
?>
<?php include_once 'inc/header.php'; ?>
	<main>

		<?php if(isset($errorShow) && $errorShow): ?>
			<div class="errorContent"><?php echo implode('<br>', $error); ?></div>
		<?php endif; ?>
		<?php if(isset($formSuccess) && $formSuccess): ?>
			<div class="successContent">
				Votre commentaire a été publié ! <a href="read.php?id=<?php echo $_GET['idArticle']; ?>" class="link">&raquo; Retour à l'article</a>
			</div>
		<?php endif; ?>


		<form method="POST">
			<input type="hidden" name="id_article" value="<?php echo $_GET['idArticle']; ?>">

			<label for="pseudo">Pseudo</label>
			<input type="text" name="pseudo" placeholder="Votre pseudo">

			<br>

			<label for="commentaire">Commentaire</label>
			<textarea name="commentaire" cols="40" rows="10"></textarea>

			<br>


			<input type="submit" value="Envoyer">

		</form>

	</main>
<?php include_once 'inc/footer.php'; ?>