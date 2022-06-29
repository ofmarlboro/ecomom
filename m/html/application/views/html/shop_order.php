<?
	$PageName = "SHOP_ORDER";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1><?=($this->input->get('sample') == "ok")?"샘플신청":"주문/결제하기";?></h1>

		<?php
		include "{$view}.php";
		?>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
