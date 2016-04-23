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
    <meta charset="utf-8">
    <title>DTT Your Debts</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
	<?php
		include 'navbar.php';
	?>
	<br>
	<form action="adddebtpage.php" class="radiowrapper">
	<?php
			$contacts=fetchContacts($mysqli,$_SESSION['uid']);
			echo "Select Contacts you would like to create debts for:<br>";
			for($count=0; $count < count($contacts); $count++){
				echo "<input type='checkbox' name='contact".$count."' value='".$contacts[$count][0]."' id='contactno".$count."'>";
				echo "<label for='contactno".$count."'>".$contacts[$count][1]."</label><br>";
			}
	?>
		<input type="submit" id="submitbutton">
		<label for="submitbutton">Submit</label>
	</form>
</body>