<?php
include 'connectToDB.php';
include 'session.php';

$email = $_POST['email'];
$password = $_POST['password'];

// verify email is an email and not taken
if(filter_var($email, FILTER_VALIDATE_EMAIL) == false)
	header('Location: index-old.php?loginerror=1');

if($stmt = $mysqli->prepare('SELECT * from users where email = ?')){
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = (array)$res->fetch_assoc();
	if(empty($row))
		header('Location: index-old.php?loginerror=2');
	else{
		$uid = $row['uid'];
		$name = $row['name'];
		$hash = $row['hash'];
	}
}

if(password_verify($password ,$hash )){
	$_SESSION['uid'] = $uid;
	$_SESSION['name'] = $name;
	header('Location: profile.php');
}
else
	header('Location: index-old.php?loginerror=2');
?>