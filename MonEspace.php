
<?php
include_once("core/header.php");

?>
<!-- start main -->
<div class="wrap">
<section class="section">
	<div class="container">
		<div class="notification">
			Votre espace personnel
	    </div>
			<?php
				if(isset($_SESSION['Etat']) == true)
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
					if($_SESSION['AccountType'] == "WebAccount")
					{
						afficheMemberCard();
					}
					else
					{
						$_SESSION['ErrorEnable'] = true;
						$_SESSION['ErrorTitle'] = "Erreur !";
						$_SESSION['ErrorType'] = "danger";
						$_SESSION['ErrorMsg'] = "Le compte que vous utilisez n'est pas un compte du site !";

						header('Location: index.php');
						exit();
					}
					
				}
				else
				{
					try
					{
						
						if(isset($_POST['CreateAccount']))
						{
							$userLogin = $_POST['rLogin'];
							$returnConnectUserData = connectUser($userLogin, $_POST['rPassword']);
							if($returnConnectUserData == "ERROR:INEXISTANT_USER")
							{
								try
								{
									executeQuery("INSERT INTO membres VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);", array($userLogin, $_POST['rPassword'], $_POST['rPseudo'], $_POST['rMail'], "Membre", 0, 0));
									executeQuery("INSERT INTO membresinfos VALUES (NULL, ?, ?, NULL, NULL, ?, ?);", array($userLogin, "Basique", 0, 2));

									initSession();

									$_SESSION['ErrorEnable'] = true;
									$_SESSION['ErrorTitle'] = "Bienvenue";
									$_SESSION['ErrorType'] = "success";
									$_SESSION['ErrorMsg'] = "Génial ! Votre compte a été créé avec succès ! Bienvenue :D";
								
									$_SESSION['Etat'] = true;
									$_SESSION['Login'] = $_POST['rLogin'];
									$_SESSION['AccountType'] = "WebAccount";

									afficheMemberCard();
								}
								catch (Exception $ex)
								{
									$_SESSION['ErrorEnable'] = true;
									$_SESSION['ErrorTitle'] = "Erreur !";
									$_SESSION['ErrorType'] = "danger";
									$_SESSION['ErrorMsg'] = "Une erreur c'est produite lros de la création de votre compte. Tous les champs ne sont pas complet.";

									header('Location: connexion.php');
									exit();
								}

							}
							else
							{
								?>
									<article class="message is-danger">
									<div class="message-header">
										<p>Erreur !</p>
										<button class="delete" aria-label="delete" ></button>
									</div>
									<div class="message-body">
										Il semblerait que ce compte soit inexistant ! Veuillez choisir un autre identifiant.
										<div class="container">
											<div class="field is-grouped">
											<div class="control">
												<a class="button is-danger" href="connexion.php">Retour</a>
											</div>
											</div>
										</div>
									</div>
									</article>
								<?php
							}
						}
						else
						{
							$userLogin = $_POST['Login'];
							$returnConnectUserData = connectUser($userLogin, $_POST['Password']);
							if($returnConnectUserData == "ERROR:INEXISTANT_USER")
							{
								?>
									<article class="message is-danger">
									<div class="message-header">
										<p>Erreur !</p>
										<button class="delete" aria-label="delete" ></button>
									</div>
									<div class="message-body">
										Il semblerait que ce compte soit inexistant !
										<div class="container">
											<div class="field is-grouped">
											<div class="control">
												<a class="button is-danger" href="connexion.php">Retour</a>
											</div>
											</div>
										</div>
									</div>
									</article>
								<?php
							}
							elseif($returnConnectUserData == "ERROR:WRONG_PASSWORD")
							{
								?>
									<article class="message is-danger">
									<div class="message-header">
										<p>Erreur !</p>
										<button class="delete" aria-label="delete" ></button>
									</div>
									<div class="message-body">
										Le mot de passe est incorrecte !
										</br>
										<div class="container">
											<div class="field is-grouped">
											<div class="control">
												<a class="button is-danger" href="connexion.php">Retour</a>
											</div>
											</div>
										</div>
									</div>
									</article>
								<?php
							}
							elseif($returnConnectUserData == "ERROR:USER_BANNED")
							{
								?>
									<article class="message is-danger">
									<div class="message-header">
										<p>Erreur !</p>
										<button class="delete" aria-label="delete" ></button>
									</div>
									<div class="message-body">
										Le compte que vous tentez d'utiliser a été suspendu par l'équipe administrative.
										</br>
										<div class="container">
											<div class="field is-grouped">
											<div class="control">
												<a class="button is-danger" href="connexion.php">Retour</a>
											</div>
											</div>
										</div>
									</div>
									</article>
								<?php
							}
							elseif($returnConnectUserData == "PASS:VALID_USER")
							{
								
								initSession();
								
								$_SESSION['Etat'] = true;
								$_SESSION['Login'] = $_POST['Login'];
								$_SESSION['AccountType'] = "WebAccount";
								header('Location: MonEspace.php');
								exit();
							}
							else
							{
								session_destroy();
								header('Location: index.php');
								exit();
							}
						}
					}
					catch (Exception $ex) 
					{

						$_SESSION['ErrorEnable'] = true;
						$_SESSION['ErrorTitle'] = "Erreur !";
						$_SESSION['ErrorType'] = "danger";
						$_SESSION['ErrorMsg'] = "Une erreur c'est produite. Veuillez réessayer.";

						session_destroy();
						header('Location: index.php');
						exit();
					}
				}
				
				//$actionget = "getMemberData";
				//$user = $_POST["identifiant"];
				//$password = $_POST["mdp"];
				// variable qui va retourner l'état (pas utilisée au final)
				//$returnMessage = "";
				
				function afficheMemberCard()
				{
					$data = executeQuery("SELECT * FROM membres WHERE Login = ?;", array($_SESSION['Login']));
					$dataInfo = executeQuery("SELECT * FROM membresinfos WHERE Membre = ?;", array($_SESSION['Login']));
					
					?>
						<div class="columns">
						  <div class="column is-one-third">
							<div class="card">
							  <div class="card-image">
								<figure class="image is-4by3">
									
									<?php
									
									if($dataInfo['Background'] != null)
									{
										?><img src="<?php echo $dataInfo['Background']; ?>" alt="Background Image"><?php
										
									}
									else
									{
										?><img src="https://bulma.io/images/placeholders/1280x960.png" alt="Background Image"><?php
									}
									?>
								
								  
								</figure>
							  </div>
							  <div class="card-content">
								<div class="media">
								  <div class="media-left">
									<figure class="image is-48x48">
										<?php 
											if($data['Rang'] == "Administrateur")
											{
												echo '<img src="imgs/adminIcon.png" alt="Administrateur">';
											}
											elseif($data['Rang'] == "Moderateur")
											{
												echo '<img src="imgs/modIcon.png" alt="Modérateur">';
											}
											elseif($data['Rang'] == "Developpeur")
											{
												echo '<img src="imgs/devIcon.png" alt="Développeur">';
											}
											elseif($data['Rang'] == "Serveur")
											{
												echo '<img src="imgs/serverIcon.png" alt="Serveur">';
											}
											elseif($data['Rang'] == "Membre")
											{
												echo '<img src="imgs/userIcon.png" alt="Membre">';
											}
										?>
									  
									</figure>
								  </div>
								  <div class="media-content">
									<p class="title is-4"><?php echo $data['Pseudo'];$dataInfo['Background']; ?></p>
									<p class="subtitle is-6"><?php 
											if($data['Rang'] == "Administrateur")
											{
												echo '<span class="tag is-danger">Administrateur</span>';
											}
											elseif($data['Rang'] == "Modérateur")
											{
												echo '<span class="tag is-warning">Modérateur</span>';
											}
											elseif($data['Rang'] == "Developpeur")
											{
												echo '<span class="tag is-danger">Développeur</span>';
											}
											elseif($data['Rang'] == "Serveur")
											{
												echo '<span class="tag is-black">Serveur</span>';
											}
											elseif($data['Rang'] == "Membre")
											{
												echo '<span class="tag is-info">Membre</span>';
											}
											echo ' '.$data['Login']
										?></p>
								  </div>
								</div>

								<div class="content">
								  <div class="control">
									<div class="tags has-addons">
									  <span class="tag is-dark">Type: </span>
									    <?php 
											if($dataInfo['TypeAccount'] == "Basique")
											{
												echo '<span class="tag is-light">Basique</span>';
											}
											elseif($dataInfo['TypeAccount'] == "VIP")
											{
												echo '<span class="tag is-success">VIP</span>';
											}
											elseif($dataInfo['TypeAccount'] == "VIP+")
											{
												echo '<span class="tag is-info">VIP+</span>';
											}
											elseif($dataInfo['TypeAccount'] == "MVP")
											{
												echo '<span class="tag is-warning">MVP</span>';
											}
											elseif($dataInfo['TypeAccount'] == "MVP+")
											{
												echo '<span class="tag is-black">MVP+</span>';
											}
											
										?>
									</div>
								  </div>
								  <?php echo $dataInfo['Description']; ?>
								  <br>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="column">
							<nav class="panel">
								  <p class="panel-heading">
									Mes pages (<?php echo $dataInfo['NbCurrentPage']; ?> / <?php echo $dataInfo['NbMaxPage']; ?>) 
									<?php 
										if($dataInfo['NbCurrentPage'] < $dataInfo['NbMaxPage'])
										{
											echo '<a class="button is-small is-primary is-light" href="CreerUnePage.php">Créer une page</a>';
										}else
										{
											echo '<a class="button is-small is-light is-light">Créer une page</a>';
										}
									?> 
								  </p>
								  <div class="box">
									<a class="button is-danger is-light is-light" href='deleteAllPage.php'>Supprimer toute les pages</a>
									<a class="button is-warning is-light is-light" href='viderAllPage.php'>Vider toute les pages</a>
								  </div>
								  <?php
									
									
									
									$query = getAllPageFromMember("SELECT * FROM pagelist WHERE Membre = ?;", array($_SESSION['Login']));
									
									$i = 1;
									
									while($data = $query->fetch())
									{
										if($i <= $dataInfo['NbCurrentPage'])
										{
											
											$i++;
											?>
											<div class="box">
												<a class="panel-block">
													<?php echo $data['PageName']; ?>
												</a>
												<p style="color: white;">-</p>
												<a class="button is-info is-small is-light" href='pages/<?php echo $data['ID']?>.php'>Accéder</a>
												<a class="button is-info is-small is-light" href='PageParameters.php?ID=<?php echo $data['ID']?>'>Paramètres</a>
												<a class="button is-warning is-small is-light" href='viderPage.php?ID=<?php echo $data['ID']?>'>Vider</a>
												<a class="button is-danger is-small is-light" href='action_deletePage.php?ID=<?php echo $data['ID']?>'>Supprimer</a>
											</div>
											<?php
										
										}
										else
										{
											break; 
										}
									}
								  ?>
								  
								</nav>
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