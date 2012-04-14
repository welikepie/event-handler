<?php

$instances = g::get('kmap.instances');
g::set('kmap.instances', $instances+1);

if(!isset($id))      $id      = 'map-' . uniqid();
if(!isset($width))   $width   = 300;
if(!isset($height))  $height  = 300;
if(!isset($type))    $type    = 'roadmap'; // roadmap, sattelite, hybrid, terrain 
if(!isset($class))   $class   = 'map';
if(!isset($zoom))    $zoom    = 15;
if(!isset($address)) $address = 'Mannheim, Germany';

?>
<?php if(!$instances): ?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

var kmap = (function () {
	"use strict";

	var init, load;

	init = function (options) {

		var img, elem, geocoder, map;

		img = document.getElementById(options.element);
		if (!img) { return; }

		elem = document.createElement('div');
		elem.id = options.element;
		elem.className = options.className;
		if (!!options.width) { elem.style.width = options.width + 'px'; }
		if (!!options.height) { elem.style.height = options.height + 'px'; }

		img.parentNode.replaceChild(elem, img);

		if (typeof options.zoom !== "number") { options.zoom = 12; }
		if ((typeof options.type !== "string") || !options.type) {
			options.type = 'ROADMAP';
		} else {
			options.type = options.type.toUpperCase();
			switch (options.type) {
			case 'ROADMAP':
			case 'SATELLITE':
			case 'HYBRID':
			case 'TERRAIN':
				break;
			default:
				options.type = 'ROADMAP';
				break;
			}
		}

		map = new google.maps.Map(elem, {
			zoom : options.zoom,
			center : new google.maps.LatLng(49.46097, 8.49042),
			mapTypeId : google.maps.MapTypeId[options.type]
		});

		geocoder = new google.maps.Geocoder();
		geocoder.geocode({'address': options.address}, function (results, status) {

			var marker;

			if (status === google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				marker = new google.maps.Marker({'map': map, 'position': results[0].geometry.location});
			}

		});

	};

	load = function (options) {

		var wrapper_event, old_onload;

		// Attempt modern approach first
		if (typeof window.addEventListener === "function") {
			window.addEventListener('load', function () { init(options); }, false);
		// Attempt older IE way
		} else if (typeof window.attachEvent === "function") {
			window.attachEvent('onload', function () { init(options); });
		// Attempt the ancient method
		} else {

			if (typeof window.onload === "function") {
				old_onload = window.onload;
				wrapper_event = function (ev) {
					old_onload(ev);
					init(options);
				};
			} else {
				wrapper_event = function (ev) {
					init(options);
				};
			}

			window.onload = wrapper_event;

		}

	};

	return {"init": init, "load": load};

}());

</script>
<?php endif; ?>
<script type="text/javascript">
kmap.load({
  'address'  : '<?php echo $address ?>',
  'zoom'     : <?php echo $zoom ?>,
  'element'  : '<?php echo $id ?>',
  'type'     : '<?php echo $type ?>',
  'width'    : '<?php echo $width ?>',
  'height'   : '<?php echo $height ?>',
  'className': '<?php echo $class ?>'  
});
</script>
<noscript id="<?php echo $id ?>" class="<?php echo $class ?>">
  <img src="http://maps.google.com/maps/api/staticmap?center=<?php echo urlencode($address) ?>&zoom=<?php echo $zoom ?>&size=<?php echo $width ?>x<?php echo $height ?>&maptype=<?php echo str::lower($type) ?>&markers=color:red|color:red|<?php echo urlencode($address) ?>&sensor=false" width="<?php echo $width ?>" height="<?php echo $height ?>" class="<?php echo $class ?>" alt="<?php echo html($address) ?>" />
</noscript>