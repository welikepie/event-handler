<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="main_content">
    	<h1><?php echo html($page->title()) ?></h1>
		
    	<?php echo kirbytext($page->text()) ?>
		
		<?php $booking = $page->booking_link();
		      if ($booking) { ?><a href="<?php echo $booking; ?>" rel="external" class="booking">Book this place</a><?php } ?>
		
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
	
	<div class="additional_content_wrapper">
		<div class="additional_content">
			<?php echo $page->additional(); ?>
		</div>
	</div>
	
  </article>

</section>

<?php snippet('footer') ?>