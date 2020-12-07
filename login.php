<!DOCTYPE html>
<?php
session_start();
include("connection.php");
if (!empty($_POST)){//checking if post is not empty
	if(isset($_POST['rms'])){//for login
		$user = $conn -> real_escape_string($_POST['uid']);//escaping input before searching the database
		$pa = sha1($conn -> real_escape_string($_POST['pass']));//password is stored in hashed format in the database
		$role = $_POST['role'];
		if($role=="0"){//for admin 
			if($user=="root" and $pa==sha1("root")){
				$_SESSION["user"] = "root";//setting the session variable
				$_SESSION["pass"] = "root";
				$_SESSION["role"] = "a";
				if(isset($_POST['cook'])){
				setcookie('username', 'root', time() + (86400 * 30));
				}
				echo "<script> window.location.href='admin.php';</script>";
			}else{
				echo "<script> alert('Invalid user id or password');</script>";
			}
		}else if($role=="1"){//for faculty
			$sql1 = "select * from faculty where fid='$user' and password='$pa'";
			$result = mysqli_query($conn, $sql1);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
			if($count==1){
				$_SESSION["user"] = $user;
				$_SESSION["pass"] = $pa;
				$_SESSION["role"] = "f";
				if(isset($_POST['cook'])){
				setcookie('username', $user, time() + (86400 * 30));
				}
				echo "<script> window.location.href='faculty.php';</script>";
			}else{
				echo "<script> alert('Invalid user id or password');</script>";
			}
		}else if($role=="2"){//for student
			$sql1 = "select * from student where sid='$user' and password='$pa'";
			$result = mysqli_query($conn, $sql1);  
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
			$count = mysqli_num_rows($result); 
			if($count==1){
				$_SESSION["user"] = $user;
				$_SESSION["pass"] = $pa;
				$_SESSION["role"] = "s";
				if(isset($_POST['cook'])){
				setcookie('username', $user, time() + (86400 * 30));
				}
				echo "<script> window.location.href='student.php';</script>";
			}else{
				echo "<script> alert('Invalid user id or password');</script>";
			}
		}else{
			echo "<script> alert('Invalid user id or password');</script>";
		}
	}
}
?>
<html>
<head>
<title> Login form </title>
<style>
.tabcontent {
  border-top: none;
  width: 662px;  
        overflow: hidden;  
        margin: auto;
        margin: 65px 200px;  
        padding: 60px 50px 30px 240px;  
        background: #00539CFF;  
        border-radius: 15px ;  
        font-family: Verdana;
		color:white;
}
 #pass,  #role, #uid{
	width: 220px;  
    height: 30px;  
    border: none;  
    border-radius: 3px;  
padding-left: 8px; 
}
 #rms{
	width: 300px;  
    height: 30px;  
    border: none;  
    border-radius: 17px;  
    color: blue;  
	cursor:pointer;
	margin: 50px 50px;  
	font-weight: bold;
}
.title{
  border-top: none;
  width: 662px;  
  overflow: hidden;  
font-size:28px;
padding: 30px 30px 30px 0px; 
}
</style>
</head>
<body style="background-color:#FFD662FF;">
<div class="tabcontent">
<div class="title"> <b>LOGIN PAGE</b></div><br>
<form name="f1" method="post" action="login.php">
<label style="color:white;"><b>USER ID</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter user ID"  value="<?php
if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" required><br><br><br>
<label style="color:white;"><b>PASSWORD</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="password" name="pass" id="pass" placeholder="Type your password" required><br><br><br>
<label style="color:white;"><b>LOGIN AS</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" id="adm" name="role" value="0" required>
<label for="adm"> ADMIN</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" id="fac" name="role" value="1">
<label for="fac"> FACULTY</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" id="stu" name="role" value="2">
<label for="stu"> STUDENT</label><br><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="cook" name="cook" value="1">
<label for="cook"> Remember me</label><br>
<input type="submit" value="Login" name="rms" id="rms">
</form>
</div>
</body>
</html>