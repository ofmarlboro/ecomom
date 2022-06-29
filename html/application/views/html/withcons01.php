<?
	$PageName = "K08";
	$SubName = "K0801";
	$PageTitle = "산골알림장";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>

		<div class="content inner">

			<?php
			include "{$view}.php";
			?>

		</div>
	</div><!--END Container-->


<? include('../include/footer.php') ?>