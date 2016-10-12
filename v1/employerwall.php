<?php

echo '<h1>Employer</h1>';
require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
$userid = $arr['id'];
?>

<div class="page-form">
	<table class="wall-table">
		<tr>
			<td>
				<form action="editemployer.php" method="POST">
					<input type="submit" value="Edit User Info">
				</form>
			</td>
			<td>
				<form action="createproject.php" method="POST">
					<input type="submit" value="Register Project">
				</form>
			</td>
			<td>
				<form action="logoutuser.php" method="POST">
					<input type="submit" value="Logout">
				</form>
			</td>
		</tr>
	</table>
</div>
	

	

<div class="project-list">
	<?php
		$value = $db->getProjects($userid, $user_type); 
		if(empty($value))
		{
	?>
		
		<h2>NO PROJECTS YET</h2>
		
	<?php
		}
		else{
	?>
		<div class="project-table-div">
			<h2>PROJECT LISTS</h2>
			<table class="project-table">
				<tr>
					<th style="padding: 10px; margin: 10px">ID</th>
					<th style="padding: 10px; margin: 10px">Title</th>
					<th style="padding: 10px; margin: 10px">Description</th>
					<th style="padding: 10px; margin: 10px">Skills Req</th>
					<th style="padding: 10px; margin: 10px">Payment</th>
					<th style="padding: 10px; margin: 10px">StartDat</th>
					<th style="padding: 10px; margin: 10px">EndDate</th>
					<th style="padding: 10px; margin: 10px">ExtraNote</th>
					<th style="padding: 10px; margin: 10px">Vetted</th>
					<th style="padding: 10px; margin: 10px">Appointed to</th>
					<th style="padding: 10px; margin: 10px">Progress</th>
				</tr>
	<?php
			foreach($value as $val){
				$id = $val['id'];
				$check = $db->checkAppointedProject($val['id'])
	?>   
				<tr>
					<td style="padding: 10px; margin: 10px"><?php echo $val['id']; ?></td> 
					<td style="padding: 10px; margin: 10px"><?php echo $val['title']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['description']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['skills']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['payment']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['startdate']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['enddate']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['extradescription']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['vetted']; ?></td>
					<?php
						if($check){
							$applicant = $db->getApplicantByPID($val['id']);
					?>
						<td style="padding: 10px; margin: 10px"><?php echo $applicant['name']; ?></td>
						<td style="padding: 10px; margin: 10px"><?php echo $applicant['status'].' %'; ?></td>
					<?php
						}else{
					?>
						<td style="padding: 10px; margin: 10px"><?php echo 'None' ?></td>
						<td style="padding: 10px; margin: 10px"><?php echo '0' ?></td>
					<?php
						}
					?>
					<td style="padding: 10px; margin: 10px">
						<form action="viewdetailproject.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="submit" value='Details'>
						</form>
					</td>
					<?php
						if(!$db->checkAppointedProject($val['id'])){
					?>
					<td style="padding: 10px; margin: 10px">
						<form action="viewapplicant.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="submit" value='Applicants'>
						</form>
					</td>
					<?php
						}
					?>
					<td style="padding: 10px; margin: 10px">
						<form action="editproject.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="submit" value='Edit'>
						</form>
						<!-- <a href = "editproject.php?id=<?php echo $id; ?>">Edit</a> -->
					</td>
					<td style="padding: 10px; margin: 10px">
						<form action="deleteproject.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="submit" value='Delete'>
						</form>
					</td>
				</tr>
	<?php 
	        }
	    }
	?>
			</table>
		</div>
	</div>

</div>