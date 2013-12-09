
var xmlhttp = new XMLHttpRequest();
xmlhttp.open('POST', 'http://localhost:2399/mailchimp', true);
xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
xmlhttp.onload = function () {
    // do something to response
    console.log(this.responseText);
};
xmlhttp.send('user=person&pwd=password&organization=place&requiredkey=key');



serialize = function(obj, prefix) {
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
