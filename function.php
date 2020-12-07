<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
session_start();
include("connection.php");
$q =$_GET['q'];
//echo $q;
if($_GET['role']=='stu'){//for students table
	if($_GET['ekk']=='a'){//for admin role
if($q==""){
$sql = "select * from student";
$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";//display a table
echo "<tr><th>Student ID</th><th>Student name</th><th>Phone number</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['sid']}</td><td>{$row['sname']}</td><td>{$row['phone']}</td></tr>\n";
}
echo "</table>";
}else{
	$q = intval($q);
	$sql = "select * from student where sid='$q'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	$count = mysqli_num_rows($result);
	if($count==1){
		$sql = "select * from student where sid='$q'";
	$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Student ID</th><th>Student name</th><th>Phone number</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['sid']}</td><td>{$row['sname']}</td><td>{$row['phone']}</td></tr>\n";
}
echo "</table>";
	}else{
		echo "You have entered an Invalid Student ID";
	}
}
}else if($_GET['ekk'] =='f'){//for faculty
	if($q==""){
		echo "You have not entered anything";
	}else{
		$q = intval($q);
		$u = intval($_SESSION['user']);
		$sql = "select * from course where cid='$q'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	$count = mysqli_num_rows($result);
	if($count==1){
			$sql = "select * from course where cid='$q' and fno = '$u'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	$count = mysqli_num_rows($result);
	if($count==1){
		$sql = "select s.sid,s.sname,s.phone from student as s, learning as l where l.cno='$q' and l.sno = s.sid";
		$result = mysqli_query($conn,$sql);
		echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Student ID</th><th>Student name</th><th>Phone number</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['sid']}</td><td>{$row['sname']}</td><td>{$row['phone']}</td></tr>\n";
}
echo "</table>";
	}else{
		echo "You do not teach this course";
	}
	}else{
		echo "You have entered invalid Course ID";
	}
	}
}

}

if($_GET['role']=='fac'){//for faculty
if($q==""){
$sql = "select * from faculty";
$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Faculty ID</th><th>Faculty name</th><th>Phone number</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['fid']}</td><td>{$row['fname']}</td><td>{$row['phone']}</td></tr>\n";
}
echo "</table>";
}else{
	$q = intval($q);
	$sql = "select * from faculty where fid='$q'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	$count = mysqli_num_rows($result);
	if($count==1){
		$sql = "select * from faculty where fid='$q'";
	$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Faculty ID</th><th>Faculty name</th><th>Phone number</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['fid']}</td><td>{$row['fname']}</td><td>{$row['phone']}</td></tr>\n";
}
echo "</table>";
	}else{
		echo "You have entered an Invalid Faculty ID";
	}
}
}

if($_GET['role']=='cou'){
	if($_GET['ekk'] == 'a'){//for courses
if($q==""){
$sql = "select c.cid,c.cname,c.credits,f.fname from faculty as f, course as c where f.fid=c.fno";
$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th><th>Faculty name</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td><td>{$row['fname']}</td></tr>\n";
}
echo "</table>";
}else{
	$q = intval($q);
	$sql = "select * from course where cid='$q'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
	$count = mysqli_num_rows($result);
	if($count==1){
		$sql = "select c.cid,c.cname,c.credits,f.fname from faculty as f, course as c where f.fid=c.fno and c.cid='$q'";
	$result = mysqli_query($conn,$sql);
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th><th>Faculty name</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
	echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td><td>{$row['fname']}</td></tr>\n";
}
echo "</table>";
	}else{
		echo "You have entered an Invalid Course ID";
	}
}
}else if($_GET['ekk'] == 'f'){
	if($q==""){
		if(isset($_SESSION['user'])){
		$us = intval($_SESSION['user']);
		}
		$sql = "select c.cid,c.cname,c.credits,c.syllabus from course as c where c.fno='$us'";
$result = mysqli_query($conn,$sql);
echo "<div id='mm'>";
echo "<table id='couTable' style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th><th>Syllabus</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td><td><button onclick='show1(this.id);'>Download</button</td></tr>\n";
}
echo "</table>";
echo "</div>";
}else{
	$q = intval($q);
	$sql = "select * from course where cid='$q'";
	$result = mysqli_query($conn, $sql);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
	if($count==1){
		$sql = "select cid,cname,credits from course where cid='$q'";
		$result = mysqli_query($conn,$sql);
		echo "<div id='mm'>";
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td></tr>\n";
}
echo "</table>";
echo "</div>";
	}else{
		echo "You have entered an invalid Course ID";
	}
}
}
else if($_GET['ekk'] == 's'){
	if($q==""){//for student
		if(isset($_SESSION['user'])){
		$us = intval($_SESSION['user']);
		}
		$sql = "select cid,cname,credits,syllabus from course where cid IN(SELECT cno from learning where sno='$us')";
$result = mysqli_query($conn,$sql);
echo "<div id='mm'>";
echo "<table id='couTable' style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th><th>Syllabus</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td><td><button onclick='show1(this.id);'>Download</button</td></tr>\n";
}
echo "</table>";
echo "</div>";
}else{
	$q = intval($q);
	$sql = "select * from course where cid='$q'";
	$result = mysqli_query($conn, $sql);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
	if($count==1){
		$sql = "select cid,cname,credits from course where cid='$q'";
		$result = mysqli_query($conn,$sql);
		echo "<div id='mm'>";
echo "<table style='width:100%;border: 1px solid white;'>";
echo "<tr><th>Course ID</th><th>Course name</th><th>Credits</th></tr>\n";
while($row=mysqli_fetch_assoc($result)){
echo "<tr><td>{$row['cid']}</td><td>{$row['cname']}</td><td>{$row['credits']}</td></tr>\n";
}
echo "</table>";
echo "</div>";
	}else{
		echo "You have entered an invalid Course ID";
	}
}
}
}
?>
</body>
</html>