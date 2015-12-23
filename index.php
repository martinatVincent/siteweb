<?php include_once 'inc/connexion.php'; ?>
<?php include_once 'inc/fonctions.php'; ?>
<?php include_once 'inc/header.php'; ?>
	<main>

			<p class="text-right">
				<a href="article.php" class="publish-article">Publier un nouvel article</a>
			</p>

		<?php 
			// Pagination
			$msgParPage = 5;


			$reqPag = $bdd->prepare('SELECT COUNT(*) as total FROM articles');
			if($reqPag->execute()){
				$nbArticles = $reqPag->fetch(PDO::FETCH_ASSOC);
			}

			$nbTotalPages = ceil($nbArticles['total'] / $msgParPage);
			
			if(isset($_GET['page']) && is_numeric($_GET['page'])){
				$pageCourante = (int) $_GET['page'];

				if($pageCourante > $nbTotalPages){
					$pageCourante = $nbTotalPages;
				}
			}
			else {
				$pageCourante = 1;
			}
			$start = ($pageCourante - 1) * $msgParPage;

			$req = $bdd->prepare('SELECT * FROM articles ORDER BY date DESC LIMIT :start, :maxi');
			$req->bindParam(':start', $start, PDO::PARAM_INT);
			$req->bindParam(':maxi', $msgParPage, PDO::PARAM_INT);
			if($req->execute()){
				$articles = $req->fetchAll(PDO::FETCH_ASSOC);
			}
			else {
				echo '<div class="errorContent">Une erreur est survenue. Veuillez réessayer plus tard.</div>';
			}
		?>
			<p class="text-left">
				<a href="utilsateurs.php" class="publish-article">Utilisateurs</a>
			</p>



		<?php 
			// Si $articles contient notre contenu, on affiche le tout
			if(isset($articles) && !empty($articles)): 
				foreach($articles as $art):
		?>
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
		<?php 
	  			endforeach; 
	  		endif;
		?>

		<div class="pagination-content">
			<ul class="pagination">
			<?php 
				for($i=1; $i<=$nbTotalPages; $i++){
	     	     	if($i == $pageCourante){
	     				echo '<li class="active">'.$i.'</li>'; 
				}
	     		else {
	          		echo '<li><a href="index.php?page='.$i.'">'.$i.'</a></li>';
	     		}
			}
			?>
			</ul>
		</div>
</div>
	</main>
<?php include_once 'inc/footer.php'; ?>