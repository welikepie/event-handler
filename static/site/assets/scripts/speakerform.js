"use strict";
document.forms["speakerform"].onsubmit = function(){
var obj = {
"name":document.forms["speakerform"].elements[0],
"contactinfo":document.forms["speakerform"].elements[1],
"association" : document.forms["speakerform"].elements[2],
"why" : document.forms["speakerform"].elements[3],
"what" : document.forms["speakerform"].elements[4],
"style" : document.forms["speakerform"].elements[5],
"length" : document.forms["speakerform"].elements[6],
"links" : document.forms["speakerform"].elements[7],
"lanyrd" : document.forms["speakerform"].elements[8],
"subjects" : {"value":(function(){
	try{
	var string = "";
	for(var i = 0; i < document.forms["speakerform"].elements.length; i++){
		var j = document.forms["speakerform"].elements[i];
		if(j.className == "formquestionchecks"){
			if(j.checked == true){
				if(string.length>0){
					string+=", ";
				}
				var labelText = findLabelTextForControl(j);
				
				if(labelText.replace(/^\s\s*/, '').replace(/\s\s*$/, '') != "Other:"){
				string+=labelText;
				}
				else{
					string+= document.forms["speakerform"].elements[42].value;
				}
			}
		}
	}
return string;
}
catch(e){console.log(e.stack);return "ERROR";}
})()}
}
try{
	var x = new ErrorCheck({"array_of_elements":[obj.name,obj.contactinfo],
		"array_of_types":["String","String"],
		"success_function":function(){
		for(var i in obj){
			if(obj.hasOwnProperty(i)){
				if(obj[i].value === ""){
					delete obj[i];
				}else{
					obj[i] = obj[i].value;
				}
			}
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.open('POST', 'http://localhost:2399/writespeakerform', true);
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.onload = function () {
		    console.log(this.responseText);
		};
		xmlhttp.send(serialize(obj));
	},
	"fail_function":function(){alert("your inputs haven't validated.")}
	});
	x.submit();
}
	catch(e){console.log(e.stack);}
return false;
}

function serialize(obj, prefix) {
  var str = [];
  for(var p in obj) {
  if(obj.hasOwnProperty(p)){
    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
    str.push(typeof v == "object" ?
      serialize(v, k) :
      encodeURIComponent(k) + "=" + encodeURIComponent(v));
  	}
  }
  return str.join("&");
}


function findLabelTextForControl(el) {
   var idVal = el.id;
   var labels = document.getElementsByTagName('label');
   for( var i = 0; i < labels.length; i++ ) {
      if (labels[i].htmlFor == idVal)
           return labels[i].innerHTML;
   }
}