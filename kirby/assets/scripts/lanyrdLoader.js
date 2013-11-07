var lanyrdEls = document.getElementsByClassName("lanyrd_speakers");
for(var i = 0; i < lanyrdEls.length; i++){
	populate(lanyrdEls[i],$(lanyrdEls[i]).data("lanyrd"));
}
function populate(el,url){
	if(url.charAt(url.length-1)!="/"){
		url+="/";
	}
		console.log(url);
$.ajax({
			method:"GET",
			url:"/assets/serverside/getLanyrd.php",
			contentType:"json",
			data:"url="+url,
			success:function(response){
			//	console.log(response);
			el.innerHTML = JSON.parse(response).data;
			sortThrough(el);
			}
		})
}
/*
								echo('<div class="heads">Speakers</div>');
								echo (('<div class="fullwidth" id = "speakerField"><ul class="people">'.utf8_decode($speakersOut).'</ul></div>')); 
								echo('<div class="heads">Organisers & Hosts</div>');
								echo(('<div class="fullwidth" id = "organiserField"><ul class="people">'.utf8_decode($organisersOut).'</ul></div>'));

//ini_set("display_errors","1");
						//ERROR_REPORTING(E_ALL);
						if ($event -> lanyard()) {
							//https://api.twitter.com/1/users/profile_image/ TWITTER USERNAME
							$data = file_get_contents($event -> lanyard());
							$dom = new DOMDocument;
							@$dom -> loadHTML($data);
							$organisersOut = "";
							$speakersOut = "";
							$finder = new DomXPath($dom);
							$classname="people";
							$nodes = $finder->query("//ul[contains(@class, '$classname')]"); 
							//returns domNodeList. All speakers lists and organisers lists are contained in <ul class="people">
							
							foreach($nodes as $key => $element)
							{
								if($key < ($nodes -> length)-1){ //get childnodes of elements.
								$LIarr = $element->childNodes;
									foreach($LIarr as $LIchild){
										$speakersOut .= $element->ownerDocument->saveXML($LIchild); //everything before last must be speakers.
									}
								}			
								if($key == ($nodes -> length)-1){
								$LIarr = $element->childNodes;
									foreach($LIarr as $LIchild){
										$organisersOut .= $element->ownerDocument->saveXML($LIchild); //everything before last must be speakers.
									}	
								}
							}
							echo('<div class="lanyrd_speakers"></div>');
						}
*/