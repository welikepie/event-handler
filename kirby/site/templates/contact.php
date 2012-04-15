<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="main_content">
    	<h1><?php echo html($page->title()) ?></h1>
    	<?php echo kirbytext($page->text()); ?>
		
		<h2>Subscribe to our mailing list</h2>
		<form action="http://welikepie.us2.list-manage1.com/subscribe/post?u=b76886bab37470b1e293804f6&amp;id=801bc2e5e9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate mailing_list" target="_blank">
			<label><input type="email" name="EMAIL" class="email" id="mce-EMAIL" value="" placeholder="Your e-mail address" required></label>
			<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
		</form>
		
	</div>
  </article>

</section>

<?php snippet('footer') ?>