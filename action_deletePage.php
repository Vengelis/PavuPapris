<?php
include('core/header.php');
if(isset($_SESSION['Etat']))
{
	$pageIDselected = $_GET['ID'];
	
	$data = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
	
	if($data['Membre'] == $_SESSION['Login'])
	{
		$data = executeQuery("SELECT * FROM membresinfos WHERE Membre = ?;", array('Server'));
		$data['NbCurrentPage']++;
		executeQuery("UPDATE membresinfos SET NbCurrentPage = ? WHERE Membre = ?;", array($data['NbCurrentPage'],'Server'));
		
		$data2 = executeQuery("SELECT * FROM membresinfos WHERE Membre = ?;", array($_SESSION['Login']));
		$data2['NbCurrentPage']--;
		executeQuery("UPDATE membresinfos SET NbCurrentPage = ? WHERE Membre = ?;", array($data2['NbCurrentPage'],$_SESSION['Login']));
		
		executeQuery("UPDATE pagelist SET Membre = ? WHERE ID = ?;", array('Server',$pageIDselected));
		
		$data3 = executeQuery("SELECT * FROM pagelist WHERE ID = ?;", array($pageIDselected));
		$data3['PageName'] = $data3['PageName'].".".keyGenerator();
		executeQuery("UPDATE pagelist SET PageName = ? WHERE ID = ?;", array($data3['PageName'],$pageIDselected));
		
		$_SESSION['ErrorEnable'] = true;
		$_SESSION['ErrorTitle'] = "Succes !";
		$_SESSION['ErrorType'] = "success";
		$_SESSION['ErrorMsg'] = "La page a été retiré avec succès !";
		
		header('Location: MonEspace.php');
		exit();

	}
	else
	{
		
		$_SESSION['ErrorEnable'] = true;
		$_SESSION['ErrorTitle'] = "Erreur !";
		$_SESSION['ErrorType'] = "danger";
		$_SESSION['ErrorMsg'] = "La page que vous souhaitez supprimer ne vous appartient pas ou n'existe pas !";
		
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