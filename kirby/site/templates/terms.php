<?php snippet('header');?>
<div class="page_container">
	<section ckass="main_content">
		<h1><?php echo html($page->title()) ?></h1>
		<?php echo kirbytext($page -> text());?>
	</section>
</div>
<?php snippet('footer'); ?>
