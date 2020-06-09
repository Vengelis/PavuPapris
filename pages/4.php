<?php
	include('_header.php');

	if(isset($_SESSION['Etat']))
	{
		$pageIDselected = intval(str_replace(".php", "", basename(__FILE__)));

		$dataSettings = executeQuery("SELECT * FROM pagecontentproperty WHERE PageID = ?", array($pageIDselected));

		$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
		
		if($data['Membre'] == $_SESSION['Login'])
		{
			
			$_SESSION['PageMember'] = "Createur";
			$_SESSION['PageConnectedID'] = $pageIDselected;

			$_SESSION['Pseudo'] = $_SESSION['Login'];
			$_SESSION['Money'] = "Infini";
			$_SESSION['Exp'] = "Infini";
			$_SESSION['Rang'] = "Créateur";
			
		}
		if(($_SESSION['PageMember'] == "Createur" AND $_SESSION['PageConnectedID'] == $pageIDselected) OR ($_SESSION['PageMember'] == "User" AND $_SESSION['PageConnectedID'] == $pageIDselected))
		{
			
			if($_SESSION['PageMember'] == "User")
			{

				$dataMembersCard = executeQuery("SELECT * FROM pagecontentmembers WHERE PageID = ? AND Login = ?;", array($pageIDselected,$_SESSION['Login']));

				$_SESSION['Pseudo'] = $dataMembersCard['Pseudo'];
				$_SESSION['Money'] = $dataMembersCard['Money'];
				$_SESSION['Exp'] = $dataMembersCard['Exp'];
				$_SESSION['Rang'] = $dataMembersCard['Rang'];

			}

			displayPage();

		}
		elseif($_SESSION['PageMember'] == "User" AND $_SESSION['PageConnectedID'] != $pageIDselected)
		{
			
			$_SESSION['PageMember'] = "RefusedAccess";
			
			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Erreur !";
			$_SESSION['ErrorType'] = "danger";
			$_SESSION['ErrorMsg'] = "Ce compte ne vous permet pas d'accéder à cette page !" ;
			
			displayConnexionForm();
		}
		else
		{
			displayConnexionForm();
		}
		
	}
	else
	{
		$_SESSION['ErrorEnable'] = true;
		$_SESSION['ErrorTitle'] = "Erreur !";
		$_SESSION['ErrorType'] = "danger";
		$_SESSION['ErrorMsg'] = "Vous n'êtes pas connecté.";
		
		header("Location: ../index.php");
		exit();
	}

	function displayPage()
	{
		$pageIDselected = intval(str_replace(".php", "", basename(__FILE__)));
		$dataSettings = executeQuery("SELECT * FROM pagecontentproperty WHERE PageID = ?;", array($pageIDselected));

		$dataMembers = executeQuery("SELECT * FROM pagecontentmembers WHERE PageID = ? AND Login = ?;", array($pageIDselected,$_SESSION['Login']));

		?>
			<div class="container">
				<section class="section">
					<div class="container">
						<h1 class="title"><?php echo $dataSettings['Title']; ?></h1>
						<h2 class="subtitle"><?php echo $dataSettings['Description']; ?></h2>
						<h4 class="subtitle">Créateur de la page: <strong style="color: red;"><?php echo $dataSettings['Createur']; ?></strong></h4>
					</div>
				</section>
				<section class="section">
					<div class="columns">
						<div class="column is-one-third">
							<div class="card">
								<div class="card-content">
									<div class="media">
									<div class="media-left">
										<figure class="image is-48x48">
										<img src="../imgs/userIcon.png" alt="Membre">
										</figure>
									</div>
									<div class="media-content">
										<p class="title is-4"><?php echo $_SESSION['Pseudo']; ?></p>
										<p class="subtitle is-6">@<?php echo $_SESSION['Login']; ?></p>
									</div>
									</div>

									<div class="content">
										<div class="field is-grouped is-grouped-multiline">
											<div class="control">
												<div class="tags has-addons">
													<span class="tag">💰</span>
													<span class="tag is-warning"><?php echo $_SESSION['Money']; ?></span>
												</div>
											</div>

											<div class="control">
												<div class="tags has-addons">
													<span class="tag">XP</span>
													<span class="tag is-info"><?php echo $_SESSION['Exp']; ?></span>
												</div>
											</div>

											<div class="control">
												<div class="tags has-addons">
													<span class="tag">Rang</span>
													<span class="tag is-dark"><?php echo $_SESSION['Rang']; ?></span>
												</div>
											</div>
										</div>
									<time datetime="<?php echo date("F j, Y, g:i a"); ?>"><?php echo date("F j, Y, g:i a"); ?></time>
									</div>
								</div>
							</div>
						</div>
						<div class="column">
						<div class="tile is-ancestor">
							<div class="tile is-parent">
								<article class="tile is-child box">
									<article class="message is-warning">
										<div class="message-header">
											<p>Warning</p>
										</div>
										<div class="message-body">
											Lorem ipsum dolor sit amet, consectetur adipiscing elit. <strong>Pellentesque risus mi</strong>, tempus quis placerat ut, porta nec nulla. Vestibulum rhoncus ac ex sit amet fringilla. Nullam gravida purus diam, et dictum <a>felis venenatis</a> efficitur. Aenean ac <em>eleifend lacus</em>, in mollis lectus. Donec sodales, arcu et sollicitudin porttitor, tortor urna tempor ligula, id porttitor mi magna a neque. Donec dui urna, vehicula et sem eget, facilisis sodales sem.
										</div>
									</article>
								</article>
							</div>
							
						</div>
					</div>
				</section>
				<section class="section">
					<div class="tile is-ancestor">
						<?php

							$dataItems = getAllPageFromMember("SELECT * FROM pagecontentproduits WHERE PageID = ?;", array($pageIDselected));

							$i = 0;

							while($data = $dataItems->fetch())
							{
								if($data['isAvailable'] == 1)
								{
									$i++;
								?>
									<div class="tile is-parent">
										<article class="tile is-child box"> <!-- BG d'une cartouche : style="background-color: red;"-->
										
											<article class="media">
												<figure class="media-left">
													<p class="image is-64x64">
													<img src="https://bulma.io/images/placeholders/128x128.png">
													</p>
												</figure>
												<div class="media-content">
													<div class="content">
													<p>
														<strong><?php echo $data['Name']; ?></strong> <small>Vendeur: <?php echo $data['Vendeur']; ?></small>
														<br>
														<?php echo $data['Description']; ?>
													</p>
													</div>
													<div class="field is-grouped is-grouped-multiline">
														<div class="control">
															<div class="tags has-addons">
																<span class="tag">Prix</span>
																<span class="tag is-warning"><?php echo $data['Price']; ?> 💰</span>
															</div>
														</div>

														<div class="control">
															<div class="tags has-addons">
																<span class="tag">Quantité</span>
																<span class="tag is-info"><?php echo $data['Quantity']; ?></span>
															</div>
														</div>
														<button class="button is-success is-rounded is-small">Acheter</button>
													</div>
												</div>
											</article>
										</article>
									</div>
								<?php
									if($i%3 == 0)
									{
										echo "</div>";
									}
								}
							}
					?>
					</div>
				</section>
			</div>
		<?php
		
	}

	function displayConnexionForm()
	{
		$pageIDselected = intval(str_replace(".php", "", basename(__FILE__)));
		$dataSettings = executeQuery("SELECT * FROM pagecontentproperty WHERE PageID = ?;", array($pageIDselected));
		?>
			<form action="_action_page_loginUserPage.php" method="post" enctype="multipart/form-data">
			<div class="wrap">
				<section class="section">
					<div class="column">
						<h1 class="title">Se connecter</h1>
						<div class="field">
						  <label class="label">Numéro de page demandée:</label>
						  <div class="control">
							<input class="input" type="text" name="PageID" value=<?php echo intval(str_replace(".php", "", basename(__FILE__))); ?> readonly>
						  </div>
						</div>
						<div class="field">
						  <label class="label">Identifiant de page:</label>
						  <div class="control">
							<input class="input" type="text"  name="Login">
						  </div>
						</div>
						<div class="field">
						  <label class="label">Votre code d'accès:</label>
						  <div class="control">
							<input class="input" type="password" name="Password">
						  </div>
						</div>
						<div class="field is-grouped">
						  <div class="control">
							<button class="button is-link" type="submit" name="Connexion">Se connecter</button>
						  </div>
						</div>
					</div>
				</section>
				<script>
				</script>
			</div>
			
		<?php

	}

?>

<?php
	include('_footer.php');
?>