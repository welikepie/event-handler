<?php snippet('header'); ?>
<div class="page_container">
<section>

<?php
echo("<h1>LOL</h1>");
$testvalue = 2;
$year = 2012;

if(isset($_POST['nextMonth'])){
$testvalue = $_POST['monthUp'];
}
if(isset($_POST['prevMonth'])){
$testvalue = $_POST['monthDown'];
}

if($testvalue > 12){
	$testvalue = 1;
	$year = $year+1;
}
if($testvalue < 1){
	$testvalue = 12;
	$year = $year-1;
}
echo($testvalue.",".$year);?>
<form action = "test.php" method="post">
<input type = "number" name="monthUp" value = "<?php echo($testvalue+1)?>">
<input type="submit" name="nextMonth" value="nextMonth" />
</form>
<form action = "test.php" method="post">
<input type = "number" name="monthDown" value = "<?php echo($testvalue-1)?>">
<input type="submit" name="prevMonth" value="prevMonth" />
</form>










</section>
</div>
<?php snippet('footer'); ?>