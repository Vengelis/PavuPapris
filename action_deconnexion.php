<?php
include('core/header.php');
session_destroy();
header('Location: index.php');
exit();
?>