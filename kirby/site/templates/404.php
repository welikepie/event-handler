<?php snippet('header');?>
<div class="page_container">
	<section>
		<div class="tooshort">
			<h1><?php echo html($page->title()) ?></h1>
			<?php echo kirbytext($page -> text());?>
		</div>
	</section>
</div>
<?php snippet('footer'); ?>
