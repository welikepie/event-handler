<?php snippet('header')
?>

<section class="aboutus_content jobs">
<div class="introduction">
<h1><?php echo html($page -> title()); ?></h1>
<?php echo kirbytext($page -> text()); ?>
</div>

<?php echo ($page -> formstart());
$workshops = $pages->find('workshops');
$workshops = $workshops->children()->visible();
//$workshops = $workshops->sortBy('title','desc');

foreach ($workshops as $workshop) {

?>

	<div class="job">
		<h1><?php echo html($workshop -> title()); ?></h1>
			<div class="details">
				<img src= "<?php 
				if($workshop->imagepath()!=null){
				echo ($workshop->imagepath());}
				else{echo("DEFAULT PATH");} 	
				  ?>
				" >
				<p class="meta">Lecturer: <span><?php echo html($workshop -> lecturer()); ?></span></p>
				<p class="meta">Description: <span><?php echo kirbytext($workshop -> description()); ?></span></p>
				<label class="rightFormCheck">Let Me Know  <input type="checkbox" id=<?php echo(str_replace(" ","_",$workshop->title()));?> value="Subscribe" checked></label>
			</div>
	</div>

<?php

}
?>
<div>
<?php echo ($page -> formend());?>
</div>

</section>
<?php snippet('footer')
?>