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

	var x=document.forms["speakerform"]["entry.0.single"].value;
	var y=document.forms["speakerform"]["entry.1.single"].value;

if (( x == null || x == "" ) && ( y == null || y == ""))
	{
	document.getElementById("speaker").innerHTML = 
 "<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Field left empty, please specify a speaker!"+		
		"</div></div> " ;
		
	document.getElementById("contactSpeaker").innerHTML =  
	"<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Field left empty, please specify a way to contact the speaker!"+		
		"</div></div> " ;
		
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
	"<div class = \"text\"><strong>Warning!</strong> Fields left empty, please specify a speaker and way to contact them!</div>"+					
		"</div></div> " ;
	
	
	return false;
	}

	if (x==null || x=="")
	  {
	  	document.getElementById("contactSpeaker").innerHTML = "";
	  
	  
		document.getElementById("speaker").innerHTML = 
 "<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Field left empty, please specify a speaker!"+		
		"</div></div> " ;
		
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
			"<div class = \"text\"><strong>Warning!</strong> Field left empty, please specify a way to contact the speaker!"+					
		"</div></div> " ;	
		
	  return false;
	  }
	

	if (y==null || y=="")
	  {
	  	document.getElementById("speaker").innerHTML = "";
	  
	document.getElementById("contactSpeaker").innerHTML =  
	"<div class = \"boxLeftEmpty\">"+
			"<div class = \"text\"><strong>Warning!</strong> Field left empty, please specify a way to contact the speaker!"+					
		"</div></div> " ;
	
		document.getElementById("submitWarning").innerHTML =  
	"<div class = \"boxLeftEmpty bottomShove\">"+
		"<div class = \"text\"><strong>Warning! </strong>Field left empty, please specify a way to contact the speaker!"+					
		"</div></div> " ;

	  return false;

	  }
return true;
}

</script>
</html>
