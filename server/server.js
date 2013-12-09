var http = require('http'),
      fs = require('fs'),
     url = require('url'),
     mysql = require('mysql'),
     listening = 2399,
     config = require('./config'),
     queryString = require( 'querystring' ),
     contenttypes = ["application/json","application/jsonp","application/x-www-form-urlencoded"],
     responseheader = {'Access-Control-Allow-Origin':'*','Content-Type': 'json'};

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
    console.log(request.method.toLowerCase());
    if(request.method.toLowerCase() != "post")
    {
        if(request.method.toLowerCase()== "options"){
                 console.log('!OPTIONS');
      var headers = {};
      // IE8 does not allow domains to be specified, just the *
      // headers["Access-Control-Allow-Origin"] = req.headers.origin;
      headers["Access-Control-Allow-Origin"] = "*";
      headers["Access-Control-Allow-Methods"] = "POST, OPTIONS";
      headers["Access-Control-Allow-Credentials"] = false;
      headers["Access-Control-Max-Age"] = '86400'; // 24 hours
      headers["Access-Control-Allow-Headers"] = "X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept";
      response.writeHead(200, headers);
      response.end();
         }

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
                else if(stringcontainsarray(contenttypes,request.headers["content-type"].toLowerCase()) == false){
                    response.writeHead(200, responseheader);
                    response.end(JSON.stringify({"status":"error","error":"Request does not have the correct content type specified."}));
                }
                console.log("Body: " + body);
                if(contenttypes.indexOf(request.headers["content-type"].toLowerCase())==2){
                    jsondata = queryString.parse(body);
                }else{
                    jsondata = JSON.parse(body);
                }
                console.log(path == "/mailchimp");

                if(path=="/writetodb"){
                    response.writeHead(200,responseheader);
                    writeToDb(jsondata,function(input){console.log(input); response.end(input);});
                }
                if(path == "/mailchimp"){
                     response.writeHead(200,responseheader);
                     mailchimp(jsondata,function(input){console.log(input); response.end(input);});
                }
            }
            catch(e){
                response.writeHead(200, responseheader);
                response.end(JSON.stringify({"status":"error","error":JSON.stringify(e)}));
            }
        });
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

function mailchimp(inputs, callback){
    try{
        var GROUPINGS = inputs.GROUPINGS;
        var EMAIL = inputs.EMAIL;
        var listID = config.mailchimp.list[0];
        var groupString = "";
        console.log(EMAIL);
        for(var x in GROUPINGS){
            if(GROUPINGS.hasOwnProperty(x)){
                (GROUPINGS[x]==true)? GROUPINGS[x]="Subscribe" : GROUPINGS[x]="Don't Subscribe";
            }
        }

        mcApi.listSubscribe({
            id: listID,
            email_address:EMAIL,
            merge_vars: GROUPINGS,
                "double_optin": false,
                "update_existing":true
            },
            function (error, data) {
                 console.log(error);
                if (error){
                    callback(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(error)}));
                }
                else {
                    callback(JSON.stringify({"status":"success","test":true}));
                }
            });
    }catch(e){
        callback(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(e)}));
    }
}

function stringcontainsarray(array,string){
    for(var i = 0; i < array.length; i++){
        if(string.indexOf(array[i])>-1){
            return true;
        }
    }
    return false;
}