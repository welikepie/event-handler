var forbid=["eventhandleruk"]; //add people to the blacklist based on their twitter handle. Case sensitive.

var links = document.getElementsByTagName("a");

for(i=0; i< links.length; i++){

if(String(links[i]).indexOf("/profile") != -1){	
	links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
	}
}
(function(){
var organisers = document.getElementsByClassName("fullwidth");
var returnArr = new Array(organisers.length);
	for (i = 1; i < organisers.length; i= i + 2){
	var replaceOrganisers = "";
	var organiserList = organisers[i].getElementsByTagName("li");
			//console.log("PAGENUM = "+i+"------------------------------------------------");
			for(j = 0; j < organiserList.length; j ++){
				var contains=false;
				var innerList = organiserList[j].getElementsByTagName("span");
				for(n=0;n < forbid.length; n++){
					if(innerList[1].innerHTML.indexOf(forbid[n]) != -1){			
						contains=true;
					}
				}
				if(contains == false){
					replaceOrganisers += "<li>"+organiserList[j].innerHTML+"</li>";				
				}
			}
			organisers[i].innerHTML = "<ul class='people'>"+replaceOrganisers+"</ul>";		
}

})()
