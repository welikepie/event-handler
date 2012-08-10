<?php snippet('header'); ?>

		<div class="page_container">
			<section class="event_list">
				<article>		
					<div class="main_content">
						<!-- Page Title -->
						<h1><?php echo html($page->title()) ?></h1>
						
						<!-- Page Description -->
						<?php echo(kirbytext($page->text())); ?>
					</div>
					
					<!-- Global alerts -->
					<?php
						
						$temp = $site->alert();
						if ($temp) { echo('<div class="alert">' . $temp . '</div>'); }

					?>
					
				</article>
			</section>
		</div>
		
<?php snippet('footer'); ?>