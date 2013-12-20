document.getElementById("mc-embedded-subscribe-form").addEventListener("submit",function(){
  var x = new ErrorCheck({
    "array_of_elements": [document.forms["mc-embedded-subscribe-form"].elements[1]],
    "array_of_types" : ["Email"],
    "success_function" : function(){
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
},
"fail_function":function(){alert("something got messed up! Failed to validate.");},
"validation_text":[{"0":"Error0","2":"Error2","3":"Error3","4":"Error"}]
}
);
x.submit();
return false;

});
