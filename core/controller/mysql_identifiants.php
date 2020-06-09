<?php
function dbConnexion()
{
	
	try 
	{ 
		return (new PDO('mysql:host=localhost;dbname=pavupapris', 'root', '')); 
	}
	catch (Exception $ex) 
	{ 
		return('ERROR:ERROR_BDD_CONNECTION'); 
	}
	
}
?>