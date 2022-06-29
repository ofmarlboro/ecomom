<?
	$PageName = "INTE";
	$SubName = "";
	$PageTitle = "회원 아이디 통합";
	include('../include/head.php');
	include('../include/header.php');
?>


	<!--Container-->

	<style type="text/css">


	</style>

	<div id="container">
		<?include("../include/my_top.php");?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>

			<div class="inte my_cont">
				<p class="inte__tit">회원 아이디 통합</p>
				<p class="inte__stit">아래 인증 방법을 통해 본인인증 후 통합 하실 수 있습니다.</p>

				<div class="inte__iden">
					<p class="iden__tit">본인인증 후 통합</p>

					<ul class="iden__list">
						<li>
							<div class="">
								<img src="/image/sub/i01.png" alt="" />
							</div>

							<a href="javascript:;" class="inte__btn" onclick="fnPopup()">휴대폰 인증하기</a>
						</li>

					</ul>
				</div>

			</div>


		</div>
	</div>
	</div>
	<!--END Container-->


	<? include $_SERVER['DOCUMENT_ROOT']."/nice/checkplus_main.php"; ?>

	<form method="post" name="nice_certification" id="nice_certification" action="/html/dh/identity02">
		<input type="hidden" name="name">
		<input type="hidden" name="birthdate">
		<input type="hidden" name="gender">
		<input type="hidden" name="dupinfo">
		<input type="hidden" name="mobileno">
		<input type="hidden" name="mobileco">
		<input type="hidden" name="certifi_type">
	</form>

<? include('../include/footer.php') ?>

