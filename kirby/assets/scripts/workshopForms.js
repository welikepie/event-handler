	var emailAddress;
	var elementBeingCalled;
	var formUrl;
	var sourceOfActionUnder;
	var sourceOfActionDashed;
	function onClose(){
		$('.popover').fadeTo(750,0, function () {
			$('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide');
			$(".popover").remove();
			});

	}
	
	function onInterested(thisId) {
		//label clicked's ID; title with dashes
		sourceOfActionUnder = thisId.replace(/-/gi, '_');
		sourceOfActionDashed = thisId;
		$('#' + thisId).popover({
				animation : true,
				html : true,
				trigger : 'manual',
				placement : 'bottom'
				});

		if (emailAddress) {
			if (document.getElementById(thisId).innerHTML != "Subscribed") {
				document.getElementById("EMAIL" + thisId.replace(/-/gi, '_')).value = emailAddress;
				$('#' + thisId).attr("data-content",  document.getElementById("THANKS2"+thisId.replace(/-/gi, '_')).innerHTML );
				$('#' + thisId).popover('show');
				$('.popover').fadeTo(250,1, function () {});
				document.getElementById("FORM" + thisId.replace(/-/gi, '_')).submit();
				document.getElementById(thisId).className = "rightFormChecked";
				document.getElementById(thisId).innerHTML = "<div>Subscribed</div>";
				$('.popover').delay(3000).fadeTo(750,0, function () {
					$('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide');  
					$(".popover").remove();
	
				});
			}
		}
		if (!emailAddress) {
			$('#' + thisId).attr("data-content",document.getElementById(thisId.replace(/-/gi, '_')).innerHTML);
			$('#'+thisId).popover('show');
			$('.popover').fadeTo(250,1, function () {});

//			document.getElementsByClassName("popover fade top in").Id = 'POPOVER'.thisId;
		}

	}

	function onSubmit(parentId) {
		//title of event with underscores, is form container id
		//underscores with error, EMAIL, Submit and FORM pre-appended,
		//emailAddress = document.getElementById("EMAIL"+parentId).value;
		$('#' + parentId.replace(/_/gi, '-')).popover('hide');
		$('#' + parentId.replace(/_/gi,'-')).attr("data-content", document.getElementById("THANKS"+parentId).innerHTML);
		$('#' + parentId.replace(/_/gi, '-')).popover('show');
		document.getElementById(parentId.replace(/_/gi, '-')).className = "rightFormChecked";
		document.getElementById(parentId.replace(/_/gi, '-')).innerHTML = "Subscribed";
		$('.popover').delay(3000).fadeTo(750,0, function () {
			$('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide');
			$(".popover").remove();
		});
	}

	function formsubmit(sourceElement) {
		//sourceElement contains underscores.
		sourceElement = sourceElement.substring(4);
		//gets form duplicate in hidden html and deletes it so this all works properly.
		var sourceElementReplacer = document.getElementById(sourceElement).innerHTML;
		document.getElementById(sourceElement).innerHTML = "";
		var x = document.getElementById("EMAIL" + sourceElement).value;
		
		if(x===null||x===""){
			document.getElementById("ERROR" + sourceElement).innerHTML = "<div class = \"boxLeftEmpty\">" + "<div class = \"text\"><strong>Whoops!</strong> You forgot to type in your email address. " + "</div></div> ";
			document.getElementById(sourceElement).innerHTML = sourceElementReplacer;
			return false;
		}
		if (x.indexOf("@") == -1 || x.indexOf(".") == -1 || (x.indexOf("@") == -1 && (x.indexOf(".") == -1)) || (x.indexOf("@") >= x.lastIndexOf("."))) {
			document.getElementById("ERROR" + sourceElement).innerHTML = "<div class = \"boxLeftEmpty\">" + "<div class = \"text\"><strong>Whoops!</strong> It seems you've given us an incorrect email. Could you type it again? " + "</div></div> ";
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
