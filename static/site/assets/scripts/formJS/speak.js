"use strict";
document.forms["testform"].onsubmit=function(){

	var x = new ErrorCheck([document.getElementById("testElement")],["Percent2"],function(){alert("PASSED");});
	x.submit();
	
}

