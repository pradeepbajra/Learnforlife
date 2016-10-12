<?php
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_type'])){
		$email = $_POST['email'];
		$password = $_POST['password'];
		$user_type = $_POST['user_type'];
		if(!empty($email) && !empty($password) && !empty($user_type)){
			// echo $email.'-'.$password.'-'.$user_type;
			if(!filter_var($email, FILTER_VALIDATE_EMAIL) == false){
				if($db->loginUser($email, $password, $user_type)){
					$_SESSION['user_email'] = $email;
					$_SESSION['user_type'] = $user_type;
					header('Location: index.php');
				}else{
					echo 'Sorry the login failed. Please Retry';
				}
			}else{
				echo 'Email format doesn\'t match';
			}
		}else{
			echo 'empty';
		}
	}
?>
<div class="container">
	<div class="page-header">
		<h1>Learn for Life</h1>
	</div>
	<div class="page-form">
		<form action="<?php echo $current_file; ?>" method="POST">
			<!-- <?php echo $current_file;?> -->
			<h3>Email</h3><input type="input" name="email"><br/><br/>
			<h3>Password</h3><input type="password" name="password"><br/><br/>
			<h3>User Type</h3>
			<input type="radio" name="user_type" value="student" checked> Student<br>
		  	<input type="radio" name="user_type" value="employer"> Employer<br><br/>
			<input type="submit" value="Login"><br/>
			<h4>Not a User?</h4>
			<a href="registeremployer.php" style="text-decoration: none; color: #333;">Register as Employer</a><br/>
			<a href="registerstudent.php" style="text-decoration: none; color: #333;">Register as Student</a><br/>
		</form>
	</div>
</div>