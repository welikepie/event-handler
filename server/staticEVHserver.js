var http = require('http'),
      fs = require('fs'),
     url = require('url'),
     mysql = require('mysql'),
     async = require('async'),
     MailChimpAPI = require('mailchimp').MailChimpAPI,
     Eventbrite = require('eventbrite'),
     listening = 2399,
     pollTime = 15 * 60 * 1000,
     config = require('./config'),
     queryString = require( 'querystring' ),
     contenttypes = ["application/json","application/jsonp","application/x-www-form-urlencoded"],
     responseheader = {'Access-Control-Allow-Origin':'*','Content-Type': 'json'},
     eb_client = Eventbrite({'app_key':config.eventbrite.api, 'user_key':config.eventbrite.user}),
     mcApi = new MailChimpAPI(config.mailchimp.api, { version : '1.3', secure : false }),
     listID = config.mailchimp.list,
     eventscontent = getevbdata();
try{
    config.mysql.connection.connect();
}
catch(error){
    console.log(error);
}

http.createServer(function(request, response){
     var path = url.parse(request.url).pathname;
    console.log(request.method.toLowerCase());
    if(request.method.toLowerCase() != "post")
    {
        if(request.method.toLowerCase()== "options"){
      var headers = {};
      // IE8 does not allow domains to be specified, just the *
      // headers["Access-Control-Allow-Origin"] = req.headers.origin;
      headers["Access-Control-Allow-Origin"] = "*";
      headers["Access-Control-Allow-Methods"] = "POST, OPTIONS";
      headers["Access-Control-Allow-Credentials"] = false;
      headers["Access-Control-Max-Age"] = '86400'; // 24 hours
      headers["Access-Control-Allow-Headers"] = "X-WLPAPI, X-Requested-With, X-HTTP-Method-Override, Content-Type, Accept";
      response.writeHead(200, headers);
      response.end();
         }
         if(path == "/speaker"){
           if(wlpapiverify(request,{},
           function(){
                config.mysql.connection.query('SELECT `order`, UNIX_TIMESTAMP(date) as date, name, contactinfo, association, why, what, style, length, links, lanyrd, subjects, checkedout, comments from speakerform', function(err, rows, fields) {
                  if (err) throw err;
                  response.writeHead(200,responseheader);
                  response.end(JSON.stringify({"status":"success","data":rows}));
                });
            }
       ) == false){
                       response.writeHead(403, responseheader);
               response.end(JSON.stringify({"status":"error","error":"this request is not allowed to this server."}));
           }
         }else{
        response.writeHead(403, responseheader);
        response.end(JSON.stringify({"status":"error","error":"this GET request is not allowed to this server."}));
        }
    }
    else{
    var jsondata;
   
        var body = '';
        request.on('data', function (data) {
            body += data;
        });
        request.on('end', function () {
            try{
                /*if(request.headers["host"].toLowerCase().indexOf("localhost")==-1){
                    response.writeHead(200, responseheader);
                    response.end(JSON.stringify({"status":"error","error":"Request does not originate from a website hosted on this server."}));
                }*/
                var served = JSON.parse(body);
                console.log(body);
                try{
                    served = request.headers["content-type"].toLowerCase();
                }
                catch(e){
                    for(var i in served){
                        if(served.hasOwnProperty(i)){
                            console.log(i);
                            if(i.toLowerCase()=="content-type"){
                                served = served[i];
                            }
                        }
                    }
                }
                if(stringcontainsarray(contenttypes,served) == false){
                    response.writeHead(200, responseheader);
                    response.end(JSON.stringify({"status":"error","error":"Request does not have the correct content type specified."}));
                }
                console.log("Body: " + body);
                console.log(served);
                console.log(contenttypes.indexOf(served));
                if(contenttypes.indexOf(served)==2){
                    console.log("FORSOMEREASONQUERYSTRINGWAT?")
                    jsondata = queryString.parse(body);
                }else{
console.log("JSONPARSINGHERE");
                    console.log(body);
                    jsondata = JSON.parse(body);
                }
                if(path=="/writetodb"){
                    response.writeHead(200,responseheader);
                    console.log(input);
                    writeToDb(jsondata,function(input){console.log(input);
                            response.end(input);
                        });
                }
                else if(path == "/writespeakerform"){
                    response.writeHead(200,responseheader);
                    writeToSpeakerTable(jsondata,function(input){console.log(input);
                            response.end(input);
                        //config.mysql.connection.end();
                        });
                }
                else if(path == "/mailchimp"){
                     response.writeHead(200,responseheader);
                     console.log(jsondata);
                     mailchimp(jsondata,function(input){console.log(input); response.end(input);});
                }
                else if(path == "/updatespeaker"){
                    response.writeHead(200,responseheader);
                    if(wlpapiverify(request,jsondata,function(){
                        updatespeaker(jsondata,function(input){console.log(input); response.end(input);});}
                    ) == false){
                         response.writeHead(403, responseheader);
                       response.end(JSON.stringify({"status":"error","error":"this request is not allowed to this server."}));
                    }
                }
              
                else if(path == "/getevbdata"){
                    console.log("GOTHERE");
                    response.writeHead(200,responseheader);
                    if(wlpapiverify(request,jsondata,function(){
                        console.log("stuff");
                        console.log(eventscontent);
                        if(eventscontent!=undefined){
                            response.end(JSON.stringify(eventscontent));
                        }
                        else{
                            response.end(JSON.stringify(
                                    {"timestamp":Date.now(),
                                    "status":"error",
                                    "test":false,
                                    "result":"Data not returned yet. Please refresh the page!",
                                    "data":"Our server is just starting. Please refresh the page!"
                                    }
                                ));
                        }
                        }
                    ) == false){
                        response.writeHead(403, responseheader);
                        response.end(JSON.stringify({"status":"error","error":"this request is not allowed to this server."}));
                    }
                }
            }
            catch(e){
                console.log(e.stack);
                response.writeHead(200, responseheader);
                response.end(JSON.stringify({"status":"error","error":JSON.stringify(e)}));
            }
        });
}
}).listen(listening);
console.log("server initialized on "+listening);
setInterval(getevbdata,pollTime);
console.log("Intermittent EventBrite data polling set to "+(pollTime/1000/60)+" minutes and started.");

function getevbdata(){//,callback){
    var idarr = [];
    var dataarr = {};

    eb_client.user_list_events({"user":config.eventbrite.username,
        "event_statuses":"live",
        "do_not_display":"decription"
    },function(error,data){
        if(!error){
            idarr = data["events"];
            async.each(idarr,function(item,callback){
                        try{
                            var spaceleft = item.event.capacity - item.event.num_attendee_rows;
                            if(spaceleft < 0){
                                spaceleft = 0;
                            }
                            var percentage = Math.ceil((item.event.num_attendee_rows/item.event.capacity * 100))
                            if(percentage > 100){
                                percentage = 100;
                            }
                            dataarr[item["event"]["id"]] = {"spaceleft":spaceleft,"max":item.event.capacity,"current":item.event.num_attendee_rows,"percent":(percentage/100)};
                            callback(null);
                        }
                        catch(e){
                            dataarr[item["event"]["id"]] = "undefined";
                            callback(null);
                        }
                
            },function(error){
                if(error!=null){
                    console.error("ALERT: EVENTBRITE DATA RETRIEVAL FAILED AT "+Date.now()+" .");
                    console.log("----------");
                    console.log(error);
                    console.log("----------");
                }else{
                    eventscontent = {"timestamp":Date.now(),"status":"success","test":true,"result":"All queries completed successfully.","data":JSON.stringify(dataarr)};
                }       
            });
        }else{
            console.error("ALERT: EVENTBRITE USER EVENT DATA RETRIEVAL FAILED AT "+Date.now()+" .");
            console.log("----------");
            console.log(error);
            console.log("----------");
        }
    });
}

function updatespeaker(inputs,callback){
    var errors = [];
    var objs = [];
    for(var each in inputs){
        objs.push(inputs[each]);
    }
    console.log(objs);
    async.each(objs,function(item,callback){
        var order = item.order;
        delete item.order;
    config.mysql.connection.query(
        'UPDATE speakerform SET ? WHERE `order`= ?',[item,parseInt(order,10)],
            function(err,result){
                if(err){
                    callback(err);
                }else{
                    callback(null);
                }
            }
        );
    },function(error){
        if(error!=null){
            callback(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(error)}));
        }else{
            callback(JSON.stringify({"status":"success","test":true,"result":"All queries completed successfully."}));
        }
    });

}


function writeToDb(inputs,callback){
    console.log("POST");
    console.log(inputs);
    //design social development
    (inputs.design == "true")?inputs.design=1:inputs.design=0;
    (inputs.social == "true")?inputs.design=1:inputs.design=0;
    (inputs.development == "true")?inputs.design=1:inputs.design=0;

    config.mysql.connection.query(
    'INSERT INTO new_table SET ? ON DUPLICATE KEY UPDATE Email = ?, Design = ?, Social = ?, Development = ?',[inputs, inputs.email, inputs.design, inputs.social, inputs.development],
        function(err, result) {
                console.log(err);
                if (err){
                    callback(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(err)}));
                }
                else {
                    callback(JSON.stringify({"status":"success","test":true,"result":JSON.stringify(result)}));
                }

            });
//        console.log("string sent");
}

function writeToSpeakerTable(inputs,callback){
    console.log("POST");
    console.log(inputs);
    //design social development
    inputs.date = new Date();
    config.mysql.connection.query(
    'INSERT INTO speakerform SET ? ',[inputs],
        function(err, result) {
                console.log(err);
                if (err){
                    callback(JSON.stringify({"status":"error","test":false,"error":JSON.stringify(err)}));
                }
                else {
                    callback(JSON.stringify({"status":"success","test":true,"result":JSON.stringify(result)}));
                }
            });
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

function wlpapiverify(request,data,callback){
    var d = {};
    try{
        d = JSON.parse(data);
    }catch(e){
        d = data;
    }
     if(request.headers["X-WLPAPI"] !== undefined || request.headers["x-wlpapi"]!==undefined || d.hasOwnProperty("nocors")){
            var headerval;
            if(request.headers["X-WLPAPI"] !== undefined){
                headerval = request.headers["X-WLPAPI"];
            }else if(request.headers["x-wlpapi"]!==undefined){
                headerval = request.headers["x-wlpapi"];
            }else if(d.hasOwnProperty("X-WLPAPI")){
                headerval = d["X-WLPAPI"];
            }else{
                headerval = d["x-wlpapi"];
            }
            if(config.verify(headerval)==true){
                callback();
            }else{
                return false;
            }
    }
     else{
        console.log(data);
        return false;
    }
}


function jsonlength(data){
        var count = 0;
        for(var key in data){
            if(data.hasOwnProperty(key)){
                count++;
            }
        }
        return count;
    }