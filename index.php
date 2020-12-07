<!DOCTYPE html>
<html>
<?php
	if(isset($_POST['myBtn'])){
	echo "<script> window.location.href='login.php';</script>";
	}//to direct it to login page
?>
<head>
<title> Student management system </title>
<style>
 *{
  box-sizing: border-box;
	margin:0;
	padding:0;
}

body {
  margin: 0;
  font-family: Arial;
  font-size: 17px;
}

#myVideo {
  position: fixed;
  right: 0;
  margin:0;
  bottom: 0;
  object-fit:cover;
  width: 100vw; 
  height: 100vh;
}

.content {
  position: fixed;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  color: #f1f1f1;
  width: 100%;
  padding: 20px;
}

#myBtn {
  width: 200px;
  font-size: 18px;
  padding: 10px;
  border: none;
  background: #000;
  color: #fff;
  cursor: pointer;
}

#myBtn:hover {
  background: #ddd;
  color: black;
}
</style>
</head>
<body>

<video autoplay muted loop id="myVideo"><!--to play the video-->
  <source src="video.mp4" type="video/mp4">
  Your browser does not support HTML5 video.
</video>


<div class="content">
<form method="post" action="index.php">
  <h3>Welcome to the project student management system</h3><br><br>
  <button type="submit" id="myBtn" name='myBtn'>Click here to login</button>
	</form>
</div>
</body>
</html>