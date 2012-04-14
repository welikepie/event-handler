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
				
				<?php $map = $event->map();
				      if ($map) { echo "<!-- " . $map . " -->"; echo snippet('map', array('address' => $map)); } ?>
				
    			<?php echo kirbytext($event->text()) ?>
				
				<?php echo kirbytext($event->what()) ?>
				<?php echo kirbytext($event->where()) ?>
				<?php echo kirbytext($event->when()) ?>
				<?php echo kirbytext($event->cost()) ?>
				<?php echo kirbytext($event->map()) ?>
				<?php echo kirbytext($event->booking_link()) ?>
			</div>
			<div class="additional_content_wrapper_outer">
				<div class="additional_content_wrapper_inner">
					<div class="additional_content">
						<?php echo kirbytext($event->additional()) ?>
					</div>
				</div>
			</div>

  		</article>
	<?php
	
	} unset($event); unset($events);
	
	?>
</section>


<?php snippet('footer') ?>