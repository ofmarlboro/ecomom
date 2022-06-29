<?
	$PageName = "LOGIN";
	$SubName = "";
	$PageTitle = "로그인";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>
		<?php
		/*
		<div class="my_cont clearfix">
			<div class="fl join">
				<div class="my_tit">
					로그인
				</div>
				<div class="shop-login-box">
					<!-- 로그인 필드 -->
					<ul class="login-field clearfix">
						<li class="fl">
						<p>	<label for="">아이디</label>
							<input type=""></p>
						<p><label for="">비밀번호</label>
							<input type=""></p>

						</li>
						<li class="fr">
							<a href="" class="btn_login"><img src="/image/sub/lock.jpg" alt="">로그인</a>
						</li>
						<li class="w100 ac">
							<!-- <p class="lg-msg">
								<input type="checkbox" id="save-id"> <label for="save-id">아이디 저장</label>
								<span class="ml10"></span><input type="checkbox" id="login-auto"> <label for="login-auto">자동로그인</label>
							</p> -->
							<a href="">아이디 찾기</a><a href="">비밀번호 찾기</a>
						</li>

					</ul>
					<ul class="gray">
						<li>※ 아이디와 비밀번호를 입력하세요.</li>
						<li>※ 비밀번호는 대소문자를 구별합니다.</li>
					</ul>
					<!-- END 로그인 필드 -->
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

		include "{$view}.php";
		?>
	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
