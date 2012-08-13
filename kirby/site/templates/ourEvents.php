<?php snippet('header')
?>
<div class = "page_container calendar">
<section class="content">
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

foreach ($events as $event) {
	$eventArray[] = $event;
}

foreach ($foreignevents as $foreignevent) {
	$eventArray[] = $foreignevent;
}

for ($j = 1; $j < count($eventArray); $j++) {
	$tmp = $eventArray[$j];
	$i = $j;
	while (($i >= 0) && ($eventArray[$i - 1] -> date() > $tmp -> date())) {
		$eventArray[$i] = $eventArray[$i - 1];
		$i--;
	}
	$eventArray[$i] = $tmp;
}

$currentdate = getdate();
$monthvar = $currentdate['month'];
$mdayvar = $currentdate['mday'];
$wdayvar = $currentdate['wday'];
?>
<div id = "fullcal">
<h1>40 days ahead</h1>
<div id="calendar">
<div id="calendarheader">
<div class = "cal">Monday</div>
<div class = "cal">Tuesday</div>
<div class = "cal">Wednesday</div>
<div class = "cal">Thursday</div>
<div class = "cal">Friday</div>
<div class = "cal">Saturday</div>
<div class = "cal">Sunday</div>
</div>
<?php
$iMax = 40;
$eventString;
$eventClass = "";

for ($i = 1; $i < $iMax + 1; $i++) {
	$currdaytest = null;
	if ($i == 1) {
		$currdaytest = "currentDay\"";
	} else {
		$currdaytest = "\"";
	}

	foreach ($eventArray as $event) {
		if ($event -> date() != 0) {
			$dateDiff = date("z",$event -> date())-$currentdate[yday];
			$month = date("F", $event -> date());
				if ($i == $dateDiff) {
					$toString = $event -> parent();
					$eventString = "<p><a href =" . "\"" . $event -> url() . "\">" . $event -> title() . "</a></p>";
					if ((stristr((string)$toString, "events"))) {
						$eventClass = "ourEvent ";
					} else if ((stristr($event -> parent(), "foreignevents"))) {
						$eventClass = "notOurEvent ";
					}
			}

		}
	}

	if ($i == 1) {
		echo("<div class = \"" . $eventClass . "cal " . $currdaytest . "id = \"" . "c" . $wdayvar . "\"" . ">");
	} else if ($i > 1) {
		echo("<div class = \"" . $eventClass . "cal " . $currdaytest . ">");
	}
	unset($eventClass);

	echo($i);
	
	if ($i == 1) {
		echo("<p>" . "today" . "</p>");
	}
	echo($eventString);
	unset($eventString);
	echo("</div>");
}
?>

</div>
</div>

<div id = "acalendar">
<h1>Agenda</h1><br>

<!--//containing div //overflow:auto;

//display block, float left -->

<div class = "hdate" >Date</div>
<div class = "hevent">Event</div>
<div class = "hlocation">Location</div>

<?php
$monthstart = date(strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
foreach ($eventArray as $event) {
	if ($event -> date() != 0) {
		if ($event -> date() >= $monthstart) {
			$event_date = $event -> date();
			echo("<li class = \"acalendar\"><div class = \"date\">" . date("jS F", $event_date) . "</div><div class = \"event\">" . $event -> title() . "</div><div class=\"location\">" . $event -> where() . "</div>");
		}
	}
}
?>

</section>
</div>
<?php snippet('footer')
?>