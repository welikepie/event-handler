<?php snippet('header'); ?>
</head>
<div class="page_container">
	<section>
	<br><br><br><br><br><br>
	<div>
	
	<div>
	<a class ="siteLeadsLong" href="http://twitter.com/Zenmaster13">	<img src="http://api.twitter.com/1/users/profile_image/Zenmaster13"></a> <br>
<?php

$xml = simplexml_load_file('http://wizardsoweb.com/feed');
print_r($xml->channel->item[0]);
?>
</div>
	</div>
	</section>
</div>

<script type = "text/javascript">
 </script>
<?php snippet('footer'); ?>