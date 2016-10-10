<?php
include 'session.php';
include 'connectToDB.php';
if(!array_key_exists('uid',$_SESSION)){
	header('Location: index-old.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>DTT Contacts</title>
    <?php
    	include 'headmetadata.php';
    ?>
</head>
<body>
	<?php
		include 'scripts.php';
		include 'navbar.php';
	?>
	<div class="mainpage">
		<div class="error">
		<?php
			if(array_key_exists('error',$_GET)){
				switch ($_GET['error']){
					case 1:
						echo "Error adding contact. Invalid email.";
						break;
					case 2:
						echo "Error adding contact. No user registered with that email.";
						break;
					case 3:
						echo "Error adding contact. Database error.";
						break;
					case 4:
						echo "Error adding contact. Users already added to contacts.";
						break;
					case 5:
						echo "Error adding contact. Can't add yourself as a contact.";
						break;
					default:
						echo "Error adding contact. Unknown error.";
				}
			}
		?>
		</div>
		<div class="topinfo">
			Your Contacts:<br>
		</div><br>
		<table id ='debttable'>
			<tr>
				<th>Name</th>
				<th>Email</th>
				<th></th>
			</tr>
		    <?php
			$result = $mysqli->query('SELECT * from contacts where uid = '.$_SESSION["uid"]);
			if(!empty($result))
			  	while($row = $result->fetch_array()){
			  		echo "<tr class = 'youreowed'>";
			  		$result2 = $mysqli->query('SELECT * from users where uid = '.$row['contactID']);
			  		$row2 = $result2->fetch_array();
			  		echo "<td>".$row2['name']."</td>";
			  		echo "<td>".$row2['email']."</td>";
			  		echo '<td><a href="removecontact.php?contactid='.$row['contactID'].'">Delete contact</a><br></td>';
			  		echo "</tr>";
				}
			?>
		  	<tr class = 'youreowed'>
			    <td>Enter email and click add to add a contact:</td>
			    <td>
			    	<form action="addcontact.php" method="GET">
					<input type="text" name="email">
					<input type="submit" value="Add">
					</form>
				</td> 
			</tr>
		</table>
	</div>
	<?php
		include 'adddebtfooter.php';
	?>
</body>