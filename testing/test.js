document.getElementById("mc-embedded-subscribe-form").addEventListener("submit",function(){

alert("AWWYISS");
console.log(document.forms["mc-embedded-subscribe-form"].elements);

var email=document.forms["mc-embedded-subscribe-form"].elements[1].value;
var keyArray = {
"DEV":document.forms["mc-embedded-subscribe-form"].elements[3].checked,
"DESIGN":document.forms["mc-embedded-subscribe-form"].elements[4].checked,
"SOCIAL":document.forms["mc-embedded-subscribe-form"].elements[5].checked
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
