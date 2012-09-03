<?php snippet('header'); ?>
<head>
</head>
<!--<body  onload='document.getElementById("Code-along").click()'>-->
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
					
					
					<div class= "rightContainer">
						<div id = "<?php echo(str_replace(" ", "|", $workshop -> title())); ?>" class = "signUpBox">
							<div><p id = "buttonHead">Want to hear more?</p><p id = "buttonSub">Click now</p></div>
							</div>
							
							<label class="rightFormCheck" id="<?php echo(str_replace(" ", "-", $workshop -> title())); ?>" onclick="onInterested(this.id)" >
								<div>Subscribe</div>
							</label>
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
<form action = "assets/serverside/workshopForm.php" method="post" onsubmit ="return formsubmit(this.id)" id="<?php echo("FORM" . str_replace(" ", "_", $workshop -> title())); ?>" name = "mc-embedded-subscribe-form" target="formReceiver">
	<div class="formLabels">
		<label> Tell us your email address</label>
		<span class = "close" onclick="onClose()">×</span>
	</div>
	<div class = emailInput>
		<input type="text" name = "email" id="<?php echo("EMAIL" . str_replace(" ", "_", $workshop -> title())); ?>">
		<input type="submit" value = "Submit" class = "submitButton" id = <?php echo("SUBMIT" . str_replace(" ", "_", $workshop -> title())); ?>></button> 
	</div>
<div class = "hidden">InterestedIn: <input type = "text" value = "<?php echo($workshop -> interestgroup());?>" name = "interest"></div>
</form>
<div class = "error" id="<?php echo("ERROR" . str_replace(" ", "_", $workshop -> title())); ?>">
</div>
</div>	 

<div class = "hidden" id = "<?php echo("THANKS".str_replace(" ", "_", $workshop -> title())); ?>">
<label class = "close" onclick="onClose()">×</label>
<div class = "thanks"><p>Thanks for your interest, we’ll keep you updated.</p></div>
</div>

<div class = "hidden" id = "<?php echo("THANKS2".str_replace(" ", "_", $workshop -> title())); ?>">
<label class = "close" onclick="onClose()">×</label>
<div class = "thanks"><p>Thanks!</p><p>We’ve updated your subscription so we can give you information on this workshop too.</p></div>
</div>
<!--ssssh!-->

				</div>
			</div>
			<?php } ?>
			<iframe id="formReceiver" name="formReceiver"></iframe>
			
</section>
</div>
<?php snippet('workshopFooter'); ?>