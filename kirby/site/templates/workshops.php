<?php snippet('header'); ?>

<div class="page_container workshops">
	<section>
	
		<div class="introduction">
		<h1><?php echo html($page -> title()); ?></h1>
		<?php echo kirbytext($page -> text()); ?>
		</div>

		<form action="http://eventhandler.us2.list-manage.com/subscribe?u=b76886bab37470b1e293804f6&id=799f4da2e1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate mailing_list" target="_blank">
		<?php
		$workshops = $pages->find('workshops');
		$workshops = $workshops->children()->visible();
		//$workshops = $workshops->sortBy('title','desc');

		foreach ($workshops as $workshop) {
		$imgSize;
		?>
			<div class="workshop">
				<h1><?php echo html($workshop -> title()); ?></h1>
				<div class="details">
					<img src= "<?php 
					$img = ($workshop->imagepath() ? $workshop->imagepath() : 'assets/images/tbh.png');
					$imgSize = getimagesize($img);
					echo url($img); unset($img);
					?>">
					<p class="meta"><span>Lecturer:</span> <?php echo html($workshop->lecturer()); ?></p>
					<div class="description"><?php echo kirbytext($workshop->description()); ?></div>
						<div class="lists">
						<?php
						if($workshop->learn() != null){
							?>
								<span class = "listHead"><p class ="meta">What You'll Learn:</p></span><br>
								<?php echo kirbytext($workshop->learn());?>
							<?php
						}
						?></div>
						<div id="left">
						<?php
						if($workshop->requirements() != null){
							?>
								<span class ="listHead"><p class="meta">Requirements:</p></span><br>
								<?php echo kirbytext($workshop->requirements());?>
							<?php
						}
						?>
						
						</div>
					<label class="rightFormCheck">Let Me Know  <input type="checkbox" id="<?php echo(str_replace(" ","_",$workshop->title()));?>" value="Subscribe" checked></label>
				</div>
			</div>
		<?php
		
		}
		?>
			<fieldset>
				<input type="email" name="EMAIL" class="email" id="mce-EMAIL" value="" placeholder="Your e-mail address" required>
				<div class="error">You need to select at least one category.</div>
			</fieldset>
			<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
		</form>

	</section>
</div>
<?php snippet('footer'); ?>
