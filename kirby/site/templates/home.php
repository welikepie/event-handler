<?php snippet('header') ?>

<section class="content event_list"><?php
	
	$events = $pages->find('events');
	$events = $events->children()->visible();
	$events = $events->sortBy('date', 'desc');
	$events = $events->limit(10);
	
	foreach($events as $event) {
	?>
  		<article>
			<div class="main_content">
    			<h1><?php echo html($event->title()) ?></h1>
				
				<?php echo kirbytext($event->text()) ?>
				
				<?php $booking = $event->booking_link();
		              if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">Book this place</a><?php } ?>
		
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
			<div class="additional_content_wrapper">
				<div class="additional_content">
					<?php echo $event->additional(); ?>
				</div>
			</div>

  		</article>
	<?php
	
	} unset($event); unset($events);
	
	?>
</section>


<?php snippet('footer') ?>