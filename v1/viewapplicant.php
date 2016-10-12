<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$pid = $_POST['id'];
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
$userid = $arr['id'];

?>

<div class="project-list">
	<?php
		$value = $db->getProjectApplicants($pid); 
		if(empty($value))
		{
	?>
		
		<h2>NO APPLICANTS YET</h2>
		<form action="employerwall.php" method="POST">
			<input type="hidden" value=<?php echo $pid; ?> name="id">
			<input type="submit" value='Back to Wall'>
		</form>
		
	<?php
		}
		else{
	?>
		<div class="project-table-div">
			<h2>APPLICANT LISTS</h2>
			<form action="employerwall.php" method="POST">
				<input type="hidden" value=<?php echo $pid; ?> name="id">
				<input type="submit" value='Back to Wall'>
			</form>
			<table class="project-table">
				<tr>
					<th style="padding: 10px; margin: 10px">ID</th>
					<th style="padding: 10px; margin: 10px">Fullname</th>
					<th style="padding: 10px; margin: 10px">Email</th>
					<th style="padding: 10px; margin: 10px">Address</th>
					<th style="padding: 10px; margin: 10px">Skills</th>
					<th style="padding: 10px; margin: 10px">Work Experience</th>
					<th style="padding: 10px; margin: 10px">Education</th>
				</tr>
	<?php
			foreach($value as $val){
				$id = $val['id'];
	?>   
				<tr>
					<td style="padding: 10px; margin: 10px"><?php echo $val['id']; ?></td> 
					<td style="padding: 10px; margin: 10px"><?php echo $val['name']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['email']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['address']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['skills']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['work_experience']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['educational_brief']; ?></td>
					<td style="padding: 10px; margin: 10px">
						<form action="viewapplicantdetails.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="hidden" value=<?php echo $pid; ?> name="pid">
							<input type="submit" value='Details' name="detailapplicant">
						</form>
					</td>
					<td style="padding: 10px; margin: 10px">
						<form action="viewapplicant.php" method="POST">
							<input type="hidden" value=<?php echo $pid; ?> name="id">
							<input type="hidden" value=<?php echo $id; ?> name="aid">
							<input type="submit" value='Appoint' name="appointapplicant">
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

<?php
	if(isset($_POST['appointapplicant']))
	{
		$pid = $_POST['id'];
		$aid = $_POST['aid'];
		// echo $pid.' '.$aid.' '.$userid;
		if($db->appointApplicant($userid, $pid, $aid)){
			header('Location: employerwall.php');
		}else{
			echo 'Sorry something went wrong. The candidate was not appointed';
		}
	}
?>