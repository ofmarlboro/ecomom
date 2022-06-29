<?
	$PageName = "K08";
	$SubName = "K0801";
	$PageTitle = "산골알림장";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<? //include("../include/mypage_top02.php");?>
		<? //include("../include/oe_menu05.php");?>

		<div class="inner pt20 mypage">
			<h1><img src="/image/sub/sangol_notice.png" alt="" style="width: 180px;"></h1>

			<?php
			include "{$view}.php";
			?>

		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>

<? include('../include/footer.php') ?>