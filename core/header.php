<html>
<head>
<title>Pavu Papris</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- google fonts-->
<link href='http://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'>
<!-- end google fonts -->
<link href="CSS/fontawesome.css" rel="stylesheet"/>
<link href="CSS/brands.css" rel="stylesheet"/>
<link href="CSS/solid.css" rel="stylesheet"/>
<link href="CSS/regular.css" rel="stylesheet"/>
<link href="CSS/all.css" rel="stylesheet"/>
<link href="CSS/bulma.css" rel="stylesheet" type="text/css"/>
<link href="CSS/bulma.sass"/>
</head>
<!--<form action="MonEspace.php" method="post" enctype="multipart/form-data">-->
<body>
<section class="hero is-dark is-medium">
  <!-- Hero head: will stick at the top -->
  <div class="hero-head">
    <nav class="navbar">
      <div class="container">
        <div class="navbar-brand">
          <a class="navbar-item">
            <img src="imgs/logo.png" alt="Logo">
          </a>
          <span class="navbar-burger burger" data-target="navbarMenuHeroA">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </div>
        <div id="navbarMenuHeroA" class="navbar-menu">
          <div class="navbar-end">
            <a class="navbar-item is-active" href="index.php">
              Accueil
            </a>
            <a class="navbar-item">
              A propos
            </a>
            <a class="navbar-item">
              Documentation
            </a>
			<a class="navbar-item">
              Bot Discord
            </a>
			<?php
				include('core/controller/verify_user.php');
				session_start();
				
				if(isset($_SESSION['Etat']))
				{
					?>
					<span class="navbar-item">
					  <a class="button is-dark is-inverted" href="MonEspace.php">
						<span>Mon espace</span>
					  </a>
					</span>
					<a class="navbar-item" href="action_deconnexion.php">
					  Déconnexion
					</a>
					<?php
				}
				else
				{
					$_SESSION['ErrorEnable'] = false;
					?>
					<span class="navbar-item">
					  <a class="button is-dark is-inverted" href="connexion.php">
						<span>Créer un espace !</span>
					  </a>
					</span>
					<?php
					
				}
			?>
            
          </div>
        </div>
      </div>
    </nav>
  </div>

  <!-- Hero content: will be in the middle -->
  <div class="hero-body">
    <div class="container has-text-centered">
      <h1 class="title">
        Pavu Papris
      </h1>
      <h2 class="subtitle">
        Echangez vos fichiers en toute sécurité, avec symplicité et dans l'anonymat !
      </h2>
    </div>
  </div>

  <!-- Hero footer: will stick at the bottom -->
  <div class="hero-foot">
    <nav class="tabs">
      <div class="container">
        <ul>
          <li class="is-active"><a>Vue d'ensemble</a></li>
          <li><a>L'équipe</a></li>
          <li><a>Exemples</a></li>
          <li><a>Responsabilités</a></li>
          <li><a>Contact</a></li>
        </ul>
      </div>
    </nav>
  </div>
</section>