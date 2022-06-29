<?
	$PageName = "LEAVE";
	$SubName = "회원탈퇴 페이지입니다.";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>

		<script type="text/javascript">
		<!--
			function leave(){
				if(checkForm('leave_form')){
					if(confirm('회원을 탈퇴하시면 모든 주문기록 및 게시물이 삭제됩니다.\n탈퇴 하시겠습니까?')){
						$("#leave_form").submit();
					}
				}
			}
		//-->
		</script>

		<div class="my_cont clearfix">
			<?php
			include "{$view}.php";
			?>
		</div>
	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
