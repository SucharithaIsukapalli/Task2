<?php
session_start();
include("connection.php");
if($_GET['cond']=='fac'){
$var = $_SESSION['user'];
$i =0;//for downloading the syllabus into your current folder
$sql = "select syllabus from course where fno = '$var'";
$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result)){
	$i = $i+1;
	if($i == intval($_GET['q'])){
		$temp = $row['syllabus'];
	}
}
$i=0;
$url = 'C:/data/'.$temp; 
   
$file_name = basename($url); 
if(file_put_contents( $file_name,file_get_contents($url))) { 
    echo $temp." is downloaded successfully onto your folder"; 
} 
else { 
    echo $temp." downloading failed"; 
} 
}else if($_GET['cond']=='stu'){
$var = $_SESSION['user'];
$i =0;
	$sql = "select syllabus from course where cid IN(SELECT cno from learning where sno='$var')";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$i = $i+1;
	if($i == intval($_GET['q'])){
		$temp = $row['syllabus'];
	}
}
$i=0;
$url = 'C:/data/'.$temp;
$file_name = basename($url); 
if(file_put_contents( $file_name,file_get_contents($url))) { 
    echo $temp." is downloaded successfully onto your folder"; 
} 
else { 
    echo $temp." downloading failed"; 
}
}
?>