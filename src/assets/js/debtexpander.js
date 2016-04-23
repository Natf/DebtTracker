$('.expand').bind('click', function(e){ 
	if(this.className == "expand expanded"){ // aready open
		var detaileds = document.getElementsByClassName("detailedDebt "+this.id);
		console.log(detaileds.length);
		for (var i = detaileds.length; i >0; i--)
		    detaileds[i-1].className= "detailedDebt "+this.id+" hidden";

		this.innerText="[+]";
		this.className="expand";
	}
	else if(this.className == "expand"){
		var detaileds = document.getElementsByClassName("detailedDebt "+this.id+" hidden");
		for (var i = detaileds.length; i >0; i--)
		    detaileds[0].className= "detailedDebt "+this.id;

		this.innerText="[-]";
		this.className="expand expanded";
    }
});