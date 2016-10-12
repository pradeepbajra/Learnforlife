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

?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Delete Project</h2>
	</div>
	<div class="page-content">
		<h3>Are you sure you want to delete?</h3>
		Project Title: <?php echo $title; ?><br />
		Project Description: <?php echo $description; ?><br />
		Skills Required: <?php echo $skills; ?><br />
		Payment: <?php echo $payment; ?><br />
		Start Date: <?php echo $startdate; ?><br />
		End Date: <?php echo $enddate; ?><br />
		Extra Note: <?php echo $extradescription; ?><br />
	</div>
	<br />
	<div class="page-form">
		<table class="page-table">
			<tr>
				<td>
					<form action="deleteproject.php" method="POST">
						<input type="submit" name="delconfirm" value="Yes">
						<input type="hidden" value=<?php echo $id; ?> name="id">
					</form>
				</td>
				<td>
					<form action="deleteproject.php" method="POST">
						<input type="submit" name="delcancel" value="No">
						<input type="hidden" value=<?php echo $id; ?> name="id">
					</form>
				</td>
				<td>
					<form action="employerwall.php" method="POST">
						<input type="submit" value="Back to wall">
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>

<?php
if(isset($_POST['delconfirm'])){//} && isset($_POST['description']) && isset($_POST['skills']) && isset($_POST['payment']) && isset($_POST['startdate']) && isset($_POST['enddate']) && isset($_POST['extradescription'])){
	if($db->deleteProject($id)){
		header('Location: employerwall.php');
	}else{
		echo 'Sorry something went wrong. Cannot delete project';
	}
}

?>
