<?
	$PageName = "INTE";
	$SubName = "";
	$PageTitle = "회원 아이디 통합";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>

		<div class="inte03 my_cont">
			
			<div class="inte03__icon">
				<img src="/image/sub/check_icon.png" alt="" />
			</div>

			<p class="inte03__tit">
				회원 아이디 통합이 완료되었습니다.
			</p>

			<p class="inte03__stit">
				로그인하신 후 이용해 주세요.
			</p>


			<a href="/html/dh_member/login" class="inte__btn">로그인 페이지로 이동</a>
		</div>
	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>

