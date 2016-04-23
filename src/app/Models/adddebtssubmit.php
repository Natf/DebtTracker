<?php
	include 'session.php';
	include 'connectToDB.php';
	if(!array_key_exists('uid',$_SESSION)){
		header('Location: index-old.php');
	}
	$postkeys=array_keys($_POST);
	for($i=0; $i < (count($_POST)/3); $i++){
		$amount=$_POST[$postkeys[($i*3)+1]]*100;
		$desc=$_POST[$postkeys[($i*3)+2]];
		$theiruid=getUidbyEmail($mysqli,$_POST[$postkeys[$i*3]]);

		if(($amount!=0) &&($theiruid!=-1)){ // double check amount is valid and email has not returned an invalid uid
			if($amount > 0)
				addDebt($mysqli,$_SESSION['uid'], $amount, $desc, $theiruid);
			else
				addDebt($mysqli,$theiruid, $amount*-1, $desc, $_SESSION['uid']);
		}
		else
			header('Location: profile.php?error=0001');
	}

	header('Location: profile.php');
?>