<?php snippet('header') ?>

	<div class="page_container calendar">
		<section class="content">
			<h1><?php echo html($page->title()); ?></h1>
			<div class="description"><?php echo kirbytext($page->text()); ?></div>

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
			
				/* This here is basic array of event pages */
				$pages->find('events')
					->children()
					->visible()
					->_,
				
				/* This here is basic array of foreign event pages */
				$pages->find('foreignevents')
					->children()
					->visible()
					->_
			
			));
			$eventArray->sortBy('date', 'asc');

			/**
			 * Prepare variables for rendering the calendar.
			 * $today holds the general info about current date and time, for rendering
			 * the calendar correctly and filtering the events from the set.
			 * $comparison is a date string with baked-in integer format for sprintf()
			 * function - something similar to '2012-08-%02d'. The last bit is where sprintf()
			 * will put the day of the calendar into the string for comparing with event's date.
			 * $offset is used to offset the calendar fields so that they align with weekdays.
			 */
			$today = getdate();
			$comparison = date('Y-m-%02\d');
			$offset = date("N", strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));
			
			?>
			<!-- Calendar of events -->
			<div id="fullcal">
				<h1><?php echo($today['month']); ?></h1>
				<div id="calendar">
				
					<div id="calendarheader">
						<div class="cal">Monday</div>
						<div class="cal">Tuesday</div>
						<div class="cal">Wednesday</div>
						<div class="cal">Thursday</div>
						<div class="cal">Friday</div>
						<div class="cal">Saturday</div>
						<div class="cal">Sunday</div>
					</div>

					<?php
					
					// Iterate over all days of the current month
					for ($i = 1; $i <= intval(date('t'), 10); $i += 1) {
					
						$classes = array();
						$content = (string) $i;
						
						// Add class for the indicator of current day
						if ($i === intval($today['mday'], 10)) {
							$classes[] = 'currentDay';
							$content .= '<p>Today</p>';
						}
						
						// Iterate over the event and see, which ones
						// can be inserted into the calendar field.
						foreach($eventArray as $event) {
						
							if ($event->date()) {
							
								// Publish event if date matches the one on calendar
								if ($event->date('Y-m-d') === sprintf($comparison, $i)) {
								
									$content .= '<p><a href="' . $event->url() . '">' . html($event->title()) . '</a></p>';
									if ($event->parent()->uid() === 'events') {
										$classes[] = 'ourEvent';
									} elseif ($event->parent()->uid() === 'foreignevents') {
										$classes[] = 'notOurEvent';
									}
								
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
			</div>

			<div id="acalendar">
				<h1>Agenda</h1>
				
				<div class="hdate" >Date</div>
				<div class="hevent">Event</div>
				<div class="hlocation">Location</div>

				<?php
				$month_start = date(strtotime(date('m') . '/01/' . date('Y') . ' 00:00:00'));

				foreach ($eventArray as $event) {
				
					$event_date = $event->date();
					if ($event_date && ($event_date >= $month_start)) {
					
						echo(
							'<li class="acalendar">' .
								'<div class="date">' . date('jS F', $event_date) . '</div>' .
								'<div class="event">' . html($event->title()) . '</div>' .
								'<div class="location">' . html($event->where()) . '</div>' .
							'</li>'
						);
					
					}
				
				}
				?>
			</div>

		</section>
	</div>
<?php snippet('footer'); ?>