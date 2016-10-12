<?php
require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
$userid = $arr['id'];
?>

<div class="project-list">
	<?php 
		$value = $db->getUnappliedProjects(); 
		if(empty($value))
		{
	?>
		
		<h2>NO PROJECTS YET</h2>
		<form action="studentwall.php" method="POST">
			<!-- <input type="hidden" value=<?php echo $id; ?> name="id"> -->
			<input type="submit" value='Back to Wall'>
		</form>
	<?php
		}
		else{
	?>
		<div class="project-table-div">
			<h2>UNAPPLIED PROJECT LISTS</h2>
			<form action="studentwall.php" method="POST">
				<!-- <input type="hidden" value=<?php echo $id; ?> name="id"> -->
				<input type="submit" value='Back to Wall'>
			</form>
			<table class="project-table">

				<tr>
					<th style="padding: 10px; margin: 10px">Title</th>
					<th style="padding: 10px; margin: 10px">Description</th>
					<th style="padding: 10px; margin: 10px">Skills Req</th>
					<th style="padding: 10px; margin: 10px">Payment</th>
					<th style="padding: 10px; margin: 10px">StartDat</th>
					<th style="padding: 10px; margin: 10px">EndDate</th>
					<th style="padding: 10px; margin: 10px">ExtraNote</th>
					<th style="padding: 10px; margin: 10px">Action</th>
					<th style="padding: 10px; margin: 10px">Status</th>
				</tr>
	<?php
			foreach($value as $val){
				$id = $val['id'];
				if($db->checkProjectStatus($userid, $id) == -1){
	?>   
				<tr> 
					<td style="padding: 10px; margin: 10px"><?php echo $val['title']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['description']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['skills']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['payment']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['startdate']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['enddate']; ?></td>
					<td style="padding: 10px; margin: 10px"><?php echo $val['extradescription']; ?></td>
					<td style="padding: 10px; margin: 10px">
						<form action="applyproject.php" method="POST">
							<input type="hidden" value=<?php echo $id; ?> name="id">
							<input type="submit" value='Apply'>
						</form>
						<!-- <a href = "editproject.php?id=<?php echo $id; ?>">Edit</a> -->
					</td>
					<td>
						Open
					</td>
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