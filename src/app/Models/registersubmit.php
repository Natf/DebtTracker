<?php
include 'connectToDB.php';


$name = $_POST['name'];
$email = $_POST['email'];
$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

// verify email is an email and not taken
if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
	header('Location: index-old.php?registration=3');
	return;
}

if(strcmp($_POST['email'],$_POST['emailconfirmed'])!=0){ // emails dont match
	header('Location: index-old.php?registration=6');
	return;
}

if(strcmp($_POST['password'],$_POST['passwordconfirmed'])!=0){ // passwords dont match
	header('Location: index-old.php?registration=7');
	return;
}

if($stmt = $mysqli->prepare('SELECT uid from users where email = ?')){ // check if email is taken
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$res = $stmt->get_result();
	$row = (array)$res->fetch_assoc();
	if(!empty($row)){
		header('Location: index-old.php?registration=4');
		return;
	}
}

// Check password is at least 6 characters
if(strlen($_POST['password']) < 6){
	header('Location: index-old.php?registration=5');
	return;
}


if($stmt = $mysqli->prepare('INSERT INTO users VALUES (?, ?, ?,"NULL")')){ // create user finally
	$stmt->bind_param('scss',$name, $email, $hash);
	$stmt->execute();
	header('Location: index-old.php?registration=1');
}
else{
	header('Location: index-old.php?registration=2');
	return;
}
?>