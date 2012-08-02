<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="page_container podcast">
		<section>
			<h1><?php echo html($page->title()) ?></h1>
			<?php echo kirbytext($page->text()); ?>
			
			<div class="profiles">
			<?php
				$profiles = yaml($page->profiles());
				foreach ($profiles as $name => &$profile) {
				
					?><div class="profile">
						<h2><?php echo html($name); ?></h2>
						<div><?php echo kirbytext($profile['Text']); ?></div>
					</div><?php
				
				} unset($profile); unset($profiles);
			?>
			</div>
		</section>
	</div>
  </article>

</section>

<?php snippet('footer') ?>