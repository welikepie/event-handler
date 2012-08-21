<?php snippet('header'); ?>
</head>
<div class="page_container">
	<section>
	<br><br><br><br><br><br>
	<div>
	<label onclick="console.log(MCping())">Icanhazphp?</label> <br>
	<a href="#" rel="tooltip" data-original-title="first tooltip">lol</a> <br>
	<label class="btn btn-danger" id="example" rel="popover" data-content="" title = "LOL">clicky cliuck</label>
	</div>
	</section>
</div>

<script src="../assets/scripts/jQuery1-8-0.js"></script>
<script src="../assets/scripts/bootstrap-tooltip.js"></script>
<script src="../assets/scripts/bootstrap-popover.js"></script>

<script type = "text/javascript">
var leKey = "9e2f795643d9ebb639d3a0e395c1f138-us2";
var leUrl = 'http://us2.api.mailchimp.com/1.3/';
function MCping(){

 
    
//console.log(ping(leKey));
}
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
<?php 
function lulz(){
	
}
?>
<?php snippet('footer'); ?>