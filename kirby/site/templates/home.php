<?php
	snippet('header');
	snippet('dates');
?>

		<!-- Event Map Widget -->
		<div class="map_container">
			<div id="map" style="width:100%; height:100%"></div>
		</div>

		<div class="page_container">
			<section class="event_list">
			<?php
			
			snippet('page_sort');
			$events = $pages->find('events');
			$events = $events->children()->visible();
			page_sort($events, array('date_sort', 'priority_sort'));
			
			$event_count = 0;      // Increased by 1 for every event rendered
			$infobox = "";         // Holds the infobox HTML
			
			foreach ($events as $event) {
			
				// Skip all other events if we've already
				// rendered required number of upcoming events
				if ($event_count >= 10) { break; }
				
				// Only render events that are upcoming (event time in the future).
				// Compare to current date and time at midnight, so that today's events
				// show up regardless of time of day.
				$event_date = $event->date();
				$current_date = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
				if ($current_date > $event_date) { continue; }
				
				// Event has passed requirements, will be rendered.
				// Increase the counter.
				$event_count += 1;
				
				// Set up map infobox if none was set up yet
				// (this wway, only the infobox for first entry is displayed)
				if (!$infobox && $event->infobox()) {
					$infobox = '<div class="infobox-wrapper" data-loc="' . h($event->map()) . '">' .
								   '<div id="infobox">' .
									   $event->infobox() .
								   '</div>' .
							   '</div>';
				}
				
				?><article>
					<div class="main_content">
					
						<!-- Page title -->
						<h1><a href="<?php echo $event->url(); ?>"><?php echo html($event->title()) ?></a></h1>
						
						<!-- Page Description -->
						<div class="description">
						<?php
							$html = kirbytext($event->text());
							$html = preg_replace('/<p>/i', '<p><span class="figure">Fig.' . $event_count . ' </span>', $html, 1);
							echo $html;
						?>
						</div>
						
						<!-- Booking link (if available) -->
						<?php
							$booking = $event->booking_link();
							if ($booking) { echo('<a href="' . $booking . '"class="booking button">Tickets</a>'); }
						?>
					</div>
						
					<!-- Speakers grid -->
					<?php
					
						/* Speakers grid lists all the people participating in the event,
						 * if such list is specified. Given times of time slots and separate tracks
						 * with all the speakers and their topics listed, prepares a nicely animated
						 * and styled grid.
						 */
					
						$speakers = $event->speakers();
						if ($speakers) {
						
							// Parse YAML into accessible PHP data formats
							$speakers = yaml($speakers);
							
							$speaker_renders = array();
							$speaker_grid = "";
							$speaker_times = "";
							$speaker_tracks = "";
							$current_list = null;
							
							// Renders times
							if (isset($speakers['Times'])) {
								$speaker_times = '<ul>';
								foreach ($speakers['Times'] as &$time) { $speaker_times .= '<li>' . $time . '</li>'; }
								$speaker_times .= '</ul>';
							}
							
							// Generate speaker renders
							if (isset($speakers['Talks'])) {
							
								// Tracks
								$speaker_tracks = '<ul>';
								foreach ($speakers['Talks'] as $track => &$people) {
								
									$speaker_renders[] = array();
									$current_list = &$speaker_renders[count($speaker_renders)-1];
									$speaker_tracks .= '<li>' . $track . '</li>';
									
									foreach ($people as &$speaker) {
									
										$temp = '<div class="wide_box speaker_box"><figure>';
										if (isset($speaker['Image'])) { $temp .= '<img src="' . $speaker['Image'] . '" alt="">'; }
										$temp .= '<h1>' . $speaker['Name'] . '</h1>' .
												 '<h2>' . $speaker['Title'] . '</h2>' .
												 '</figure><div>' .
												 '<h2>' . $speaker['Title'] . '</h2>' .
												 kirbytext($speaker['Description']) .
												 '</div></div>';
										$current_list[] = $temp;
									
									}
								
								}
								$speaker_tracks .= '</ul>';
								
								for($i = 0; $i < count($speaker_renders[0]); $i++) {
									foreach ($speaker_renders as &$render)
										$speaker_grid .= $render[$i];
								}
							
							}
							
							echo(
								'<div class="additional_content_wrapper">' .
									'<div class="additional_content">' .
										'<div class="speaker_heading">' . $speaker_tracks . '</div>' .
										'<div class="speaker_notes">' . $speaker_times . '</div>' .
										'<div class="speaker_grid">' . $speaker_grid . '</div>' .
										($booking ? '<a href="' . $booking . '" class="booking button">Tickets</a>' : '') .
									'</div>' .
								'</div>'
							);
						
						}
					?>
						
					<!-- Event-wide alerts -->
					<?php
						$temp = $event->alert();
						if ($temp) { echo('<div class="alert">' . $temp . '</div>'); }
					?>
					
					<!-- Details table -->
					<div class="main_content">
						<table class="details">
							<caption>What</caption>
							<thead>
								<tr>
									<td colspan="2"><?php echo html($event->what()); ?></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Where</th>
									<td><?php echo html($event->where()); ?></td>
								</tr>
								<tr>
									<th scope="row">When</th>
									<td><?php echo daterange($event); ?></td>
								</tr>
								<tr>
									<th scope="row">Cost</th>
									<td><?php echo html($event->cost()); ?></td>
								</tr>
							</tbody>
						</table>
					</div>					
						<div class = "main_content">
						<?php
						if ($event -> lanyard()) {
							//https://api.twitter.com/1/users/profile_image/ TWITTER USERNAME
							$data = file_get_contents($event -> lanyard());
							$dom = new DOMDocument;
							@$dom -> loadHTML($data);
							$speakers = $dom -> getElementById("speaker-list");
							$organisers = $dom -> getElementsByTagName("ul");
							$organisersOut = "";
							$speakersOut = "";
							$finder = new DomXPath($dom);
							$classname="people";
							$nodes = $finder->query("//*[contains(@class, '$classname')]");
							
							foreach($speakers -> childNodes as $element)
							{
									$speakersOut .= $element->ownerDocument->saveXML($element);
							}
							
							foreach($nodes as $key => $element)
							{
										
								if($key == ($nodes -> length)-1){
									$organisersOut .= $element->ownerDocument->saveXML($element);	
								}
							}
							//echo('<div class="heads">Speakers</div>');
							//echo (('<div class="fullwidth" id = "speakerField">'.$speakersOut.'</div>')); 
							//echo('<div class="heads">Organisers & Hosts</div>');
							//echo(('<div class="fullwidth" id = "organiserField">'.$organisersOut.'</div>'));
						
						}
						?>
					</div>
				</article>
				<?php
			
			}
			
			/* If no event has been rendered (nothing organised at a time),
			 * render the information about missing events and some contact info.
			 */
			if (!$event_count) { ?>
				<div class="event_absent">
					<?php echo(kirbytext($page->noevents())); ?>
				</div>
			<?php } ?>
			
			</section>
		</div>
		
		<!-- Site-wide alert -->
		<?php
		
			/* Site-wide alerts have been moved to site.txt file and will be
			 * pulled and rendered from there. Only if there are any specified,
			 * of course.
			 */
			
			$temp = $site->alert();
			if ($temp) { echo('<div class="alert">' . $temp . '</div>'); }

		?>
		
		<?php echo($infobox); ?>

<?php snippet('footer', array(
	'bottom_scripts' => array(
		'http://code.jquery.com/jquery-latest.min.js',
		'http://maps.google.com/maps/api/js?sensor=false',
		'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js',

		url('assets/scripts/jquery.easydate-0.2.4.min.js')
	),
	'bottom_snippets' => array(
	<<<EOT
function map_initialize() {
    var loc, map, marker, infobox;
    loc = new google.maps.LatLng(51.526047, -0.08832);
    
    map = new google.maps.Map(document.getElementById("map"), {
         zoom: 15,
		 disableDefaultUI: true,
		 scrollwheel:false,
         center: new google.maps.LatLng(51.524245, -0.076239),
         mapTypeId: google.maps.MapTypeId.ROADMAP
    });
	
	event_map = document.getElementById("infobox");
	if (event_map) {
	
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': event_map.parentNode.getAttribute('data-loc')}, function (results, status) {

			var marker, infobox, location;

			if (status === google.maps.GeocoderStatus.OK) {
			
				location = results[0].geometry.location;
				marker = new google.maps.Marker({
					map: map,
					position: location,
					visible: false
				});
				infobox = new InfoBox({
					content: event_map,
					disableAutoPan: false,
					maxWidth: 400,
					pixelOffset: new google.maps.Size(60, -140),
					zIndex: null,
					boxStyle: {
						opacity: 1,
						width: "280px"
					}/*,
					closeBoxMargin: "12px 4px 2px 2px",
					closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
					infoBoxClearance: new google.maps.Size(1, 1)*/
				});
				
				google.maps.event.addListener(marker, 'click', function() {
					infobox.open(map, this);
					map.panTo(location);
				});
				
				infobox.open(map, marker);
				map.panTo(location);
			
			}

		});
	
	} else {
	
		geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': $('div.infobox-wrapper').get(0).getAttribute('data-loc')}, function (results, status) {
		
			var marker, location;
			if (status === google.maps.GeocoderStatus.OK) {
				location = results[0].geometry.location;
				marker = new google.maps.Marker({
					map: map,
					position: results[0].geometry.location,
					visible: false
				});
				google.maps.event.addListener(marker, 'click', function() { map.panTo(location); });
				map.panTo(location);
			}
		
		});
	
	}

}
google.maps.event.addDomListener(window, 'load', map_initialize);
EOT
	, <<<EOT
	$('.speaker_grid > div').click(function(){
		$(this).toggleClass('foo');
	});
	$(".easydate").easydate();
EOT
	)
)); ?>