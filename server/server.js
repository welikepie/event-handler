var http = require('http'),
      fs = require('fs'),
     url = require('url'),
     mysql = require('mysql'),
     async = require('async'),
     MailChimpAPI = require('mailchimp').MailChimpAPI,
     Eventbrite = require('eventbrite'),
     listening = 2399,
     pollTime = 120000,
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
           if(wlpapiverify(request,
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
                if(path=="/writetodb"){
                    response.writeHead(200,responseheader);
                    console.log(input);
                    writeToDb(jsondata,function(input){console.log(input);
                            response.end(input);
                            //config.mysql.connection.end();
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
                    if(wlpapiverify(request,function(){
                        updatespeaker(jsondata,function(input){console.log(input); response.end(input);});}
                    ) == false){
                         response.writeHead(403, responseheader);
                       response.end(JSON.stringify({"status":"error","error":"this request is not allowed to this server."}));
                    }
                }
              
                else if(path == "/getevbdata"){
                    console.log("GOTHERE");
                    response.writeHead(200,responseheader);
                    if(wlpapiverify(request,function(){
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
        "only_display":"id",
        "event_statuses":"live",
    },function(error,data){
        if(!error){
            for(var i in data["events"]){
                idarr.push(data["events"][i]["event"]["id"]);
            }
            async.each(idarr,function(item,callback){
                eb_client.event_get( {'id': item }, function(err, data){
                    if(err){
                        dataarr[item] = "undefined";
                        callback(null);
                    }
                    else{
                        try{
                            var spaceleft = data.event.capacity - data.event.num_attendee_rows;
                            if(spaceleft < 0){
                                spaceleft = 0;
                            }
                            var percentage = Math.ceil((data.event.num_attendee_rows/data.event.capacity * 100))
                            if(percentage > 100){
                                percentage = 100;
                            }
                            dataarr[item] = {"spaceleft":spaceleft,"max":data.event.capacity,"current":data.event.num_attendee_rows,"percent":(percentage/100)};
                            callback(null);
                        }
                        catch(e){
                            dataarr[item] = "undefined";
                            callback(null);
                        }
                    }
                   // console.log( countdown_widget_html + ticket_widget_html );
                });
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

function wlpapiverify(request,callback){
     if(request.headers["X-WLPAPI"] !== undefined || request.headers["x-wlpapi"]!==undefined){
            var headerval;
            if(request.headers["X-WLPAPI"] !== undefined){
                headerval = request.headers["X-WLPAPI"];
            }else{
                headerval = request.headers["x-wlpapi"];
            }
            if(config.verify(headerval)==true){
                callback();
            }else{
                return false;
            }
            }
            else{
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