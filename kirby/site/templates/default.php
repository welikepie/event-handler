<?php snippet('header') ?>

<div class="map_container">
	<div id="map" style="width:100%; height:100%"></div>
</div>

<div class="page_container">

<section class="content event_list">
  <article>
	<div class="main_content">
    	<h1><?php echo html($page->title()) ?></h1>
		
    	<?php
					$html = kirbytext($page->text());
					$html = preg_replace('/<p>/i', '<p><span class="figure">Fig. 1 </span>', $html, 1);
					echo $html;
				?>
		
		<?php $booking = $page->booking_link();
		      if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">View Tickets</a><?php } ?>

		
	</div>
	
	<?php $speakers = $page->speakers(); if ($speakers) { ?>		
		<div class="additional_content_wrapper">
			<div class="additional_content">

				<div class="speaker_heading">
					<ul>
						<li>Track BlackBerry</li>
						<li>Track B</li>
					</ul>
				</div>
				<div class="speaker_notes">
					<ul>
						<li>10:00</li>
						<li>10:30</li>
						<li>12:15</li>
						<li>14:00</li>
						<li>15:45</li>
						<li>17:30</li>
					</ul>
				</div>
				<div class="speaker_grid">
						<?php echo $speakers; ?>
				</div>
				
				<?php $booking = $page->booking_link();
		              if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">View Tickets</a><?php } ?>
			</div>
		</div>
		<?php } ?>
		
		<?php
			$temp = $page->alert(); if ($temp) {
				?><div class="alert"><?php echo($temp); ?></div><?php
			} unset($temp);
		?>
		
		<div class="main_content">
			<table>
				<caption>What</caption>
				<thead>
					<tr>
						<td colspan="2"><?php echo kirbytext($page->what()); ?></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">Where</th>
						<td><?php echo kirbytext($page->where()); ?></td>
					</tr>
					<tr>
						<th scope="row">When</th>
						<td><?php echo $page->date("jS F Y"); ?></td>
					</tr>
					<tr>
						<th scope="row">Cost</th>
						<td><?php echo kirbytext($page->cost()); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php

			$homepage = $pages->find('home');
			$temp = $homepage->alert(); if ($temp) {
				?><div class="alert"><?php echo($temp); ?></div><?php
			}
		?>
  </article>

</section>

</div>

<div class="infobox-wrapper">
    <div id="infobox">
        <h1>
        	<span>JS School Trip</span>
			<span>30th June 2012</span>
			<abbr class="easydate">Sat, 30 June 2012 07:25:58 -0700</abbr>
			<span>Tickets £75</span>
        </h1>
    </div>
</div>

<script type="text/javascript" src="/assets/scripts/details.js"></script>
<?php snippet('footer') ?>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script type="text/javascript">
function initialize() {
    var loc, map, marker, infobox;
    loc = new google.maps.LatLng(51.526047, -0.08832);
    
    map = new google.maps.Map(document.getElementById("map"), {
         zoom: 15,
		 disableDefaultUI: true,
		 scrollwheel:false,
         center: new google.maps.LatLng(51.524245, -0.076239),
         mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    marker = new google.maps.Marker({
        map: map,
        position: loc,
        visible: false
    });

    infobox = new InfoBox({
         content: document.getElementById("infobox"),
         disableAutoPan: false,
         maxWidth: 400,
         pixelOffset: new google.maps.Size(80, -60),
         zIndex: null,
         boxStyle: {
            opacity: 1,
            width: "280px"
        },
//        closeBoxMargin: "12px 4px 2px 2px",
//        closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
//        infoBoxClearance: new google.maps.Size(1, 1)
    });
    
	google.maps.event.addListener(marker, 'click', function() {
		infobox.open(map, this);
		map.panTo(loc);
    });
    
    infobox.open(map, marker);
//   map.panTo(loc);
}
google.maps.event.addDomListener(window, 'load', initialize);




</script>
<script type="text/javascript" src="/assets/scripts/details.js"></script>
<script type="text/javascript" src="/assets/scripts/jquery.easydate-0.2.4.min.js"></script>

<script type="text/javascript" charset="utf-8">
	$('.speaker_grid > div').click(function(){
	  $(this).toggleClass('foo');
	});
</script>

<script type="text/javascript" charset="utf-8">
	$(".easydate").easydate();
</script>
