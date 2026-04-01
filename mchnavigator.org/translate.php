<?php
$section = 'about';
$page = 'copyright';
$page_title = "Translate";
include ('incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('incl/leftnav.html'); ?>
<div class="nine columns">

<div class="tbl">
	<div style="display: table-row;">
		<div style="display: table-cell; min-width: 160px;">
			<img alt="<?php echo($page_title) ?>" src="<? echo($baseURL) ?>images/headers/trainings.jpg" style="border-radius: 15px 0 0 15px; display: block; width: 100%;">
		</div>
		<div class="title">
			<h1 id="fittext3" style="line-height: .9;"><?php echo($page_title)?></h1>
		</div>
	</div>
</div>	
<span><?php include(__DIR__ . "/../globals/translate.php") ?></span> 

</div>
</div>


<?php include('incl/footer.html'); ?>