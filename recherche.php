<?php 
/**
 * Code by Manu
 */
require_once 'inc/connexion.php';
include_once 'inc/fonctions.php'; 
include_once 'inc/header.php'; 

$erreurs = array();
if(empty($_GET["search"])){
	$erreurs[] = "Recherche impossible";
} 
else {
	$recherche = strip_tags($_GET["search"]);
	$req = $bdd->prepare("SELECT * FROM articles WHERE title LIKE :recherche OR content LIKE :recherche");
	$req->bindValue(":recherche", '%'.$recherche.'%', PDO::PARAM_STR);
	if($req->execute()){
		$articles = $req->fetchAll();
	} else {
		$erreurs[] = "Une erreur est intervenue.";
	}
}
if(count($erreurs)==0): 
	foreach($articles as $art):
?>
	<main>
	  	<article>
	  		<div class="info-post">
				<h2 class="title-post"><?php echo $art['title']; ?></h2>
		  		<p class="date-post">Article posté le <?php echo date('d/m/Y H:i', strtotime($art['date'])); ?></p>
	  		</div>
	  		<img src="<?php echo $art['img']; ?>" class="caption">
		  	<p><?php echo cutString($art['content'], 200); ?></p>
		  	<p class="text-right">
		  		<a href="read.php?id=<?php echo $art['id']; ?>" class="link">&raquo; Lire cet article</a>
	  		</p>
	  	</article>
	 </main>
<?php
	endforeach;
else: 
?>
  	<article>
  		<h1>Erreur</h1>
	 	<?php 
	 		foreach($erreurs as $err){
				echo '<p>'.$err.'</p>';
	  		} 
		?>
  	</article>

<?php endif; ?>
<?php include_once 'inc/footer.php'; ?>
