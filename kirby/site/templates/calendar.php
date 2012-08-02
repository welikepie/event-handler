<?php snippet('header')?>

<section class="aboutus_content jobs">
<div class="introduction">
<h1><?php echo html($page -> title()); ?></h1>
<?php echo kirbytext($page -> text()); ?>

	
<?php
snippet('page_sort');
$count = 0;
$events = $pages -> find('events');
$events = $events -> children() -> visible();
page_sort($events, array('date_sort', 'priority_sort'));
echo("<table><thead><th>Date</th><th>Event</th><th>Location</th></thead>");
echo("<tbody>");
//sort shit by date
foreach ($events as $event) {
	$count += 1;
	if ($count >= 20) {
		break;
	}
	$event_date = $event -> date();
	if ($event_date != 0) {
		$current_date = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
		//if($current_date < $event_date){
		$event_date = date("jS F Y ", $event_date);
		echo("<tr><td>" . $event_date . "</td><td>" . $event -> title() . "</td><td>" . $event -> where() . "</td></tr>");
		//}
	}
}
echo("</tbody></table>");
?>
	
</div>
</section>

<?php snippet('footer') ?>