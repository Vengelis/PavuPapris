<?php
include('core/header.php');
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
		
		$fileName = str_replace(" ", "_", $_POST['pageTitle']);
		$rep = executeQuery("INSERT INTO pagelist VALUES (NULL,?,?,?);", array($_SESSION['Login'], $_POST['pageTitle'], $fileName));
		
		$data = executeQuery("SELECT * FROM membresinfos WHERE Membre = ?;", array($_SESSION['Login']));
		
		$data['NbCurrentPage']++;
		
		executeQuery("UPDATE membresinfos SET NbCurrentPage = ? WHERE Membre = ?;", array($data['NbCurrentPage'],$_SESSION['Login']));
		
		$newPage = executeQuery("SELECT * FROM pagelist WHERE Membre = ? AND PageName = ?;", array($_SESSION['Login'],$_POST['pageTitle']));
		
		executeQuery("INSERT INTO pagecontentproperty VALUES (NULL, ?, ?, ?, ?, ?);", array($newPage['ID'], $_SESSION['Login'], intval($_POST['isAvailable']), $_POST['pageTitle'], $_POST['pageDesc']));
		
		$file = 'pages/_pageModele.php';
		$newfile = 'pages/'.$newPage['ID'].'.php';
		
		if (!copy($file, $newfile)) 
		{
			header('Location: erreurCreationPage.php');
			exit();
		}
		else
		{
			//echo $_SESSION['Login']. " | ";
			//echo $_POST['pageTitle']. " | ";
			//echo $fileName;
			header('Location: '.$newfile);
			exit();
		}
	}
	
}
else
{
	header('Location: index.php');
	exit();
}
?>