<?
	$PageName = "JOIN";
	$SubName = "";
	$PageTitle = "회원가입";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>

		<?php
		include "{$view}.php";
		?>

		<?php
		/*
		<div class="my_cont clearfix">
			<div class="fl join">
				<div class="my_tit">
					회원가입 약관
				</div>
				<textarea name="" id=""></textarea>
				<input type="checkbox"><label for="">회원가입약관에 동의합니다.</label>
				<div class="my_tit mt30">
					개인정보처리방침
				</div>
				<textarea name="" id=""></textarea>
				<input type="checkbox"><label for="">개인정보처리방침에 동의합니다.</label>
				<div class="ac mt20">
					<a href="" class="btn_big">회원가입</a>
				</div>
			</div>

			<div class="fr join02">
				<div class="my_tit">
					SNS 로그인
				</div>
				<ul class="sns_login">
					<li><a href=""><img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기</a></li>
					<li><a href=""><img src="/image/sub/sns02.jpg" alt="">네이버로 시작하기</a></li>
					<li><a href=""><img src="/image/sub/sns03.jpg" alt="">카카오톡으로 시작하기</a></li>
				</ul>
			</div>

		</div>
		*/
		?>

	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
