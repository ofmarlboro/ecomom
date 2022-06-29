<?
	if(strpos($_SERVER['REQUEST_URI'],"dh/wc04")!==false){
		alert(cdir()."/dh_board/lists/wc04");
	}

	$PageName = "K08";
	$SubName = "K080304";
	$PageTitle = "이유식공부하기";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<? //include("../include/mypage_top02.php");?>
		<? //include("../include/oe_menu05.php");?>
		<? include("../include/view_tab04.php");?>


		<div class="inner pt20">

			<?php
			include "{$view}.php";
			?>

		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>










<? include('../include/footer.php') ?>


