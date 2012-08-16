		<footer>
			<!--<?php echo kirbytext($site->copyright()) ?>-->
		</footer>
	</body>
	<?php
	if (isset($bottom_scripts))
		foreach ($bottom_scripts as &$script)
			echo('<script type="text/javascript" src="' . $script . '"></script>');
	if (isset($bottom_snippets))
		foreach ($bottom_snippets as &$snippet)
			echo('<script type="text/javascript">' . $snippet . '</script>');
	?>
	
<script src="assets/scripts/jQuery1-8-0.js"></script>
<script src="assets/scripts/bootstrap-tooltip.js"></script>
<script src="assets/scripts/bootstrap-popover.js"></script>
<script type="text/javascript">

var emailAddress;
var elementBeingCalled;
var formUrl;

function onInterested(thisId){
//label clicked's ID; title with dashes
//Myvar = document.getElementById(thisId.replace(/-/gi,'_')).innerHTML;

 
 
 
	console.log("onInterest:"+thisId);
	console.log(emailAddress);
	
	
	if(emailAddress){
		if(document.getElementById(thisId).innerHTML!="Subscribed"){
		console.log("Email set");
		document.getElementById("MERGE0"+thisId.replace(/-/gi,'_')).value = emailAddress;
		console.log(emailAddress);
		document.getElementById("FORM"+thisId.replace(/-/gi,'_')).submit();
		document.getElementById(thisId).className = "rightFormChecked";
		document.getElementById(thisId).innerHTML = "Subscribed";
		}
	}
	
	if(!emailAddress){
 $('#'+thisId).popover({
 		animation: true,
        html: true,
        trigger: 'manual',
        placement: 'top'
   });					
$('#'+thisId).attr("data-content", '<div id="'+thisId.replace(/-/gi,'_')+'">'+document.getElementById(thisId.replace(/-/gi,'_')).innerHTML+'</div>' );       
    $('#'+thisId).popover('show');


	}

	
}

function onSubmit(parentId){
//title of event with underscores, is form container id
//underscores with error, MERGE0, Submit and FORM pre-appended, 
emailAddress = document.getElementById("MERGE0"+parentId).value;
$('#'+parentId.replace(/_/gi,'-')).popover('hide');
console.log(parentId.replace(/_/gi,'-'));
document.getElementById(parentId.replace(/_/gi,'-')).className = "rightFormChecked";
document.getElementById(parentId.replace(/_/gi,'-')).innerHTML = "Subscribed";
console.log("onSubmit:"+parentId);
	console.log("Email:"+emailAddress);
	console.log(document.getElementById(parentId.replace(/_/gi,'-')).value	);

//	document.getElementById(parentId).className = "hiddenMailSubscribe";
//make form disappear

}

function formsubmit(sourceElement) {
console.log("formSubmit"+sourceElement);
//gets form duplicate in hidden html and deletes it so this all works properly.
  document.getElementById(thisId.replace(/-/gi,'_')).innerHTML = "";

	var x=document.getElementById("MERGE0"+sourceElement).value;
console.log(x);
	if (x.indexOf("@") == -1 || x.indexOf(".") == -1 || (x.indexOf("@") == -1 && (x.indexOf(".") == -1)) || (x.indexOf("@") >= x.indexOf(".")) )
	  { 
	  	console.log("falsed");
/*console.log(x.indexOf("@"));
console.log(x.indexOf("."));
*/

document.getElementById("ERROR"+sourceElement).innerHTML = 
 "<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong>  Oh dear, it seems you forgot to tell us your email address. Please type that in and submit the form again. "+		
		"</div></div> " ;
	  return false;
	  }

	if ((x.indexOf(".") != -1 && x.indexOf("@") != -1) && ( x.indexOf("@") <= x.indexOf(".") ) )
	  {
	  	console.log("trued"); 
		document.getElementById("ERROR"+sourceElement).innerHTML = "" ;
		onSubmit(sourceElement);
	  return true;
	  }
return false;
}

</script>
</html>
