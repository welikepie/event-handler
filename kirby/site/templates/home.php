<?php snippet('header') ?>

<section class="event_list"><?php
	
	$events = $pages->find('events');
	$events = $events->children()->visible();
	$events = $events->sortBy('date', 'desc');
	$events = $events->limit(5);
	
	foreach($events as $event) {
	?>
		<article>
			<h1><?php echo html($event->title()); ?></h1>
			<p><?php echo kirbytext($event->text()); ?></p>
			<a href="<?php echo $event->url(); ?>">View More</a>
		</article>
	<?php
	
	} unset($event); unset($events);
	
	?>
</section>

<section class="content">

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
	<div class="additional_content"><?php echo kirbytext($page->additional()) ?></div>
	
  </article>

</section>

<?php snippet('footer') ?>