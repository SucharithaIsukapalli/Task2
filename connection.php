<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentmanagementsystem";//database name
$conn = new mysqli($servername, $username, $password, $dbname);//establishing connection to the database
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}
$sql2 = "use studentmanagementsystem;";//selecting the database
if ($conn->query($sql2) === TRUE) {
  //echo "Database task2 selected successfully";
} else {
 $s1 = "ERROR SELECTING DATABASE!";
	$s2 = $conn->error;
	$s3 = $s1.$s2;
	echo '<script type="text/javascript">alert("'.$s3.'");</script>';
}
?>
