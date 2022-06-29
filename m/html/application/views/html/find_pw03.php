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
							<p class="align-c tit">비밀번호 재설정</p>
							<p class="align-c sub">안전한 개인정보보호를 위해 초기화된 비밀번호를 재설정해주세요.</p>
						</div>

						<div class="t-wide mt30">
							
							<ul class="login-form">
								<li class="mb10">
									<input type="password" id="" placeholder="새로 변경하실 비밀번호를 입력해주세요.">
								</li>
								<li>
									<input type="password" id="" placeholder="확인을 위해 비밀번호를 한번 더 입력해주세요."">
								</li>
							</ul>

						</div>

						<div class="align-c btn_ban mt40">
							<button type="button" class="plain my_btn one">변경</button>
							<button type="button" class="plain my_btn two">취소</button>
						</div>

					</div>
					<!-- //변경된 비밀번호찾기 폼 -->

				</div><!-- END Join -->


			</div><!-- End Member Inner -->
		</div><!-- END MEMBER Wrap -->

</div>
<!--END Container-->

<? include('../include/footer.php') ?>
