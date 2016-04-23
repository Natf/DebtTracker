<?php
include 'connectToDB.php';
include 'session.php';
if(array_key_exists('uid',$_SESSION)){
	header('Location: profile.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Debt Tracker</title>
    <?php
    	include 'scripts.php';
    	include 'headmetadata.php';
    ?>
</head>
<body>
	
	<?php
		include 'navbar.php';
	?>
	
	<div class = "container">
		<div class = "row">
			<div class = "col-md-6">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="5000" data-pause="hover">
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>
					<div class="carousel-inner">
						<div class="item active">
							<img src="../../../resources/images/homepageimage1.png" alt="Your own personal debt tracking tool">
						</div>
						<div class="item">
							<img src="../../../resources/images/homepageimage2.png" alt="Get detailed information at a glance">
						</div>
						<div class="item">
							<img src="../../../resources/images/homepageimage3.png" alt="Easily create debts">
						</div>
					</div>
				</div>
			</div>

			<div class = "col-md-6">
				<h2>Register Now</h2>
				<div class="error">
					<?php
						if(array_key_exists('registration',$_GET)){
							switch ($_GET['registration']){
								case 1:
									echo "<font color='green'>Registration successful. You may now Login.</font>";
								break;
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
								case 6:
									echo "There was a problem registering. Emails don't match. <br>";
									break;
								case 7:
									echo "There was a problem registering. Passwords don't match. <br>";
									break;
								default:
					        		echo "There was a problem registering. Unknown error. <br>";
							}
						}
					?>
				</div>
				<form action="registersubmit.php" method="POST">
					<fieldset class="form-group">
						<label for="exampleInputEmail1">Your Name</label>
						<input type="text" class="form-control" name="name" placeholder="Enter Name">
						<small class="text-muted">The name other people who've added you will see.</small>
					</fieldset>
					<fieldset class="form-group">
						<label for="exampleInputEmail1">Email address</label>
						<input type="email" class="form-control" name="email" placeholder="Enter email">
					</fieldset>
					<fieldset class="form-group">
						<input type="email" class="form-control" name="emailconfirmed" placeholder="Confirm email">
						<small class="text-muted">We'll never share your email with anyone else.</small>
					</fieldset>
					<fieldset class="form-group">
						<label for="exampleInputEmail1">Password</label>
						<input type="password" class="form-control" name="password" placeholder="Enter password">
					</fieldset>
					<fieldset class="form-group">
						<input type="password" class="form-control" name="passwordconfirmed" placeholder="Confirm password">
						<small class="text-muted">Password must be at least 6 characters and contain at least 1 capital and 1 lower case letter.</small>
					</fieldset>
					<button id="registerbutton" type="submit" class="btn btn-primary">Register</button>
				</form>
			</div>
		</div>
	</div>

	<script src="../../assets/js/registercheck.js"></script>
				
	<br><br><br><br>
</body>