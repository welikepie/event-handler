<?php
	$typekit_adjust = <<< EOT
// Typekit badge is sometimes inserted in such places that
// it breaks layout. Reposition it as soon as posssible
var typekit_adjust = setInterval(function () {
	var badge = $('.typekit-badge');
	if (badge.length) {
		badge.remove().appendTo('body');
		clearInterval(typekit_adjust);
	}
}, 1000);
EOT;
	if ($bottom_snippets) {
		$bottom_snippets[] = $typekit_adjust;
	} else {
		$bottom_snippets = array($typekit_adjust);
	}
?>		<footer>
			<a href="<?php echo ($pages->find('terms')->url()); ?>">Terms &amp; Conditions</a>
		</footer>
	</body>
	<?php
	if (isset($bottom_scripts))
		foreach ($bottom_scripts as &$script)
			echo('<script type="text/javascript" src="' . $script . '"></script>');
	if (isset($bottom_snippets))
		foreach ($bottom_snippets as &$snippet)
			echo('<script type="text/javascript">' . $snippet . '</script>');

?>
	<script type="text/javascript">
		
	$(document).ready(function () {
		//$("[rel=tooltip]").tooltip();
	  });
		
	</script>

</html>