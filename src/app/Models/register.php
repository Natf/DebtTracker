<?php
include 'session.php';
if(array_key_exists('uid',$_SESSION)){
	header('Location: profile.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Debt Tennis Tracker Registration</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
	<div class="loginreg">
		<div class="error">
			<?php
				if(array_key_exists('registration',$_GET)){
					switch ($_GET['registration']){
						case 2:
							echo "There was a problem registering. Database error. <br>";
							break;
						case 3:
							echo "There was a problem registering. Invalid email. <br>";
							break;
						case 4:
							echo "There was a problem registering. Email already taken. <br>";
							break;
						case 5:
							echo "There was a problem registering. Password must be longer than 6 characters. <br>";
							break;
						default:
			        		echo "There was a problem registering. Unknown error. <br>";
					}
				}
			?>
		</div>
		<form action="registersubmit.php" method="POST">
		Name:<input type="text" name="name">
		<br>
		Email:<input type="text" name="email">
		<br>
		Password:<input type="password" name="password">
		<br>
		<input type="submit" value="Register">
		</form>
		<br><a href="index-old.php">Click here to login instead.</a>
	</div>
</body>