<?php
	include('_header.php');

	if(isset($_SESSION['Etat']))
	{
		$pageIDselected = intval(str_replace(".php", "", basename(__FILE__)));

		$dataSettings = executeQuery("SELECT * FROM pagecontentproperty WHERE PageID = ?;", array($pageIDselected));
		$dataMembers = executeQuery("SELECT * FROM pagecontentmembers WHERE PageID = ?;", array($pageIDselected));

		$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
		
		if($data['Membre'] == $_SESSION['Login'])
		{
			
			$_SESSION['PageMember'] = "Createur";
			$_SESSION['PageConnectedID'] = $pageIDselected;
			
		}
		if(($_SESSION['PageMember'] == "Createur" AND $_SESSION['PageConnectedID'] == $pageIDselected) OR ($_SESSION['PageMember'] == "User" AND $_SESSION['PageConnectedID'] == $pageIDselected))
		{
			
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

		$dataMembers = executeQuery("SELECT * FROM pagecontentmembers WHERE PageID = ? AND Login = ?;", array($pageIDselected,));

		?>
			<div class="wrap">
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
										<?php 
											if($data['Rang'] == "Administrateur")
											{
												echo '<img src="imgs/adminIcon.png" alt="Administrateur">';
											}
											elseif($data['Rang'] == "Moderateur")
											{
												echo '<img src="imgs/modIcon.png" alt="Administrateur">';
											}
											elseif($data['Rang'] == "Developpeur")
											{
												echo '<img src="imgs/devIcon.png" alt="Administrateur">';
											}
											elseif($data['Rang'] == "Serveur")
											{
												echo '<img src="imgs/serverIcon.png" alt="Administrateur">';
											}
											elseif($data['Rang'] == "Membre")
											{
												echo '<img src="imgs/userIcon.png" alt="Administrateur">';
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
							</div>
						</div>
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