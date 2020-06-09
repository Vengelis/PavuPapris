<?php
/*
require("core/controller/mysql_controller.php");

$dbh = new PDO('mysql:host=localhost;dbname=pavupapris', 'root', '');

$del = $dbh->prepare("INSERT INTO `pagecontentproperty`(`ID`, `PageID`, `Createur`, `Enabled`, `Title`, `Description`) VALUES (NULL,20,'Test',false,'test','test');");
$del->execute();

 Retourne le nombre de lignes effacées 
print("Retourne le nombre de lignes effacées :\n");
$count = $del->rowCount();

echo $count;


echo executeQuery("INSERT INTO `pagecontentproperty`(`ID`, `PageID`, `Createur`, `Enabled`, `Title`, `Description`) VALUES (NULL,?,?,?,?,'test1');", array(10,'test5',0,'test'));
*/
header('Location: index.php');
exit();
?>
