<?
	$PageName = "";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!-- Mirae Log Analysis Conversion Script Ver 1.0   -->
<script type='text/javascript'>
var mi_type = 'member';
var mi_val = 'Y';
</script>
<!-- Mirae Log Analysis Conversion Script END  -->

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?//include("../include/mypage_top02.php");?>

		<?php
		include "{$view}.php";
		?>

		<?php
		/*
				<div class="inner">
					<div class="joinok">
						<div><span class="name">홍길동</span>님!<br>에코맘 산골이유식의 회원이 되신 것을<br>진심으로 환영합니다.<br>신규 회원가입을 하신 분들께는<br><span class="red">1,000</span>원을 적립해드립니다.</div>
						<ul>
							<li>이름 : 홍길동</li>
							<li>아이디 : roeenff</li>
							<li>이메일 : fjfjid@naver.com</li>
						</ul>
					</div>

					<div class="ac mt20">
						<a href="" class="btn_g fz16">홈으로 이동</a>
					</div>
				</div>
		*/
		?>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>










<? include('../include/footer.php') ?>


