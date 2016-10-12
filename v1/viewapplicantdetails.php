<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$id = $_POST['id'];
$pid = $_POST['pid'];
$value = $db->getProjectApplicant($id); 
$name = $value['name'];
$email = $value['email'];
$address = $value['address'];
$skills = $value['skills'];
$work = $value['work_experience'];
$education = $value['educational_brief'];
?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Applicant Details</h2>
	</div>
	<div class="page-content">
		<b>Fullname: </b><?php echo $name; ?><br />
		<b>Email: </b><?php echo $email; ?><br />
		<b>Address: </b><?php echo $address; ?><br />
		<b>Skills: </b><?php echo $skills; ?><br />
		<b>Work Experience: </b><?php echo $work; ?><br />
		<b>Educational Brief: </b><?php echo $education; ?><br />
	</div>
	<br />
	<div class="page-form">
		<table class="page-table">
			<tr>
				<td>
					<form action="viewapplicant.php" method="POST">
						<input type="hidden" value=<?php echo $pid; ?> name="id">
						<input type="hidden" value=<?php echo $id; ?> name="aid">
						<input type="submit" value='Appoint' name="appointapplicant">
					</form>
				</td>
				<td>
					<form action="viewapplicant.php" method="POST">
						<!-- <input type="hidden" value=<?php echo $id; ?> name="id"> -->
						<input type="hidden" value=<?php echo $pid; ?> name="id">
						<input type="submit" value='Back to Applicants'>
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
