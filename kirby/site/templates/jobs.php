<?php snippet('header') ?>

<section class="main_content jobs">
	<div class="introduction">
		<h1><?php echo html($page->title()); ?></h1>
		<?php echo kirbytext($page->text()); ?>
	</div>
	
	<?php
	
	$jobs = $pages->find('jobs');
	$jobs = $jobs->children()->visible();
	$jobs = $jobs->sortBy('date', 'desc');
	
	foreach ($jobs as $job) {
	
		// Don't list of older than 3 months
		$job_date = $job->date();
		$current_date = mktime(
			0, 0, 0,
			date('n'), date('j'), date('Y')
		);
		
		$adjusted_date = $current_date - (3 * 30 * 24 * 60 * 60);
		if ($adjusted_date > $job_date) { continue; }
		
		?><div class="job">
			<h1><?php echo html($job->title()); ?></h1>
			<div class="details">
				<p class="meta">Company: <span><?php echo html($job->company()); ?></span></p>
				<p class="meta">Location: <span><?php echo html($job->location()); ?></span></p>
				<p class="meta">Job type: <span><?php echo html($job->type()); ?></span></p>
				<div class="tags"><span>Tags:</span> <?php
				
					$tags = $job->tags();
					if ($tags) {
						$tags = explode(",", $tags);
						foreach($tags as $tag) {
						
							$tag = trim($tag);
							if (!$tag) { continue; }
							echo('<p class="tag">' . $tag . '</p>');
						
						}
					}
				
				?></div>
				<div class="contact"><span>Contact:</span> <a href="<?php echo $job->application(); ?>" rel="external" class="application">Contact the Employer</a></div>
				<div class="description"><?php echo kirbytext($job->text()); ?></div>
				<a class="extender">View More</a>
			</div>
		</div><?php
	
	}
	
	?>
	
</section>

<script type="text/javascript" src="/assets/scripts/jobs.js"></script>
<?php snippet('footer') ?>