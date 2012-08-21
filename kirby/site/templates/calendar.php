<?php snippet('header');
?>

<div class="page_container calendar">
<section class="content">
<h1><?php echo html($page -> title()); ?></h1>
<div class="description"><?php echo kirbytext($page -> text()); ?></div>

<?php

$count = 0;

/* Bit of a trickery to get one list comprised of
 * events of both types, sorted ascendingly by date.
 * Each collection of pages is essentially an instance of `pages` class,
 * a simple wrapper around simple array of `page` objects, with some shorthand
 * functions for sorting or iteration. The raw array can be accessed as an
 * underscore property ($pages->_).
 * What I did here is take the raw arrays of both all event pages and foreign
 * event pages, join them, then use them to create new `pages` object and apply
 * date sorting.
 */
$eventArray = new pages(array_merge(

/* This here is basic array of event pages */$pages -> find('events') -> children() -> visible() -> _,

/* This here is basic array of foreign event pages */
$pages -> find('foreignevents') -> children() -> visible() -> _));
$eventArray = $eventArray -> sortBy('date', 'asc');

/**
 * Prepare variables for rendering the calendar.
 * $today holds the general info about current date and time, for rendering
 * the calendar correctly and filtering the events from the set.
 * $comparison is a date string with baked-in integer format for sprintf()
 * function - something similar to '2012-08-%02d'. The last bit is where sprintf()
 * will put the day of the calendar into the string for comparing with event's date.
 * $offset is used to offset the calendar fields so that they align with weekdays.
 */

if((!isset($_POST['nextMonth']))&&(!isset($_POST['prevMonth']))){
$today = getdate();
$currentMonth = date(n);
$currentYear = date(Y);
}
$comparison = date('Y-m-%02\d');
$offset = date("N", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));

if(isset($_POST['nextMonth'])){
$currentMonth = $_POST['monthUp'];
$currentYear = $_POST['Jahr'];
	if($currentMonth > 12){
		$currentYear = $_POST['yearUp'];
		$currentMonth = 1;
	}

}

if(isset($_POST['prevMonth'])){
$currentMonth = $_POST['monthDown'];
$currentYear = $_POST['Jahr'];
if($currentMonth < 1){
		$currentYear = $_POST['yearDown'];
		$currentMonth = 12;
	}
}

$trueToday = false;
$today = getdate();
if($currentMonth == date('n') && $currentYear == date('Y') ){
$trueToday = true;
}
else{
$trueToday = false;
}
			?>
			<!-- Calendar of events -->
			<div class="fullcal">
				<h1><?php echo(date( 'F', mktime(0, 0, 0, $currentMonth)).", ".$currentYear); ?></h1>
			<!--	<?php echo ($currentMonth.",".$currentYear);
				 	 echo(date('n').",".date('Y'));
				 	 echo($trueToday);?> -->
<form action = "calendar.php" method="post">
<input type = "number" class = "hidden" name="monthUp" value = "<?php echo($currentMonth+1)?>">
<input type = "number" class = "hidden" name="Jahr" value = "<?php echo($currentYear)?>">
<input type = "number" class = "hidden" name="yearUp" value = "<?php echo($currentYear+1)?>">
<input type="submit" name="nextMonth" value="nextMonth" />
</form>
<form action = "calendar.php" method="post">
<input type = "number" class = "hidden" name="monthDown" value = "<?php echo($currentMonth-1)?>">
<input type = "number" class = "hidden" name="Jahr" value = "<?php echo($currentYear)?>">
<input type = "number" class = "hidden" name="yearDown" value = "<?php echo($currentYear-1)?>">
<input type="submit" name="prevMonth" value="prevMonth" />
</form>
				<div class="calendar">
					<div class="calendarheader">
						<div class="calHead right">Monday</div>
						<div class="calHead both">Tuesday</div>
						<div class="calHead both">Wednesday</div>
						<div class="calHead both">Thursday</div>
						<div class="calHead both">Friday</div>
						<div class="calHead both">Saturday</div>
						<div class="calHead left">Sunday</div>
					</div>
					<?php

					// Iterate over all days of the current month
					for ($i = 1; $i <= intval(date('t'), 10); $i += 1) {

						$classes = array();
						$content = (string)$i;

						// Add class for the indicator of current day
						if ($i === intval($today['mday'], 10)) {
						 if($trueToday == 1){
							$classes[] = 'currentDay';
							}
						}

						// Iterate over the event and see, which ones
						// can be inserted into the calendar field.
						foreach ($eventArray as $event) {
							if ($event -> date()) {
								// Publish event if date matches the one on calendar
								if ($event -> date('Y-m-d') === sprintf($comparison, $i)) {
									 			
									 $eventClass = "";

								if( intval($event->date('j'),10) < intval($today['mday'],10) )
									 {
									 	$eventClass .= 'past';
									 }
								
								   if ($event -> parent() -> uid() === 'events') 
									{	
										$eventClass .= 'ourEvent';
									} else if ($event -> parent() -> uid() === 'foreignevents') {									
										
										$eventClass .= 'foreignEvent';
									}
								   
									$content .= '<p class = "'.$eventClass.'">'.'<a href="' . $event -> url() . '" id = "eventLink" rel="tooltip" title="'.$event -> blurb().'">' . html($event -> title()) . '</a></p>';
								}

							}

						}

						// Compile class list and assign offset as needed
						$classes[] = 'cal';
						$classes = implode(' ', array_unique($classes));

						if ($i === 1) {
							$offset = ' id="c' . $offset . '"';
						} else {
							$offset = '';
						}

						echo('<div class="' . $classes . '"' . $offset . '>' . $content . '</div>');

					}
					?>
				
				</div>
				</fieldset>
			</div>

			<div class="acalendar">
				<fieldset><h1>Agenda</h1>
				
				<div class = "hdate" >Date</div>
<div class = "hevent">Event</div>
<div class = "hlocation">Location</div>

<?php
$monthstart = date(strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
foreach ($eventArray as $event) {
	if ($event -> date() != 0) {
		if ($event -> date() >= $monthstart) {
			$event_date = $event -> date();
			echo("<li class = \"acalendar\"><div class = \"date\">" . date("jS F", $event_date) . "</div><div class = \"event\">" . "<a href=\"" . $event -> url() . "\">" . $event -> title() . "</a>" . "</div><div class=\"location\">" . $event -> where() . "</div>");
		}
	}
}
?>			</div>		</section>
	</div>
<?php snippet('footer'); ?>