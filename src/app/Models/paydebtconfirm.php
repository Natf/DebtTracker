<?php
include 'connectToDB.php';
include 'session.php';
if(!array_key_exists('uid',$_SESSION)){
	header('Location: index-old.php');
}
if(!array_key_exists('debt0',$_GET)){ // somehow got to this page with no debts being paid
	header('Location: profile.php?payerror=1');
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
			<div class = "col-md-12">
				<h1>Please confirm payment for the following debts:<h1>
				<h3>You can remove any debts you don't wish to confirm by pressing the X next to them. You can also adjust how much of the debt you'd like to pay off.</h3>
				<table class="table">
			    	<colgroup>
			    		<col span="1" style="width: 5%;">
						<col span="1" style="width: 15%;">
						<col span="1" style="width: 80%;">
					</colgroup>
				    <thead>
				      <tr>
				      	<th>Remove</th>
				        <th>Name</th>
				        <th>Amount to pay off</th>
				      </tr>
				    </thead>
				    <tbody>
				      <?php
				      		for($i = 0; $i < count($_GET); $i++){
				      			$amount =fetchUserSpecificDebts($mysqli, $_SESSION['uid'], $_GET['debt'.$i]);
				      			$details=getNameEmailbyUid($mysqli,$_GET['debt'.$i]);
					    		echo "
					    				<tr id = '".$details[1]."'>
					    					<td class='text-align:center;'><div class = 'btn-default btn btn-sm'>X</div></td>
									        <td>".$details[0]."</td>
									        <td class='amount'>
									        	<div class='input-group input-group-sm' style='max-width:300px;'>
												    <span class='input-group-addon'>£</span>
												    <input type='number' class='form-control amountbox' id='".$details[1]."' step='0.01' value='".($amount/-100)."' max='".($amount/-100)."' min='0'>
												    <span class='input-group-btn'>
												    	<button class='btn btn-secondary' type='button'>Set to max</button>
												    </span>
											    </div>
											</td>
									       "./* <td class = 'hidden'>".$contacts[$i]->uid."</td>*/"
								      	</tr>
					    		";
					    	}
					    ?>
				    </tbody>
				</table>
				<a href="profile.php" class = "btn-danger btn pull-left">Cancel</a>
				<div id="paydebtconfirm" class = "navbar-btn btn-success btn pull-right">Confirm Payment(s)</div>
				<script src="../../assets/js/paydebtconfirm.js"></script>
			</div>
		</div>
	</div>

	<script src="../../assets/js/registercheck.js"></script>
				
	<br><br><br><br>
</body>