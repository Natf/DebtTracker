$('#paydebtconfirm').bind('click', function(e){ 
	var amounts = document.getElementsByClassName('amountbox');
	var data="userid0="+amounts[0].id+"&amount0="+amounts[0].value;
	for(var i=1; i<amounts.length; i++){
		data+="&userid"+i+"="+amounts[i].id+"&amount"+i+"="+amounts[i].value;
	}
	window.location.href = "http://localhost/debttracker/paydebt.php?"+data;
});