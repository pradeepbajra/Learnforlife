<?php

require_once '../includes/DBHandler.php';
require_once 'core.inc.php';

$db = new DBHandler();
if(!loggedin()){
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-repeat']) && isset($_POST['address']) && isset($_POST['work']) && isset($_POST['education']) && isset($_POST['skills']))
	{

		$name = ($_POST['name']);
		$email = ($_POST['email']);
		$password = ($_POST['password']);
		$password_repeat = ($_POST['password-repeat']);
		$address = ($_POST['address']);
		$education = ($_POST['education']);
		$work = ($_POST['work']);
		$skills = $_POST['skills'];

		if(!empty($name) && !empty($email) && !empty($password) && !empty($password_repeat) && !empty($address) && !empty($education) && !empty($work) && !empty($skills)){
			if(strcmp($password, $password_repeat)){
				echo 'The passwords do not match';
			}else{
				if(strlen($password) < 8){
					echo 'Password length must be more than 8 characters';
				}else{
					if(filter_var($email, FILTER_VALIDATE_EMAIL)!=false)
					{
						if($db->createStudent($name, $email, $password, $address, $work, $education, $skills)){
							header('Location: index.php');
						}else{
							echo '. User was not registered';
						}
					}else{
						echo 'Email format doesn\'t match';
					}
				}
			}
		}else{
			echo 'Please fill in all the fields';
		}
	}
?>

<h1>LEARN FOR LIFE</h1>
<h2>Register as Student</h2>
<form action="registerstudent.php" method="POST" id="studentregform">
	<h3>Fullname</h3><input type="text" name="name" maxlength="64" value="<?php if(isset($name)){ echo $name; }?>">
	<h3>Email</h3><input type="text" name="email" maxlength="64" value="<?php if(isset($email)){ echo $email; }?>">
	<h3>Password</h3><input type="password" name="password">
	<h3>Repeat Password</h3><input type="password" name="password-repeat">
	<h3>Address</h3><input type="text" name="address"  maxlength="64" value="<?php if(isset($address)){ echo $address; }?>">
	<h3>Skills(Separate by comma)</h3><br/><input type="text" name="skills"  maxlength="64" value="<?php if(isset($skills)){ echo $skills; }?>">
	
	<h3>Work Experience</h3>
	<textarea rows="8" cols="50" name="work" form="studentregform">
	<?php if(isset($work)){echo $work;} else{ echo'All your work experiences detail'; }?></textarea>
	<h3>Education</h3>
	<textarea rows="8" cols="50" name="education" form="studentregform">
	<?php if(isset($education)){echo $education;} else{ echo'All you educational brief'; }?></textarea><br />
	<input type="submit" value="Register"> 
</form>


<?php
}else if(loggedin()){
	'You are logged in';
}

?>