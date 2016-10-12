<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);
// print_r($arr);
$id = $arr['id'];
$name = $arr['name'];
$address = $arr['address'];
$skills = $arr['skills'];
$work = $arr['work'];
$education = $arr['education'];

if(isset($_POST['name']) && isset($_POST['address']) && isset($_POST['work']) && isset($_POST['education']) && isset($_POST['skills']))
{
	$name = ($_POST['name']);
	$address = ($_POST['address']);
	$education = ($_POST['education']);
	$work = ($_POST['work']);
	$skills = $_POST['skills'];

	if(!empty($name) && !empty($address) && !empty($education) && !empty($work) && !empty($skills)){
		$value = array('id'=>$id, 'name'=>$name, 'address'=>$address, 'skills'=>$skills, 'work'=>$work, 'education'=>$education);
		if($db->updateUserInfo($user_type, $value)){
			echo 'Your Info updated successfully';
		}else{
			echo 'There seems to be a problem, can\'t edit info';
		}
	}else{
		echo 'Please fill all the information';
	}

}

?>

<div class="container">
	<div class="site-header">
		<h1>LEARN FOR LIFE</h1>
	</div>
	<div class="page-header">
		<h2>Edit your information</h2>
	</div>
	<div class="page-form">
		<form action="editstudent.php" method="POST" id="studentregform">
			<h3>Fullname</h3><input type="text" name="name" maxlength="64" value="<?php if(isset($name)){ echo $name; }?>">
			<h3>Address</h3><input type="text" name="address"  maxlength="64" value="<?php if(isset($address)){ echo $address; }?>">
			<h3>Skills(Separate by comma)</h3><br/><input type="text" name="skills"  maxlength="64" value="<?php if(isset($skills)){ echo $skills; }?>">
			
			<h3>Work Experience</h3>
			<textarea rows="8" cols="50" name="work" form="studentregform">
			<?php if(isset($work)){echo $work;} else{ echo'All your work experiences detail'; }?></textarea>
			<h3>Education</h3>
			<textarea rows="8" cols="50" name="education" form="studentregform">
			<?php if(isset($education)){echo $education;} else{ echo'All you educational brief'; }?></textarea><br />
			<input type="submit" value="Update"> 
		</form>

		<form action="studentwall.php" method="POST">
			<input type="submit" value="Back to Wall">
		</form>
	</div>
</div>