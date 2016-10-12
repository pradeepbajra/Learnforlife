<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$id = $_POST['id'];
$value = $db->getProjectInfo($id);
$title = $value['title'];
// echo $id;
/*$value = $db->getProjectInfo($id);
$title = $value['title'];
$description = $value['description'];
$skills = $value['skills'];
$payment = $value['payment'];
$startdate = $value['startdate'];
$enddate = $value['enddate'];
$extradescription = $value['extradescription'];*/

if(isset($_POST['progress']) && !empty($_POST['progress'])){
	$progress = $_POST['progress'];
	echo $id.' '.$progress;
	if($db->updateProjectProgress($id, $progress)){
		header('Location: studentwall.php');
	}else{
		echo 'Something went wrong, couldn\'t update progress';
	}
}

?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Project Progress - <?php echo $title; ?></h2>
	</div>
	<div class="page-form">
		<form action="projectprogress.php" method="POST" id="projectregform">
			<h3>Project Completed(in %)</h3><input type="text" name="progress" value="<?php if(isset($progress)){ echo $progress; }?>">
			<input type="hidden" value="<?php echo $id; ?>" name="id">
			<input type="submit" value="Update"> 
		</form>

		<form action="studentwall.php" method="POST">
		<input type="submit" value="Back to Wall">
	</form>
	</div>
</div>