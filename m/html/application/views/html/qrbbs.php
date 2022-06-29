<?
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>

		<div class="inner pt20 mypage">

			<?php
			include "{$view}.php";
			?>

		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>

<? include('../include/footer.php') ?>