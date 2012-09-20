var links = document.getElementsByClassName("button");
var falseLinks = ["eventhandler"];
for(i=0; i< links.length; i++){

if(links[i].getAttribute('href') == null || links[i].getAttribute('href') == undefined){
			i=i+1;
		}
var falsehood = false;
	for(var j = 0; j < falseLinks.length; j++){
		
		if(links[i].getAttribute('href').substr(7).indexOf(falseLinks[j]) != -1){
			falsehood = true;		
		}
	}
		if(falsehood == false){
			console.log(links[i].offsetTop);
			links[i].parentNode.setAttribute('rel','tooltip');
			links[i].parentNode.setAttribute('data-original-title',links[i].getAttribute('href').substr(7));	
		}
	
}
//if(links[i].getAttribute('href').indexOf("eventhandler") == -1 && links[i].getAttribute('href')!= null ){
//	console.log(links[i].parentNode);

//}

//if(String(links[i]).indexOf("/profile") != -1){	
//	links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
//	}



//			if(organisers[i].firstChild.getAttribute('href').indexOf(forbid[n]) != -1){				
