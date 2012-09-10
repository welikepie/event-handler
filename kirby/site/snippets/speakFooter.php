		<footer>
			<a href="<?php echo ($pages->find('terms')->url()); ?>">Terms &amp; Conditions</a>
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
<script type="text/javascript">

function formsubmit() {

	var x=document.forms["speakerform"]["entry.0.single"].value;
	var y=document.forms["speakerform"]["entry.1.single"].value;

if (( x == null || x == "" ) && ( y == null || y == ""))
	{
	document.getElementById("speaker").innerHTML = 
 "<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Oh dear, it seems you forgot to tell us the name of the speaker you'd like to see. Please type that in in the \"Name\" section and submit the form again at the bottom of the page. "+		
		"</div></div> " ;
		
	document.getElementById("contactSpeaker").innerHTML =  
	"<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Whoops, it seems you forgot to include how we can contact the speaker. Please type that in and give us their details so we can get in touch with them and get some ideas going."+		
		"</div></div> " ;
		
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
	"<div class = \"text\"><strong>Warning!</strong> How mysterious of you, you didn't tell us your suggested speakers' name or contact details. Please fill in both the name and contact sections of the form and submit at the bottom of the page so we know who they are.</div>"+					
		"</div></div> " ;
	
	
	return false;
	}

	if (x==null || x=="")
	  {
	  	document.getElementById("contactSpeaker").innerHTML = "";
	  
	  
		document.getElementById("speaker").innerHTML = 
 "<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong>  Oh dear, it seems you forgot to tell us the name of the speaker you'd like to see. Please type that in in the \"Name\" section and submit the form again at the bottom of the page. "+		
		"</div></div> " ;
		
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
			"<div class = \"text\"><strong>Warning!</strong>  Oh dear, it seems you forgot to tell us the name of the speaker you'd like to see. Please type that in in the \"Name\" section and submit the form again at the bottom of the page. "+					
		"</div></div> " ;	
		
	  return false;
	  }
	

	if (y==null || y=="")
	  {
	  	document.getElementById("speaker").innerHTML = "";
	  
	document.getElementById("contactSpeaker").innerHTML =  
	"<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Whoops, it seems you forgot to include how we can contact the speaker. Please type that in and give us their details so we can get in touch with them and get some ideas going."+					
		"</div></div> " ;
	
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
		"<div class = \"text\"><strong>Warning! </strong> Whoops, it seems you forgot to include how we can contact the speaker. Please type that in and give us their details so we can get in touch with them and get some ideas going."+					
		"</div></div> " ;

	  return false;

	  }
return true;
}

</script>
</html>
