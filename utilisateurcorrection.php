<?php include_once 'inc/header.php'; ?>
<?php require_once 'inc/connexion.php'; ?>
<?php include_once 'inc/fonctions.php'; ?>

<?php 
if (isset($_GET['recherche']) && !empty($_GET['recherche'])) {


				$recherche = trim($_GET['search']);
				$reqrecherche= $bdd ->prepare('SELECT * FROM users WHERE nickname LIKE :pseudo');
				$reqrecherche->bindValue (':pseudo','%'.$recherche.'%', PDO::PARAM_STR);
				$reqrecherche->execute() 
				$users = $req->fetchAll(PDO::FETCH_ASSOC);
				}
else{
	$req= $bdd->prepare('SELECT * FROM users ORDER BY date_registered DESC');

	$req->execute();
	$users= $req -> fetchAll(PDO::FETCH_ASSOC);
}

?>
<main>
	<form method="get">
		<input name="recherche" placeholder="recherche...">
		<button type="submit">Envoyer</button>
	</form>
	<?php if (isset($users) && !empty($users)): 
			foreach ($users as  $value) : ?>
			<p><strong>Nickname :</strong><?php echo $value['nickname']; ?> <strong>Date enregistrement : </strong> <?php echo date ('d/m/Y à H:i', strtotime($value['date_registered'])) ?> </p>
				<?php endforeach;
				    endif; ?>

</main>
<?php include_once 'inc/footer.php'; ?>