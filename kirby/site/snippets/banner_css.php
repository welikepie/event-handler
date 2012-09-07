<?php if (isset($banners)) {

	$mq = '@media all and (max-width: %dpx) { %s }';
	$style ='.map_container + .page_container { ' .
				'margin-top: %dpx; ' .
			'} ' .
			'.map_container { ' .
				'height: %dpx; ' .
				'background: white url("%s") no-repeat %dpx top; ' .
			'}';
	
	$images = array();
	foreach ($banners as &$filename) { $images[] = $page->images()->find($filename); }
	usort($images, create_function('$a, $b', 'return $b->width() - $a->width();'));
	
	$result = array();
	$first = true;
	foreach ($images as &$image) {
		$temp = ((960 - $image->width()) / 2) + 89;
		$temp = sprintf($style, $image->height() + 60, $image->height(), $image->url(), $temp);
		if ($first) { $first = false; }
		else { $temp = sprintf($mq, $image->width(), $temp); }
		$result[] = $temp;
	}
	
	echo("<style type=\"text/css\">\n" . implode("\n", $result) . "\n</style>\n");

} ?>