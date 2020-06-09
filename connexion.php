<!DOCTYPE HTML>
<?php
	include_once("core/header.php");
?>
<!-- start main -->
<form action="MonEspace.php" method="post" enctype="multipart/form-data">
<div class="wrap">
<section class="section">
	<div class="container">
		<?php
		
		if(isset($_SESSION['Etat']))
		{
			header('Location: MonEspace.php');
			exit();
		}
		else
		{
			?>
				<div class="columns">
					<div class="column">
						<h1 class="title">S'enregistrer</h1>
						<div class="field">
						  <label class="label">Pseudo</label>
						  <div class="control">
							<input class="input" type="text" placeholder="Votre pseudo" name="rPseudo">
						  </div>
						</div>

						<div class="field">
						  <label class="label">Identifiant</label>
						  <div class="control has-icons-left">
							<input class="input" type="text" placeholder="Votre login" name="rLogin">
							<span class="icon is-small is-left">
							  <i class="fas fa-user"></i>
							</span>
						  </div>
						</div>

						<div class="field">
						  <label class="label">Email</label>
						  <!-- <div class="control has-icons-left has-icons-right"> -->
						  <div class="control has-icons-left">
							<input class="input" type="email" placeholder="Votre Email" name="rMail">
							<span class="icon is-small is-left">
							  <i class="fas fa-k"></i>
							</span>
							<!--<span class="icon is-small is-right">
							  <i class="fas fa-exclamation-triangle"></i>
							</span>-->
						  </div>
						</div>
						
						<div class="field">
						  <label class="label">Mot de passe</label>
						  <div class="control has-icons-left">
							<input class="input" type="password" placeholder="Votre mot de passe" name="rPassword">
							<span class="icon is-small is-left">
							  <i class="fas fa-key"></i>
							</span>
						  </div>
						</div>
						<div class="field">
						  <label class="label">Confirmer le mot de passe</label>
						  <div class="control has-icons-left">
							<input class="input" type="text" placeholder="Votre mot de passe" name="rConfirmPassword">
							<span class="icon is-small is-left">
							  <i class="fas fa-key"></i>
							</span>
						  </div>
						</div>
						
						<div class="field">
						  <div class="control">
							<label class="checkbox">
							  <input type="checkbox" name="rAccept">
							  J'accepte la <a href="#">politique de confidencialité</a> ainsi que les <a href="#">conditions d'utilisations</a>
							</label>
						  </div>
						</div>

						<div class="field is-grouped">
						  <div class="control">
							<button class="button is-link" type="submit" name="CreateAccount">Créer son compte</button>
						  </div>
						</div>
					</div>
					<div class="column">
					</br>
					</div>
					<div class="column">
						<h1 class="title">Se connecter</h1>
						<div class="field">
						  <label class="label">Identifiant</label>
						  <div class="control has-icons-left">
							<input class="input" type="text" placeholder="Votre login" name="Login">
							<span class="icon is-small is-left">
							  <i class="fas fa-user"></i>
							</span>
						  </div>
						</div>
						<div class="field">
						  <label class="label">Mot de passe</label>
						  <div class="control has-icons-left">
							<input class="input" type="password" placeholder="Votre mot de passe" name="Password">
							<span class="icon is-small is-left">
							  <i class="fas fa-key"></i>
							</span>
						  </div>
						</div>
						<div class="field is-grouped">
						  <div class="control">
							<button class="button is-link" type="submit" name="Connexion">Se connecter</button>
						  </div>
						</div>
					</div>
				</div>
			<?php
		}
		?>
		
   </div>
  </section>
</div>
<?php
	include_once("core/footer.php");
?>
</body>
</html>