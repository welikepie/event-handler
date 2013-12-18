"use strict";
window.onload = function(){
	dom.hide(document.getElementById("savebutton"));
	document.getElementById("savebutton").onclick = function(){
		savedata();
	}
	var xmlhttp = new XMLHttpRequest();
		xmlhttp.open('GET', 'http://localhost:2399/speaker', true);
		xmlhttp.setRequestHeader('X-WLPAPI', '23458');
		xmlhttp.onload = function () {
		    dom.parseJSON(this.responseText);
		};
		xmlhttp.send();
}