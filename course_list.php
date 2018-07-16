<?php
	//$servername = "localhost";
	$servername = "db_service_host:3306";
	$dbname = "cc_project_database";
	$username = "auth_service_user";
	//$password = "";
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
        <title>دروس ارائه شده در ترم</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="..//source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
        <link href="..//source/main-style.css" rel="stylesheet" type="text/css"/>
        <script src="..//source/bootstrap/js/bootstrap.min.js" ></script>
    </head>

<body>
<p class="title-tbl">لیست دروس ارائه شده </p>
<div class="col-sm-4"></div>
<div class="col-sm-4">
<table class="table-responsive table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr>
				<th>نام استاد</th>
				<th>ظرفیت</th>
				<th>واحد</th>
				<th>نام درس</th>
				<th>گروه</th>
				<th>شماره درس</th>
				<th>ردیف</th>
				
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = "SELECT * FROM courses";
			$result = $conn->query($sql);
			//var_dump($result);

			if ($result->num_rows > 0) {
				// output data of each row
				$i = 0;
				while ($row = $result->fetch_assoc()) {
					$i++;
			?>
				<tr>
					<td><?php echo $row['ProfName']; ?></td>
					<td><?php echo $row['Capacity']; ?></td>
					<td><?php echo $row['Unite']; ?></td>
					<td><?php echo $row['Name']; ?></td>
					<td><?php echo $row['GroupNo']; ?></td>
					<td><?php echo $row['Number']; ?></td>
					<td><?php echo $i; ?></td>
				</tr>
			<?php }
			} else {
				echo "0 results";
			} ?>
		</tbody>
	</table>
	<div class="link-back">
<a class="" href="http://172.100.100.120:80/main.html">بازگشت</a>
</div>
	
</div>

<div class="col-sm-4"></div>

	
	
</body>
</html>
<?php $conn->close(); ?>
