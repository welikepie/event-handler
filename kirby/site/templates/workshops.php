<?php snippet('header'); ?>
<div class="page_container workshops">
	<section>
		<div class="introduction">
			<h1><?php echo html($page -> title()); ?></h1>
			<div class="description"><?php echo kirbytext($page -> text()); ?></div>
		</div>
<script type="text/javascript">var Myvar;</script>

	<!--	<form action="http://eventhandler.us2.list-manage.com/subscribe/post?u=b76886bab37470b1e293804f6&id=799f4da2e1" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate mailing_list" onsubmit="return formsubmit()" target="_blank">--></form>
			<?php
		$fieldName=64;
			$workshops = $pages
				->find('workshops')
				->children()
				->visible();
		
			foreach ($workshops as $workshop) { ?>
			<div class="workshop">
			<script type="text/javascript">Myvar="";</script>
				<h1><?php echo html($workshop -> title()); ?></h1>
				<div class="details">
					
				<div class="workshopLeft">
					<!-- Workshop image -->
					<?php
					$image = $workshop -> image();
					$image = url($image ? $image : 'assets/images/tbh.png');
					?><img src="<?php echo($image); ?>" alt="">
					
					<!-- Lecturer's name -->
					<p class="meta"><span><?php echo html(strtoupper($workshop -> lecturer())); ?></span></p>
					<p class="meta"><span class = jobTwitter><?php echo html($workshop -> job()); ?></span></p>
					<p class="meta"><span class = jobTwitter><a href="http://www.twitter.com/<?php echo html($workshop -> twitter()); ?>">@<?php echo html($workshop -> twitter()); ?></a></span></p>
				</div>
				<div class="gradiented">
				<div class="workshopRight">
					<div class="description">
						<?php
						echo('<p class ="meta"><span>Workshop Description:</span></p>');
						echo(kirbytext($workshop -> description()));
						?>
					</div>
					
					<!-- List of skills obtained -->
					<div class="skills">
						<?php
						$learn = $workshop -> learn();
						if ($learn) {
							echo('<p class="meta"><span>What you\'ll learn:</span></p>');
							echo(kirbytext($learn));
						}
						?>
					</div>
					
					<!-- List of requirements -->
					<div class="requirements">
					<?php
					$requirements = $workshop -> requirements();

					if ($requirements) {
						echo('<p class="meta"><span>Requirements:</span></p>');
						echo(kirbytext($requirements));
					}
					?>
					</div>
						</div>
			</div>
<!--div is hidden from the user. Intentionally. -->			
<div class = "hiddenMailSubscribe" id="<?php echo(str_replace(" ", "_", $workshop -> title())); ?>" >
<?php
$formUrl = $workshop -> formsite();
$formSite = "";
if ($formUrl) {
$formSite = html($formUrl);
}
?>
<label onclick="$('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide');">x</label>
<form action =	 <?php echo($formSite) ?> method="post" id="<?php echo("FORM" . str_replace(" ", "_", $workshop -> title())); ?>" onsubmit ="return formsubmit(this.parentNode.id)" name = "mc-embedded-subscribe-form" target="blank">
Email: <input type="text" name = "MERGE0" id="<?php echo("MERGE0" . str_replace(" ", "_", $workshop -> title())); ?>">
<div class = "error" id="<?php echo("ERROR" . str_replace(" ", "_", $workshop -> title())); ?>">
</div>
<input type="submit" value = "Submit" id = <?php echo("SUBMIT" . str_replace(" ", "_", $workshop -> title())); ?>></button> 
</form>
</div>	 

					<div class=rightContainer>
						<div id = "<?php echo(str_replace(" ", "|", $workshop -> title())); ?>" class = "signUpBox">
						</div>
						<label class="rightFormCheck" id="<?php echo(str_replace(" ", "-", $workshop -> title())); ?>" onclick="onInterested(this.id)" data-content= "" title = "Subscription" >
							Interested?
						</label>
					</div>
				</div>
			</div>
			<?php } ?>
	</section>
</div>
<?php snippet('workshopFooter'); ?>
