var http = require('http'),
      fs = require('fs'),
     url = require('url'),
     mysql = require('mysql'),
     listening = 2399,
     config = require('./config'),
     queryString = require( 'querystring' ),
     contenttypes = ["json","jsonp","application/x-www-form-urlencoded"],
     responseheader = {'Access-Control-Allow-Origin':'*',"Content-Type": "json"};

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
        response.writeHead(403, responseheader);
        response.end(JSON.stringify({"status":"error","error":"GET requests are not allowed to this server."}));
    }
    else{
    var jsondata;
    var path = url.parse(request.url).pathname;
        var body = '';
        request.on('data', function (data) {
            body += data;
        });
        request.on('end', function () {
            try{
                if(request.headers["host"].toLowerCase().indexOf("localhost")==-1){
                    response.writeHead(200, responseheader);
                    response.end(JSON.stringify({"status":"error","error":"Request does not originate from a website hosted on this server."}));
                }
                else if(contenttypes.indexOf(request.headers["content-type"].toLowerCase())==-1){
                    response.writeHead(200, responseheader);
                    response.end(JSON.stringify({"status":"error","error":"Request does not have the correct content type specified."}));
                }
                console.log("Body: " + body);
                if(contenttypes.indexOf(request.headers["content-type"].toLowerCase())==2){
                    jsondata = queryString.parse(body);
                }else{
                    jsondata = JSON.parse(body);
                }
                console.log(jsondata);
                if(path=="/writetodb"){
                    writeToDb(jsondata);
                }
                else if(path == "/mailchimp"){
                     mailchimp(jsondata);
                }
            }
            catch(e){
                response.writeHead(200, {'Content-Type': 'json'});
                response.end(JSON.stringify({'Access-Control-Allow-Origin':'*',"status":"error","error":JSON.stringify(e)}));
            }
        });
        response.writeHead(200, responseheader);
        response.end(JSON.stringify({"status":"success"}));
}
}).listen(listening);
console.log("server initialized on "+listening);

function writeToDb(inputs){
    /*config.mysql.connection.query(
    ''//'INSERT INTO content SET ? ON DUPLICATE KEY UPDATE hashtag = ?, id = ?, text = ?, user = ?,name = ?, userIMG = ?, time = ?, link = ?, img_large = ?, img_med = ?, img_small = ?, lat = ?, lon = ?'
    , 
    [send, send.hashtag, send.id, send.text, send.user, send.name, send.userIMG, send.time, send.link, send.img_large, send.img_med, send.img_small, send.lat, send.lon], 
        function(err, result) {
            if (err != null) {
                console.log(result);
                }
            });*/
    console.log("POST");
    console.log(inputs);
//        console.log("string sent");
}

function mailchimp(inputs){
    console.log(inputs);
    response.writeHead(200, {'Content-Type': 'json', 'Access-Control-Allow-Origin':'*'});
    try{
        var GROUPINGS = JSON.parse(inputs.GROUPINGS);
        var EMAIL = JSON.parse(inputs.EMAIL);
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
                response.end(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(error)}));
            }
            else {
                response.end(JSON.stringify({"status":"success","test":true}));
            }
        });
    }catch(e){
        response.end(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(e)}));
        console.log(e.stack);
    }
}