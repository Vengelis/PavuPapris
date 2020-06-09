<?php
include('mysql_controller.php');

function connectUser($login, $password)
{
	$data = executeQuery("SELECT * FROM membres WHERE Login = ?;", array($login));
	
	if (empty($data['Login']))
	{
		return("ERROR:INEXISTANT_USER");
	}
	else if ($data['Password'] != $password)
	{
		return("ERROR:WRONG_PASSWORD");
	} 
	elseif ($data['EtatMod'] == 3)
	{
		return("ERROR:USER_BANNED");
	}
	else
	{
		return("PASS:VALID_USER");
	}
}

?>