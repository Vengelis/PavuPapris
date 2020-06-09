
<?php
include_once("core/header.php");

?>
<!-- start main -->
<div class="wrap">
<section class="section">
	<div class="container">
		<div class="notification">
			Espace de paramétrage de la page.
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
					
					$pageIDselected = $_GET["ID"];
					
					if($pageIDselected == null)
					{
						header('Location: MonEspace.php');
						exit();
					}
					else
					{
						$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
						
						if($data["Membre"] == $_SESSION['Login'])
						{
							afficheMemberCard();
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
									Vous n'êtes pas le proprietaire de cette page ou cette page n'existe pas !
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
					}
				}
				else
				{
					try
					{
						$_SESSION = $_POST['CreateAccount'];

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
					catch (Exception $ex) 
					{
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
					$pageIDselected = $_GET["ID"];
					
					$data2 = executeQuery("SELECT * FROM pagecontentproperty WHERE PageID = ?;", array($pageIDselected));

					?>
						
						<div class="columns">
						  <div class="column">
							<nav class="panel">
								<p class="panel-heading">
									Paramètre de la page (ID: <?php echo $pageIDselected; ?>)
								</p> 
								<div class="panel-block">
									<p class="control">
									  <strong>Titre de la page: </strong>
									  <input class="input" type="text" placeholder="Titre" id="TitlePage" value="<?php echo $data2['Title']; ?>">
									</p>
								</div>	
								<div class="panel-block">
									<p class="control">
									  <strong>Description de la page: </strong>
									  <input class="input" type="text" placeholder="Description" id="DescPage" value="<?php echo $data2['Description']; ?>">
									</p>
								</div>
								<div class="box">
									<button class="button is-success is-light" type="submit" name="sendData" onClick="ModifyPage(<?php echo $_GET["ID"]; ?>)">Enregistrer</button>
								</div>								
							</nav>
							<div class="columns">
							  <div class="column">
								  <nav class="panel">
									<p class="panel-heading">
										Gestion des membres
									</p> 
									<div class="panel-block">
										<table class="table">
										  <thead>
											<tr>
											  <!--<th><abbr title="Numéro de compte unique">ID</abbr></th>-->
											  <th><abbr title="Pseudo visible à partir du compte de page">Pseudo</abbr></th>
											  <th><abbr title="Code d'accès pour rejoindre la page">Code</abbr></th>
											  <th><abbr title="Role du compte sur la page">Role</abbr></th>
											  <th><abbr title="Action à faire sur le compte">Actions</abbr></th>
											</tr>
										  </thead>
										  <tfoot>
											<tr>
											  <!--<th><abbr title="Numéro de compte unique">ID</abbr></th>-->
											  <th><abbr title="Pseudo visible à partir du compte de page">Pseudo</abbr></th>
											  <th><abbr title="Code d'accès pour rejoindre la page">Code</abbr></th>
											  <th><abbr title="Role du compte sur la page">Role</abbr></th>
											  <th><abbr title="Action à faire sur le compte">Actions</abbr></th>
											</tr>
										  </tfoot>
										  <tbody>

										  <?php
									
									
									
											$query = getAllPageFromMember("SELECT * FROM pagecontentmembers WHERE PageID = ?;", array($_GET["ID"]));

											while($data = $query->fetch())

											{

												?>
												<tr>
												  <!--<td><?php echo $data['ID']?></td>-->
												  <td><?php echo $data['Pseudo']?></td>
												  <td><?php echo $data['Password']?></td>
												  <td><span class="tag 
													<?php
														if($data['Rang']=="Admin"){
															echo "is-danger";
														}elseif($data['Rang']=="Mod"){
															echo "is-warning";
														}elseif($data['Rang']=="Banned"){
															echo "is-light";
														}else{
															echo "is-success";
														}
													?>"><?php echo $data['Rang']?></span></td>
												  <td>
													<?php
														if($data['Rang']=="Banned"){
															?>
																<button class="button is-success is-small" onClick="UnbanMember(<?php echo $_GET["ID"]; ?>, <?php echo $data['ID']?>)">Libérer</button> 
															<?php
														}else{
															?>
																<button class="button is-warning is-small" onClick="BanMember(<?php echo $_GET["ID"]; ?>, <?php echo $data['ID']?>)">Bannir</button> 
															<?php
														}
													?>
													<button class="button is-danger is-small" onClick="DelMember(<?php echo $_GET["ID"]; ?>, <?php echo $data['ID']?>)">Supprimer</button>
												  </td>
												</tr>
												<?php
												
											}
										  ?>
											
										  </tbody>
										</table>	
									</div>
								</nav>
								
							  </div>
							  <div class="column">
								<nav class="panel">
									<p class="panel-heading">
										Création d'un membre
									</p> 
									<div class="field">
									  <label class="label">Pseudo</label>
									  <div class="control has-icons-left">
										<input class="input" type="text" placeholder="Le pseudo" id="pagePseudoCreate">
										<span class="icon is-small is-left">
										  <i class="fas fa-user"></i>
										</span>
									  </div>
									</div>
									<div class="field">
									  <label class="label">Code</label>
									  <div class="control has-icons-left">
										<input class="input" type="text" placeholder="Le code" id="pageCodeCreate">
										<span class="icon is-small is-left">
										  <i class="fas fa-user"></i>
										</span>
									  </div>
									</div>
									<a class="button is-success" onClick="CreateUser(<?php echo $_GET["ID"]; ?>,'Membre')" >Créer un membre</a> <a class="button is-warning"  onClick="CreateUser(<?php echo $_GET["ID"]; ?>,'Mod')">Créer un modérateur</a>
								</nav>
							  </div>
							</div>
						  </div>
						</div>
						<script>
							function CreateUser(id, rank) {
								let pseudo = document.getElementById("pagePseudoCreate").value
								let password = document.getElementById("pageCodeCreate").value
								let urlInString =  "action_page_createMembre.php?ID=" + id + "&newMembre=" + pseudo + "&newCode=" + password + "&newRank="+rank
								let urlEncoded = encodeURI(urlInString)
								//console.log(urlInString)
								window.location = urlEncoded
							}

							function ModifyPage(id){
								let title = document.getElementById("TitlePage").value
								let desc = document.getElementById("DescPage").value
								let urlInString =  "action_page_savePageModify.php?ID=" + id + "&newTitle=" + title + "&newDesc=" + desc
								let urlEncoded = encodeURI(urlInString)
								//console.log(urlInString)
								window.location = urlEncoded
							}

							function BanMember(id, member){
								let title = document.getElementById("TitlePage").value
								let desc = document.getElementById("DescPage").value
								let urlInString =  "action_page_banMembre.php?ID=" + id + "&banMember=" + member
								let urlEncoded = encodeURI(urlInString)
								//console.log(urlInString)
								window.location = urlEncoded
							}

							function UnbanMember(id, member){
								let title = document.getElementById("TitlePage").value
								let desc = document.getElementById("DescPage").value
								let urlInString =  "action_page_unbanMembre.php?ID=" + id + "&banMember=" + member
								let urlEncoded = encodeURI(urlInString)
								//console.log(urlInString)
								window.location = urlEncoded
							}

							function DelMember(id, member){
								let title = document.getElementById("TitlePage").value
								let desc = document.getElementById("DescPage").value
								let urlInString =  "action_page_delMembre.php?ID=" + id + "&delMember=" + member
								let urlEncoded = encodeURI(urlInString)
								//console.log(urlInString)
								window.location = urlEncoded
							}
						</script>
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