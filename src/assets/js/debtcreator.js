document.getElementById('debtnext').onclick=function(){
	var x = document.getElementsByClassName('stepactive');
	// todo switch case
	switch(x[0].id){
		case "stepcontacts": // we're on contacts step
			var contacts = document.getElementsByClassName('selected');

			//first clear all amounts being shown in 2nd step
			var amounts = document.getElementsByClassName('amountshown');
			for(var count = amounts.length; count >0; count--)
				amounts[0].className="hidden";

			//then clear all descriptions being shown in 3rd step
			var descs = document.getElementsByClassName('descshown');
			for(var count = descs.length; count >0; count--)
				descs[0].className="hidden";

			// only continue if we've selected contacts
			if(contacts.length>0){
				// update the next steps so that only contacts selected are shown
				for(var i=0; i< contacts.length; i++){
					for (var x = 0; x < contacts[i].childNodes.length; x++) {
					    if (contacts[i].childNodes[x].className == "email") {
					      var email = contacts[i].childNodes[x].innerText;
					      break;
					    }        
					}
					document.getElementById(email).className="amountshown";
					document.getElementById("description"+email).className="descshown";
				}

				// move on to the next step
				document.getElementById('error1').className="error hidden"; // clear error
				document.getElementById('stepcontacts').className="stephidden";
				document.getElementById('stepamounts').className="stepactive";
				document.getElementById('step1').className="completedstep";
				document.getElementById('step2').className="currentstep"; 

				// when we progress to next step we'll no longer be on first step so can display the go back button
				document.getElementById('debtprevious').className="navbar-btn btn-danger btn pull-right";
			}
			else // no contacts selected to display error
				document.getElementById('error1').className="error";
		break;
		case "stepamounts": // we're on amounts step
			// first check that an amount has been entered for each contact
			var amounts = document.getElementsByClassName('amountshown');
			var test = true; // set to false if a contact has an invalid amount entered
			for(var x =0; x < amounts.length; x++){
				var amount = document.getElementById("amount"+amounts[x].id).value;
		    	if(isNaN(amount) || (amount==0)){
		    		test=false;
		    		break;
		    	}
			}
			if(test){ // if all values entered we can move to next step
				document.getElementById('error2').className="error hidden"; // clear error
				document.getElementById('stepamounts').className="stephidden";
				document.getElementById('stepdescription').className="stepactive";
				document.getElementById('step2').className="completedstep";
				document.getElementById('step3').className="currentstep";

				// since next step is last, update our button to show finish rather than next
				document.getElementById('debtnext').innerText="Finish";
			}
			else // not all values entered so throw error
				document.getElementById('error2').className="error";
		break;
		case "stepdescription":
			// finish button has been clicked so close modal if on pc and redirect if on mobile and add the debts
			//submit debts
			var contacts=document.getElementsByClassName('contact selected'); // get all contacts
			var data=""; // this will be our html form containing all of the debts created
			for(var i = 0; i<contacts.length; i++){
				var email =""; // gotta first get the email of each contact selected
				for (var count = 0; count < contacts[i].childNodes.length; count++) {
				    if (contacts[i].childNodes[count].className == "email") {
				      email=contacts[i].childNodes[count].innerText;
				      break;
				    }        
				}
				// then we can easily select the amount and description associated to this contact using the ID
				var amount =document.getElementById('amount'+email).value;
				var description=document.getElementById('desc'+email).value;

				// add each of our bits of data to the "form"
				data+="<input type='text' name='email"+i+"' value='"+email+"' />";
				data+="<input type='number' name='amount"+i+"' value='"+amount+"' />";
				data+="<input type='text' name='description"+i+"' value='"+description+"' />";
			}
			//create our form with our data appended
			var form = $('<form action="../../app/models/adddebtssubmit.php" method="POST">' +
			  data
			  +'</form>');

			//add form to html and run it 
			$('body').append(form);
			form.submit();

			// redirect/close modal & reset form PERHAPS NEEDED IN FUTURE. CURRENTLY IT WILL ALWAYS REDIRECT AS PHP IS RAN ON DIFFERENT PAGW
			//TODO - PERHAPS IMPLEMENT AJAX IN FUTURE
			//console.log(window.location.href);
			/*
			if(window.location.href.search("debtcreatormobile")==-1){// on desktop
				$('#selectcontacts').modal('hide')
				resetSteps();
			}
			else
				window.location.href="http://localhost/debttracker/profile.php";
			*/
		break;
		default:
		break;
	}
};
document.getElementById('debtprevious').onclick=function(){
	var x = document.getElementsByClassName('stepactive');
	// todo switch case
	switch(x[0].id){
		case "stepcontacts":
			break;
		case "stepamounts":
			document.getElementById('stepcontacts').className="stepactive";
			document.getElementById('stepamounts').className="stephidden";
			document.getElementById('step1').className="currentstep";
			document.getElementById('step2').className="completedstep";
			// can't show go back if we're on the first step
			document.getElementById('debtprevious').className="navbar-btn btn-danger btn pull-right hidden";
			break;
		case "stepdescription":
			document.getElementById('stepamounts').className="stepactive";
			document.getElementById('stepdescription').className="stephidden";
			document.getElementById('step2').className="currentstep";
			document.getElementById('step3').className="completedstep";
			// no longer on final step so show next again rather than finish
			document.getElementById('debtnext').innerText="Next >";
			break;
		default:
			break;
	}
};
$('.contact').bind('click', function(e){ 
	if(this.className == "contact selected"){
		for (var i = 0; i < this.childNodes.length; i++) {
		    if (this.childNodes[i].className == "plus") {
		      this.childNodes[i].innerText="+";
		      break;
		    }        
		}
		this.className="contact";
	}
	else{
		for (var i = 0; i < this.childNodes.length; i++) {
		    if (this.childNodes[i].className == "plus") {
		      this.childNodes[i].innerText="-";
		      break;
		    }        
		}
    	this.className="contact selected";
    }
});

function resetSteps(){ // resets the form
	//Clear all selected contacts in 1st step
	var contacts=document.getElementsByClassName('contact');
	for(var count = 0; count <contacts.length; count++){
		for (var i = 0; i < contacts[count].childNodes.length; i++) {
		    if (contacts[count].childNodes[i].className == "plus") {
		      contacts[count].childNodes[i].innerText="+";
		      break;
		    }        
		}
		contacts[count].className="contact";
	}

	//2nd clear all amounts being shown in 2nd step
	var amounts = document.getElementsByClassName('amountshown');
	for(var count = amounts.length; count >0; count--)
		amounts[0].className="hidden";

	//then clear all descriptions being shown in 3rd step
	var descs = document.getElementsByClassName('descshown');
	for(var count = descs.length; count >0; count--)
		descs[0].className="hidden";
	// then reset the step counter
	document.getElementById('step1').className="currentstep";
	document.getElementById('step2').className="uncompletedstep"; 
	document.getElementById('step3').className="uncompletedstep"; 

	// then reset all steps
	document.getElementById('stepcontacts').className="stepactive";
	document.getElementById('stepamounts').className="stephidden"; 
	document.getElementById('stepdescription').className="stephidden"; 

	// clear amounts in boxes
	var amountboxes = document.getElementsByClassName('amountbox');
	for(var i = 0; i < amountboxes.length; i++)
		amountboxes[i].value='0.00';

	// and clear descriptions in boxes
	var descboxes = document.getElementsByClassName('descbox');
	for(var i = 0; i < descboxes.length; i++)
		descboxes[i].value='';

	// finall reset the buttons
	document.getElementById('debtprevious').className="navbar-btn btn-danger btn pull-right hidden";
	document.getElementById('debtnext').innerText="Next >";
}

$('#selectcontacts').on('hide.bs.modal', function () {
	resetSteps();
});