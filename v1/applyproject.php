<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
$userid = $arr['id'];

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
		<h2>Application for Project</h2>
	</div>
	<div class="page-content">
		<b>Project Title: </b><?php echo $title; ?><br />
		<b>Project Description: </b><?php echo $description; ?><br />
		<b>Skills Required: </b><?php echo $skills; ?><br />
		<b>Payment: </b><?php echo $payment; ?><br />
		<b>Start Date: </b><?php echo $startdate; ?><br />
		<b>End Date: </b><?php echo $enddate; ?><br />
		<b>Extra Note: </b><?php echo $extradescription; ?><br /><br /><br />
		<h3>Learn for life - Terms and Conditions</h3>
		<p>If you apply for the project you will be responsible for its progress and secrecy according to the Terms and Conditions of the employer. <em>Learnforlife</em> is not responsible for any arrangements the students have with the employer. Do you agree to these terms and conditions?</p>
	</div>
	<br />
	<div class="page-form">
		<table class="page-table">
			<tr>
				<td>
					<form action="applyproject.php" method="POST">
						<table class="radio-table">
							<tr>
								<td><input type="radio" name="agree-disagree" value="agree" checked>I agree</td>
							  	<td><input type="radio" name="agree-disagree" value="disagree">I disagree</td>
							  	<td><input type="hidden" value=<?php echo $id; ?> name="id"></td>
							  	<td><input type="submit" name="applyconfirm" value="Apply"></td>
						  	</tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td>
					<form action="viewproject.php" method="POST">
						<input type="submit" value="Back to Project list">
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>

<?php
if(isset($_POST['agree-disagree'])){
	$agree_disagree = $_POST['agree-disagree'];
	if(!empty($agree_disagree)){
		if(strcasecmp($agree_disagree, 'agree') == 0){
			if($db->registerApplicant($userid, $id)){
				echo 'You have successfully applied for the project. The employer will contact you soon';
				header('Location: studentwall.php');
			}else{
				echo 'There seems to be some problem. Please retry';
			}
		}else{
			echo 'You must agree if you want to apply';
		}
	}
}

?>
