<?
	$PageName = "";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?php
		include "{$view}.php";
		?>
	</div>
	<!--END Container-->
	<div class="mg95"></div>

<? include('../include/footer.php') ?>


