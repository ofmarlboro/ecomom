<?
	$PageName = "FIND_PW";
	$SubName = "";
	$PageTitle = "비밀번호 찾기";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/my_top.php");?>
		<div class="inner clearfix mt20">

				<?php
				include "{$view}.php";
				?>

		</div>
	</div><!--END Container-->


<? include('../include/footer.php') ?>