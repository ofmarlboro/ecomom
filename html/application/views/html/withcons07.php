<?
	if($mybbs){
		$PageName = "MYQNA";
		$SubName = "MYQNA";
		$PageTitle = "";
	}
	else{
		$PageName = "K08";
		$SubName = "K0807";
		$PageTitle = "1:1문의";
	}
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?php
		if($mybbs){
			include("../include/my_top.php");
		?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">
				<div>
					<?php

					include "{$view}.php";
					?>
				</div>
			</div>
		</div>
		<?php
		}
		else{
			include("../include/sub_top.php");
			?>
			<div class="content inner">
				<?php
				include "{$view}.php";
				?>
			</div>
			<?php
		}
		?>

	</div><!--END Container-->

	<script type="text/javascript">
		function menuPop(recom_idx){
			window.open('/html/dh/menu_popup?recom_idx='+recom_idx, 'menu', 'width=900, height=800, scrollbars=yes');
		}
	</script>


<? include('../include/footer.php') ?>