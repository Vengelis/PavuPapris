<?php
	include_once("core/header.php");
?>
<!-- start main -->
<div class="wrap">
<section class="section">
	<div class="container is-fluid">
	<div class="notification">
    Bienvenue sur <strong>Pas Vu Pas Pris</strong> ! Ce site est dédié au partage de tout et de rien. Que ça soit des devoirs d'étudiants, des fichiers ou des images, bref de tout.
  </div>
		<?php
			if(isset($_SESSION['ErrorEnable']))
			{
				if ($_SESSION['ErrorEnable'] == true)
				{
					
					$_SESSION['ErrorEnable'] = false;
					?>
					
						<article class="message is-<?php echo $_SESSION['ErrorType']; ?>">
						  <div class="message-header">
							<p><?php echo $_SESSION['ErrorTitle']; ?></p>
						  </div>
						  <div class="message-body">
							<?php echo $_SESSION['ErrorMsg']; ?>
						  </div>
						</article>
					
					<?php
					
				}
				
			}
		
		?>
      <div class="tile is-ancestor">
		  <div class="tile is-parent">
			<article class="tile is-child box">
			  <p class="title">C'est quoi ?</p>
			  <p class="subtitle">Bien plus qu'une zone d'échange</p>
			  <div class="content">
				<p>Imaginez une zone cachée à la vue de tout publique non invité. Seul l'administrateur de la zone d'échange peut donner des accès et superviser les trafics. 
				Vous allez pouvoir échanger vos documents à l'abris des regards.
				Si vous souhaitez voir à quoi ressemble une exempel d'espace d'échange, voici une petite vidéo de présentation:
				</p>
				<figure class="image is-4by3">
					<img src="https://bulma.io/images/placeholders/640x480.png">
				</figure>
			  </div>
			</article>
		  </div>
		  <div class="tile is-parent is-8">
			<article class="tile is-child box">
			  <p class="title">Que comporte la zone d'échange</p>
			  <p class="subtitle">Pleins de petites fonctionnalités</p>
			  <div class="content">
					<strong>Une page d'administration:</strong> 
					<p>L'administrateur de la page va avoir accès à un panel lui permettant de superviser les transfères et les points des membres. Il va pouvoir également configurer les comptes 
					pouvant avoir accès à la page en question.</p>
					<p>Un compte d'une page ne peut être utilisé que par une page. Ce sont des identifiants uniques généré par le gestionnaire de la page</p>
					<p>L'administrateur peut décider de donner des rangs aux membres de la page. Differents rangs sont disponibles lors de la création des comptes.</p>
					
					<div class="columns is-gapless">
					  <div class="column">
						  <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					</div>

					</br>
					<strong>Un espace d'échange:</strong>
					<p>L'espace d'échange regroupe plusieurs catégories. Une zone va servir à voir les éléments disposibles sur la page, une zone va permettre de faire un échange et une autre zone va permettre de poster
					une ressource.</p>
					<p>Une ressource peut être gratuite mais aussi payante avec des points obtenable via diverses moyens mit à disposition par l'administrateur de la page. Ca peut être en faisant des ventes, des achats ou pleins
					d'autres choses selon les envies de l'administrateur.</p>
					
					<div class="columns is-gapless">
					  <div class="column">
						  <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					</div>
					
					</br>
					<strong>Un espace de membre:</strong>
					<p>Rien de mieux que de personnaliser son profil de page. Via cette page, vous allez pouvoir accéder à votre classement de page et tout un tas d'autres informations qui vous permettrons d'accéder à des zones
					supplémentaires à la zone d'échange. C'est ici aussi que vous verrez vos derniers produits échangés dans le mois en cours. Vous accederez à tout un tas de services utiles et spontanés.
					</p>
					<div class="columns is-gapless">
					  <div class="column">
						  <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					  <div class="column">
					    <figure class="image is-480x480">
							  <img src="https://bulma.io/images/placeholders/256x256.png">
						  </figure>
					  </div>
					</div>
			  </div>
			</article>
		  </div>
		</div>
    </div>
  </section>
</div>
<?php
	include_once("core/footer.php");
?>
</body>
</html>