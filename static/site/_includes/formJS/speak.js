"use strict";

var x = new ErrorCheck([document.getElementById("testElement")],["Integer"],function(){console.log("LOL");});

document.getElementById("button").onclick=x.submit();


function ErrorCheck(array_of_els, array_of_types,submit_function){
	this.elements = array_of_els;
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
		console.log(this.responses);
		if(this.validate()===true){
			this.submitfunction();
		}else{
			for(var i = 0; i < this.elements.length; i++){
				if(this.responses[i] != 1){
					console.log(this.elements[i] +"came out to "+this.discreteTextReturns[this.responses[i].toString()]);
				}
			}
		}
	};
	this.validate = function(){
		console.log(this.elements[0].value);
		var sameLength = (this.elements.length == this.types.length);
		if(sameLength == false){console.log("Your Arrays of IDs and Types are not the same length!"); return false;}
		for(var i = 0; i < this.elements.length; i++){
			console.log(this.elements[i].value);
			this.responses[i] = this.discreteTest(this.elements[i].value,i);
		}
		for(var i = 0; i < this.elements.length; i++){
			if(this.responses[i] != 1){
				return false;
			}
		}
		return true;
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
        if(this.types[index] == "Percent2"){
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
        	console.log("TESTING");
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
        } if (this.types[index] == "Float") {
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