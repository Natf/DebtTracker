<?php
$mysqli = new mysqli("localhost", "root", "", "my_db");

//var_dump($mysqli); die;

function getDateToday(){
	$date = getdate();
	$timestamp = strtotime((string)($date['year'].'-'.$date['mon'].'-'.$date['mday']));
	$dt = date("Y-m-d", $timestamp);
	return $dt;
}

function fetchContacts($mysqli, $UID){ // fetch's all of '$uid's contacts
	$contacts = array();
	$count=0;
	$result = $mysqli->query('SELECT * from contacts INNER JOIN users ON users.uid = contacts.contactID WHERE contacts.uid = '.$UID);
		if(!empty($result))
			while($row = $result->fetch_array()){
				$contacts[$count][0]=$row['uid'];
				$contacts[$count][1]=$row['name'];
				$count++;
			}
	return $contacts;		
}
function addGroupDebt($mysqli,$UID, $amount, $group){ // splits a debt of 'amount' evenly between 'group' //TODO probably not going to be used and is not properly set up
	$amount=$amount/count($group);
	for($count=0; $count < count($group); $count++)
		if(addDebt($mysqli,$UID, $amount,$group[$count]) == -1)
			return 0;

	return 1;
}
function addDebt($mysqli,$UID, $amount, $description, $owerID){ // adds a debt to the database 
	// first there exists a scenario where person A owes person B money. However person B may now be creating a debt where they owe money to A. the smartest thing to do would be to take away that amount from the current debt.
	// using this we can basically make sure at any single point a person can only either owe another person or be owed to them. not both.
	$originalamount=$amount;
	$amounttest=fetchUserSpecificDebts($mysqli,$UID,$owerID);
	if($amounttest < 0){ //we owe them money so we need to subtract this from the debt
		$amount=tryToPay($mysqli, $UID,$owerID, $amount);
		if($amount>0)//we still have debt left
			addDebtDirectOriginal($mysqli,$UID, $amount, $description, $owerID,0,$originalamount);
		else // it is not enough to just pay off debts, we should also add the debt as if it were paid, for historical reasons
			addDebtDirectOriginal($mysqli,$UID, $amount, $description, $owerID,1,$originalamount);
	}
	else // uid doesn't owe them money so can just add extra debt
		addDebtDirect($mysqli,$UID, $amount, $description, $owerID,0); 
}

function payDebts($mysqli, $user, $uids, $amounts){ // pays amount to each $uid trying to pay of all debts
	for($i=0; $i < count($uids); $i++)
		tryToPay($mysqli,$user,$uids[$i],$amounts[$i]*100);
}

function tryToPay($mysqli, $user, $uid, $amount){ // trys to pay off amount for user to uid
	// the most logical way to do this is to try and eliminate smallest debts first so as to reduce the number of debts as much as possible.
		// if we can't fully eliminate a debt then we need to edit it. However it would be useful to show that the debt has been edited and why.
		// we can also have an opposite scenario where we eliminate all current debts and still have a remainder, we should do the same where we create the debt but show that it has been edited.
		//first fetch all debts uid owes them
	if($stmt = $mysqli->prepare("SELECT amount, debtid from debts where debtower=? and paid=0 and debtuowed=? ORDER BY amount ASC")){
		$stmt->bind_param("ii",$user,$uid);
		$stmt->execute();
		$stmt->bind_result($amounts,$debtid);
		$stmt->store_result();
		while($stmt->fetch()){
			if($amount>0){
				if($amount>=$amounts){ // we can fully pay off this debt
					$mysqli->query("UPDATE debts SET paid=1, datePaid='".getDateToday()."' WHERE debtid=".$debtid);
					$amount-=$amounts;
				}
				else{ // we need to update the debt and subtract the amount left
					$mysqli->query("UPDATE debts SET amount=".($amounts-$amount)." WHERE debtid=".$debtid);
					$amount-=$amounts;
					break;
				}
			}
		}
		return $amount;
	}
}

function addDebtDirect($mysqli,$UID, $amount, $description, $owerID, $paid){ // adds debt straight to database without trying to simplify existing debts. only for use internally
	if($stmt = $mysqli->prepare("INSERT INTO debts (`debtid`, `debtuowed`, `debtower`, `amount`, `description`, `paid`, `dateCreated`, `datePaid`, `originalamount`) VALUES (NULL, ?, ?, ?, ?, ?, ?, '', ?);")){
		$stmt->bind_param('iiisisi',$UID, $owerID, $amount,$description,$paid,getDateToday(),$amount);
		$stmt->execute();
		return 1;
	}
	else
		return 0;
}
function addDebtDirectOriginal($mysqli,$UID, $amount, $description, $owerID, $paid,$originalamount){ // adds debt straight to database without trying to simplify existing debts. only for use internally. Also has an original amount argument
	if($stmt = $mysqli->prepare("INSERT INTO debts (`debtid`, `debtuowed`, `debtower`, `amount`, `description`, `paid`, `dateCreated`, `datePaid`, `originalamount`) VALUES (NULL, ?, ?, ?, ?, ?, ?, '', ?);")){
		$stmt->bind_param('iiisisi',$UID, $owerID, $amount,$description,$paid,getDateToday(),$originalamount);
		$stmt->execute();
		return 1;
	}
	else
		return 0;
}

function getUidbyEmail($mysqli,$email){ // returns uid of user with email if found else returns -1
	if($stmt = $mysqli->prepare("SELECT uid from users where email =?")){
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->bind_result($uid);
		$stmt->fetch();
		return $uid;
	}
	else
		return -1;
}

function getNameEmailbyUid($mysqli,$uid){ // returns and array containing the name and email of user with uid. returns -1 is not found/error
	if($stmt = $mysqli->prepare("SELECT name, email from users where uid =?")){
		$stmt->bind_param("s",$uid);
		$stmt->execute();
		$stmt->bind_result($name,$email);
		$stmt->fetch();
		return array($name,$email);
	}
	else
		return -1;
}

function fetchUserSpecificDebts($mysqli, $user1, $user2){ // will fetch all debts associated between $user1 and $user2. returns a single value being positive when user 2 owes user 1 and negative when user1 owes user2
	if($stmt = $mysqli->prepare("SELECT amount from debts where debtuowed=? and paid=0 and debtower=?")){
		$total=0;
		$stmt->bind_param("ii",$user1,$user2);
		$stmt->execute();
		$stmt->bind_result($amounts);

		while($stmt->fetch())
			$total+=$amounts;

		if($stmt = $mysqli->prepare("SELECT amount from debts where debtower=? and paid=0 and debtuowed=?")){
			$stmt->bind_param("ii",$user1,$user2);
			$stmt->execute();
			$stmt->bind_result($amounts);

			while($stmt->fetch())
				$total-=$amounts;

			return $total;
		}
		else // db error
			return 0;
	}
	else // db error
		return 0;
}

function fetchDebts($mysqli, $UID){ // fetchs all debts NOT PAID associated with $UID
	$allDebts = array();
	$result = $mysqli->query('SELECT * from debts INNER JOIN users ON CASE WHEN debts.debtower='.$UID.' THEN debts.debtuowed = users.uid WHEN debts.debtuowed='.$UID.' THEN debts.debtower = users.uid END WHERE debts.paid = 0 ORDER BY name');
	if(!empty($result)){
		$count=0;
		while($row = $result->fetch_array()){
			$allDebts[$count] = $row;
			$count++;
		}
		return $allDebts;
	}
	else
		return 0; //database error
}
function fetchDebtsOwed($mysqli, $UID){ //fetches all debts uid owes
	$allDebts = array();
	$result = $mysqli->query('SELECT * from debts INNER JOIN users ON debts.debtuowed=users.uid WHERE debts.paid = 0 AND debts.debtower='.$UID.' ORDER BY name');
	if(!empty($result)){
		$count=0;
		while($row = $result->fetch_array()){
			$allDebts[$count] = $row;
			$count++;
		}
		return $allDebts;
	}
	else
		return 0; //database error
}
function fetchDebtsOwedTo($mysqli, $UID){ //fetches all debts owed to uid
	$allDebts = array();
	$result = $mysqli->query('SELECT * from debts INNER JOIN users ON debts.debtower=users.uid WHERE debts.paid = 0 AND debts.debtuowed='.$UID.' ORDER BY name');
	if(!empty($result)){
		$count=0;
		while($row = $result->fetch_array()){
			$allDebts[$count] = $row;
			$count++;
		}
		return $allDebts;
	}
	else
		return 0; //database error
}
function getContacts($mysqli, $UID){ // returns an associative array containing all contacts
	$contacts = array();
	$result = $mysqli->query('SELECT * FROM contacts INNER JOIN users ON contacts.contactID = users.uid WHERE contacts.uid="'.$UID.'"');
	for($i=0;$row = $result->fetch_array();$i++)
		$contacts[$i] = (object) array('name' => $row['name'], 'email' => $row['email'], 'uid' => $row['contactID']);
	return $contacts;
}

function compressDebts($debts){ // will compress all debts so only the total debt for each user is returned
	$compressedDebts = array();
	$lastUID="";
	$count=-1; // start index at -1 as index will always be incremented on first loop
	for($i = 0; $i < count($debts); $i++){
		if($lastUID == $debts[$i]['uid'])
			$compressedDebts[$count]['amount']+=$debts[$i]['amount'];
		else{
			$count++;
			$lastUID = $debts[$i]['uid'];
			$compressedDebts[$count]['amount']=$debts[$i]['amount'];
			$compressedDebts[$count]['email']=$debts[$i]['email'];
			$compressedDebts[$count]['uid']=$debts[$i]['uid'];
			$compressedDebts[$count]['name']=$debts[$i]['name'];
		}
	}
	return $compressedDebts;
}

function compressAllDebts($debtsowed,$debtslent){ // returns an array of debt total, total owed, number owed to, total owed to u, total number of people owed to you
	$compressedDebts = array(
						"total" => 0,
						"totalowed" => 0,
						"totalowedc" => 0,
						"totalowed2u" => 0,
						"totalowed2uc" => 0,
						);
	$lastUID="";
	$count=-1; // start index at -1 as index will always be incremented on first loop
	for($i = 0; $i < count($debtsowed); $i++){
		if($lastUID == $debtsowed[$i]['uid']){
			$compressedDebts['total']-=$debtsowed[$i]['amount'];
			$compressedDebts['totalowed']+=$debtsowed[$i]['amount'];
		}
		else{
			$count++;
			$lastUID = $debtsowed[$i]['uid'];
			$compressedDebts['total']-=$debtsowed[$i]['amount'];
			$compressedDebts['totalowed']+=$debtsowed[$i]['amount'];
			$compressedDebts['totalowedc']++;
		}
	}

	$lastUID="";
	$count=-1; // start index at -1 as index will always be incremented on first loop
	for($i = 0; $i < count($debtslent); $i++){
		if($lastUID == $debtslent[$i]['uid']){
			$compressedDebts['total']+=$debtslent[$i]['amount'];
			$compressedDebts['totalowed2u']+=$debtslent[$i]['amount'];
		}
		else{
			$count++;
			$lastUID = $debtslent[$i]['uid'];
			$compressedDebts['total']+=$debtslent[$i]['amount'];
			$compressedDebts['totalowed2u']+=$debtslent[$i]['amount'];
			$compressedDebts['totalowed2uc']++;
		}
	}

	return $compressedDebts;
}
//makeMoney();
//$mysqli->select_db("my_db");
//$mysqli->select_db("mydb"); // for real site
?>