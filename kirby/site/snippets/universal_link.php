<?php

	require_once('_Validate.php');
	
	// UNIVERSAL LINK HANDLER
	// Returns appropriate <a href> attribute based on what sort of data you pass.
	// Entry variable - $link.
	$link = trim($link);
	
	// E-Mail Address
	if (Validate::email($link, array('use_rfc822' => true))) {
	
		echo('mailto:' . $link);
	
	// Default case
	} else {
	
		echo($link);
	
	}

?>