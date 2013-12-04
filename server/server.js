var http = require('http'),
      fs = require('fs'),
     url = require('url'),
     mysql = require('mysql'),
     listening = 8001,
     config = require('./config');

//SETUP MAILCHIMP API - You must replace your API Key and List ID which you can find in your Mailchimp Account
var MailChimpAPI = require('mailchimp').MailChimpAPI;
var apiKey = config.mailchimp.api;  // Change this to your Key
var listID = config.mailchimp.list;  // Change this to your List ID

try {
    var mcApi = new MailChimpAPI(apiKey, { version : '1.3', secure : false });
} catch (error) {
    console.log(error.message);
}

http.createServer(function(request, response){
    if(request.method.toLowerCase() != "post")
    {
        response.writeHead(403, {"Content-Type": "text/plain"});
        response.end("{GET requests are not allowed to this server.}");
    }
        else{
    var path = url.parse(request.url).pathname;
    if(path=="/writetodb"){
config.mysql.connection.query('INSERT INTO content SET ? ON DUPLICATE KEY UPDATE hashtag = ?, id = ?, text = ?, user = ?,name = ?, userIMG = ?, time = ?, link = ?, img_large = ?, img_med = ?, img_small = ?, lat = ?, lon = ?', 
    [send, send.hashtag, send.id, send.text, send.user, send.name, send.userIMG, send.time, send.link, send.img_large, send.img_med, send.img_small, send.lat, send.lon], 
        function(err, result) {
            if (err != null) {
                console.log(result);
                }
            });
        response.writeHead(200, {"Content-Type": "text/plain"});
        response.end("");
//        console.log("string sent");
    }
    if(path == "/mailchimp"){
           try{
            var GROUPINGS = JSON.parse(req.body.GROUPINGS);
            var EMAIL = JSON.parse(req.body.EMAIL);
            var listID = config.mailchimp.list[0];

        mcApi.listSubscribe({
            id: listID,
            email_address:EMAIL,
            merge_vars: {
                "GROUPINGS": GROUPINGS},
                "double_optin": false,
                "update_existing":true
            },
            function (error, data) {
            if (error){
                res.end(JSON.stringify({"response":"error","test":false,"error":JSON.stringify(error)}));
            }
            else {
                res.end(JSON.stringify({"response":"success","test":true}));
            }
        });
        }catch(e){
            console.log(e.stack);
        }
    }
}
}).listen(listening);
console.log("server initialized on "+listening);