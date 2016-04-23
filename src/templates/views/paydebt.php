<?php
include 'connectToDB.php';
include 'session.php';
if(!array_key_exists('uid',$_SESSION)){
	header('Location: index-old.php');
}
$uids=array();
$amounts=array();
$keys=array_keys($_GET);
for($i=0; $i< count($_GET); $i+=2){
	$uids[$i/2]=getUidbyEmail($mysqli,$_GET[$keys[$i]]);
	$amounts[$i/2]=$_GET[$keys[$i+1]];
}

payDebts($mysqli, $_SESSION['uid'], $uids, $amounts);
header("Location: profile.php");
exit;
?>