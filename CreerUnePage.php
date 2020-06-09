<?php
include_once("core/header.php");
?>
<!-- start main -->
<form action="action_createPage.php" method="post" enctype="multipart/form-data">
<div class="wrap">
<section class="section">
	<div class="container">
		<div class="notification">
			Création d'une page. Les champs bleus sont optionnels.
	    </div>
			<?php
				if(isset($_SESSION['Etat']))
				{
					$dataInfo = executeQuery("SELECT * FROM membresinfos WHERE Membre = ?;", array($_SESSION['Login']));
					if($dataInfo['NbCurrentPage'] >= $dataInfo['NbMaxPage'])
					{
						$_SESSION['ErrorEnable'] = true;
						$_SESSION['ErrorTitle'] = "Erreur !";
						$_SESSION['ErrorType'] = "danger";
						$_SESSION['ErrorMsg'] = "Vous avez atteint le nombre maximum de page ! Augmentez votre type de compte si vous souhaitez créer plus de page.";
						
						header('Location: MonEspace.php');
						exit();
					}
					else
					{
						afficheCreerPage();
					}
					
				}
				else
				{
					header('Location: index.php');
					exit();
				}
				
				//$actionget = "getMemberData";
				//$user = $_POST["identifiant"];
				//$password = $_POST["mdp"];
				// variable qui va retourner l'état (pas utilisée au final)
				//$returnMessage = "";
				
				function afficheCreerPage()
				{
					?>
					
					<div class="box">
						<div class="field">
						  <label class="label">Titre de la page</label>
						  <div class="control">
							<input class="input" type="text" placeholder="Titre de votre page" name="pageTitle">
						  </div>
						</div>
						<div class="field">
						  <label class="label">Description de la page</label>
						  <div class="control">
							<input class="input is-info" type="text" placeholder="Description de votre page" name="pageDesc">
						  </div>
						</div>
						<label class="checkbox">
						  <input type="checkbox" name="isAvailable">
						  La page est disponible pour votre publique.
						</label>
						<h3 style="color: white;">-</h3>
						<div class="buttons">
						  <button class="button is-success" type="submit" name="CreatePage">Créer la page</button>
						  <a class="button is-danger" href="MonEspace.php">Annuler</a>
						</div>
					</div>
					
					<?php
				}
					
			?>
		</div>
	</div>
</section>
</div>
<?php
include_once("core/footer.php");
?>
</body>
</html>