<?php							//https://api.twitter.com/1/users/profile_image/ TWITTER USERNAME
$arr=$_GET;
if(key_exists("url", $arr)){
if (strpos(mb_strtolower($arr["url"]),"lanyrd") === false){
	printOut('{"response":false, "data":false, "error":"lanyrd not in name"}');
	return;
}
$dom = new DOMDocument;
$data = file_get_contents($arr["url"]);
@$dom -> loadHTML($data);
$organisersOut = "";
$speakersOut = "";
$finder = new DomXPath($dom);
$classname = "people";
$nodes = $finder -> query("//ul[contains(@class, '$classname')]");
//returns domNodeList. All speakers lists and organisers lists are contained in <ul class="people">

foreach ($nodes as $key => $element) {
	if ($key < ($nodes -> length) - 1) {//get childnodes of elements.
		$LIarr = $element -> childNodes;
		foreach ($LIarr as $LIchild) {
			$speakersOut .= $element -> ownerDocument -> saveXML($LIchild);
			//everything before last must be speakers.
		}
	}
	if ($key == ($nodes -> length) - 1) {
		$LIarr = $element -> childNodes;
		foreach ($LIarr as $LIchild) {
			$organisersOut .= $element -> ownerDocument -> saveXML($LIchild);
			//everything before last must be speakers.
		}
	}
}
$toOutput = "";
if(sizeof(utf8_decode($speakersOut)) > 0){
$toOutput.='<div class="heads">Speakers</div>';
$toOutput.='<div class="fullwidth" id = "speakerField"><ul class="people">' . utf8_decode($speakersOut) . '</ul></div>';
}
if(sizeof(utf8_decode($organisersOut))>0){
	$toOutput.='<div class="heads">Organisers & Hosts</div>';
	$toOutput.='<div class="fullwidth" id = "organiserField"><ul class="people">' . utf8_decode($organisersOut) . '</ul></div>';
}
if(sizeof(utf8_decode($organisersOut))>0||sizeof(utf8_decode($speakersOut))>0){
	printOut('{"response":true, "data":'.json_encode(str_replace(array(PHP_EOL,"\t","\n","\r\n"), '', $toOutput)).'}');
}else{
	printOut('{"response":false, "data":false, "error":"no data returned."}');
}
}else{
	printOut('{"response":false, "data":false,"error":"no URL field"}');
}

function printOut($data) {
		$data = json_encode($data);
		if(array_key_exists('callback', $_GET)){
	
	    header('Content-Type: text/javascript; charset=utf8');
	    header('Access-Control-Allow-Origin: *');
	    header('Access-Control-Max-Age: 3628800');
	    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	
	    $callback = $_GET['callback'];
	    echo $callback.'('.$data.');';

	}else{
	    // normal JSON string
	    header('Content-Type: application/json; charset=utf8');
	
	    echo $data;
	}
return;
}


?>