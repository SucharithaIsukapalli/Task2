<?php
session_start();
if(!isset($_SESSION['user'])){
	header('location: login.php');
	die();
}//open this page only if user session variable is set
?>
<!DOCTYPE html>
<html>
<?php
include("connection.php");
if (!empty($_POST)){
	if(isset($_POST['log'])){
		$uname=intval($conn -> real_escape_string($_POST['uname']));
		$pass=sha1($conn -> real_escape_string($_POST['pass']));
		$phone=$conn -> real_escape_string($_POST['phone']);
		$name=$conn -> real_escape_string($_POST['name']);
		$role=$conn -> real_escape_string($_POST['role']);
		if($role=='S' or $role=='s'){//to insert a student or faculty record
			$sql3 = "INSERT INTO student (sid,sname,password,phone) VALUES('$uname', '$name', '$pass', '$phone')";
			if ($conn->query($sql3) === TRUE) {
				echo '<script>
						alert("Student registered succesfully!");
					</script>';
			} else {
				$s4 = "Error! ";
				$s5 = $conn->error;
				$s6 = $s4.$s5;
				echo '<script>
					alert("'.$s6.'");
					window.location.href="admin.php";
					</script>';
			}
		}
		if($role=='F' or $role=='f'){
			$sql3 = "INSERT INTO faculty (fid,fname,password,phone) VALUES('$uname', '$name', '$pass', '$phone')";
			if ($conn->query($sql3) === TRUE) {
				echo '<script>
						alert("Faculty registered succesfully!");
					</script>';
			} else {
				$s4 = "Error! ";
				$s5 = $conn->error;
				$s6 = $s4.$s5;
				echo '<script>
					alert("'.$s6.'");
					window.location.href="admin.php";
					</script>';
			}
		}
	}
	
	if(isset($_POST['inc'])){//include a course
		$cid = intval($conn -> real_escape_string($_POST['uid']));
		$uc = intval($conn -> real_escape_string($_POST['uc']));
		$uname = $conn -> real_escape_string($_POST['uname']);
		$target_dir = "C:/data/";
		if(isset($_FILES['syll'])){
			$syll = htmlspecialchars(basename($_FILES["syll"]["name"]));
			$target_file = $target_dir . $syll;
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if (file_exists($target_file)) {
				$uploadOk = 2;
			}
			if($imageFileType != "pdf" ) {
				$uploadOk = 3;
			}
			if($uploadOk == 2){
				echo "<script>alert('File already exists!');</script>";
			}else if($uploadOk == 3){
				echo "<script>alert('Only pdf filetype is accepted!');</script>";
			}else{
				if (move_uploaded_file($_FILES["syll"]["tmp_name"], $target_file)) {
					$sql3 = "INSERT INTO course (cid,cname,credits,syllabus) VALUES('$cid', '$uname', '$uc', '$syll')";
					if ($conn->query($sql3) === TRUE) {
						echo '<script>
							alert("Course registered succesfully!");
						</script>';
					} else {
						$s4 = "Error! ";
						$s5 = $conn->error;
						$s6 = $s4.$s5;
						echo '<script>
							alert("'.$s6.'");
						</script>';
					}
				}else{
					echo "<script>alert('Error uploading file!');</script>";
				}
			}
		}
	}
	
	if(isset($_POST['instc'])){//include student into a course
		$cid=intval($conn -> real_escape_string($_POST['uid']));
		$sid=intval($conn -> real_escape_string($_POST['uname']));
		$sql3 = "INSERT INTO learning (sno,cno) VALUES('$sid', '$cid')";
		if ($conn->query($sql3) === TRUE) {
			echo '<script>
				alert("Student registered into course successfully!");
			</script>';
		} else {
			$s4 = "Error! ";
			$s5 = $conn->error;
			$s6 = $s4.$s5;
			echo '<script>
				alert("'.$s6.'");
			</script>';
		}
	}
	
	if(isset($_POST['inftc'])){//include faculty to a course
		$cide=intval($conn -> real_escape_string($_POST['uid']));
		$fide=intval($conn -> real_escape_string($_POST['uname']));
		$sql3 = "update course set fno = '$fide' where cid='$cide' and fno IS NULL";
		if ($conn -> query($sql3)==TRUE) {
			if($conn -> affected_rows == 1){
				echo '<script>
					alert("Faculty added to this course successfully!");
				</script>';
			}else{
				echo '<script>
					alert("No records updated!");
				</script>';
			}
		} else {
			$s4 = "Error! ";
			$s5 = $conn -> error;
			$s6 = $s4.$s5;
			echo '<script>
				alert("'.$s6.'");
			</script>';
		}
	}
	
	if(isset($_POST['rms'])){//remove a student
		$id = intval($conn -> real_escape_string($_POST['uid']));
		$sql3 = "delete from student where sid='$id'";
		if ($conn -> query($sql3)==TRUE) {
			if($conn -> affected_rows > 0){
				echo '<script>
					alert("Student deleted successfully!");
				</script>';
			}else{
				echo '<script>
					alert("No records updated!");
				</script>';
			}
		}else{
			$s4 = "Error! ";
			$s5 = $conn -> error;
			$s6 = $s4.$s5;
			echo '<script>
				alert("'.$s6.'");
			</script>';
		}
	}
	
	if(isset($_POST['rmf'])){//remove a faculty
		$id = intval($conn -> real_escape_string($_POST['uid']));
		$sql3 = "delete from faculty where fid='$id'";
		if ($conn -> query($sql3)==TRUE) {
			if($conn -> affected_rows > 0){
				echo '<script>
					alert("Faculty deleted successfully!");
				</script>';
			}else{
				echo '<script>
					alert("No records deleted!");
				</script>';
			}
		}else{
			$s4 = "Error! ";
			$s5 = $conn -> error;
			$s6 = $s4.$s5;
			echo '<script>
				alert("'.$s6.'");
			</script>';
		}
	}
	
	if(isset($_POST['rmc'])){//remove a course
		$id = intval($conn -> real_escape_string($_POST['uid']));
		$file_pointer = "C:/data/";
		$sql2 = "select syllabus from course where cid='$id'";
		$result = mysqli_query($conn,$sql2);
		$row=mysqli_fetch_assoc($result);
		$file_pointer = $file_pointer.$row['syllabus'];
		if (!unlink($file_pointer)) {  
			//echo ("$file_pointer cannot be deleted due to an error");  
		}  
		else {  
			//echo ("$file_pointer has been deleted");  
		}
		$sql3 = "delete from course where cid='$id'";
		if ($conn -> query($sql3)==TRUE) {
			if($conn -> affected_rows > 0){
				echo '<script>
					alert("Course deleted successfully!");
				</script>';
			}else{
				echo '<script>
					alert("No records deleted!");
				</script>';
			}
		}else{
			$s4 = "Error! ";
			$s5 = $conn -> error;
			$s6 = $s4.$s5;
			echo '<script>
				alert("'.$s6.'");
			</script>';
		}
	}
	
	if(isset($_POST['SignOut'])){
		unset($_SESSION['user']);
		unset($_SESSION['pass']);
		unset($_SESSION['role']);
		session_destroy();
		setcookie("username", "", time() - 3600);
		echo "<script>window.location.href = 'index.php'</script>";
	}
	
	function getName($n) { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 

	if(isset($_POST['reset'])){
		$us = $_POST['uid'];
		$role = $_POST['r'];
		if($role=='S' or $role=='s'){
			$sql = "select * from student where sid='$us'";
			$result = mysqli_query($conn, $sql);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
			if($count==1){
				$temp = getName(8);
				$temp1 = sha1($temp);
				$sql = "update student set password='$temp1' where sid='$us'";
				if ($conn->query($sql) === TRUE) {
					$s4 = "Password is reset! ".$temp;
						echo '<script>
							alert("'.$s4.'");
						</script>';
				}else{
					$s4 = "Error! ";
						$s5 = $conn->error;
						$s6 = $s4.$s5;
						echo '<script>
							alert("'.$s6.'");
						</script>';
				}
			}else{
				echo "<script>alert('You have entered invalid student id');</script>";
			}
		}else if($role=='F' or $role=='f'){
			$sql = "select * from faculty where fid='$us'";
			$result = mysqli_query($conn, $sql);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
			if($count==1){
				$temp = getName(8);
				$temp1 = sha1($temp);
				$sql = "update faculty set password='$temp1' where fid='$us'";
				if ($conn->query($sql) === TRUE) {
					$s4 = "Password is reset! ".$temp;
						echo '<script>
							alert("'.$s4.'");
						</script>';
				}else{
					$s4 = "Error! ";
						$s5 = $conn->error;
						$s6 = $s4.$s5;
						echo '<script>
							alert("'.$s6.'");
						</script>';
				}
			}else{
				echo "<script>alert('You have entered invalid faculty id');</script>";
			}
		}else{
			echo "<script>alert('You have entered invalid role');</script>";
		}
	}
	
	if(isset($_POST['Contact'])){
		echo "<script> window.location.href='mail.php';</script>";
	}
}
?>
<head>
<title>Admin dashboard </title>
<style>
.tab{
	width: 1180px;  
        overflow: hidden;  
        margin: auto;
        margin: 50px 50px;  
        padding: 30px;  
        background: #00539CFF;  
        border-radius: 40px ;  
        font-family: Verdana;
		color:white;
}
table, th, td {
  border: 1px solid white;
  border-collapse: collapse;
  padding: 15px;
  text-align:center;
}
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  text-decoration: underline;
  padding: 10px 15px;
  transition: 0.3s;
  font-size: 17px;
  color:white;
  margin: auto;
        margin: 10px 10px;
}

.tab button:hover {
  background-color: powderblue;
  color:black;
  font-weight:bolder;
}
.tabcontent {
  display: none;
  border-top: none;
  width: 662px;  
        overflow: hidden;  
        margin: auto;
        margin: 60px 200px;  
        padding: 60px 50px 30px 240px;  
        background: #00539CFF;  
        border-radius: 15px ;  
        font-family: Verdana;
		color:white;
}
.tabcontent1 {
  display: none;
  border-top: none;
  width: 662px;  
        overflow: hidden;  
        margin: auto;
        margin: 60px 260px;  
        padding: 60px 50px 50px 50px;  
        background: #00539CFF;  
        border-radius: 15px ;  
        font-family: Verdana;
		color:white;
}
#uname, #pass, #name, #phone, #role, #uid, #uc, #syll, #r{
	width: 220px;  
    height: 30px;  
    border: none;  
    border-radius: 3px;  
padding-left: 8px; 
}
#log, #inc, #instc, #inftc, #rms, #rmf, #rmc,#reset{
	width: 300px;  
    height: 30px;  
    border: none;  
    border-radius: 17px;  
    color: blue;  
	cursor:pointer;
	margin: 50px 50px;  
	font-weight: bold;
}

</style>
</head>

<body style="background-color:#FFD662FF;">
<div class="tab">
<br>
<span style="font-size:34px;"> <b>ADMIN DASHBOARD</b></span>
<span class="tablinks" style="float: right;"> WELCOME, ROOT! </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
<form method="post" action="admin.php">
<button type="submit" id="SignOut" name="SignOut" class="tablinks" style="float: right;" >SIGN OUT</button><br><br><br><br>
</form>
<form method="post" action="admin.php">
<button type="submit" id="Contact" name="Contact" class="tablinks" style="float: right;" >Contact page</button><br><br><br><br>
</form>
<button class="tablinks" onclick="openForm(event, 'AddStudent')">Add a Student / Faculty</button>
<button class="tablinks" onclick="openForm(event, 'AddCourse')">Add a Course</button>
<button class="tablinks" onclick="openForm(event,'AddStudentToCourse')"> Add student to a Course </button>
<button class="tablinks" onclick="openForm(event,'AddFacultyToCourse')"> Add Faculty to a Course </button>
<button class="tablinks" onclick="openForm(event,'RemoveStudent')"> Remove a student </button>
<button class="tablinks" onclick="openForm(event,'RemoveFaculty')"> Remove a faculty </button>
<button class="tablinks" onclick="openForm(event,'RemoveCourse')"> Remove a course </button>
<button class="tablinks" onclick="openForm(event,'ViewStudents')"> View Students </button>
<button class="tablinks" onclick="openForm(event,'ViewFaculty')"> View Faculty </button>
<button class="tablinks" onclick="openForm(event,'ViewCourses')"> View Courses that have faculty</button>
<button class="tablinks" onclick="openForm(event,'ResetPassword')"> Reset password</button>
</div>
<div id="AddStudent" class="tabcontent">
	<form name="f1" onsubmit="return validation('f1');" method="post" action="admin.php">
    <label style="color:white;"><b>USER ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uname" id="uname" placeholder="Enter your username" required><br><br><br>
<label style="color:white;"><b>PASSWORD</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="password" name="pass" id="pass" placeholder="Type your password" required><br><br><br>
<label style="color:white;"><b>NAME</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="name" id="name" placeholder="Enter your name" required><br><br><br>
<label style="color:white;"><b>PHONE NUMBER</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="phone" id="phone" placeholder="Enter your phone number" required><br><br><br>
<label style="color:white;"><b>ROLE</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="role" id="role" placeholder="Enter S for student or F for faculty" required>
<input type="submit" name="log" id="log" value="Register">
</form>
</div>

<div id="AddCourse" class="tabcontent">
<form name="f2" method="post" action="admin.php" enctype="multipart/form-data">
    <label style="color:white;"><b>Course ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter course ID" required><br><br><br>
<label style="color:white;"><b>Course name</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uname" id="uname" placeholder="Enter course name" required><br><br><br>
<label style="color:white;"><b>Course credits</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uc" id="uc" placeholder="Enter course credits" required><br><br><br>
<label style="color:white;"><b>Upload syllabus</b></label>&nbsp;&nbsp;
<input type="file" name="syll" id="syll" placeholder="Enter course name" required><br>
<input type="submit" value="Include course" name="inc" id="inc">
</form>
</div>

<div id="AddStudentToCourse" class="tabcontent">
<form name="f3" method="post" action="admin.php">
<label style="color:white;"><b>Course ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter course ID" required><br><br><br>
<label style="color:white;"><b>Student ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uname" id="uname" placeholder="Enter student ID" required>
<input type="submit" value="Include student" name="instc" id="instc">
</form>
</div>

<div id="AddFacultyToCourse" class="tabcontent">
<form name="f4" method="post" action="admin.php">
<label style="color:white;"><b>Course ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter course ID" required><br><br><br>
<label style="color:white;"><b>Faculty ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uname" id="uname" placeholder="Enter Faculty ID" required>
<input type="submit" value="Include Faculty" name="inftc" id="inftc">
</form>
</div>

<div id="RemoveStudent" class="tabcontent">
<form name="f5" method="post" action="admin.php">
<label style="color:white;"><b>Student ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter student ID" required>
<input type="submit" value="Remove Student" name="rms" id="rms">
</form>
</div>

<div id="RemoveFaculty" class="tabcontent">
<form name="f6" method="post" action="admin.php">
<label style="color:white;"><b>Faculty ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter faculty ID" required>
<input type="submit" value="Remove Faculty" name="rmf" id="rmf">
</form>
</div>

<div id="RemoveCourse" class="tabcontent">
<form name="f7" method="post" action="admin.php">
<label style="color:white;"><b>Course ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter Course ID" required>
<input type="submit" value="Remove Course" name="rmc" id="rmc">
</form>
</div>

<div id="ViewStudents"  class="tabcontent1">
<form>
<input style="width: 220px;  
    height: 30px;  
    border: none;  
    border-radius: 3px;  
padding-left: 8px; margin-bottom:30px;" type="text" placeholder="Enter Student ID" id="num">&nbsp;&nbsp;&nbsp;

<input type="button" onclick="show('stu','num','res','a')" name="vs" id="vs" style="width: 100px;  
    height: 30px;  
    border: none;  
    border-radius: 17px;  
    color: blue;  
	cursor:pointer;
	font-weight: bold;" Value="Search"><br> 
</form>
<div id="res"> Click on search button without entering anything, to view all the student records<br> For viewing a specific record, enter student ID, then click on search button</div>
</div>

<div id="ViewFaculty"  class="tabcontent1">
<form>
<input style="width: 220px;  
    height: 30px;  
    border: none;  
    border-radius: 3px;  
padding-left: 8px; margin-bottom:30px;" type="text" placeholder="Enter Faculty ID" id="numf">&nbsp;&nbsp;&nbsp;

<input type="button" onclick="show('fac','numf','res1','a')" name="vf" id="vf" style="width: 100px;  
    height: 30px;  
    border: none;  
    border-radius: 17px;  
    color: blue;  
	cursor:pointer;
	font-weight: bold;" Value="Search"><br> 
</form>
<div id="res1"> Click on search button without entering anything, to view all the faculty records<br> For viewing a specific record, enter faculty ID, then click on search button</div>
</div>

<div id="ViewCourses"  class="tabcontent1">
<form>
<input style="width: 220px;  
    height: 30px;  
    border: none;  
    border-radius: 3px;  
padding-left: 8px; margin-bottom:30px;" type="text" placeholder="Enter Course ID" id="numc">&nbsp;&nbsp;&nbsp;

<input type="button" onclick="show('cou','numc','res2','a')" name="vc" id="vc" style="width: 100px;  
    height: 30px;  
    border: none;  
    border-radius: 17px;  
    color: blue;  
	cursor:pointer;
	font-weight: bold;" Value="Search"><br> 
</form>
<div id="res2"> Click on search button without entering anything, to view all the Course records with faculty<br> For viewing a specific record, enter Course ID, then click on search button</div>
</div>

<div id="ResetPassword" class="tabcontent">
<form name="f8" method="post" action="admin.php">
<label style="color:white;"><b>User ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter user ID" required><br><br>
<label style="color:white;"><b>Role</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="r" id="r" placeholder="Enter S for student or F for faculty" required><br>
<input type="submit" value="Reset password" name="reset" id="reset">
</form>
</div>

<script>
function openForm(evt, divName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
tabcontent1 = document.getElementsByClassName("tabcontent1");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  for (i = 0; i < tabcontent1.length; i++) {
    tabcontent1[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(divName).style.display = "block";
  evt.currentTarget.className += " active";
  document.getElementById('num').value = "";
  document.getElementById("res").innerHTML = "Click on search button without entering anything, to view all the student records<br> For viewing a specific record, enter student ID, then click on search button";
  document.getElementById("res1").innerHTML = "Click on search button without entering anything, to view all the faculty records<br> For viewing a specific record, enter faculty ID, then click on search button";
  document.getElementById("res2").innerHTML = "Click on search button without entering anything, to view all the course records with faculty<br> For viewing a specific record, enter course ID, then click on search button";
  
}

function validation(formname){
	var phoneno = /^\d{10}$/;
	var v3=document.forms[formname]["phone"].value;
	var v2=document.forms[formname]['role'].value;
					if(!v3.match(phoneno)){
						window.alert("Enter a valid phone number!");
						return false;
					}else{
					if(!(v2=='S' || v2=='F' ||v2=='s'||v2=='f')){
						window.alert("Enter a valid role!");
						return false;
					}
}
}//validating form inputs

function show(role,num,r,e){
	str =  document.getElementById(num).value;
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(this.readyState == 4 && this.status == 200){
				document.getElementById(r).innerHTML = this.responseText;
			}
		};
		xmlhttp.open("GET","function.php?q="+str+"&role="+role+"&ekk="+e,true);
		xmlhttp.send();
	}
</script>
</body>
</html>