<?
	$PageName = "LOGIN";
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
		<h2 class="mt20">
			로그인
		</h2>
		<div class="shop-login-box">
			<!-- 로그인 필드 -->
			<div class="login-field">
				<p>
					<label for="id" class="left">아이디</label>
					<input type="text" id="id" class="right">
				</p>
				<p>
					<label for="password" class="left">비밀번호</label>
					<input type="password" id="password" class="right">
				</p>
				<p>
					<a href="mypage_idx.php" class="btn_login">
					로그인
					</a>
				</p>

				<p class="lg-msg ac">
					<input type="checkbox" id="save-id">
					<label for="save-id">아이디 저장</label>
					<span class="ml10"></span>
					<input type="checkbox" id="login-auto">
					<label for="login-auto">자동로그인</label>
				</p>

				<p class="bd mt20"></p>

				<p class="gray"><a href="#">
				아이디 찾기
				</a>
				&nbsp;
				<a href="#">
				비밀번호 찾기
				</a></p>


				<ul class="gray">
					<li>
						※ 아이디와 비밀번호를 입력하세요.
					</li>
					<li>
						※ 비밀번호는 대소문자를 구별합니다.
					</li>
				</ul>
			</div>

			<!-- END 로그인 필드 -->
		</div>
		<h2 class="mt50">
			SNS 로그인
		</h2>
		<ul class="sns_login">
			<li>
				<a href="#">
				<img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기
				</a>
			</li>
			<li>
				<a href="#">
				<img src="/image/sub/sns02.jpg" alt="">네이버로 시작하기
				</a>
			</li>
			<li>
				<a href="#">
				<img src="/image/sub/sns03.jpg" alt="">카카오톡으로 시작하기
				</a>
			</li>
		</ul>
	</div>
	*/
	?>
	<!-- //inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
