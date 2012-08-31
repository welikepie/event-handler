var links = document.getElementsByTagName("a");

for(i=0; i< links.length; i++){

if(String(links[i]).indexOf("/profile") != -1){	
	links[i].setAttribute('href',links[i].getAttribute('href').replace('/profile','http://www.twitter.com'));
	links[i].setAttribute('rel', 'tooltip');
	links[i].setAttribute('data-original-title','Follow me on Twitter!')
	}
}
var divs = document.getElementsByTagName("div");
var replacerHTML = "";
	for (i = 0; i < divs.length; i++){
		if (divs[i].className == "column" || divs[i].className == "column first" ){
			replacerHTML += divs[i].innerHTML;
		}
	}
document.getElementById("speakerField").innerHTML = replacerHTML;
