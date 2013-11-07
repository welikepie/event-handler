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