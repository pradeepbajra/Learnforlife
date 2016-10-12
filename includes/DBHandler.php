<?php

class DBHandler{

	private $conn;

	function __construct()
	{

		require_once '../includes/DBConnect.php';
		$db = new DBConnect();
		$this->conn = $db->Connect();
	}


	public function loginUser($email, $password, $user_type){
		require_once '../includes/PassHash.php';
        // fetching user by email
        if(strcasecmp($user_type, 'student') == 0){
        	// echo 'Student';
        	$stmt = $this->conn->prepare("SELECT id, password FROM tbl_user_student WHERE email = ?");
        }else if(strcasecmp($user_type, 'employer') == 0){
        	// echo 'Employer';
        	$stmt = $this->conn->prepare("SELECT id, password FROM tbl_user_employer WHERE email = ?");	
        }
        /*$stmt = $this->conn->prepare("SELECT id, password FROM tbl_user_student WHERE email = ?");*/
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id, $password_hash);
        $stmt->store_result();
 		if ($stmt->num_rows > 0) {
            // Found user with the email
            // Now verify the password
            $stmt->fetch();
            $stmt->close();
            if (PassHash::check_password($password_hash, $password)) {
                return TRUE;
                // User password is correct
                
            } else {
                // user password is incorrect
                return FALSE;
                echo 'Email / Password is wrong';
            }
        } else {
            $stmt->close();
            // user not existed with the email
            echo 'This email doesn\'t exists';
            return FALSE;
        }
	}

    public function createStudent($name, $email, $password, $address, $work, $education, $skills) {
        require_once '../includes/PassHash.php';
        $response = array();
 
        // First check if user already existed in db
        if (!$this->isStudentExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);
 
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO tbl_user_student(name, email, password, address, skills, work_experience, educational_brief) values(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $email, $password_hash, $address, $skills, $work, $education);
 
            $result = $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                echo 'User Successfully registered';
                return TRUE;
            } else {
                // Failed to create user
                echo 'Could not register user';
                return FALSE;
            }
        } else {
            // User with same email already existed in the db
            echo 'This email has already been registered';
            return FALSE;
        }
 
        // return $response;
    }

    public function createEmployer($name, $email, $password, $phone, $address, $description) {
        require_once '../includes/PassHash.php';
        $response = array();
 
        // First check if user already existed in db
        if (!$this->isEmployerExists($email)) {
            echo 'here';
            // Generating password hash
            $password_hash = PassHash::hash($password);
 
            // insert query
            $stmt = $this->conn->prepare("INSERT INTO tbl_user_employer(name, email, password, phone, address, description) values(?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $name, $email, $password_hash, $phone, $address, $description);
 
            $result = $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
 
            // Check for successful insertion
            if ($result) {
                echo 'User Successfully registered';
                return TRUE;
            } else {
                // Failed to create user
                echo 'Could not register user';
                return FALSE;
            }
        } else {
            // User with same email already existed in the db
            echo 'This email has already been registered';
            return FALSE;
        }
 
        // return $response;
    }

    private function isStudentExists($email) {
        $stmt = $this->conn->prepare("SELECT id from tbl_user_student WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    private function isEmployerExists($email) {
        $stmt = $this->conn->prepare("SELECT id from tbl_user_employer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function getUserInfo($user_type, $email){
        $value = array();
        if(strcasecmp($user_type, 'student') == 0){
            // echo 'Student';
            $stmt = $this->conn->prepare("SELECT id, name, address, skills, work_experience, educational_brief FROM tbl_user_student WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $name, $address, $skills, $work_experience,  $educational_brief);
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->fetch();
                $stmt->close();
            }
            $value = array('id'=>$id, 'name'=>$name, 'address'=>$address, 'skills'=>$skills, 'work'=>$work_experience, 'education'=>$educational_brief);
            return $value;
        }else if(strcasecmp($user_type, 'employer') == 0){
            // echo 'Employer';
            $stmt = $this->conn->prepare("SELECT id, name, phone, address, description FROM tbl_user_employer WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $name, $phone, $address, $description);
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->fetch();
                $stmt->close();
            }
            $value = array('id'=>$id, 'name'=>$name, 'phone'=>$phone, 'address'=>$address, 'description'=>$description);
            return $value;
        }

    }

    public function updateUserInfo($user_type, $value){
        if(strcasecmp($user_type, 'student') == 0){
            $id = $value['id'];
            $name = $value['name'];
            $address = $value['address'];
            $education = $value['education'];
            $work = $value['work'];
            $skills = $value['skills'];
            $stmt = $this->conn->prepare("UPDATE tbl_user_student SET name = ?, address = ?, skills = ?, work_experience = ?, educational_brief = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $name, $address, $skills, $work, $education, $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }else if(strcasecmp($user_type, 'employer') == 0) {
            $id = $value['id'];
            $name = $value['name'];
            $phone = $value['phone'];
            $address = $value['address'];
            $description = $value['description'];
            $stmt = $this->conn->prepare("UPDATE tbl_user_employer SET name = ?, phone = ?, address = ?, description = ? WHERE id = ?");
       
            $stmt->bind_param("ssssi", $name, $phone, $address, $description, $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    public function registerProject($userid, $title, $description, $skills, $payment, $startdate, $enddate, $extradescription)
    {
        $stmt = $this->conn->prepare("INSERT INTO tbl_project(prjt_title, prjt_description, skills, payment, start_date, end_date, description) values(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $title, $description, $skills, $payment, $startdate, $enddate, $extradescription);
        $result = $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            if($this->linkEmployerProject($userid, $id)){
                echo 'Project Successfully registered';
                return TRUE;
            }else{
                echo 'Project not registered';
                return FALSE;
            }
        } else {
            // Failed to create user
            echo 'Could not register project';
            return FALSE;
        }
    }

    private function linkEmployerProject($userid, $id){
        $stmt = $this->conn->prepare("INSERT INTO tbl_employer_project(prjt_id, emp_id) values(?, ?)");
        $stmt->bind_param("ii", $id, $userid);
        $result = $stmt->execute();
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getProjects($id, $user_type){
        $value = array();
        $id_arr = $this->getProjectIDs($id, $user_type);
        // print_r($id_arr);
        for($i = 0; $i < count($id_arr); $i++){
            $ind_value = $this->getProjectInfo($id_arr[$i]);
            array_push($value, $ind_value);
        }
        return $value;
    }

    private function getProjectIDs($id, $user_type){
        // $prjt_id = array();
        if(strcasecmp($user_type, 'employer') == 0){
            $stmt = $this->conn->prepare("SELECT prjt_id FROM tbl_employer_project WHERE emp_id = ?");
        }else if(strcasecmp($user_type, 'student') == 0){
            $stmt = $this->conn->prepare("SELECT prjt_id FROM tbl_std_prjt WHERE std_id = ?");
        }
        // $stmt = $this->conn->prepare("SELECT prjt_id FROM tbl_employer_project WHERE emp_id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($prj_id);
        $stmt->store_result();
        $prjt_id = array();
        while($stmt->fetch()){
            $prjt_id[] = $prj_id;
            // array_push($prjt_id, $prj_id);
        }
        // print_r($prjt_id);
        $stmt->close();
        return $prjt_id;
    }

    public function getProjectInfo($id){
        $stmt = $this->conn->prepare("SELECT prjt_title, prjt_description, skills, payment, start_date, end_date, description, vetted FROM tbl_project WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($title, $description, $skills, $payment, $startdate, $enddate, $extradescription, $vetted);
        $stmt->store_result();
        if($stmt->num_rows == 1){
            $stmt->fetch();
            $ind_value = array('id'=>$id, 'title'=>$title, 'description'=>$description, 'skills'=>$skills, 'payment'=>$payment, 'startdate'=>$startdate, 'enddate'=>$enddate, 'extradescription'=>$extradescription, 'vetted'=>$vetted);
        }
        return $ind_value;
    }

    public function getAllProjects(){
        $value = array();
        $stmt = $this->conn->prepare("SELECT id, prjt_title, prjt_description, skills, payment, start_date, end_date, description, vetted FROM tbl_project");
        // $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($id, $title, $description, $skills, $payment, $startdate, $enddate, $extradescription, $vetted);
        $stmt->store_result();
        while($stmt->fetch()){
            if($vetted == 1){
                $ind_value = array('id'=>$id, 'title'=>$title, 'description'=>$description, 'skills'=>$skills, 'payment'=>$payment, 'startdate'=>$startdate, 'enddate'=>$enddate, 'extradescription'=>$extradescription, 'vetted'=>$vetted);
                array_push($value, $ind_value);
            }
        }
        return $value;
    }

    public function getUnappliedProjects(){
        $value = array();
        $applied = 0;
        $stmt = $this->conn->prepare("SELECT id, prjt_title, prjt_description, skills, payment, start_date, end_date, description, vetted FROM tbl_project WHERE appointed = ?");
        $stmt->bind_param("i", $applied);
        $result = $stmt->execute();
        $stmt->bind_result($id, $title, $description, $skills, $payment, $startdate, $enddate, $extradescription, $vetted);
        $stmt->store_result();
        while($stmt->fetch()){
            if($vetted == 1){
                $ind_value = array('id'=>$id, 'title'=>$title, 'description'=>$description, 'skills'=>$skills, 'payment'=>$payment, 'startdate'=>$startdate, 'enddate'=>$enddate, 'extradescription'=>$extradescription, 'vetted'=>$vetted);
                array_push($value, $ind_value);
            }
        }
        return $value;
    }

    public function updateProject($value){
        $id = $value['id'];
        $title = $value['title'];
        $description = $value['description'];
        $skills = $value['skills'];
        $payment = $value['payment'];
        $startdate = $value['startdate'];
        $enddate = $value['enddate'];
        $extradescription = $value['extradescription'];
        $stmt = $this->conn->prepare("UPDATE tbl_project SET prjt_title = ?, prjt_description = ?, skills = ?, payment = ?, start_date = ?, end_date = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $title, $description, $skills, $payment, $startdate, $enddate, $extradescription, $id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function deleteProject($id){
        if($this->ifProjectExist($id)){
            $this->deleteLinkEmployerProject($id);
            $this->deleteLinkEmployerStudentProject($id);
            $this->deleteLinkStudentProject($id);
            $stmt = $this->conn->prepare("DELETE FROM tbl_project WHERE id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        return TRUE;
    }

    private function ifProjectExist($id){
        $stmt = $this->conn->prepare("SELECT id from tbl_project WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    private function deleteLinkEmployerProject($id){
        if($this->ifLinkEmployerProjectExists($id)){
            $stmt = $this->conn->prepare("DELETE FROM tbl_employer_project WHERE prjt_id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }else{
            return TRUE;
        }
    }

    private function ifLinkEmployerProjectExists($id){
        $stmt = $this->conn->prepare("SELECT id from tbl_employer_project WHERE prjt_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    private function deleteLinkEmployerStudentProject($id){
        if($this->ifLinkEmployerStudentProjectExists($id)){
            $stmt = $this->conn->prepare("DELETE FROM tbl_emp_prjt_std WHERE prjt_id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    private function ifLinkEmployerStudentProjectExists($id){
        $stmt = $this->conn->prepare("SELECT id from tbl_emp_prjt_std WHERE prjt_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    private function deleteLinkStudentProject($id){
        if($this->ifLinkStudentProjectExists($id)){
            $stmt = $this->conn->prepare("DELETE FROM tbl_std_prjt WHERE prjt_id = ?");
            $stmt->bind_param("i", $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }

    private function ifLinkStudentProjectExists($id){
        $stmt = $this->conn->prepare("SELECT id from tbl_std_prjt WHERE prjt_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }


    public function registerApplicant($userid, $id){
        $stmt = $this->conn->prepare("INSERT INTO tbl_applicants(prjt_id, std_id) values(?, ?)");
        $stmt->bind_param("ii", $id, $userid);
        $result = $stmt->execute();
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            $stmt = $this->conn->prepare("INSERT INTO tbl_std_prjt(prjt_id, std_id) values(?, ?)");
            $stmt->bind_param("ii", $id, $userid);
            $result = $stmt->execute();
            $stmt->close();
            if($result){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    public function checkProjectStatus($userid, $id){
        $stmt = $this->conn->prepare("SELECT id, status from tbl_std_prjt WHERE prjt_id = ? AND std_id = ?");
        $stmt->bind_param("ii", $id, $userid);
        $stmt->execute();
        $stmt->bind_result($id, $status);
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        if($num_rows > 0){
            $stmt->fetch();
            $stmt->close();
            // echo $status;
            return $status;
        }
        $stmt->close();
        return -1;
    }

    public function getAppliedProjects($id, $user_type){
        $value = array();
        $id_arr = $this->getProjectIDs($id, $user_type);
        // print_r($id_arr);
        for($i = 0; $i < count($id_arr); $i++){
            $ind_value = $this->getProjectInfo($id_arr[$i]);
            $status = $this->checkProjectStatus($id, $ind_value['id']);
            $ind_value['status'] = $status;
            array_push($value, $ind_value);
        }
        return $value;
    }

    public function getProjectApplicants($id){
        $value = array();
        $id_arr = $this->getApplicantIDs($id);
        // print_r($id_arr);
        for($i = 0; $i < count($id_arr); $i++){
            $stmt = $this->conn->prepare("SELECT name, email, address, skills, work_experience, educational_brief FROM tbl_user_student WHERE id = ?");
            $stmt->bind_param("i", $id_arr[$i]);
            $result = $stmt->execute();
            $stmt->bind_result($name, $email, $address, $skills, $work_experience, $educational_brief);
            $stmt->store_result();
            if($stmt->num_rows == 1){
                $stmt->fetch();
                $ind_value = array('id'=>$id_arr[$i], 'name'=>$name, 'email'=>$email, 'address'=>$address, 'skills'=>$skills, 'work_experience'=>$work_experience, 'educational_brief'=>$educational_brief);
            }
            $stmt->close();
            array_push($value, $ind_value);
        }
        // print_r($value);
        return $value;
    }


    public function getProjectApplicant($app_id){
        $stmt = $this->conn->prepare("SELECT name, email, address, skills, work_experience, educational_brief FROM tbl_user_student WHERE id = ?");
        $stmt->bind_param("i", $app_id);
        $result = $stmt->execute();
        $stmt->bind_result($name, $email, $address, $skills, $work_experience, $educational_brief);
        $stmt->store_result();
        if($stmt->num_rows == 1){
            $stmt->fetch();
            $ind_value = array('id'=>$app_id, 'name'=>$name, 'email'=>$email, 'address'=>$address, 'skills'=>$skills, 'work_experience'=>$work_experience, 'educational_brief'=>$educational_brief);

        }
        $stmt->close();
        return $ind_value;
    }

    private function getApplicantIDs($id){
        $stmt = $this->conn->prepare("SELECT std_id FROM tbl_applicants WHERE prjt_id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->bind_result($std_id);
        $stmt->store_result();
        $student_id = array();
        while($stmt->fetch()){
            $student_id[] = $std_id;
            // array_push($prjt_id, $prj_id);
        }
        // print_r($student_id);
        $stmt->close();
        return $student_id;
    }

    public function appointApplicant($userid, $pid, $aid){
        $stmt = $this->conn->prepare("INSERT INTO tbl_emp_prjt_std(emp_id, prjt_id, std_id) values(?, ?, ?)");
        $stmt->bind_param("iii", $userid, $pid, $aid);
        $result = $stmt->execute();
        $stmt->close();

        // Check for successful insertion
        if ($result) {
            if($this->clearCandidates($pid)){
                if($this->setAppointedProject($pid)){
                    if($this->setApprovalStudent($aid, $pid)){
                        return TRUE;
                    }
                    else{
                        return FALSE;
                    }
                }
                else{
                    return FALSE;
                }
            }
            else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    private function setApprovalStudent($aid, $pid){
        if($this->rejectAll($pid)){
            $appointed = 1;
            $stmt = $this->conn->prepare("UPDATE tbl_std_prjt SET status = ? WHERE std_id = ? AND prjt_id = ?");
            $stmt->bind_param("iii", $appointed, $aid, $pid);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return TRUE;
            }
            else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    private function rejectAll($pid){
        $appointed = -1;
        $stmt = $this->conn->prepare("UPDATE tbl_std_prjt SET status = ? WHERE prjt_id = ?");
        $stmt->bind_param("ii", $appointed, $pid);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function clearCandidates($pid){
        $stmt = $this->conn->prepare("DELETE FROM tbl_applicants WHERE prjt_id = ?");
        $stmt->bind_param("i", $pid);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    private function setAppointedProject($pid){
        $appointed = 1;
        $stmt = $this->conn->prepare("UPDATE tbl_project SET appointed = ? WHERE id = ?");
        $stmt->bind_param("ii", $appointed, $pid);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function checkAppointedProject($pid){
        $stmt = $this->conn->prepare("SELECT id from tbl_emp_prjt_std WHERE prjt_id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    private function getEmployeeByPID($pid){
        $stmt = $this->conn->prepare("SELECT emp_id FROM tbl_employer_project WHERE prjt_id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->bind_result($eid);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
        }
        return $eid;
    }

    public function getApplicantByPID($pid){
        $stmt = $this->conn->prepare("SELECT std_id, prjt_progress FROM tbl_emp_prjt_std WHERE prjt_id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->bind_result($aid, $status);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
        }
        $applicant = $this->getProjectApplicant($aid);
        $applicant['status'] = $status;
        return $applicant;
    }

    public function getProjectProgress($pid){
        $stmt = $this->conn->prepare("SELECT std_id, prjt_progress FROM tbl_emp_prjt_std WHERE prjt_id = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        $stmt->bind_result($aid, $status);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();
        }
        return $status;
    }

    public function updateProjectProgress($id, $progress){
        $stmt = $this->conn->prepare("UPDATE tbl_emp_prjt_std SET prjt_progress = ? WHERE prjt_id = ?");
        $stmt->bind_param("ii", $progress, $id);
        $result = $stmt->execute();
        $stmt->close();
        if ($result) {
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}

?>