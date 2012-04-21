<?php snippet('header') ?>

<?php

	$homepage = $pages->find('home');
	$temp = $homepage->alert(); if ($temp) {
		?><div class="alert"><?php echo($temp); ?></div><?php
	}
?>

<section class="content">
  <article>
	<div class="main_content">
    	<h1><?php echo html($page->title()) ?></h1>
		
    	<?php
					$html = kirbytext($page->text());
					$html = preg_replace('/<p>/i', '<p><span class="figure">Fig. 1 </span>', $html, 1);
					echo $html;
				?>
		
		<?php $booking = $page->booking_link();
		      if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">View Tickets</a><?php } ?>
		
		<table>
			<caption>What</caption>
			<thead>
				<tr>
					<td colspan="2"><?php echo kirbytext($page->what()); ?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th scope="row">Where</th>
					<td><?php echo kirbytext($page->where()); ?></td>
				</tr>
				<tr>
					<th scope="row">When</th>
					<td><?php echo $page->date("jS F Y"); ?></td>
				</tr>
				<tr>
					<th scope="row">Cost</th>
					<td><?php echo kirbytext($page->cost()); ?></td>
				</tr>
			</tbody>
		</table>
		
		<?php $map = $page->map();
		      if ($map) { echo snippet('map', array('address' => $map, 'width' => '', 'height' => '')); } ?>
	
	</div>
	
	<?php $additional = $page->additional(); if ($additional) { ?>
	<div class="additional_content_wrapper">
		<div class="background_element">
			<div class="actual_background"></div>
		</div>
		<div class="additional_content">
			<?php echo $additional; ?>
		</div>
	</div>
	<?php } ?>
  </article>

</section>

<?php snippet('footer') ?>