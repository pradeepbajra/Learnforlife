<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
$id = $arr['id'];

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['skills']) && isset($_POST['payment']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['extradescription'])){
	$title = $_POST['title'];
	$description = $_POST['description'];
	$skills = $_POST['skills'];
	$payment = $_POST['payment'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$extradescription = $_POST['extradescription'];
	if(!empty($title) && !empty($description) && !empty($skills) && !empty($payment) && !empty($startdate) && !empty($enddate) && !empty($extradescription)){
		if($db->registerProject($id, $title, $description, $skills, $payment, $startdate, $enddate, $extradescription)){
			header('Location: employerwall.php');
		}else{
			echo 'Project not registered. Please retry';
		}
	}
}

?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Register a Project</h2>
	</div>
	<div class="page-form">
		<form action="createproject.php" method="POST" id="projectregform">
			<h3>Project Title</h3><input type="text" name="title" maxlength="64" value="<?php if(isset($title)){ echo $title; }?>">
			<h3>Project Description</h3>
			<textarea rows="8" cols="50" name="description" form="projectregform">
			<?php if(isset($description)){echo $description;} else{ echo'Project description'; }?></textarea><br />
			<h3>Skills Required (comma separated)</h3><br/><input type="text" name="skills"  maxlength="64" value="<?php if(isset($skills)){ echo $skills; }?>">
			<h3>Payment (in $)</h3><br/><input type="text" name="payment"  maxlength="64" value="<?php if(isset($payment)){ echo $payment; }?>">
			<h3>Start Date</h3><input type="date" name="startdate"  maxlength="64" value="<?php if(isset($startdate)){ echo $startdate; }?>">
			<h3>End Date</h3><input type="date" name="enddate"  maxlength="64" value="<?php if(isset($enddate)){ echo $enddate; }?>">
			<h3>Description</h3>
			<textarea rows="8" cols="50" name="extradescription" form="projectregform">
			<?php if(isset($extradescription)){echo $extradescription;} else{ echo'Extra description'; }?></textarea><br />
			
			<input type="submit" value="Create"> 
		</form>

		<form action="employerwall.php" method="POST">
		<input type="submit" value="Back to Wall">
	</form>
	</div>
</div>