<?php
include('core/header.php');
if(isset($_SESSION['Etat']))
{
	$pageIDselected = $_GET['ID'];
	
	$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
	
	if($data['Membre'] == $_SESSION['Login'])
	{
		
		$paramPage = 'Location: PageParameters.php?ID='.$pageIDselected;

		if(isset($_GET['newMembre']) & isset($_GET['newCode']) & isset($_GET['newRank']))
		{
			$membreToAdd = $_GET['newMembre'];
			$membreNewPass = $_GET['newCode'];
			$membreRole = $_GET['newRank'];
			
			executeQuery("INSERT INTO pagecontentmembers VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?);", array($pageIDselected, $membreToAdd, $membreToAdd, $membreNewPass, $membreRole, 0, 0, 0, 0));

			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Succes !";
			$_SESSION['ErrorType'] = "success";
			$_SESSION['ErrorMsg'] = "Le membre '".$membreToAdd."' a été créé avec succès !";
			
			header($paramPage);
			exit();
		}
		else
		{
			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Erreur !";
			$_SESSION['ErrorType'] = "danger";
			$_SESSION['ErrorMsg'] = "Une erreur c'est produite lors de la modification !";

			header($paramPage);
			exit();
		}

		

	}
	else
	{
		
		$_SESSION['ErrorEnable'] = true;
		$_SESSION['ErrorTitle'] = "Erreur !";
		$_SESSION['ErrorType'] = "danger";
		$_SESSION['ErrorMsg'] = "La page que vous souhaitez modifier ne vous appartient pas ou n'existe pas !";
		
		header('Location: MonEspace.php');
		exit();
	}
	
}
else
{
	header('Location: index.php');
	exit();
}
?>