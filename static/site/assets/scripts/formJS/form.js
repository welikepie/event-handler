"use strict";

/*input = {array_of_els : [],
 array_of_types : [],
 submit_function : function(){},
 validation_text : [],
 fail_function : function(){}
}; */
function ErrorCheck(input){
	if(arguments[1]!=undefined){
        console.error("Youre using the wrong type of function. Please switch to the JSON formatting documented in the README!");
        return false;
    }

    this.elements = undefined;
    this.types = undefined;
    this.submitfunction = undefined;

    if(input.hasOwnProperty("array_of_elements")){
        this.elements = input["array_of_elements"];
    }
    if(input.hasOwnProperty("array_of_types")){
        this.types = input["array_of_types"];
    }
    if(input.hasOwnProperty("success_function")){
        this.submitfunction = input["success_function"];
    }
    if(this.elements == undefined || this.types == undefined || this.submitfunction == undefined){
        console.log(input);
        if(this.elements == undefined){
            console.error("You did not supply the elements as the \"array_of_elements\" parameter.");
        }else if(this.types==undefined){
            console.error("You did not supply the array of types as the \"array_of_types\" parameter.");
        }else if(this.submitfunction == undefined){
            console.error("You did not supply the success function as the \"success_function\" parameter.");
        }
        return false;
    }
	this.responses = new Array(this.elements.length);
    this.failfunction = undefined;
    if(input.hasOwnProperty("fail_function") != undefined && typeof input["fail_function"] == "function"){
        this.failfunction = input["fail_function"];
    }
    this.returnmessages = undefined;
    if(input.hasOwnProperty("validation_text")){
        this.returnmessages = input["validation_text"];
        if(this.returnmessages.length != this.elements.length){
            if(this.returnmessages.length > 1){
                console.error("Error: Error Message length isn't the same as elements array, and is greater than one.");
            }
            this.returnmessages = [this.returnmessages[0]];
        }
    }
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
            if(this.returnmessages!==undefined){
                for(var i = 0; i < this.elements.length; i++){
                     this.error(this.elements[i].getAttribute("id")+"Error",undefined);
                }
            }
			this.submitfunction();
		}else{
			for(var i = 0; i < this.elements.length; i++){
				if(this.responses[i] != 1){
					console.log(this.elements[i]);
                    console.log("came out to "+this.discreteTextReturns[this.responses[i].toString()]);
				}
                if(this.returnmessages!==undefined){
                    if(this.responses[i]!=1){
                        if(this.returnmessages.length > 1){
                            this.error(this.elements[i].getAttribute("id")+"Error",this.returnmessages[i][this.responses[i].toString()]);
                            //console.log(this.elements[i] + "came out to "+this.returnmessages[i][this.responses[i].toString()]);
                        }else{
                            this.error(this.elements[i].getAttribute("id")+"Error",this.returnmessages[0][this.responses[i].toString()]);
                        }
                    }else{
                        this.error(this.elements[i].getAttribute("id")+"Error",undefined);
                    }
                }
			}
            if(this.failfunction!=undefined){
                this.failfunction();
            }
		}
	};
    this.error = function(id,message){
        var element = document.getElementById(id);
        if(element!=null){
            if(message == undefined){
                element.class="formerror success";
                element.className = "formerror success";
                element.style.display = "none";
                element.style.visibility = "hidden";
            }else{
                element.class="formerror failure";
                element.className = "formerror failure";
                element.innerHTML = message;
                element.style.display = "inline";
                element.style.visibility = "visible";
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
        if (this.types[index].toLowerCase() === "percent") {
                if (toTest % 1 !== 0 || toTest === "" || parseFloat(toTest,10) > 100 || parseFloat(toTest,10) <0) {
                        if (toTest === "") {
                        	return 4;
                        } else if (toTest % 1 !== 0 ) {
                            return 2;
                         }
                        else if (parseFloat(toTest,10) > 100 || parseFloat(toTest,10)< 0){
                         return 3;
                        }
                } else {
                	return 1;
                }
        }
        if(this.types[index].toLowerCase() === "percent2"){
                console.log(parseFloat(toTest.replace("%", "").replace(/\s/g,""),10));
                if(toTest.length > 0 && /[a-zA-Z]{1,}/.test(toTest) === false){
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
                               console.log(e);
                               return 2;
                            }
                        }
                }else{
                      return 0;
                }
        }
        if (this.types[index].toLowerCase() === "phone") {
                var toText = 0;
                if (toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/) != null) {
                        toText = toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/)[0].length;
                }
                if (toText !== toTest.length || toTest === "" || /[a-zA-Z]{1,}/.test(toTest) === true) {
                        if (toTest === "") {
                      		return 4;
                        } else if (/[a-zA-Z]{0,}/.test(toTest) === true) {
                            return 2;
                        }
                } else {
                        return 1;
                }
        }
        if (this.types[index].toLowerCase() === "currency") {
                if (toTest === "" || toTest.length === 0) {
                        return 4;
                } else {
                	return 1;
                }
        }
        if (this.types[index].toLowerCase() === "string") {
                if ( typeof toTest != "string" || toTest === "") {
                        if (toTest === "") {
                            return 4;
                        } else if ( typeof toTest != "string") {
                     		return 2;
                        }
                           return 0;
                } else {
                       return 1;
                }
        }
        if (this.types[index].toLowerCase() === "integer") {
                if (toTest % 1 !== 0 || toTest === "" || parseFloat(toTest,10) === 0) {
                        if (toTest === "") {
                            return 4;
                        } else if (toTest % 1 !== 0) {
                        	return 2;
                        }else if (parseFloat(toTest,10) === 0){
                            return 3;
                        }
                        	return 0;
                } else {
                        return 1;
                }
        } if (this.types[index].toLowerCase() === "float") {
                //regex for 0-9 and one .
                if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) === false || toTest === "" || /[a-zA-Z]{1,}/.test(toTest) === true || parseFloat(toTest,10)==0) {
                        if (toTest === "") {
                                return 4;
                        } else if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) === false || /[a-zA-Z]{1,}/.test(toTest) === true) {
                          		return 2;
                        } else if (parseFloat(toTest,10)===0){
                                return 3;
                        }
                        return 0;
                } else {
                	return 1;
                }
        } else if (this.types[index].toLowerCase() === "email") {
                //regex ?
                if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) === false || toTest === "") {
                        if (toTest === "") {
                               return 4;
                        } else if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) === false) {
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