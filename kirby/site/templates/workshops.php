<?php snippet('header'); ?>
<head>
	
		<?php echo css('assets/styles/main.css'); ?>
</head>
<div class="page_container workshops">
	<section>
		<div class="introduction">
			<h1><?php echo html($page -> title()); ?></h1>
			<div class="description"><?php echo kirbytext($page -> text()); ?></div>
		</div>
			<?php
		$fieldName=64;
			$workshops = $pages
				->find('workshops')
				->children()
				->visible();
		
			foreach ($workshops as $workshop) { ?>
			<div class="workshop">
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
<!--divs are hidden from the user. Intentionally. -->			
<div class = "hiddenMailSubscribe" id="<?php echo(str_replace(" ", "_", $workshop -> title())); ?>" >
<?php
$formUrl = $workshop -> formsite();
$formSite = "";
if ($formUrl) {
$formSite = html($formUrl);
}
?>
<label onclick="		$('.popover').fadeToggle('fast', function () { $('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide')});">x</label>
<form action = "assets/serverside/workshopForm.php" method="post" onsubmit ="return formsubmit(this.id)" id="<?php echo("FORM" . str_replace(" ", "_", $workshop -> title())); ?>" name = "mc-embedded-subscribe-form" target="formReceiver">
<div class = emailInput><p>What is your email address?</p><input type="text" name = "email" id="<?php echo("EMAIL" . str_replace(" ", "_", $workshop -> title())); ?>"></div>
<div class = "hidden">InterestedIn: <input type = "text" value = "<?php echo($workshop -> title()." with ".$workshop -> lecturer())?>" name = "interest"></div>
<div class = "error" id="<?php echo("ERROR" . str_replace(" ", "_", $workshop -> title())); ?>">
</div>
<input type="submit" value = "Submit" class = "submitButton" id = <?php echo("SUBMIT" . str_replace(" ", "_", $workshop -> title())); ?>></button> 
</form>
</div>	 

<div class = "hidden" id = "<?php echo("THANKS".str_replace(" ", "_", $workshop -> title())); ?>">
<label onclick="		$('.popover').fadeToggle('fast', function () { $('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide')});">x</label>
<div>Thank you for showing interest! We'll get back to you soon!</div>
</div>

<div class = "hidden" id = "<?php echo("THANKS2".str_replace(" ", "_", $workshop -> title())); ?>">
<label onclick="		$('.popover').fadeToggle('fast', function () { $('#'+this.parentNode.id.replace(/_/gi,'-')).popover('hide')});">x</label>
<div>You're Awesome! Have Karma!</div>
</div>
<!--ssssh!-->
					<div class= "rightContainer">
						<div id = "<?php echo(str_replace(" ", "|", $workshop -> title())); ?>" class = "signUpBox">
							<div><p id = "buttonHead">Sign up for free</p><p id = "buttonSub">For any of our workshops</p></div>
							</div>
							
							<label class="rightFormCheck" id="<?php echo(str_replace(" ", "-", $workshop -> title())); ?>" onclick="onInterested(this.id)" data-content= "" title = "Subscription" >
								<div>Signup Now</div>
							</label>
					</div>
				</div>
			</div>
			<?php } ?>
			<iframe id="formReceiver" name="formReceiver"></iframe>
			
</section>
</div>
<?php snippet('workshopFooter'); ?>
