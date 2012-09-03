var links = document.getElementsByTagName("a");

for(i=0; i< links.length; i++){
if(links[i].className.indexOf("followMe") != -1){ //classname of link you want to attach a tooltip to
	links[i].setAttribute('rel','tooltip'); //setting up tooltip
	links[i].setAttribute('data-original-title','Follow me on Twitter!'); //content of tooltip
}

if(links[i].className.indexOf("getTicket") != -1){
	links[i].setAttribute('rel','tooltip');
	links[i].setAttribute('data-original-title','Get your ticket here!');
}

if(links[i].className.indexOf("siteLeadsLong") != -1){
	console.log(links[i].getAttribute('href'));
	links[i].setAttribute('rel','tooltip');
	links[i].setAttribute('data-original-title',"Click here to go to "+links[i].getAttribute('href').substring(7));
}



//if(String(links[i]).indexOf("/profile") != -1){	
//	links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
//	}

}

//			if(organisers[i].firstChild.getAttribute('href').indexOf(forbid[n]) != -1){				
