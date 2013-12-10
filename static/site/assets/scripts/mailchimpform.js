document.getElementById("mc-embedded-subscribe-form").addEventListener("submit",function(){
  var x = new ErrorCheck([document.forms["mc-embedded-subscribe-form"].elements[1]],["Email"],function(){
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
x.submit();
return false;

});
