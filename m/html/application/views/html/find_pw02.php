<?
	$PageName = "FINDID";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>

	<!-- MEMBER Wrap -->
		<div class="member-wrap">
			<div class="member-inner mem-tinted-bg">

				<!-- Join -->
				<div class="join-wrap">
					<h3 class="join-tit"><img src="/m/image/members/tit_find.png" alt="아이디/비밀번호 찾기" width="250" height="26"></h3>

					<!-- Tab of Find Type -->
					<ul class="find-type">
						<li><a href="<?=cdir()?>/dh_member/find_id">아이디 찾기</a></li>
						<li class="on"><a href="<?=cdir()?>/dh_member/find_pw">비밀번호 찾기</a></li>
					</ul><!-- END Tab of Find Type -->

					<!-- 변경된 비밀번호찾기 폼 -->
					<div class="pw-wrap">
						
						<div class="my_wrap">
							<p class="align-c tit">비밀번호 찾기</p>
							<p class="align-c sub">아래 인증 방법을 통해<br /> 패스워드를 변경 하실 수 있습니다.</p>
						</div>

						<div class="t-wide my_box mt30">
							<p class="title align-c">본인인증으로 찾기</p>
							<p class="sub align-c">본인 명의의 휴대폰, 아이핀을 통한 인증 방법입니다.</p>

							<ul class="id_inj clearfix">
								<li class="align-c">
									<p class="img"><img src="/image/sub/i01.png" alt=""></p>
									<p><button type="button" class="plain my_btn" onclick="location.href='/html/dh/find_pw03.php'">휴대폰 인증하기</button></p>
								</li>
								<li class="align-c">
									<p class="img"><img src="/image/sub/i02.png" alt=""></p>
									<p><button type="button" class="plain my_btn" onclick="">아이핀 인증하기</button></p>
								</li>
							</ul>

						</div>

					</div>
					<!-- //변경된 비밀번호찾기 폼 -->

				</div><!-- END Join -->


			</div><!-- End Member Inner -->
		</div><!-- END MEMBER Wrap -->

</div>
<!--END Container-->

<? include('../include/footer.php') ?>
