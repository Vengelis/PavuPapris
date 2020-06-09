<?php
include('_header.php');
if(isset($_SESSION['Etat']))
{
	try
	{
		$pageIDselected = $_POST['PageID'];
	
		$query = getAllPageFromMember("SELECT * FROM pagecontentmembers WHERE PageID = ?;", array($pageIDselected));
		$ended = false;

		while($data = $query->fetch())
		{
			if($data['Login']== $_POST['Login'] AND $data['Password']== $_POST['Password'])
			{
				$ended = true;

				initSession();
								
				$_SESSION['Etat'] = true;
				$_SESSION['Login'] = $_POST['Login'];
				$_SESSION['AccountType'] = "PageAccount";

				$_SESSION['PageMember'] = "User";
				$_SESSION['PageConnectedID'] = $pageIDselected;

				$pageRedirect = "Location: ../pages/".$_POST['PageID'].".php";
				header($pageRedirect);
				exit();
			}
		}
		if($ended == false)
		{
			$_SESSION['ErrorEnable'] = true;
			$_SESSION['ErrorTitle'] = "Erreur !";
			$_SESSION['ErrorType'] = "danger";
			$_SESSION['ErrorMsg'] = "Aucun membre n'a été trouvé avec cet identifiant.";
			
			$pageRedirect = "Location: ../pages/".$_POST['PageID'].".php";
			header($pageRedirect);
			exit();
		}

	}
	
	catch(Exception $ex)
	{
		$pageRedirect = "Location: ../pages/".$_POST['PageID'].".php";
		header($pageRedirect);
		exit();
	}

}
else
{
	header('Location: ../index.php');
	exit();
}
?>