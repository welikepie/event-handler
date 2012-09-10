<?php snippet('header');?>
<div class="page_container">
	<section class="main_content terms">
		<h1><?php echo html($page->title()) ?></h1>
		<?php echo kirbytext($page -> text());?>
	</section>
</div>
<?php snippet('footer'); ?>
