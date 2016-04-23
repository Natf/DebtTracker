<div id="debtcreator" class=
	<?php
		require_once 'mobileDetect/Mobile_Detect.php';
		$detect = new Mobile_Detect;
		if ( $detect->isMobile() ) 
		 	echo '"touch"';
		else
			echo '"no-touch"';
	?>
>
    <div id="container">
    	<table id="steps">
    		<tr>
    			<td id="step1" class="currentstep"><h3>Select Contact(s)</h3></td>
    			<td id="step2" class="uncompletedstep"><h3>Debt Amount(s)</h3></td> 
    			<td id="step3" class="uncompletedstep"><h3>Add Description(s)</h3></td>
    		</tr>
    	</table>
    	<div id="stepcontacts" class="stepactive">
			<p>Click a contact to select or deselect them. Selected contacts will be highlighted. You can create debts for multiple people at once by selecting more than one contact.</p>
			<p id = "error1" class="error hidden">Please select at least one contact.</p>
			<table class="table">
				<colgroup>
					<col span="1" style="width: 30%;">
					<col span="1" style="width: 50%;">
					<col span="1" style="width: 20%;">
				</colgroup>
			    <thead>
			      <tr>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Selected</th>
			      </tr>
			    </thead>
			    <tbody>
				    <?php
				    	$contacts = getContacts($mysqli, $_SESSION['uid']);
				    	for($i = 0; $i < count($contacts); $i++){
				    		echo "
				    				<tr class = 'contact'>
								        <td>".$contacts[$i]->name."</td>
								        <td class='email'>".$contacts[$i]->email."</td>
								        <td class='plus' style='text-align:center;'>+</td>
								       "./* <td class = 'hidden'>".$contacts[$i]->uid."</td>*/"
							      	</tr>
				    		";
				    	}
				    ?>
				</tbody>
			</table>
    	</div>
    	<div id="stepamounts" class="stephidden">
			<p>Insert the amount each contact owes you. You can insert a negative value if you owe the contact money.</p>
			<p id = "error2" class="error hidden">Please enter a non zero numerical value for each contact.</p>
            <table class="table">
            	<colgroup>
					<col span="1" style="width: 30%;">
					<col span="1" style="width: 45%;">
					<col span="1" style="width: 25%;">
				</colgroup>
			    <thead>
			      <tr>
			        <th>Name</th>
			        <th>Email</th>
			        <th>Amount</th>
			      </tr>
			    </thead>
			    <tbody>
			      <?php
				    	$contacts = getContacts($mysqli, $_SESSION['uid']);
				    	for($i = 0; $i < count($contacts); $i++){
				    		echo "
				    				<tr id = '".$contacts[$i]->email."' class='hidden'>
								        <td>".$contacts[$i]->name."</td>
								        <td>".$contacts[$i]->email."</td>
								        <td class='amount'>
								        	<div class='input-group'>
											    <span class='input-group-addon'>£</span>
											    <input type='number' class='form-control amountbox' id='amount".$contacts[$i]->email."' step='0.01' placeholder='0.00' >
										    </div>
										</td>
								       "./* <td class = 'hidden'>".$contacts[$i]->uid."</td>*/"
							      	</tr>
				    		";
				    	}
				    ?>
			    </tbody>
			</table>
    	</div>
    	<div id="stepdescription" class="stephidden">
			<p>Add a description for each debt. Or don't.</p>
            <table class="table">
            	<colgroup>
					<col span="1" style="width: 30%;">
					<col span="1" style="width: 70%;">
				</colgroup>
			    <thead>
			      <tr>
			        <th>Name</th>
			        <th>Description</th>
			      </tr>
			    </thead>
			    <tbody>
			      <?php
				    	$contacts = getContacts($mysqli, $_SESSION['uid']);
				    	for($i = 0; $i < count($contacts); $i++){
				    		echo "
				    				<tr id = 'description".$contacts[$i]->email."' class='hidden'>
								        <td>".$contacts[$i]->name."</td>
								        <td class='description'>
								        	<textarea name='desc".$contacts[$i]->email."' id='desc".$contacts[$i]->email."' class='descbox form-control' rows='2' placeholder='Enter a description'></textarea>
										</td>
								       "./* <td class = 'hidden'>".$contacts[$i]->uid."</td>*/"
							      	</tr>
				    		";
				    	}
				    ?>
			    </tbody>
			</table>
    	</div>
    </div>
</div>