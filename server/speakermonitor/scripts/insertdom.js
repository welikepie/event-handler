"use strict";
var speakdata = {
	"proposals":[],
		"topush":{}
};
var dom = {
	"toMonitor" : ["checkedtick","commentsbox"],
	"toMonitorType" : ["checkbox","textarea"],
	"loadedJSON":{},
	"parseJSON":function(input){
		try{
		dom.loadedJSON = JSON.parse(input);
		}catch(e){
			alert("Something went really wrong! Check the dev console!");
			console.log(e.stack);
		}
		if(dom.loadedJSON["status"]!=="success"){
			alert("Error retrieving data. Credentials not correct.");
			console.log(dom.loadedJSON);
		}else{
			speakdata.proposals = dom.loadedJSON.data;
			for(var i = speakdata.proposals.length-1; i >= 0 ; i--){
				dom.insertListElement(document.getElementById("data"),speakdata.proposals[i]);
			}
			console.log(speakdata.proposals);
		}
	},
	"insertListElement": function(destination,dataobject){
		var li = document.createElement("li");
		li.setAttribute("data-order",dataobject["order"]);
		var dl = document.createElement("dl");

		for(var i in dataobject){
			if(dataobject.hasOwnProperty(i)){
				if(i!=="order"&&i!=="checkedout"&&i!=="comments"){
					var dttext = "";
					if(i == "date"){
							dttext = "Date: ";
					}else if(i == "name"){
							dttext = "Name: ";
					}else if(i == "lanyrd"){
							dttext = "Lanyrd Link: ";
					}else if(i == "contactinfo"){
							dttext = "Contact Information: ";
					}else if(i == "length"){
							dttext = "Length of Talk: ";
					}else if(i == "association"){
							dttext = "How do you know them? ";
					}else if(i == "subjects"){
							dttext = "Subjects: ";
					}else if(i == "why"){
							dttext = "What can you bring to us? ";
					}else if(i == "what"){
							dttext = "What do you want to talk about? ";
					}else if(i == "style"){
							dttext = "Style of presentation: ";
					}else if(i == "links"){
							dttext = "Links to supporting media: ";
					}
					if(dataobject[i]!==null){
						var dt = document.createElement("dt");
						dt.innerHTML = dttext;
						var dd = document.createElement("dd");
						if(i ==="date"){
							dd.innerHTML = new Date(dataobject[i]);
						}else{
							dd.innerHTML = dataobject[i];
						}
						dl.appendChild(dt);
						dl.appendChild(dd);
					}
				}
			}
		}
		var dt = document.createElement("dt");
		dt.innerHTML = "Checked this out yet?";
		dl.appendChild(dt);
		var dd = document.createElement("dd");
		var check = document.createElement("input");
		check.setAttribute("type","checkbox");
		check.checked = dataobject["checkedout"];
		check.setAttribute("data-order",dataobject["order"]);
		check.setAttribute("data-correlate","checkedout");
		check.setAttribute("class","checkedtick");
		check.setAttribute("className","checkedtick");
		check.onclick=function(){
			dom.parity();
		};
		dd.appendChild(check);
		dl.appendChild(dd);

		var dt = document.createElement("dt");
		dt.innerHTML = "Any thoughts?";
		dl.appendChild(dt);
		var dd = document.createElement("dd");

		var check = document.createElement("textarea");
		check.innerHTML = dataobject["comments"];
		check.setAttribute("data-order",dataobject["order"]);
		check.setAttribute("data-correlate","comments");
		check.setAttribute("class","commentsbox");
		check.setAttribute("className","commentsbox");
		check.onblur = function(){
			dom.parity();
		}
		dd.appendChild(check);
		dl.appendChild(dd);

		li.appendChild(dl);
		destination.appendChild(li);
	},
	"display" : function(target){
		target.style.display="inline";
	},
	"hide" : function(target){
		target.style.display="none";
	},
	"parity" : function(){
		speakdata.topush = {};
		for(var i = 0; i < dom.toMonitor.length; i++){
			var elar = document.getElementsByClassName(dom.toMonitor[i]);
			for(var j = 0; j < elar.length; j++){
			var value;
				if(dom.toMonitorType[i] == "checkbox"){
					(elar[j].checked == true)?value = 1:value = 0;
				}
				else if(dom.toMonitorType[i] == "textarea"){
					(elar[j].value == "")?value = null:value = elar[j].value ;
				}
				console.log(value+","+speakdata.proposals[parseInt(elar[j].getAttribute("data-order"),10)-1][elar[j].getAttribute("data-correlate")]);
				if(value!=speakdata.proposals[parseInt(elar[j].getAttribute("data-order"),10)-1][elar[j].getAttribute("data-correlate")]){
					if(!speakdata.topush.hasOwnProperty(elar[j].getAttribute("data-order"))){
						speakdata.topush[elar[j].getAttribute("data-order")] = speakdata.proposals[parseInt(elar[j].getAttribute("data-order"),10)-1];
					}
					speakdata.topush[elar[j].getAttribute("data-order")][elar[j].getAttribute("data-correlate")] = value;
				}
			}
		}


		console.log(speakdata.topush);
	}
};