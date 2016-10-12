<!-- <?php
require_once '../includes/DBHandler.php';
$db = new DBHandler();

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_type'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$user_type = $_POST['user_type'];
	if(!empty($email) && !empty($password) && !empty($user_type)){
		echo 'OK';
		echo $email.'-'.$password.'-'.$user_type;
		// $db->loginUser($email, $password, $user_type);
	}else{
		echo 'empty';
	}
}

?> -->

<?php

require_once 'core.inc.php';
session_destroy();
header('Location: index.php');

?>