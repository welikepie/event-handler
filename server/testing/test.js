document.getElementById("mc-embedded-subscribe-form2").addEventListener("submit",function(){
	var email=document.forms["mc-embedded-subscribe-form2"].elements[1].value;
var keyArray = {
"DEV":document.forms["mc-embedded-subscribe-form2"].elements[3].checked,
"DESIGN":document.forms["mc-embedded-subscribe-form2"].elements[4].checked,
"SOCIAL":document.forms["mc-embedded-subscribe-form2"].elements[5].checked
};

var xmlhttp = new XMLHttpRequest();
xmlhttp.open('POST', 'http://localhost:2399/mailchimp', true);
//xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xmlhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

xmlhttp.onload = function () {
    // do something to response
    console.log(this.responseText);
};

var toSend = {"EMAIL":email,"GROUPINGS":keyArray};
//xmlhttp.send(serialize(toSend));
xmlhttp.send(JSON.stringify(toSend));
});

document.getElementById("mc-embedded-subscribe-form").addEventListener("submit",function(){

var ema=document.forms["mc-embedded-subscribe-form"].elements[1].value;
var dev = document.forms["mc-embedded-subscribe-form"].elements[3].checked;
var des = document.forms["mc-embedded-subscribe-form"].elements[4].checked;
var soc = document.forms["mc-embedded-subscribe-form"].elements[5].checked;

var x = {
	email: ema,
	development: dev,
	design: des,
	social: soc
};

var xmlhttp = new XMLHttpRequest();
xmlhttp.open('POST', 'http://localhost:2399/writetodb', true);
xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//xmlhttp.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

xmlhttp.onload = function () {
    // do something to response
    console.log(this.responseText);
};
xmlhttp.send(serialize(x));
});


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
