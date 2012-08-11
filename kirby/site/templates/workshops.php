<?php snippet('header'); ?>

<div class="page_container workshops">
	<section>
	
		<div class="introduction">
			<h1><?php echo html($page->title()); ?></h1>
			<div class="description"><?php echo kirbytext($page->text()); ?></div>
		</div>

		<form action="http://eventhandler.us2.list-manage.com/subscribe/post?u=b76886bab37470b1e293804f6&id=799f4da2e1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate mailing_list" onsubmit="return formsubmit()" target="_blank">
			<?php
		$fieldName=64;
			$workshops = $pages
				->find('workshops')
				->children()
				->visible();
		
			foreach ($workshops as $workshop) { ?>
			<div class="workshop">
			
				<h1><?php echo html($workshop->title()); ?></h1>
				<div class="details">
				
					<!-- Workshop image -->
					<?php
						$image = $workshop->image();
						$image = url($image ? $image : 'assets/images/tbh.png');
					?><img src="<?php echo($image); ?>" alt="">
					
					<!-- Lecturer's name -->
					<p class="meta"><span>Lecturer:</span> <?php echo html($workshop->lecturer()); ?></p>
					<div class="description"><?php echo(kirbytext($workshop->description())); ?></div>
					
					<!-- List of skills obtained -->
					<div class="skills">
					<?php
						$learn = $workshop->learn();
						if ($learn) {
							echo('<p class="meta"><span>What you\'ll learn:</span></p>');
							echo(kirbytext($learn));
						}
					?>
					</div>
					
					<!-- List of requirements -->
					<div class="requirements">
					<?php
						$requirements = $workshop->requirements();
						if ($requirements) {
							echo('<p class="meta"><span>Requirements:</span></p>');
							echo(kirbytext($requirements));
						}
					?>
					</div>
					
					<label class="rightFormCheck">Let Me Know <input type="checkbox" id="<?php echo(str_replace(" ","_",$workshop->title()));?>" name="<?php echo("group[11569][".$fieldName."]"); $fieldName = $fieldName*2; ?>" value="Subscribe" checked></label>
				
				</div>
			
			</div>
			<?php } ?>
			
			<fieldset>
				<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Your e-mail address">
				<div id="emailMissing"></div>
			</fieldset>
			<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
			
		</form>

	</section>
</div>
<?php snippet('workshopFooter'); ?>
