<?php
header("Location: unit.php");
    $servername = "db_service_host:3306";
	$dbname = "cc_project_database";
	$username = "auth_service_user";
	$password = "Auth_service@1397";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$type = $_GET['type'];
if ($type == 'add') {
	$student_id = $_POST['clientID'];
	$status = '1';
	$insStr = "";

	if (isset($_POST['btnsave'])) {
		if (!empty($_POST['cid'])) {
			foreach($_POST['cid'] as $course_id) {
				if($insStr == "") {
					$insStr = "('$course_id','$student_id','$status')";
				} else {
					$insStr .= ",('$course_id','$student_id','$status')";
				}
			}
			$sql = "INSERT INTO course_student (C_ID, s_id, cs_status) VALUES $insStr";
			//$conn->exec($sql);
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}

if ($type == 'del') {
	$student_id = $_POST['clientID'];
	$delStr = "";
	
	if (isset($_POST['btndel'])) {
		if (!empty($_POST['ckid'])) {
			foreach($_POST['ckid'] as $cs_id) {
				if($delStr == "") {
					$delStr = "('$cs_id')";
				} else {
					$delStr .= ",('$cs_id')";
				}
			}
			$sql = "UPDATE course_student
					SET cs_status = 0
					WHERE id IN ($delStr)";
			//$conn->exec($sql);
			if ($conn->query($sql) === TRUE) {
				echo "New record created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
}

redirect(base_url().'Unit.php');
?>
