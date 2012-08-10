<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="page_container podcast">
		<section>
			<h1><?php echo html($page->title()) ?></h1>
			<?php echo kirbytext($page->text()); ?>
			
			<div class="profiles">
			<?php
				$profiles = yaml($page->profiles());
				foreach ($profiles as $name => &$profile) {
				
					?><div class="profile">
						<h2><?php echo html($name); ?></h2>
						<!-- <?php var_dump($profile['Description']); ?>-->
						<div class="description"><?php echo kirbytext($profile['Description']); ?></div>
						<div class="lists">
						<?php
						
							// Podcasts list
							if (count($profile['Podcasts'])) {
								echo('<!-- '); var_dump($profile['Podcasts']); echo(' -->');
								echo('<ul class="podcasts">');
								foreach ($profile['Podcasts'] as $title => $link) {
									echo('<li><a href="' . $link . '">' . $title . '</a></li>');
								}
								echo('</ul>');
							}
							
							// Videos list
							if (count($profile['Videos'])) {
								echo('<ul class="videos">');
								foreach ($profile['Videos'] as $title => $link) {
								
									// Vimeo embed
									$temp = array(); 
									if (preg_match('/^http:\/\/(?:www\.)?vimeo.com\/([0-9]+)/i', $link, $temp)) {
										$link = 'http://player.vimeo.com/video/' . $temp[1];
									}
									
									echo('<li><iframe src="' . $link . '" width="480" height="358" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe><p>' . $title . '</p></li>');
									
								}
								echo('</ul>');
							}
						
						?>
						</div>
					</div><?php
				
				} unset($profile); unset($profiles);
			?>
			</div>
		</section>
	</div>
  </article>

</section>

<?php snippet('footer') ?>