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
<!--contactSpeaker, speaker, form name  -->
entry.1.single, entry.0.single , 
<script type="text/javascript">

function formsubmit() {

	var x=document.forms["mc-embedded-subscribe-form"]["EMAIL"].value;
	

	if (x==null || x=="")
	  { 
		document.getElementById("emailMissing").innerHTML = 
 "<div class = \"boxLeftEmpty bottomShove\">"+
			"<div class = \"text\"><strong>Warning!</strong>  Oh dear, it seems you forgot to tell us your email address. Please type that in and submit the form again. "+		
		"</div></div> " ;
				
	  return false;
	  }

	if (x!=null || x!="")
	  { 
		document.getElementById("emailMissing").innerHTML = 
 "" ;
				
	  return true;
	  }

	
return true;
}

</script>
</html>
