<?
	$PageName = "";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?php
		include "{$view}.php";
		?>
		<?php
		/*
		<div class="inner mypage">
			<h2 class="mt30">회원가입 약관</h2>

				<div class="join01">
				<div class="ta"></div>
				<input type="checkbox" id="agree"><label for="agree">회원가입약관에 동의합니다.</label>

				<h2 class="mt30">개인정보처리방침</h2>
				<div class="ta"></div>
				<input type="checkbox" id="info"><label for="info">개인정보처리방침에 동의합니다.</label>
				<div class="ac mt20">
					<a href="join02.php" class="btn_g fz16">회원가입</a>
				</div>
			</div>

			<h2 class="mt50">SNS 로그인</h2>
				<ul class="sns_login">
					<li><a href="#"><img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기</a></li>
					<li><a href="#"><img src="/image/sub/sns02.jpg" alt="">네이버로 시작하기</a></li>
					<li><a href="#"><img src="/image/sub/sns03.jpg" alt="">카카오톡으로 시작하기</a></li>
				</ul>

		</div>
		*/
		?>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>









<? include('../include/footer.php') ?>


