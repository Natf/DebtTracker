<?php
include 'connectToDB.php';
include 'session.php';

$email = $_GET['email'];

// verify email is an email
if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
	header('Location: contacts.php?error=1');
	exit;
}

// get the contacts uid from the email
if($stmt = $mysqli->prepare('SELECT * from users where email = ?')){
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = (array)$res->fetch_assoc();
	if(empty($row)){ // email not found
		header('Location: contacts.php?error=2');
		exit;
	}
	else if($row['uid'] == $_SESSION['uid']){// make sure user isn'trying to add self
		header('Location: contacts.php?error=5');
		exit;
	}
	else
		$uid = $row['uid']; // the contacts uid
}

// verify user hasnt been added before
if($stmt = $mysqli->prepare('SELECT * from contacts where uid = ? and contactid = ?')){
	$stmt->bind_param('ss',$_SESSION['uid'], $uid);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = (array)$res->fetch_assoc();
	if(!empty($row)){ // if array isn't empty then user has been added
		header('Location: contacts.php?error=4');
		exit;
	}
}

if($stmt = $mysqli->prepare('INSERT INTO contacts VALUES (?, ?, NULL)')){
	$stmt->bind_param('ii',$_SESSION['uid'], $uid);
	$stmt->execute();
	header('Location: contacts.php');
}
else
	header('Location: contacts.php?error=3');
?>