<?php
	//$studentID = 1;
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
?>

<!doctype html>
<html>
	<head>
        <title>انتخاب واحد</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="..//source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="..//source/main-style.css" rel="stylesheet" type="text/css"/>
        <script src="..//source/bootstrap/js/bootstrap.min.js"></script>
     </head>

<body>
<div class="col-sm-3"></div>
<div class="col-sm-6">
	<form action="course.php?type=add" method="post" class="form-horizontal">
			<p class="title-tbl">لطفا دروس مورد نظر خود را از لیست زیر انتخاب کنید</p>
		<table class="table-responsive table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr>
					<th>انتخاب</th>
					<th>نام استاد</th>
					<th>ظرفیت</th>
					<th>واحد</th>
					<th>گروه</th>
					<th>نام درس</th>
					<th>شماره درس</th>
					<th>ردیف</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT courses.*, course_student.C_ID as used, course_student.cs_status FROM courses
						LEFT JOIN course_student on course_student.C_ID = courses.ID";
				/*$sql = "SELECT * FROM courses
						INNER JOIN course_student ON courses.ID = course_student.C_ID
						WHERE course_student.cs_status != 1 AND course_student.s_id = $studentID";*/
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {
					// output data of each row
					$i = 0;
					while ($row = $result->fetch_assoc()) {
						$i++;
				?>
					<tr>
						<td>
							<?php
							if(isset($row['ID'])) {
								$inputData = "<input type='checkbox' ";
								if(!empty($row['cs_status'])){ $inputData.= "disabled"; }
								$inputData.=" class='checked' name='cid[]' value='".$row['ID']."'/>";
							}
							echo $inputData;
							?>
							<!--<input type="checkbox" class="checked" name="cid[]" value="<?php echo $row['ID']; ?>"/>-->
						</td>
						<td><?php echo $row['ProfName']; ?></td>
						<td><?php echo $row['Capacity']; ?></td>
						<td><?php echo $row['Unite']; ?></td>
						<td><?php echo $row['GroupNo']; ?></td>
						<td><?php echo $row['Name']; ?></td>
						<td><?php echo $row['Number']; ?></td>
						<td><?php echo $i; ?></td>
					</tr>
				<?php }
				} else {
					echo "درسی ارائه نشده است!!!";
				} ?>
			</tbody>
		</table>
		<div class="form-button">
			<button type="submit" name="btnsave" class="btn btn-success save">اعمال</button>
			<button type="reset" class="btn btn-success reset">پاک کردن</button>
		</div>
		<input type="hidden" name="clientID" value="<?php echo $studentID; ?>"/>
	</form>
		<div class="clearfix"></div>
		<div class="clearfix"></div>
		<div class="clearfix"></div>
		<form action="course.php?type=del" method="post" class="form-horizontal">
			<p class="title-tbl">لیست دروس انتخاب شده و حذف شده</p>
			<?php
			$student_course = "SELECT course_student.id, course_student.cs_status, courses.Number, courses.GroupNo,
			courses.Name, courses.Unite From course_student INNER JOIN courses on courses.ID = course_student.C_ID
			WHERE course_student.s_id = '".$studentID."'";
			$result = $conn->query($student_course);
			if ($result->num_rows > 0) {
			?>
			<table class="table-responsive table-bordered table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>حذف</th>
						<th>وضعیت</th>
						<th>گروه</th>
						<th>واحد</th>
						<th>نام درس</th>
						<th>شماره درس</th>
						<th>ردیف</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						while ($row = $result->fetch_assoc()) {
							$i++;
					?>
						<tr>
							
							<td>
								<input type="checkbox" class="checked" name="ckid[]" value="<?php echo $row['id'];?>"/>
							</td>
							<td><?php
								if ($row['cs_status'] == '1')
									echo 'انتخاب شده';
								else if ($row['cs_status'] == '0')
									echo 'حذف شده';
								?>
							</td>
							<td><?php echo $row['GroupNo']; ?></td>
							<td><?php echo $row['Unite']; ?></td>
							<td><?php echo $row['Name']; ?></td>
							<td><?php echo $row['Number']; ?></td>
							<td><?php echo $i; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="form-button">
				<button type="submit" name="btndel" class="btn btn-success del">اعمال</button>
				<button type="reset" class="btn btn-success reset">پاک کردن</button>
			</div>
			<input type="hidden" name="clientID" value="<?php echo $studentID; ?>"/>
		</form>
	<?php } ?>
	<a href="http://172.100.100.120:80/main.html">بازگشت</a>
</div>
<div class="col-sm-3"></div>
</body>
</html>
<?php $conn->close(); ?>
