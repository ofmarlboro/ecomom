<?
	$PageName = "INTE";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->
<div id="container">
	<?include("../include/top_menu.php");?>


	<div class="inte">
		<p class="inte__tit">회원 아이디 통합</p>
		<p class="inte__stit">회원 아이디 통합 페이지 입니다.</p>

		<div class="inner">
			<p class="inte__param01">아래 인증 방법을 통해 <br> 본인인증 후 통합 하실 수 있습니다.</p>

			<div class="inte__iden">
				<p class="iden__tit">본인인증 후 통합</p>

				<div class="">
					<img src="/image/sub/i01.png" alt="" />
				</div>

				<a href="javascript:;" class="inte__btn" onclick="fnPopup()">휴대폰 인증하기</a>

			</div>
		</div>
	</div>
	<!-- //inner -->
</div>
<!--END Container-->


	<? include $_SERVER['DOCUMENT_ROOT']."/nice/checkplus_main.php"; ?>

	<form method="post" name="nice_certification" id="nice_certification" action="<?=cdir()?>/dh/identity02">
		<input type="hidden" name="name">
		<input type="hidden" name="birthdate">
		<input type="hidden" name="gender">
		<input type="hidden" name="dupinfo">
		<input type="hidden" name="mobileno">
		<input type="hidden" name="mobileco">
		<input type="hidden" name="certifi_type">
	</form>


<? include('../include/footer.php') ?>

