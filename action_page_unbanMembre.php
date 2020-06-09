<?php
include('core/header.php');
if(isset($_SESSION['Etat']))
{
	$pageIDselected = $_GET['ID'];
	
	$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
	
	if($data['Membre'] == $_SESSION['Login'])
	{
		
		$paramPage = 'Location: PageParameters.php?ID='.$pageIDselected;

		if(isset($_GET['banMember']))
		{
			
			executeQuery("UPDATE pagecontentmembers SET Rang = 'Membre' WHERE ID = ?;", array($_GET['banMember']));

			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Succes !";
			$_SESSION['ErrorType'] = "success";
			$_SESSION['ErrorMsg'] = "Le membre a bien été libéré !";
			
			header($paramPage);
			exit();
		}
		else
		{
			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Erreur !";
			$_SESSION['ErrorType'] = "danger";
			$_SESSION['ErrorMsg'] = "Une erreur c'est produite lors de la modification ! Vous devez renseigner tous les arguments !";

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