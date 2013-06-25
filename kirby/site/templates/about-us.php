<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="page_container about_us">
		<section>
			<h1><?php echo html($page->title()) ?></h1>
			<?php echo kirbytext($page->text()); ?>
			
			<div class="profiles">
			<?php
				$profiles = yaml($page->profiles());
				foreach ($profiles as $name => &$profile) {
					?><div class="profile">
						<div>
							<h2><?php echo html($name); ?></h2>
							<?php echo kirbytext($profile['Text']); ?>
						</div>
						<img src="<?php echo url($profile['Image']); ?>" alt="Picture of <?php echo $name; ?>">
					</div><?php
				
				} unset($profile); unset($profiles);
			?>
			</div>
		</section>
	</div>
  </article>
</section>

<?php snippet('footer', array(
	'bottom_snippets' => array(
<<<EOT
var formSubmitted = false;
var errorFree = false;

function formSubmit(){
	var regex = /[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
	if(document.getElementById("mce-EMAIL").value.match(regex)!=null){	
		document.getElementById("email").style.display = "none";
		formSubmitted = true;
		return true;
	}
	else{
		document.getElementById("successSubmit").style.display = "none";
		document.getElementById("email").style.display = "block";
		formSubmitted = false;
		return false;
	}	
}
	(function () { 
	
		var form = document.getElementById('mc-embedded-subscribe-form');
		var toggle_checkbox = document.getElementById('everything_check');
		var category_boxes = [form.DEV, form.DESIGN, form.SOCIAL];
		var error_message = document.getElementById('mc-embedded-subscribe-form')
		                    .getElementsByTagName('div');
		error_message = document.getElementById("cat");
		
		
		
		var form_submit = function (ev) {
			var i, temp = false;
			for (i = 0; i < category_boxes.length; i++)
				if (category_boxes[i].checked)
					temp = true;
			if (!temp) {
				ev.preventDefault();
				document.getElementById("successSubmit").style.display = "none";
				errorFree = false;
				error_message.style.display = 'block';
			}
			else{
				errorFree = true;
				error_message.style.display = 'none';
			}
		if(errorFree == true && formSubmitted == true){
			document.getElementById("successSubmit").style.display = "block";
			errorFree == false;
			formSubmitted == false;
		}
		};
		
		var everything_toggle = function (ev) {
			var i;
			for (i = 0; i < category_boxes.length; i++)
				category_boxes[i].checked = toggle_checkbox.checked;
		};
		
		var adjust_toggle = function(ev) {
			var i, temp = true;
			for (i = 0; i < category_boxes.length; i++)
				if (!category_boxes[i].checked)
					temp = false;
			toggle_checkbox.checked = temp;
		}
		
		var i;
		if (typeof window.addEventListener === 'function') {
			form.addEventListener('submit', form_submit, false);
			toggle_checkbox.addEventListener('change', everything_toggle, false);
			for (i = 0; i < category_boxes.length; i++)
				category_boxes[i].addEventListener('change', adjust_toggle, false);
		} else if (typeof window.attachEvent === 'function') {
			form.attachEvent('onsubmit', form_submit);
			toggle_checkbox.attachEvent('onchange', everything_toggle);
			for (i = 0; i < category_boxes.length; i++)
				category_boxes[i].attachEvent('onchange', adjust_toggle);
		}
	
	}());
EOT
	)
)) ?>