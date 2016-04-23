<?php
include 'connectToDB.php';
include 'session.php';
if(!array_key_exists('uid',$_SESSION)){
	header('Location: index-old.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>DTT Profile</title>
    <?php
    	include 'scripts.php';
    	include 'headmetadata.php';
    ?>
</head>
<body>
	<?php
		include 'navbar.php';
?>
	<div class = "debtcontainer">
		<?php
			include "debtcreator.php";
		?>
	</div>
	<br><br><br><br><br><br>
	<div class = "navbar navbar-default navbar-fixed-bottom">
		<div class="buttons">
		    <div id="debtnext" class = "navbar-btn btn-success btn pull-right">Next ></div>
		    <div id="debtprevious" class = "navbar-btn btn-danger btn pull-right hidden">< Go Back</div>
		</div>
	</div>
	<script src = "../../assets/js/debtcreator.js"></script>
</body>