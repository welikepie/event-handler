		<footer>
			<!--<?php echo kirbytext($site->copyright()) ?>-->
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
</html>