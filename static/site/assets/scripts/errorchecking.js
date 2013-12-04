var init = {
formElements : [],
type : [],
errorMessageEmpty : [],
errorMessageWrongType : [
],
onSuccessMessage : [
]
};
function discreteTest(value, index) {
	var toTest = value;
	if (util.type[index] == "Percent") {
		if (toTest % 1 != 0 || toTest == "" || parseFloat(toTest,10) > 100 || parseFloat(toTest,10) < 0) {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if (toTest % 1 != 0 || parseFloat(toTest,10) > 100 || parseFloat(toTest,10) < 0) {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Warning");

			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
				document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	}
	/*if(util.type[index] == "Percent"){
		console.log(parseFloat(toTest.replace("%", "").replace(/\s/g,""),10));
		if(toTest.length > 0 && /[a-zA-Z]{1,}/.test(toTest) == false){
			if(toTest.indexOf("%")>0 && parseFloat(toTest.replace("%", "").replace(/\s/g,""),10) >= 0 && parseFloat(toTest.replace("%", "").replace(/\s/g,""),10) <= 100 ){
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
			}
			else{
				try{
				parseFloat(toTest,10);
				if(parseFloat(toTest,10) > 0 && parseFloat(toTest,10)<100){
				if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
				} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
				}


			}
			else{
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className" , "Error Warning");
				document.getElementById(util.formElements[index] + "Error").style.display = "inline";
				return false;
			}
				}
				catch(e){
					document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
					document.getElementById(util.formElements[index] + "Error").setAttribute("className" , "Error Warning");
					document.getElementById(util.formElements[index] + "Error").style.display = "inline";
					return false;
					console.log(e);
				}
			}
		}else{
			document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			document.getElementById(util.formElements[index] + "Error").setAttribute("className", "Error Warning");
			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			return false;
		}
	}*/
	if (util.type[index] == "Phone") {
		var toText = 0;
		if (toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/) != null) {
			toText = toTest.match(/[0-9+\-\(\)\[\],. ]{1,}/)[0].length;
		}
		if (toText != toTest.length || toTest == "" || /[a-zA-Z]{1,}/.test(toTest) == true) {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if (/[a-zA-Z]{0,}/.test(toTest) == true) {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className" , "Error Warning");
			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className" , "Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	}
	if (util.type[index] == "Currency") {
		if (toTest == "" || toTest.length == 0) {
			document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Warning");
			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className", "Error Success");
				document.getElementById(util.formElements[index] + "Error").setAttribute("class", "Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	}
	if (util.type[index] == "String") {
		if ( typeof toTest != "string" || toTest == "") {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if ( typeof toTest != "string") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className", "Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class", "Error Warning");

			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	} else if (util.type[index] == "Integer") {
		if (toTest % 1 != 0 || toTest == "") {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if (toTest % 1 != 0) {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Warning");

			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
				document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	} else if (util.type[index] == "Float") {
		//regex a motherfucker for 0-9 and one .
		if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) == false || toTest == "" || /[a-zA-Z]{1,}/.test(toTest) == true) {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if (/[0-9]{1,}[.]{0,1}[0-9]{0,}/.test(toTest) == false || /[a-zA-Z]{1,}/.test(toTest) == true) {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Warning");
			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
				document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	} else if (util.type[index] == "Email") {
		//regex ?
		if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) == false || toTest == "") {
			if (toTest == "") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageEmpty[index] + "</div>";
			} else if (/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,4}/.test(toTest) == false) {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='fail'></div><div class='message'>" + util.errorMessageWrongType[index] + "</div>";
			}
			document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Warning");
			document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Warning");
			document.getElementById(util.formElements[index] + "Error").style.display = "inline";
			if (util.inMandatory(util.formElements[index]) == true) {
				return false;
			}
		} else {
			if (document.getElementById(util.formElements[index] + "Error").style.display != "none") {
				document.getElementById(util.formElements[index] + "Error").innerHTML = "<div class='succ'></div><div class='message'>" + util.onSuccessMessage[index] + "</div>";
				document.getElementById(util.formElements[index] + "Error").setAttribute("className","Error Success");
				document.getElementById(util.formElements[index] + "Error").setAttribute("class","Error Success");
			} else {
				document.getElementById(util.formElements[index] + "Error").style.display = "none";
			}
		}
	}
	return true;

}