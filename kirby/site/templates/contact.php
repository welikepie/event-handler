<?php snippet('header') ?>

<section class="content">

  <article>
	<div class="page_container contact">
		<section>
			<h1><?php echo html($page->title()) ?></h1>
			<?php echo kirbytext($page->text()); ?>
			
			<h2>Subscribe to our mailing list</h2>
			<form action="http://welikepie.us2.list-manage1.com/subscribe/post?u=b76886bab37470b1e293804f6&amp;id=801bc2e5e9" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate mailing_list" target="_blank">
				<fieldset>
					<input type="email" name="EMAIL" class="email" id="mce-EMAIL" value="" placeholder="Your e-mail address" required>
					<div class="categories">
						<label><input type="checkbox" id="everything_check" checked> Everything</label>
						<label><input type="checkbox" name="DEV" value="Subscribe" checked> Development</label>
						<label><input type="checkbox" name="DESIGN" value="Subscribe" checked> Design</label>
						<label><input type="checkbox" name="SOCIAL" value="Subscribe" checked> Social</label>
					</div>
					<div class="error">You need to select at least one category.</div>
				</fieldset>
				<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
			</form>
		</section>
	</div>
  </article>

</section>

<script type="text/javascript">

	window.contact_checkboxes = function () {
	
		var form = document.getElementById('mc-embedded-subscribe-form');
		var toggle_checkbox = document.getElementById('everything_check');
		var category_boxes = [form.DEV, form.DESIGN, form.SOCIAL];
		var error_message = document.getElementById('mc-embedded-subscribe-form')
		                    .getElementsByTagName('div');
		error_message = error_message[error_message.length - 1];
		
		var form_submit = function (ev) {
			var i, temp = false;
			for (i = 0; i < category_boxes.length; i++)
				if (category_boxes[i].checked)
					temp = true;
			if (!temp) {
				ev.preventDefault();
				error_message.style.display = 'block';
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
	
	}();

</script>

<?php snippet('footer') ?>