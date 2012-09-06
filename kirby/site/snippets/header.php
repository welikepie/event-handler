<!DOCTYPE html>
<html lang="en">
	<head>
		
		<title><?php echo html($site->title()); ?> - <?php echo html($page->title()); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
		<meta name="description" content="<?php echo html($site->description()); ?>">
		<meta name="keywords" content="<?php echo html($site->keywords()); ?>">
		<meta name="robots" content="index, follow">

		<?php echo css('assets/styles/main.css'); ?>
		<!--[if lt IE 8]><style type="text/css">
		
		/* This is more or less how the box sizing polyfill is to be used.
		 * Not added in a script tag (as it is NOT a script, but as CSS "behavior" property,
		 * a proprietary MS extension. Just as it was specified in the usage instructions on
		 * the polyfill's github page.
		 * The line is included here, in HTML, rather than in CSS because "behavior" property
		 * resolves its URLs relative to HTML document, not the CSS file, hence the need to
		 * use the url() kirby function.
		 */
		
		* {
			box-sizing: border-box;
			behavior: url(<?php echo url('assets/styles/boxsizing.htc'); ?>);
		}
		
		</style><![endif]-->
		
		<link rel="shortcut icon" href="<?php echo url('assets/images/favicon.png'); ?>" type="image/png">
		<link rel="icon" href="<?php echo url('assets/images/favicon.png'); ?>" type="image/png">
		<link rel="apple-touch-icon" href="<?php echo url('assets/images/apple-touch-icon.png'); ?>">

		<!--[if lt IE 9]><script type="text/javascript" src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<script type="text/javascript" src="http://use.typekit.com/enx4ueb.js">console.log("LOL");</script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-30903988-1']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();

		</script>
		<?php
		if (isset($head_scripts))
			foreach ($head_scripts as &$script)
				echo('<script type="text/javascript" src="' . $script . '"></script>');
		if (isset($head_snippets))
			foreach ($head_snippets as &$snippet)
				echo('<script type="text/javascript">' . $snippet . '</script>');
		?>
	</head>
	<body>
		<header class="tk-futura-pt-condensed">
			<h1><a href="<?php echo url(''); ?>"><span class="hidden">Event Handler - events for geeks</span></a></h1>
			<?php snippet('menu'); ?>
		</header>