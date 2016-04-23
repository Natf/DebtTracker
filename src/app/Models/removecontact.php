<?php
include 'connectToDB.php';
include 'session.php';

$uid = $_GET['contactid'];
if($stmt = $mysqli->prepare('DELETE from contacts where contactID = ? and uid = ?')){
	$stmt->bind_param('ss', $uid,$_SESSION['uid']);
	$stmt->execute();
	header('Location: contacts.php');
	exit;
}
?>