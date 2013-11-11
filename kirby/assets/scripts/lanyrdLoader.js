var lanyrdEls = $(".lanyrd_speakers");
for(var i = 0; i < lanyrdEls.length; i++){
	populate(lanyrdEls[i],$(lanyrdEls[i]).data("lanyrdapi"));
}
function populate(el,url){
$.ajax({
			method:"GET",
			url:url,
			crossDomain:true,
			dataType:"jsonp",
			success:function(response){
				createDom(response.speakers, el);
			}
		})
}

function createDom(input, element){
	if(input.length>0){
		var topDiv = document.createElement("div");
		topDiv.innerHTML = "Speakers";
		topDiv.className = "heads";
		element.appendChild(topDiv);
		var speakDiv = document.createElement("div");
		speakDiv.className="fullwidth speakerDiv";
		
		var ulList = document.createElement("ul");
		ulList.className = "people";
		speakDiv.appendChild(ulList);
		for(var i = 0; i < input.length; i++){
			var li = document.createElement("li");
			var div = document.createElement("div");
			div.className="avatar avatar-med";
			if(input[i].twitter!=undefined){
			var link = document.createElement("a");
			link.href = "http://www.twitter.com/"+input[i].twitter.substring(1,input[i].twitter.length);
			div.appendChild(link);
			}
			var image = document.createElement("img");
			image.src=input[i].image_75;
			
			if(input[i].twitter!=undefined){
			link.appendChild(image);
			}else{
			div.appendChild(image);	
			}
			var span = document.createElement("span");
			span.className="name";
			if(input[i].twitter!=undefined){
				//add link to person's name 
				var twitLink = document.createElement("a");
				twitLink.href = "http://www.twitter.com/"+input[i].twitter.substring(1,input[i].twitter.length);
				twitLink.innerHTML = input[i].name;
				span.appendChild(twitLink);
				div.appendChild(link);
			}
			else{
				span.innerHTML = input[i].name;
			}
			li.appendChild(div);
			li.appendChild(span);
			ulList.appendChild(li);
			
		}
		element.appendChild(speakDiv);
		sortThrough(speakDiv);
	}
}
