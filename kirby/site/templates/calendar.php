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
$events = $events -> sortBy('date', 'asc');

$foreignevents = $pages -> find('foreignevents');
$foreignevents = $foreignevents -> children() -> visible();
$foreignevents = $foreignevents -> sortBy('date', 'asc');

$eventArray = array();

foreach ($events as $event){
$eventArray[] = $event;	
}
foreach ($foreignevents as $foreignevent){
$eventArray[] = $foreignevent;	
}

for($j=1; $j < count($eventArray); $j++) 
	{
        $tmp = $eventArray[$j];
        $i = $j;
    	    while(($i >= 0) && ($eventArray[$i-1]->date() > $tmp->date())) 
    	    	{
            		$eventArray[$i] = $eventArray[$i-1];
            		$i--;
        		}
        $eventArray[$i] = $tmp;
	}?>




<?php 
$currentdate = getdate(); 
$monthvar = $currentdate['month'];
$mdayvar = $currentdate['mday'];
$wdayvar = $currentdate['wday'];
?>
<h1><?php echo ($monthvar); ?></h1>
<div id="callendar">
<div class = "calendarheader"><span class = "cal c1">Monday</span><span class = "cal c2">Tuesday</span><span class = "cal c3">Wednesday</span>
	<span class = "cal c4">Thursday</span><span class = "cal c5">Friday</span><span class = "cal c6">Saturday</span><span class = "cal c7">Sunday</span></div>
	<!--check class names and make for loop happen, because you're a bawss.-->	
<?php

$iMax = date("t");
for($i = 1; $i < $iMax+1; $i++){
	echo("<span>");
	echo("||".(($i+($mdayvar%$wdayvar))%7).",".$i."||");
	foreach($eventArray as $event){
		if($event->date()!=0)
			{
				$month = date("F",$event-> date());
					if($monthvar == $month)
						{
						
							if($i == date("j",$event->date()))
								{
									echo(date("jS",$event->date()).", ".$event->title());
								}
						}
				
			}
	}
	echo("</span>");
	if((($i+($mdayvar%$wdayvar))%7)==0){
		echo("<br>");
	}
}
?>
<br><br>
</div>



	
<div id = "acalendar">
<h1>Agenda</h1><br><span class = "date" style = " width:"100px"; ">Date</span><span class = "event" style = " width:"100px";">Event</span>
<span class = "location" style = "width:"100px";">Location</span>

<?php
	foreach($eventArray as $event){
		if($event->date() != 0){
		$event_date = $event->date();
	echo("<li class = \"acalendar\"><span class = \"date\">" . date("jS F Y ", $event_date) . "</span><span class = \"event\">" . $event -> title() . "</span><span class=\"location\">" . $event -> where() . "</span>");
		}
	}
?>
</div>
</div>

</section>

<?php snippet('footer') ?>