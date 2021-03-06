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
		<h2>Project Details</h2>
	</div>
	<div class="page-content">
		Project Title: <?php echo $title; ?><br />
		Project Description: <?php echo $description; ?><br />
		Skills Required: <?php echo $skills; ?><br />
		Payment: <?php echo $payment; ?><br />
		Start Date: <?php echo $startdate; ?><br />
		End Date: <?php echo $enddate; ?><br />
		Extra Note: <?php echo $extradescription; ?><br />
		<?php
			if($db->checkAppointedProject($id)){
				$applicant = $db->getApplicantByPID($id);
				$name = $applicant['name'];
				$email = $applicant['email'];
				$address = $applicant['address'];
				$skills = $applicant['skills'];
				$work = $applicant['work_experience'];
				$education = $applicant['educational_brief'];
		?>
			<div class="applicant-content">
				<div class="applicant-header">
					<h2>Applicant Details</h2>
				</div>
				<div class="applicant-info">
					Fullname: <?php echo $name; ?><br />
					Email: <?php echo $email; ?><br />
					Address: <?php echo $address; ?><br />
					Skills: <?php echo $skills; ?><br />
					Work Experience: <?php echo $work; ?><br />
					Education: <?php echo $education; ?><br />
				</div>
			</div>
		<?php
			}
			
		?>
	</div>
	<br />
	<div class="page-form">
		<table class="page-table">
			<tr>
				<td>
					<form action="deleteproject.php" method="POST">
						<input type="submit" name="delproject" value="Delete">
						<input type="hidden" value=<?php echo $id; ?> name="id">
					</form>
				</td>
				<td>
					<form action="editproject.php" method="POST">
						<input type="submit" name="editproject" value="Edit">
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
