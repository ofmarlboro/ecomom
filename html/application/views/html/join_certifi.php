<?
	$PageName = "JOIN";
	$SubName = "";
	$PageTitle = "회원가입";
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
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>

		<?php
		include "{$view}.php";
		?>

		<?php
		/*
		<div class="my_cont">

			<div class="joinok">
				<p><span class="name">홍길동</span>님! 에코맘 산골이유식의 회원이 되신 것을 진심으로 환영합니다.<br>신규 회원가입을 하신 분들께는 <span class="red">1,000</span>원을 적립해드립니다.</p>
				<ul>
					<li>이름 : 홍길동</li>
					<li>아이디 : roeenff</li>
					<li>이메일 : fjfjid@naver.com</li>
				</ul>
			</div>

			<div class="ac">
				<a href="" class="btn_big">홈으로 이동</a>
			</div>
		</div>
		*/
		?>
	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
