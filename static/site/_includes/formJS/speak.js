"use strict";

var speaker = {
	"elements" : [document.forms["speakerform"].elements[0],document.forms["speakerform"].elements[1]],
	"errorElements" : [],
	"submit" : function(){
		if(speaker.validate() === true){
			console.log(document.forms["speakerform"]);
		}
	},
	"validate" : function(){
		var error = false;
		for(var speak in speaker.elements){
			if(speaker.elements[speak].value == ""){
				speaker.displayErrors(speak);
				error = true;
			}
		}
		if (error === false){
			return true;
		}
		else{
			return false;
		}
	},
	"displayErrors" : function(index){
		console.log(index);
	}
};