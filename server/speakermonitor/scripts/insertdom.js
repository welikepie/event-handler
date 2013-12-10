"use strict";
var speakdata = {
	"proposals":[]
};
var dom = {
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
			console.log(speakdata.proposals);
		}
	}
};