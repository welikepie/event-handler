var forbid=["eventhandleruk"]; //add people to the blacklist based on their twitter handle. Case sensitive.
var targetBlanks = ["eventhandler","localhost"];

var linksOne = document.getElementsByTagName("a");
//	console.log(links);
	for(i=0; i < linksOne.length; i++){
		if(linksOne[i].href.toLowerCase().indexOf(targetBlanks[0])==-1&&linksOne[i].href.toLowerCase().indexOf(targetBlanks[1])==-1){
			linksOne[i].setAttribute('target','_blank');
		}
	}

function sortThrough(el){
//var organisers = document.getElementsByClassName("fullwidth");
var organisers = el.querySelectorAll('.fullwidth');
var returnArr = new Array(organisers.length);
	for (i = 0; i < organisers.length; i++){
	if(i%2 == 0){
		var replaceSpeakers = "";
		var organiserList = organisers[i].getElementsByTagName("li");
				for(j = 0; j < organiserList.length; j ++){
					var innerList = organiserList[j].querySelectorAll(".avatar.avatar-med");
					for(k=0; k < innerList.length; k++){
						if(innerList[k].innerHTML.length == 12){
							innerList[k].innerHTML = "<img src = '/assets/images/spareAvatar.png'>";	//spareAvatar.png needs to be 40*40.
						}
					}
				}
			}
	if(i%2 == 1){
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
	}
	var links = el.getElementsByTagName("a");
//	console.log(links);
	for(i=0; i < links.length; i++){
		if(String(links[i]).indexOf("/profile") != -1){	
			links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
			links[i].setAttribute('href',links[i].getAttribute('href').replace('http://lanyrd.com',''));
		}
		if(links[i].href.toLowerCase().indexOf(targetBlanks[0])==-1 &&links[i].href.toLowerCase().indexOf(targetBlanks[1])==-1){
			links[i].setAttribute('target','_blank');
		}
	}
}
