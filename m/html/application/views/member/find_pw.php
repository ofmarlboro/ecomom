
<?php
if($find_cnt==1 && isset($findRow->idx)){		//최종 변경
	?>
		<script type="text/javascript">
		<!--
			function cancel_real(){
				msg = '비밀번호 변경을 취소 하시겠습니까?';
				if(confirm(msg)){
					location.href="/";
				}
			}

			function pwc_send(){
				var form = document.pwchg;
				if(form.passwd.value.length < 6 || form.passwd.value.length > 16){ alert("비밀번호는 영문과 숫자 조합으로 6~16자리로 입력해 주세요."); return; }
				if(form.passwd_check.value==""){ alert("비밀번호 확인을 위해 한번 더 입력해 주세요."); return; }
				if(form.passwd.value != form.passwd_check.value){ alert("비밀번호가 정확하지 않습니다. 정확히 입력해 주세요."); return; }
				form.submit();
			}
		//-->
		</script>


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

						<form method="post" name="pwchg" id="pwchg">
							<input type="hidden" name="passchg" value="ok">
							<input type="hidden" name="mem_idx" value="<?=$findRow->idx?>">

							<input style="display:none" aria-hidden="true">
							<input type="password" style="display:none" aria-hidden="true">

							<input type="hidden" name="userid_chk">

						<div class="t-wide mt30">

							<ul class="login-form">
								<li class="mb10">
									<input type="password" name="passwd" autocomplete="new-password" placeholder="새로 변경하실 비밀번호를 입력해주세요.">
								</li>
								<li>
									<input type="password" name="passwd_check" placeholder="확인을 위해 비밀번호를 한번 더 입력해주세요."">
								</li>
							</ul>

						</div>

						</form>

						<div class="align-c btn_ban mt40">
							<button type="button" class="plain my_btn one" onclick="pwc_send()">변경</button>
							<button type="button" class="plain my_btn two" onclick="cancel_real()">취소</button>
						</div>

					</div>
					<!-- //변경된 비밀번호찾기 폼 -->

				</div><!-- END Join -->


			</div><!-- End Member Inner -->
		</div><!-- END MEMBER Wrap -->
	<?php
}
else{
	if($this->input->post('idx')){	//아이디 입력후 본인인증
		include $_SERVER['DOCUMENT_ROOT']."/nice/ipin_main.php";
		include $_SERVER['DOCUMENT_ROOT']."/nice/checkplus_main.php";
		?>
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

						<form method="post" name="nice_certification" id="nice_certification">
							<input type="hidden" name="useridx" value="<?=$this->input->post('idx')?>">
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
		<?php
	}
	else{		//최초 아이디 입력
		?>
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
						<div class="t-wide">
							<h2 class="login_tit">비밀번호 찾기</h2>

							<p class="img align-c"><img src="/image/sub/lock.png" height="50" alt=""></p>
							<p class="align-c mb20 mt20" style="font-size: 15px;">비밀번호를 찾기위한 <span class="dh_red">아이디</span>를 입력해주세요.</p>

							<form method="post" onsubmit="return false;" name="form">
							<ul class="login-form">
								<li class="align-c">
									<input type="text" id="user-id" placeholder="아이디를 입력해주세요." style="width: 90%;" name="userid" onkeydown="mainLoginInputSendit();">
								</li>
							</ul>
							</form>

							<hr class="mt20">

							<p class="login-side">
								<span>· 아이디를 찾으시나요?</span>
								 <a href="<?=cdir()?>/dh_member/find_id"> 아이디찾기</a>
							</p>

							<div class="align-c mt40">
								<button type="button" class="plain my_btn" style="width: 80%;" onclick="chkid()">다음단계</button>
							</div>

						</div>
					</div>
					<!-- //변경된 비밀번호찾기 폼 -->

				</div><!-- END Join -->


			</div><!-- End Member Inner -->
		</div><!-- END MEMBER Wrap -->

			<script type="text/javascript">
			<!--
				function chkid(){
					var frm = document.form;
					if(frm.userid.value==""){
						alert("아이디를 입력해 주세요.");
						return;
					}
					frm.submit();
				}

				function mainLoginInputSendit(){
					if(event.keyCode==13) {
						chkid();
					}
				}
			//-->
			</script>
		<?php
	}
}
?>