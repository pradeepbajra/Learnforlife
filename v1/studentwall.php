<?php

echo '<h1>Student</h1>';
require_once 'core.inc.php';
// session_destroy();
// header('Location: index.php');
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
				<form action="editstudent.php" method="POST">
					<input type="submit" value="Edit User Info">
				</form>
			</td>
			<td>
				<form action="viewproject.php" method="POST">
					<input type="submit" value="View Projects">
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
		$value = $db->getAppliedProjects($userid, $user_type); 
		if(empty($value))
		{
	?>
		
		<h2>YOU HAVEN'T APPLIED TO ANY PROJECTS</h2>
		
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
					<th style="padding: 10px; margin: 10px">Status</th>
				</tr>
	<?php
			foreach($value as $val){
				$id = $val['id'];
				if($val['status'] != -1){
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
					<?php
						if($val['status'] == 0){
					?>
							<td style="padding: 10px; margin: 10px"><?php echo 'Pending Approval' ?></td>
					<?php
						}else{
					?>
							<td style="padding: 10px; margin: 10px"><?php echo $db->getProjectProgress($val['id']).' %'; ?></td>	
							<td style="padding: 10px; margin: 10px">
								<form action="projectprogress.php" method="POST">
									<input type="hidden" value=<?php echo $id; ?> name="id">
									<input type="submit" value='Update'>
								</form>
							</td>
					<?php
						}
					?>
				</tr>
	<?php 
				}
	        }
	    }
	?>
			</table>
		</div>
	</div>

</div>