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
						document.getElementById(id).innerHTML = data[id].spaceleft;
					document.getElementById(id+"percentbar").setAttribute("data-percentage",data[id].percent);
					createPercentBar(id+"percentbar");
					}else{
						document.getElementById(id).innerHTML = "No information could be retrieved for this event. Check eventbriteid.";
					}
				}
			}
		};
		xmlhttp.send(JSON.stringify({"data":lis}));
}

function createPercentBar(id){
var element = document.getElementById(id);
var baseclass = "percentagebar";
var percent = element.getAttribute("data-percentage");
var percentString = (percent*100) + "%";
if(percent*100>75){
	baseclass+= " good";
}
else if(percent*100>50){
	baseclass+= " middle";
}
else{
	baseclass+= " poor";
}


//element.setAttribute("className", baseclass);
element.setAttribute("class",baseclass);

var outerbar = document.createElement("div");
outerbar.setAttribute("class","outerbar");
//outerbar.setAttribute("className", "outerbar");

var innerbar = document.createElement("div");
innerbar.setAttribute("class","innerbar");
//innerbar.setAttribute("className", "innerbar");

innerbar.style.width = percentString;
outerbar.appendChild(innerbar);
element.appendChild(outerbar);


var perc = document.createElement("div");
perc.setAttribute("class","percentage");
//perc.setAttribute("className", "percentage");

perc.innerHTML = percentString;
element.appendChild(perc);
}