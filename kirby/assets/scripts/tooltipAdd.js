var links = $(".button");
var falseLinks = ["eventhandler"];
for (var i = 0; i < links.length; i++) {
	if (links[i] != undefined) {
		if (links[i].getAttribute('href') == null || links[i].getAttribute('href') == undefined) {
			break;
		}
		var falsehood = false;
		for (var j = 0; j < falseLinks.length; j++) {
			if (links[i].getAttribute('href').substr(7).indexOf(falseLinks[j]) != -1) {
				falsehood = true;
			}
		}
		if (falsehood == false) {
			console.log(links[i].offsetTop);
			links[i].parentNode.setAttribute('rel', 'tooltip');
			links[i].parentNode.setAttribute('data-original-title', links[i].getAttribute('href').substr(7));
		}
	}
}