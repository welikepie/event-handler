<?php
snippet('header');
snippet('dates');

/* RESPONSIVE BANNER HANDLING
 * The event can be set up with the responsive banner - the series of banners
 * that load accordingly to the screen size, in place of the map.
 */
$banners = $page->banners();
if ($banners) {
	snippet('banner_css', array('banners' => yaml($banners)));
	$banners = true;
} else {
	$banners = false;
}

?>

		<!-- Event Map Widget -->
		<div class="map_container">
			<?php if (!$banners) { ?><div id="map" style="width:100%; height:100%;"></div><?php } ?>
		</div>
		<div class="page_container extended">
			<section class="event_list">
				<article>		
					<div class="main_content">
						<!-- Page Title -->
						<h1><?php echo html($page->title()) ?></h1>
						
						<!-- Page Description -->
						<?php
						$html = kirbytext($page -> text());
						$html = preg_replace('/<p>/i', '<p><span class="figure">Fig. 1 </span>', $html, 1);
						echo $html;
						?>
						
						<!-- Booking link (if available) -->
						<!--<?php
							$booking = $page->booking_link();
							if ($booking) { ?><a href="<?php echo $booking; ?>" class="booking button">Tickets</a><?php } ?>-->
					</div>
					
					<?php
						$speakers = $page->speakers();
						if ($speakers) { $speakers = yaml($speakers);
							
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
							
							?><div class="additional_content_wrapper">
								<div class="additional_content">
									<div class="speaker_heading"><?php echo $speaker_tracks; ?></div>
									<div class="speaker_notes"><?php echo $speaker_times; ?></div>
									<div class="speaker_grid"><?php echo $speaker_grid; ?></div>
									<?php if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external tooltip" data-original-title="Click here to get a ticket!" class="booking">Tickets</a><?php } ?> 
								</div>
							</div><?php

							}
					?>
					
					<!-- Event-wide alerts -->
					<?php
						$temp = $page->alert(); if ($temp) {
							?><div class="alert"><?php echo($temp); ?></div><?php
							} unset($temp);
					?>
					
					<div class="main_content">
						<table class="details">
							<caption>What</caption>
							<thead>
								<tr>
									<td colspan="2"><?php echo html($page -> what()); ?></td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th scope="row">Where</th>
									<td><?php echo html($page -> where()); ?></td>
								</tr>
								<tr>
									<th scope="row">When</th>
									<td><?php echo daterange($page); ?></td>
								</tr>
								<tr>
									<th scope="row">Cost</th>
									<td><?php echo html($page -> cost()); ?></td>
								</tr>
							</tbody>
						</table>
						
						<?php if ($banners) { ?>
						<div class="map_wrapper">
							<div id="map" style="width: 100%; height: 100%;"></div>
						</div>
						<?php } ?>
						
					</div>
					
					<!-- Global alerts -->
					<?php

					/* Site-wide alerts have been moved to site.txt file and will be
					 * pulled and rendered from there. Only if there are any specified,
					 * of course.
					 */

					$temp = $site -> alert();
					if ($temp) { echo('<div class="alert">' . $temp . '</div>');
					}
					?>
					<div class = "main_content">
					<?php
						if ($page -> lanyrd() && $page -> lanyrdapi()) {
							echo('<div class="lanyrd_speakers" data-lanyrdAPI="'.$page->lanyrdapi().'" data-lanyrd="'.$page->lanyrd().'"></div>');						
						}
					?>

						
						<!-- Booking link (if available) -->
						<?php
							$booking = $page->booking_link();
							if ($booking) { ?><a href="<?php echo $booking; ?>" class="red-button">View Tickets</a><?php
						} ?>
						
						<?php
							$sponsors = $page->sponsors();
							if ($sponsors) {
							
								?><div class="sponsors"><?php
								
								$sponsors = yaml($sponsors);
								foreach ($sponsors as &$sponsorship) {
								
									echo('<div class="sponsorship">');
										if (isset($sponsorship['title'])) { echo('<div class="title">' . $sponsorship['title'] . '</div>'); }
										echo('<div class="banners">');
										foreach ($sponsorship['sponsors'] as &$item) {
											if (isset($item['url'])) { echo('<a href="' . $item['url'] . '">'); }
											echo('<img src="' . $item['image'] . '" alt="' . (isset($item['title']) ? $item['title'] : '') . '">');
											if (isset($item['url'])) { echo('</a>'); }
										}
										echo('</div>');
									echo('</div>');
								
								}
								
								?></div><?php
							
							}
						?>
					</div>
				</article>
			</section>
		</div>
		
		<!-- Infobox render -->
		<div class="infobox-wrapper" data-loc="<?php echo h($page -> map()); ?>">
			<?php $temp = $page->infobox(); if ($temp) { ?>
			<div id="infobox"><?php echo $temp; ?></div>
			<?php } ?>
		</div>
		
<?php snippet('footer', array(
	'bottom_scripts' => array(
		'http://code.jquery.com/jquery-latest.min.js',
		'http://maps.google.com/maps/api/js?sensor=false',
		'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js',
		url('assets/scripts/lanyrdLoader.js'),
		url('assets/scripts/scrapeFormatter.js'),
		url('assets/scripts/tooltipAdd.js'),
		url('assets/scripts/tooltipMod.js'),
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