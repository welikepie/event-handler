		<footer>
			<div><?php echo kirbytext($site->copyright()) ?></div>
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

<script src="assets/scripts/jQuery1-8-0.js"></script>
<script src="assets/scripts/bootstrap-tooltip.js"></script>
<script src="assets/scripts/tooltipAdd.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("[rel=tooltip]").tooltip();
	});
	
	$('#monthAdd').live('submit', function() { // catch the form's submit event
	//event.preventDefault();
	console.log($("#monthAdd :input"));
	console.log($(this).attr('action')+$(this).serialize());
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: 'POST', // GET or POST
        url: $(this).attr('action'),
        success: function(response) { // on success..
    //console.log(response);
    //console.log(response);
    var responder = $(response);
    $('#calendarWrapper').html(responder.contents().find('#calendarWrapper').contents());
    $("[rel=tooltip]").tooltip();
        }
    });
    console.log("action stopped");
    return false; // cancel original event to prevent form submitting
});


$('#monthSub').live('submit', function() { // catch the form's submit event
	console.log($("#monthSub :input"));
	console.log($(this).attr('action')+$(this).serialize());
    $.ajax({ // create an AJAX call...
        data: $(this).serialize(), // get the form data
        type: 'POST', // GET or POST
        url: $(this).attr('action'),
        success: function(response) { // on success..
    //console.log(response);
    //console.log(response);
    var responder = $(response);
   $('#calendarWrapper').html(responder.contents().find('#calendarWrapper').contents());
	$("[rel=tooltip]").tooltip();
        }
    });
    console.log("action stopped");
    return false; // cancel original event to prevent form submitting
});
</script>
</html>