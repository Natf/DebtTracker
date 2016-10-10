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

			</div>
		</div>
	</div>

	<script src="../../assets/js/registercheck.js"></script>
				
	<br><br><br><br>
</body>