<?php
	
require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();

if(!loggedin()){
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password-repeat']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['description'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$password_repeat = $_POST['password-repeat'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$description = $_POST['description'];

		if(!empty($name) && !empty($email) && !empty($password)  && !empty($password_repeat) && !empty($phone) && !empty($address) && !empty($description)){
			if(strcmp($password, $password_repeat)){
				echo 'The passwords do not match';
			}else{
				if(strlen($password) < 8){
					echo 'Password length must be more than 8 characters';
				}else{
					if(filter_var($email, FILTER_VALIDATE_EMAIL)!=false)
					{
						/*echo $name.' '.$email.' '.$password.' '.$password_repeat.' '.$phone.' '.$address.' '.$description.' ';*/
						if($db->createEmployer($name, $email, $password, $phone, $address, $description)){
							header('Location: index.php');
						}else{
							echo '. User was not registered';
						}
					}
					else{
						echo 'Email format doesn\'t match';
					}
				}
			}
		}
	}else{
		echo 'Please fill all the fields';
	}
?>

<h1>LEARN FOR LIFE</h1>
<h2>Register as Employer</h2>
<form action="registeremployer.php" method="POST" id="employerregform">
	<h3>Fullname</h3><input type="text" name="name" maxlength="64" value="<?php if(isset($name)){ echo $name; }?>">
	<h3>Email</h3><input type="text" name="email" maxlength="64" value="<?php if(isset($email)){ echo $email; }?>">
	<h3>Password</h3><input type="password" name="password">
	<h3>Repeat Password</h3><input type="password" name="password-repeat">
	<h3>Phone</h3><br/><input type="text" name="phone"  maxlength="64" value="<?php if(isset($phone)){ echo $phone; }?>">
	<h3>Address</h3><input type="text" name="address"  maxlength="64" value="<?php if(isset($address)){ echo $address; }?>">
	
	<h3>Description</h3>
	<textarea rows="8" cols="50" name="description" form="employerregform">
	<?php if(isset($description)){echo $description;} else{ echo'Your description'; }?></textarea><br />
	<input type="submit" value="Register"> 
</form>

<?php
}else{
	echo 'You are logged in';
}

?>