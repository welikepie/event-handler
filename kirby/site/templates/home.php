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
    			<h1><?php echo html($page->title()) ?></h1>
    			<?php echo kirbytext($page->text()) ?>
				
				<?php echo kirbytext($page->what()) ?>
				<?php echo kirbytext($page->where()) ?>
				<?php echo kirbytext($page->when()) ?>
				<?php echo kirbytext($page->cost()) ?>
				<?php echo kirbytext($page->map()) ?>
				<?php echo kirbytext($page->booking_link()) ?>
			</div>
			<div class="additional_content_wrapper_outer">
				<div class="additional_content_wrapper_inner">
					<div class="additional_content">
						<?php echo kirbytext($page->additional()) ?>
					</div>
				</div>
			</div>

  		</article>
	<?php
	
	} unset($event); unset($events);
	
	?>
</section>


<?php snippet('footer') ?>