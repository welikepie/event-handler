<?php snippet('header') ?>

<section class="main_content job">
	<h1><?php echo html($page->title()); ?></h1>
	<div class="details">
		<p class="meta">Company: <span><?php echo html($page->company()); ?></span></p>
		<p class="meta">Location: <span><?php echo html($page->location()); ?></span></p>
		<p class="meta">Job type: <span><?php echo html($page->type()); ?></span></p>
		<div class="tags"><span>Tags:</span> <?php
		
			$tags = $page->tags();
			if ($tags) {
				$tags = explode(",", $tags);
				foreach($tags as $tag) {
				
					$tag = trim($tag);
					if (!$tag) { continue; }
					echo('<p class="tag">' . $tag . '</p>');
				
				}
			}
		
		?></div>
		<div class="contact"><span>Contact:</span> <a href="<?php snippet('universal_link', array('link' => $job->application())); ?>" rel="external" class="application">Contact the Employer</a></div>
		<div class="description open">
			<?php echo kirbytext($page->text()); ?>
		</div>
	</div>
	
</section>

<?php snippet('footer') ?>