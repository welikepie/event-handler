"use strict";
window.onload = function(){
var list = document.getElementById("eventslist").childNodes;
console.log(list);
var lis = [];
for(var elements in list){
	if(list[elements].nodeName=="LI" && list[elements].getAttribute("data-evb")!=null){
		console.log(list[elements].getAttribute("data-evb"));
		lis.push(list[elements].getAttribute("data-evb"));
	}
}

console.log(lis);
	var xmlhttp = new XMLHttpRequest();
		xmlhttp.open('POST', 'http://localhost:2399/getevbdata', true);
		xmlhttp.setRequestHeader('X-WLPAPI', '23458');
		xmlhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
		xmlhttp.onload = function () {
		    var results = JSON.parse(this.responseText);
		    console.log(results);
		    if(results.test == false){
		    	alert("Data could not be retrieved: "+JSON.parse(results.data));
		    }else{
				var data = JSON.parse(results.data);
				for(var id in data){
					if(data[id]!="undefined"){
						document.getElementById(id).innerHTML = data[id];
					}else{
						document.getElementById(id).innerHTML = "No information could be retrieved for this event. Check eventbriteid.";
					}
					console.log(data[id]);
				}
			}
		};
		xmlhttp.send(JSON.stringify({"data":lis}));
}