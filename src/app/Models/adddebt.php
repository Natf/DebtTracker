<?php
include 'session.php';
include 'connectToDB.php';
if(!array_key_exists('uid',$_SESSION)){
	header('Location: index-old.php');
}
$uid = $_POST['uid'];
if(empty($uid)){ // no contact selected
	header('Location: profile.php?debterror=1');
	exit;
}

$amount = $_POST['amount'];
if(empty($amount)){ // no amount entered
	header('Location: profile.php?debterror=4');
	exit;
}

$description = $_POST['description'];

str_replace ('£', '', $amount);
$amount = (int)((float)$amount*100);

if($amount <= 0){ // amount is less that 0
	header('Location: profile.php?debterror=4');
	exit;
}

if($stmt = $mysqli->prepare('SELECT * from contacts where uid = ? and contactID = ?')){
	$stmt->bind_param('ii', $_SESSION['uid'],$uid);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = (array)$res->fetch_assoc();

	if(!empty($row)){ // check ontact exists TODO
		if(addDebt($mysqli,$_SESSION['uid'],$amount,$uid))
			header('Location: profile.php');
		else
			header('Location: profile.php?error=3'); // database error*/
	}
	else // user not added to contacts
		header('Location: profile.php?debterror=2');
}
?>