		<div class="inner mypage">
			<div class="member-wrap">
				<div class="member-inner">

					<!-- Join -->
					<div class="join-wrap">
						<!-- 변경된 비밀번호찾기 폼 -->
						<div class="pw-wrap">

							<div class="my_wrap">
								<p class="align-c tit">회원가입</p>
								<p class="align-c sub">아래 인증 방법을 통해<br>본인인증 후 가입 하실 수 있습니다.</p>
							</div>

							<?php
							include $_SERVER['DOCUMENT_ROOT']."/nice/ipin_main.php";
							include $_SERVER['DOCUMENT_ROOT']."/nice/checkplus_main.php";
							?>

							<div class="t-wide my_box mt30">
								<p class="title align-c">본인인증 후 가입</p>

								<ul class="id_inj clearfix">
									<li class="align-c">
										<p class="img"><img src="/image/sub/i01.png" alt=""></p>
										<p><button type="button" class="plain my_btn" onclick="fnPopup()">휴대폰 인증하기</button></p>
									</li>
									<li class="align-c">
										<p class="img"><img src="/image/sub/i02.png" alt=""></p>
										<p><button type="button" class="plain my_btn" onclick="ipinpop()">아이핀 인증하기</button></p>
									</li>
								</ul>

							</div>

						</div>
						<!-- //변경된 비밀번호찾기 폼 -->

						<form method="post" name="nice_certification" id="nice_certification" action="?agree=1">
							<input type="hidden" name="name" value="">
							<input type="hidden" name="birthdate" value="">
							<input type="hidden" name="gender" value="">
							<input type="hidden" name="dupinfo" value="">
							<input type="hidden" name="mobileno" value="">
							<input type="hidden" name="mobileco" value="">
							<input type="hidden" name="enc_data" value="">
							<input type="hidden" name="certifi_type" value="">
						</form>

					</div><!-- END Join -->


				</div><!-- End Member Inner -->
			</div><!-- END MEMBER Wrap -->
		</div>