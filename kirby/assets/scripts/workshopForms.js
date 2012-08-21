	var emailAddress;
	var elementBeingCalled;
	var formUrl;

	function onInterested(thisId) {
		//label clicked's ID; title with dashes
		$('#' + thisId).popover({
				animation : true,
				html : true,
				trigger : 'manual',
				placement : 'top'
				});

		if (emailAddress) {
			if (document.getElementById(thisId).innerHTML != "Subscribed") {
				document.getElementById("EMAIL" + thisId.replace(/-/gi, '_')).value = emailAddress;
				$('#' + thisId).attr("data-content", '<div id="' + thisId.replace(/-/gi, '_') + '">' + document.getElementById("THANKS2"+thisId.replace(/-/gi, '_')).innerHTML + '</div>');
				$('#' + thisId).popover('show');
				$('.popover').fadeIn("slow", function(){});
				document.getElementById("FORM" + thisId.replace(/-/gi, '_')).submit();
				document.getElementById(thisId).className = "rightFormChecked";
				document.getElementById(thisId).innerHTML = "<div>Subscribed</div>";
				$('.popover').delay(2000).fadeToggle("slow", function () { $('#'.thisId).popover('hide'); });
			}
		}
		if (!emailAddress) {
			$('#' + thisId).attr("data-content", '<div id="' + thisId.replace(/-/gi, '_') + '">' + document.getElementById(thisId.replace(/-/gi, '_')).innerHTML + '</div>');
			$('#'+thisId).popover('show');
			$('.popover').fadeIn('slow', function () {}); 

//			document.getElementsByClassName("popover fade top in").Id = 'POPOVER'.thisId;
		}

	}

	function onSubmit(parentId) {
		//title of event with underscores, is form container id
		//underscores with error, EMAIL, Submit and FORM pre-appended,
		//emailAddress = document.getElementById("EMAIL"+parentId).value;
		$('#' + parentId.replace(/_/gi, '-')).popover('hide');
		$('#' + parentId.replace(/_/gi,'-')).attr("data-content", '<div id="' + parentId + '">'+document.getElementById("THANKS"+parentId).innerHTML+ '</div>');
		$('#' + parentId.replace(/_/gi, '-')).popover('show');
		$('.popover').delay(2000).fadeToggle("slow", function () { $('#' + parentId.replace(/_/gi, '-')).popover('hide'); });
		document.getElementById(parentId.replace(/_/gi, '-')).className = "rightFormChecked";
		document.getElementById(parentId.replace(/_/gi, '-')).innerHTML = "Subscribed";
	}

	function formsubmit(sourceElement) {
		sourceElement = sourceElement.substring(4);
		//gets form duplicate in hidden html and deletes it so this all works properly.
		var sourceElementReplacer = document.getElementById(sourceElement).innerHTML;
		document.getElementById(sourceElement).innerHTML = "";
		var x = document.getElementById("EMAIL" + sourceElement).value;
		if (x.indexOf("@") == -1 || x.indexOf(".") == -1 || (x.indexOf("@") == -1 && (x.indexOf(".") == -1)) || (x.indexOf("@") >= x.lastIndexOf("."))) {
			document.getElementById("ERROR" + sourceElement).innerHTML = "<div class = \"boxLeftEmpty\">" + "<div class = \"text\"><strong>Warning!</strong>  Oh dear, it seems you forgot to tell us your email address. Please type that in and submit the form again. " + "</div></div> ";
			document.getElementById(sourceElement).innerHTML = sourceElementReplacer;
			return false;
		}

		if ((x.indexOf(".") != -1 && x.indexOf("@") != -1) && (x.indexOf("@") <= x.lastIndexOf(".") )) {
			document.getElementById("ERROR" + sourceElement).innerHTML = "";
			emailAddress = document.getElementById("EMAIL" + sourceElement).value;
			onSubmit(sourceElement);
			return true;
		}
			document.getElementById(sourceElement).innerHTML = sourceElementReplacer;
		return false;
	}
