<?php

require_once '../includes/DBHandler.php';
require_once 'core.inc.php';
$db = new DBHandler();

if(loggedin()){
	echo $_SESSION['user_type'];
	if(strcasecmp($_SESSION['user_type'], 'student') == 0){
		header('Location: studentwall.php');
	}else if(strcasecmp($_SESSION['user_type'], 'employer') == 0){
		header('Location: employerwall.php');
	}
	// echo '<a href="loginuser.php">Logout</a>';
}else{
	include_once 'loginform.inc.php';
}



?>

