var fs = require('fs');
var yaml = require('js-yaml');
var marked = require('marked');
var markdown = require( "markdown" ).markdown;

var parseMkdn = function(array,done){
  for(var i in array["markdown"]){
    console.log(array["markdown"][i]);
    var text = fs.readFileSync(array["markdown"][i],{"encoding":"utf-8"});
    text = text.split("----");
    var json = "{\"";
    for(var k in text){
      if(text[k].replace(/\s/g, "").length==0){
      console.log(text[k]);
       text.splice(k,1);
      }else{
        var toCheck = text[k].split(":")[0].replace(/\s/g,"").toLowerCase();
        if(toCheck=="text"){
          text[k] = "Text:"+markdown.toHTML(text[k].substring(7,text[k].length));
        }
        if(toCheck == "speakers"){
          text[k] = "Speakers:"+ markdown.toHTML(text[k].substring(11,text[k].length));
        }
      }
    }
    for(var k in text){
      text[k] = text[k].replace(/\r?\n|\r/g,"").replace(/\s/g, " ");
      text[k] = text[k].replace(/"/g,"\\\"");
      text[k] = text[k].replace(/:/,"\":\"");
      
//        console.log(k+","+text.length);
      
      if(k == text.length-1){
        console.log("STUFF");
  //      console.log(text[k]);
        json+=text[k];
      }else{
        console.log("OTHER");
        json+=text[k]+"\",\"";
      }
    }
    json+="\"}";
    //try{JSON.parse(json);}
    //catch(e){console.log(e); console.log(text);}
    json = JSON.parse(json);
    var js = {};
    for(var z in json){
      js[z.replace(/^\s\s*/, '').replace(/\s\s*$/, '').toLowerCase()] = json[z].replace(/^\s\s*/, '').replace(/\s\s*$/, ''); 
    }
    json = js;
    //console.log(json);
    var cherrypick = {"speakerID":"","series":0,"eventbriteid":"","venue":""};
    if(json.hasOwnProperty("title")){
      cherrypick["title"]=json["title"];
    }
    if(json.hasOwnProperty("map")){
      cherrypick["map"]=json["map"];
    }
    if(json.hasOwnProperty("cost")){
      cherrypick["cost"]=json["cost"];
    }
    if(json.hasOwnProperty("text")){
      cherrypick["text"]=json["text"];
    }
    if(json.hasOwnProperty("lanyrdapi")){
      cherrypick["lanyrdAPI"]=json["lanyrdapi"];
    }
    if(json.hasOwnProperty("lanyard")){
      cherrypick["lanyrd"]=json["lanyard"];
    }
    if(json.hasOwnProperty("lanyrd")){
      cherrypick["lanyrd"]=json["lanyrd"];
    }
    if(json.hasOwnProperty("booking_link")){
      cherrypick["booking_link"]=json["booking_link"];
    }
    if(json.hasOwnProperty("cost")){
      cherrypick["cost"]=json["cost"];
    }
    if(json.hasOwnProperty("blurb")){
      cherrypick["blurb"]=json["blurb"];
    }
    if(json.hasOwnProperty("date")){
      cherrypick["date"]=json["date"];
    }
    if(json.hasOwnProperty("end_date")){
      cherrypick["end_Date"]=json["end_date"];
    }
 //   console.log();
//    fs.writeFile("output/"+i+".json",JSON.stringify(cherrypick),console.log(i+" written!"));
        fs.writeFile("output/"+array["markdown"][i].split("/").pop().split(".")[0]+".yaml",yaml.safeDump(cherrypick),console.log(i+" written as yaml!"));
//console.log(json);
//console.log(JSON.parse(json));
//    console.log(markdown.parse(text));
//console.log(marked.lexer(text,{}));
//console.log(yaml.load(text));
    if(i == array["markdown"].length-1){
      done("woop woop!");
    }
  }
};
var walk = function(dir, done) {
  var results = {"markdown":[],"images":[]};
  fs.readdir(dir, function(err, list) {
    if (err) return done(err);
    var pending = list.length;
    if (!pending) return done(null, results);
    list.forEach(function(file) {
      file = dir + '/' + file;
      fs.stat(file, function(err, stat) {
        if (stat && stat.isDirectory()) {
          walk(file, function(err, res) {
            results["markdown"] = results["markdown"].concat(res["markdown"]);
            results["images"] = results["images"].concat(res["images"]);
            if (!--pending) done(null, results);
          });
        } else {
          if(file.split(".")[1]=="txt"){
            results["markdown"].push(file);
          }else{
            results["images"].push(file);
          }
          if (!--pending) done(null, results);
        }
      });
    });
  });
};

walk("samples",function(err, results) {
  if (err) throw err;
  parseMkdn(results,function(res){
    console.log(res);
  });
});
