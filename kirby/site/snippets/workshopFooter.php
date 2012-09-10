		<footer>
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

<script src="assets/scripts/jQuery1-8-0.js"></script>
<script src="assets/scripts/bootstrap-tooltip.js"></script>
<script src="assets/scripts/bootstrap-popover.js"></script>
<script src="assets/scripts/workshopForms.js"></script>

</html>
