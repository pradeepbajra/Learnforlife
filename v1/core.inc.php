<?php

ob_start();
session_start();
$current_file = $_SERVER['SCRIPT_NAME'];
// $current_file = ltrim($current_file, 'Learnforlife/')

function loggedin(){
	if(isset($_SESSION['user_email']) && isset($_SESSION['user_type']) && !empty($_SESSION['user_email']) && !empty($_SESSION['user_type'])){
		return true;
	}else{
		return false;
	}
}

function studentloggedin(){
	if(isset($_SESSION['user_email']) && isset($_SESSION['user_type']) && !empty($_SESSION['user_email']) && !empty($_SESSION['user_type'])){
		if(stecasecmp($_SESSION['user_type'], 'employer') == 0)
			return true;
		else
			return false;
	}else{
		return false;
	}
}

function employerloggedin(){
	if(isset($_SESSION['user_email']) && isset($_SESSION['user_type']) && !empty($_SESSION['user_email']) && !empty($_SESSION['user_type'])){
		if(stecasecmp($_SESSION['user_type'], 'student')==0)
			return true;
		else
			return false;
	}else{
		return false;
	}
}

?>