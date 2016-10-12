<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$id = $_POST['id'];
// echo $id;
$value = $db->getProjectInfo($id);
$title = $value['title'];
$description = $value['description'];
$skills = $value['skills'];
$payment = $value['payment'];
$startdate = $value['startdate'];
$enddate = $value['enddate'];
$extradescription = $value['extradescription'];

if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['skills']) && isset($_POST['payment']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['extradescription'])){
	$title = $_POST['title'];
	$description = $_POST['description'];
	$skills = $_POST['skills'];
	$payment = $_POST['payment'];
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$extradescription = $_POST['extradescription'];
	if(!empty($title) && !empty($description) && !empty($skills) && !empty($payment) && !empty($startdate) && !empty($enddate) && !empty($extradescription))
	{
		$ind_value = array('id'=>$id, 'title'=>$title, 'description'=>$description, 'skills'=>$skills, 'payment'=>$payment, 'startdate'=>$startdate, 'enddate'=>$enddate, 'extradescription'=>$extradescription);
		print_r($ind_value);
		if($db->updateProject($ind_value)){
			header('Location: employerwall.php');
		}else{
			echo 'There seems to be a problem, can\'t edit info';
		}
	}
	else{
		echo 'Please fill all the information';
	}
}

?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Edit Project</h2>
	</div>
	<div class="page-form">
		<form action="editproject.php" method="POST" id="projectregform">
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
			<input type="hidden" value="<?php echo $id; ?>" name="id">
			<input type="submit" value="Update"> 
		</form>

		<form action="employerwall.php" method="POST">
		<input type="submit" value="Back to Wall">
	</form>
	</div>
</div>