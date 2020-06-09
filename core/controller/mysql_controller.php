<?php
require('mysql_identifiants.php');
require('session_constructor.php');

function executeQuery($query, $args, $fetch = true)
{
	
	$bdd = dbConnexion();
	$response = $bdd->prepare($query);
	$response->execute($args);
	//var_dump($response);
	if ($fetch)
	{
		$data = $response->fetch();
		$response->closeCursor();
		return ($data);
	}else Return ($response);
}


function getAllPageFromMember($query, $args, $fetch = true)
{
	
	$bdd = dbConnexion();
	$response = $bdd->prepare($query);
	$response->execute($args);
	return $response;
}

function keyGenerator(){
   $key = '';
   $str = strtoupper(substr(md5(uniqid(rand(), true)), 0, 25));
   for ($i=0; $i < 25; $i++) {
      if ($i == 5 OR $i == 10 OR $i == 15 OR $i == 20){
         $key .= '-';
      }
      $key .= $str[$i];
   }
   return $key;
}

?>