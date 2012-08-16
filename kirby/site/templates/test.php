<?php snippet('header'); ?>
</head>
<div class="page_container">
	<section>
		<br><br><br><br><br><br>
	<div>
	<label class="btn btn-danger" id="example" rel="popover" data-content="" title = "LOL">clicky cliuck</label>
	</div>
	</section>
</div>

<script src="../assets/scripts/jQuery1-8-0.js"></script>
<script src="../assets/scripts/bootstrap-tooltip.js"></script>
<script src="../assets/scripts/bootstrap-popover.js"></script>

<script type = "text/javascript">
jQuery(document).ready(function($) {
$('#example').popover({
        html: true,
        trigger: 'manual',
        placement: 'top',
    }).click(function() {
    	$('#example').attr("data-content", "dis be some dope shizz");
        $(this).popover('toggle');
        $(this).load("STRINGSZ AND SHIT");
        console.log("doing shit!");
    });
});
</script>
<?php snippet('footer'); ?>