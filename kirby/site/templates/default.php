<?php snippet('header') ?>

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