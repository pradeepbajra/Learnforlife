<?php

require_once 'core.inc.php';
require_once '../includes/DBHandler.php';

$db = new DBHandler();
$user_type = $_SESSION['user_type'];
$user_email = $_SESSION['user_email'];
$arr = $db->getUserInfo($user_type, $user_email);

$id = $arr['id'];
$name = $arr['name'];
$phone = $arr['phone'];
$address = $arr['address'];
$description = $arr['description'];

if(isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['description'])){
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$description = $_POST['description'];

	if(!empty($name) && !empty($phone) && !empty($address) && !empty($description)){
		$value = array('id'=>$id, 'name'=>$name, 'phone'=>$phone, 'address'=>$address, 'description'=>$description);
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
		<form action="editemployer.php" method="POST" id="employerregform">
			<h3>Fullname</h3><input type="text" name="name" maxlength="64" value="<?php if(isset($name)){ echo $name; }?>">
			<h3>Phone</h3><br/><input type="text" name="phone"  maxlength="64" value="<?php if(isset($phone)){ echo $phone; }?>">
			<h3>Address</h3><input type="text" name="address"  maxlength="64" value="<?php if(isset($address)){ echo $address; }?>">
			
			<h3>Description</h3>
			<textarea rows="8" cols="50" name="description" form="employerregform">
			<?php if(isset($description)){echo $description;} else{ echo'Your description'; }?></textarea><br />
			<input type="submit" value="Update"> 
		</form>

		<form action="employerwall.php" method="POST">
		<input type="submit" value="Back to Wall">
	</form>
	</div>
</div>