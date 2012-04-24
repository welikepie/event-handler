<?php snippet('header'); ?>

<?php $temp = $page->alert(); if ($temp) {
	?><div class="alert"><?php echo($temp); ?></div><?php
} ?>

<section class="content event_list"><?php
	
	snippet('page_sort');
	$events = $pages->find('events');
	$events = $events->children()->visible();
	page_sort($events, array('date_sort', 'priority_sort'));
	
	$counter = 1;
	foreach($events as $event) {
		if ($counter > 10) { break; }
	
		// Only display events that are about to happen
		$event_date = $event->date();
		$current_date = mktime(
			0, 0, 0,
			date('n'), date('j'), date('Y')
		);
		
		if ($event_date < $current_date) { continue; }
	
	?>
  		<article>
			<div class="main_content">
    			<h1><a href="<?php echo $event->url(); ?>"><?php echo html($event->title()); ?></a></h1>
				
				<?php
					$html = kirbytext($event->text());
					$html = preg_replace('/<p>/i', '<p><span class="figure">Fig.' . $counter++ . ' </span>', $html, 1);
					echo $html;
				?>
				
				<?php $booking = $event->booking_link();
		              if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">View Tickets</a><?php } ?>
		
				<table>
					<caption>What</caption>
					<thead>
						<tr>
							<td colspan="2"><?php echo kirbytext($event->what()); ?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Where</th>
							<td><?php echo kirbytext($event->where()); ?></td>
						</tr>
						<tr>
							<th scope="row">When</th>
							<td><?php echo $event->date("jS F Y"); ?></td>
						</tr>
						<tr>
							<th scope="row">Cost</th>
							<td><?php echo kirbytext($event->cost()); ?></td>
						</tr>
					</tbody>
				</table>
				
				<?php $map = $event->map();
		              if ($map) { echo snippet('map', array('address' => $map, 'width' => '', 'height' => '')); } ?>

			</div>
			
			<?php $additional = $event->additional(); if ($additional) { ?>
			<div class="additional_content_wrapper">
				<div class="background_element">
					<div class="actual_background"></div>
				</div>
				<div class="additional_content">
					<?php echo $additional; ?>
				</div>
			</div>
			<?php } ?>

  		</article>
	<?php
	
	} unset($event); unset($events);
	
	?>
</section>

<script type="text/javascript" src="/assets/scripts/details.js"></script>
<?php snippet('footer') ?>