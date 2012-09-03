var forbid=["eventhandleruk"]; //add people to the blacklist based on their twitter handle.

var links = document.getElementsByTagName("a");

for(i=0; i< links.length; i++){

if(String(links[i]).indexOf("/profile") != -1){	
	links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
	}
}
var divs = document.getElementsByTagName("div");
var replacerHTML = "";
	for (i = 0; i < divs.length; i++){
		if (divs[i].className == "column" || divs[i].className == "column first" ){
			var one = divs[i].innerHTML.replace('<span','<div');
			var two = one.replace('/span','/div');
			replacerHTML += two;
		}
	}

var organisers = document.getElementById("organiserField").getElementsByClassName("name");
var replaceOrganisers = "";
	for (i = 0; i < organisers.length; i++){
console.log(organisers.length);
		var contains=false;
		for(n=0;n < forbid.length; n++){
			if(organisers[i].firstChild.getAttribute('href').indexOf(forbid[n]) != -1){				
				contains=true;
			}
		}
		if(contains == false){
		console.log(organisers[i].parentNode.innerHTML);
		replaceOrganisers += "<li>"+organisers[i].parentNode.innerHTML+"</li>";	
		}
	}


document.getElementById("speakerField").innerHTML = replacerHTML;
document.getElementById("organiserField").innerHTML = "<ul class='people'>"+replaceOrganisers+"</ul>";
