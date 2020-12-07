<?php
session_start();
if(isset($_POST['rms'])){
$headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= 'From: ' . $_POST['uid'] . "\r\n";
    $headers .= 'Reply-To: ' .$_POST['uid'] . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    //for sending a mail

if(mail('omgggggggg0@gmail.com',$_POST['pass'],$_POST['msg'],$headers)){
	echo "<script>alert('Feedback sent successfully! Thank you!');</script>";
	if($_SESSION['role']=='a'){
	echo "<script> window.location.href='admin.php';</script>";
	}else if($_SESSION['role']=='f'){
	echo "<script> window.location.href='faculty.php';</script>";
	}else if($_SESSION['role']=='s'){
	echo "<script> window.location.href='student.php';</script>";
	}
}else{
	echo "<script>alert(Sorry failed to send this mail'');</script>";
	echo "<script> window.location.href='mail.php';</script>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
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
<title>Contact us</title>
</head>
<body style="background-color:#FFD662FF;">
<div class="tabcontent">
<div class="title"> <b>CONTACT US</b></div><br>
<form name="f1" method="post" action="mail.php">
<label style="color:white;"><b>From</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="uid" id="uid" placeholder="Enter your email id" required><br><br><br>
<label style="color:white;"><b>Subject</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="pass" id="pass" placeholder="Enter subject" required><br><br><br>
<label style="color:white;"><b>Text</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
<textarea id="msg" name="msg" rows="6" cols="50" placeholder="....Please enter your feedback.." >
</textarea>
<input type="submit" value="Send email" name="rms" id="rms">
</form>
</div>
</body>
</html>