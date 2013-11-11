<?php snippet('header') ?>

<div class="page_container speakersubs">
	<section>
		<h1><?php echo html($page->title()) ?></h1>
		<?php echo kirbytext($page -> text());
			echo $page -> form();
		?>
		
		<h1>Submit a talk</h1>
				<p>
					Fields denoted with a * are required
				</p>
		<div class="speaker_submission">
				<div class="ss-form">
					<iframe name="hidden_iframe" id="hidden_iframe">
					</iframe>
<form action="http://docs.google.com/spreadsheet/formResponse?formkey=dHo5ckpodXpYbzJRelplb2MzN3pOZ2c6MQ&amp;embedded=true&amp;ifq" target="hidden_iframe" id="ss-form" name = "speakerform" method="post"
target="hidden_iframe" onsubmit="(function(){if(formsubmit()){submitted=true;}})();">
						<fieldset>
							<script type="text/javascript"></script>
						<div class="errorbox-good">
							<div class="ss-item ss-item-required ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_0">What is the speakers name? *</label>
									<input type="text" name="entry.0.single" value="" class="ss-q-short" id="entry_0">
									<div id = "speaker"></div>								
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item ss-item-required ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_1">How can we contact them? <span class="ss-required-asterisk">*</span></label>
									<label class="ss-q-help" for="entry_1">Email, Twitter or IM, however we can get in touch!</label>
									<input type="text" name="entry.1.single" value="" class="ss-q-short" id="entry_1">
									<div id = "contactSpeaker"></div>
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-select">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_2">How do you know the speaker? </label>
									<label class="ss-q-help" for="entry_2"></label>
									<select name="entry.2.single" id="entry_2" class="ss-q-short">
										<option value=""></option>
										<option value="I saw them speak at an event.">I saw them speak at an event.</option>
										<option value="They are a friend/colleague.">They are a friend/colleague.</option>
										<option value="It&#39;s me, the speaker!">It&#39;s me, the speaker!</option>
									</select>
								</div>
							</div>
						</div>

						<div class="errorbox-good">
							<div class="ss-item  ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_3">Why should they speak for us? </label>
									<label class="ss-q-help" for="entry_3">What could they bring to the table? Tell us why they are awesome!</label>
									<textarea name="entry.3.single" value="" class="ss-q-short" id="entry_3" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_4">What would you like them to talk about? </label>
									<label class="ss-q-help" for="entry_4"></label>
									<textarea name="entry.4.single" value="" class="ss-q-short" id="entry_4" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-select">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_5">What should the style of their talk be? </label>
									<label class="ss-q-help" for="entry_5"></label>
									<select name="entry.5.single" id="entry_5" class="ss-q-short">
										<option value = ""></option>
										<option value="Talk">Talk</option>
										<option value="Lightning Talk">Lightning Talk</option>
										<option value="Panel Discussion">Panel Discussion</option>
										<option value="Tech Demo">Tech Demo</option>
										<option value="Workshop">Workshop</option>
									</select>
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-select">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_6">Preferred Length of Talk? </label>
									<label class="ss-q-help" for="entry_6"></label>
									<select name="entry.6.single" id="entry_6" class="ss-q-short">
										<option value=""></option>
										<option value="5-10 Minutes">5-10 Minutes</option>
										<option value="10-20 Minutes">10-20 Minutes</option>
										<option value="20-30 Minutes">20-30 Minutes</option>
										<option value="30-45 Minutes">30-45 Minutes</option>
										<option value="1 Hour+">1 Hour+</option>
										<option value="Full Day Workshop">Full Day Workshop</option>
									</select>
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_8">Links to things they have done. </label>
									<label class="ss-q-help" for="entry_8">Projects, Apps, Websites, Talks, anything!</label>
									<input type="text" name="entry.8.single" value="" class="ss-q-short" id="entry_8">
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_9">Their GitHub / Portfolio / Blog </label>
									<label class="ss-q-help" for="entry_9"></label>
									<input type="text" name="entry.9.single" value="" class="ss-q-short" id="entry_9">
								</div>
							</div>
						</div>
						<div class="errorbox-good">
							<div class="ss-item  ss-text">
								<div class="ss-form-entry">
									<label class="ss-q-title" for="entry_10">Link to their Lanyrd account. </label>
									<input type="text" name="entry.10.single" value="" class="ss-q-short" id="entry_10">
								</div>
							</div>
						</div>
						<div class="errorbox-good-list">
							<div class="ss-item  ss-checkbox">
								<label for="entry_7">What do you want them to talk about?</label>
								<div class="categories">
									<ul>
										<li class = "ss-choice-item">
											<input type="checkbox" name="entry.7.group" value="Zombies" class="ss-q-checkbox" id="group_7_1">
											<label class="ss-choice-label" for="group_7_1">Zombies</label>
										</li>
										<li class="ss-choice-item">
										
											<input type="checkbox" name="entry.7.group" value="Writing" class="ss-q-checkbox" id="group_7_2">	
												<label class="ss-choice-label" for"group_7_2">Writing</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Design" class="ss-q-checkbox" id="group_7_3">
												<label class="ss-choice-label" for "group_7_3">Design</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Javascript" class="ss-q-checkbox" id="group_7_4">
												<label class="ss-choice-label" for "group_7_4">Javascript</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="LEGO" class="ss-q-checkbox" id="group_7_5">
												<label class="ss-choice-label" for "group_7_5">LEGO</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Illustration" class="ss-q-checkbox" id="group_7_6">
												<label class="ss-choice-label" for "group_7_6">Illustration</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Web Design" class="ss-q-checkbox" id="group_7_7">
												<label class="ss-choice-label" for "group_7_7">Web Design</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Development" class="ss-q-checkbox" id="group_7_8">
												<label class="ss-choice-label" for "group_7_8">Development</label>
										</li>
										<li class="ss-choice-item">
										
												<input type="checkbox" name="entry.7.group" value="Libraries" class="ss-q-checkbox" id="group_7_9">
													<label class="ss-choice-label" for "group_7_9">Libraries</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="APIs" class="ss-q-checkbox" id="group_7_10">
												<label class="ss-choice-label" for "group_7_10">APIs</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Arduino" class="ss-q-checkbox" id="group_7_11">
												<label class="ss-choice-label" for "group_7_11">Arduino</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Mobile" class="ss-q-checkbox" id="group_7_12">
												<label class="ss-choice-label" for "group_7_12">Mobile</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Internet of things" class="ss-q-checkbox" id="group_7_13">
												<label class="ss-choice-label" for "group_7_13">Internet of things</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Gaming" class="ss-q-checkbox" id="group_7_14">
												<label class="ss-choice-label" for "group_7_14">Gaming</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Scaling" class="ss-q-checkbox" id="group_7_15">
												<label class="ss-choice-label" for "group_7_15">Scaling</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Architecture" class="ss-q-checkbox" id="group_7_16">
												<label class="ss-choice-label" for "group_7_16">Architecture</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Optimisation" class="ss-q-checkbox" id="group_7_17">
												<label class="ss-choice-label" for "group_7_17">Optimisation</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Browsers" class="ss-q-checkbox" id="group_7_18">
												<label class="ss-choice-label" for "group_7_18">Browsers</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Frameworks" class="ss-q-checkbox" id="group_7_19">
												<label class="ss-choice-label" for "group_7_19">Frameworks</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Serverside" class="ss-q-checkbox" id="group_7_20">
												<label class="ss-choice-label" for "group_7_20">Serverside</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Clientside" class="ss-q-checkbox" id="group_7_21">
												<label class="ss-choice-label" for "group_7_21">Clientside</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="TV" class="ss-q-checkbox" id="group_7_22">
												<label class="ss-choice-label" for "group_7_22">TV</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Patterns" class="ss-q-checkbox" id="group_7_23">
												<label class="ss-choice-label" for "group_7_23">Patterns</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Real time web" class="ss-q-checkbox" id="group_7_24">
												<label class="ss-choice-label" for "group_7_24">Real time web</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Data" class="ss-q-checkbox" id="group_7_25">
												<label class="ss-choice-label" for "group_7_25">Data</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Security" class="ss-q-checkbox" id="group_7_26">
												<label class="ss-choice-label" for "group_7_26">Security</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Testing" class="ss-q-checkbox" id="group_7_27">
												<label class="ss-choice-label" for "group_7_27">Testing</label>
										</li>
										<li class="ss-choice-item">
											<label class="ss-choice-label">
												<input type="checkbox" name="entry.7.group" value="Electronics" class="ss-q-checkbox" id="group_7_28">
												Electronics</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Hacking" class="ss-q-checkbox" id="group_7_29">
												<label class="ss-choice-label" for "group_7_29">Hacking</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Storytelling" class="ss-q-checkbox" id="group_7_30">
												<label class="ss-choice-label" for "group_7_30">Storytelling</label>
										</li>
										<li class="ss-choice-item">
											
												<input type="checkbox" name="entry.7.group" value="Hardware" class="ss-q-checkbox" id="group_7_31">
												<label class="ss-choice-label"for "group_7_31">Hardware</label>
										</li> 
										<!-- li, first input, label, second.
										//li, input -->
										<li class="ss-choice-item wider">
											<input type="checkbox" name="entry.7.group" value="__option__" class="ss-q-checkbox" id="other_option:7">
											<label for="other_option:7">
												Other:
											</label>
										<input type="text" name="entry.7.group.other_option_" value="" class="ss-q-other" id="other_option:7">
										</li>
									</ul>
								</div>
							</div>
						</div>
						</fieldset>
						<div id = "submitWarning"></div>	
						<div class="ss-form-entry">
										<input type="hidden" name="pageNumber" value="0">
						<input type="hidden" name="backupCache" value="">
				<input type="submit" name="submit" value="Submit" class="button">
			</div>
					</form>
				</div>
			
			
			</section>
		</div>
<?php snippet('speakFooter',array(
	'bottom_scripts' => array(
		'http://code.jquery.com/jquery-latest.min.js')))?>