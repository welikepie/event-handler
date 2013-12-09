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

function ErrorCheck(array_of_ids, array_of_types,submit_function){
	this.elements = array_of_ids;
	this.types = array_of_types;
	this.responses = new Array(this.elements.length);
	this.submitfunction = submit_function;
	this.discreteTextReturns = {
		"0":"Wrong for some reason",
		"1":"Passed!",
		"2":"Wrong Type for Value",
		"3":"Value Unexpected",
		"4":"Empty Value"
	};
	this.submit = function(){
		if(this.validate()===true){
			this.submitfunction();
		}
	};
	this.validate = function(){
		var sameLength = (this.elements.length == this.types.length);
		if(sameLength == false){return false;}
		for(var i = 0; i < this.elements.length; i++){
			this.responses[i] = this.discreteTest(document.getElementById(this.elements[i]).value,i);
		}
	};
	this.discreteTest = function(value, index) {
        var toTest = value;
        if (this.types[index] == "Percent") {
                if (toTest % 1 != 0 || toTest == "" || parseFloat(toTest,10) > 100 || parseFloat(toTest,10) ==0) {
                        if (toTest == "") {
                        	return 4;
                        } else if (toTest % 1 != 0 ) {
                            return 2;
                         }
                        else if (parseFloat(toTest,10) > 100 || parseFloat(toTest,10) ==0){
                         return 3;
                        }
                } else {
                	return 1;
                }
        }
        if(this.types[index] == "Percent"){
                console.log(parseFloat(toTest.replace("%", "").replace(/\s/g,""),10));
                if(toTest.length > 0 && /[a-zA-Z]{1,}/.test(toTest) == false){
                        if(toTest.indexOf("%")>0 && parseFloat(toTest.replace("%", "").replace(/\s/g,""),10) >= 0 && parseFloat(toTest.replace("%", "").replace(/\s/g,""),10) <= 100 ){
 						return 1;
                        }
                        else{
                            try{
                                parseFloat(toTest,10);
                              if(parseFloat(toTest,10) > 0 && parseFloat(toTest,10)<100){
                                return 1;
                              }
		                        else{
		                           return 3;
		                        }
                             }
                            catch(e){
                               return 2;
                               console.log(e);
                            }
                        }
                }else{
                      return 0;
                }
        }
        if (this.types[index] == "Phone") {
                var toText = 0;
                if (toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/) != null) {
                        toText = toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/)[0].length;
                }
                if (toText != toTest.length || toTest == "" || /[a-zA-Z]{1,}/.test(toTest) == true) {
                        if (toTest == "") {
                      		return 4;
                        } else if (/[a-zA-Z]{0,}/.test(toTest) == true) {
                            return 2;
                        }
                } else {
                        return 1;
                }
        }
        if (this.types[index] == "Currency") {
                if (toTest == "" || toTest.length == 0) {
                        return 4;
                } else {
                	return 1;
                }
        }
        if (this.types[index] == "String") {
                if ( typeof toTest != "string" || toTest == "") {
                        if (toTest == "") {
                            return 4;
                        } else if ( typeof toTest != "string") {
                     		return 2;
                        }
                           return 0;
                } else {
                       return 1;
                }
        } 
        if (this.types[index] == "Integer") {
                if (toTest % 1 != 0 || toTest == "" || parseFloat(toTest,10) == 0) {
                        if (toTest == "") {
                            return 4;
                        } else if (toTest % 1 != 0) {
                        	return 2;
                        }else if (parseFloat(toTest,10) == 0){
                            return 3;
                        }
                        	return 0;
                } else {
                        return 1;
                }
        } else if (this.types[index] == "Float") {
                //regex for 0-9 and one .
                if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) == false || toTest == "" || /[a-zA-Z]{1,}/.test(toTest) == true || parseFloat(toTest,10)==0) {
                        if (toTest == "") {
                                return 4;
                        } else if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) == false || /[a-zA-Z]{1,}/.test(toTest) == true) {
                          		return 2;
                        } else if (parseFloat(toTest,10)==0){
                                return 3;
                        }
                        return 0;
                } else {
                	return 1;
                }
        } else if (this.types[index] == "Email") {
                //regex ?
                if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) == false || toTest == "") {
                        if (toTest == "") {
                               return 4;
                        } else if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) == false) {
                              return 2;
                        }
                        return 0;
                } else {
                       return 1;
                }
        }
        return 1;
	};
}