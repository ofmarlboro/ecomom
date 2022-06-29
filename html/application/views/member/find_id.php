<style type="text/css">
.find-account-l .tit, .find-account-r .tit {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.find-account-l .txt, .find-account-r .txt {
    font-size: 12px;
    letter-spacing: -0.05em;
    color: #777;
    font-family: 'Noto Sans', sans-serif;
}
</style>

<!-- Member Wrap -->
<div class="member-wrap">
	<!-- Find Account : 아이디 찾기-->
	<div class="find-account">

		<!-- Tab of Find Type -->
		<ul class="find-type">
			<li class="on"><a href="<?=cdir()?>/dh_member/find_id">아이디 찾기</a></li>
			<li><a href="<?=cdir()?>/dh_member/find_pw">비밀번호 찾기</a></li>
		</ul><!-- END Tab of Find Type -->

		<? if($find_cnt==1 && isset($findRow[0]->idx)){ ?>

			<div class="find-form-wrap">

				<table class="dh_content" style="margin-left:40px;" width="592" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="text-align:center; line-height:25px; font-size:12px; color:#888888;">
							고객님의 아이디를 알려드립니다.<br>
							비밀번호가 기억나지 않는 경우, [비밀번호 찾기] 에서 확인하실 수 있습니다.
						</td>
					</tr>
					<tr><td height="20" style="font-size:0;"></td></tr>


					<tr class="dh_bgbox">
						<td style="background:#f9f9f9; color:#555555;">
							<!-- 백그라운드 박스 -->
							<table width="592" border="0" cellspacing="0" cellpadding="0">
								<tr><td height="20" style="font-size:0;"></td></tr>
								<tr>
									<td style="font-weight:bold; text-align:center; line-height:30px; font-size:12px;">
										<?php
										$normal_id_cnt = 0;
										foreach($findRow as $c){
											if($c->regist_type != "sns"){
												$normal_id_cnt++;
											}
										}

										foreach($findRow as $fl){
											if($fl->regist_type == "sns"){
												$naver_ok = strpos($fl->userid,"nv_") !== false ? true : false ;
												$kakao_ok = strpos($fl->userid,"kko_") !== false ? true : false ;
												?>
												<!-- 연동된 SNS 계정 <span style="margin-left:40px; color:#ff2040; font-size:16px;"><?=$naver_ok ? "네이버 연동" : "" ;?> <?=$kakao_ok ? ", 카카오 연동" : "" ;?></span> -->
												<?php
											}
											else if($normal_id_cnt){
												?>
												<br>
												일반가입 아이디 <span style="margin-left:40px; color:#ff2040; font-size:16px;"><?=$fl->userid?></span>
												<?php
											}
										}
										?>

										<br>
										<span style="margin-left:40px; color:#2040ff; font-size:12px;">SNS 연동회원은 아이디를 노출하지 않습니다.</span>

									</td>
								</tr>
								<tr><td height="20" style="font-size:0; background:#f9f9f9;"></td></tr>
							</table>
							<!-- END 백그라운드 박스 -->
						</td>
					</tr>

					<tr>
						<td style="text-align:center; line-height:25px; font-size:12px; color:#888888;">

						</td>
					</tr>

					<tr><td height="40" style="font-size:0;"></td></tr>

		<tr>
			<td style="text-align:center;">
				<!-- 버튼영역 -->
				<a href="<?=cdir()?>/dh_member/login"><img src="http://newadm.myelhub.com/image/shop_mail/btn_login.png" alt="로그인하기" border="0"></a>
				<span style="margin-left:10px;">&nbsp;</span>
				<a href="<?=cdir()?>/dh_member/find_pw"><img src="http://newadm.myelhub.com/image/shop_mail/btn_pwfind.png" alt="비밀번호 찾기" border="0"></a>
				<!-- END 버튼영역 -->
			</td>
		</tr>

				</table>

		</div>

		<?}else{?>

		<p>가입하신 회원정보로 정확한 아이디를 확인하실 수 있습니다.<br>아래의 방법으로 아이디/비밀번호찾기가 불가능하시거나, 사이트장애, 오류 발생 시 고객센터로 문의해 주시기 바랍니다.</p>

		<!-- Find Form -->
		<div class="find-form-wrap">

			<form method="post" name="idsearch_form1" id="idsearch_form1" onsubmit="idpwsearch(1);event.returnValue = false;">
			<input type="hidden" name="find_mode" value="1">
			<div class="find-account-l">
				<p class="tit">휴대폰 번호로 찾기</p>
				<p class="txt">가입하신 휴대폰 번호로 검색하여 아이디를 찾습니다.</p>
				<div class="find-form">
					<ul>
						<li><label for="tel_name"><img src="/image/members/f_name.png" alt="이름"></label><input type="text" id="tel_name" name="name" onKeyDown="inputSendit(1);"></li>
						<li><label for="tel"><img src="/image/members/f_number.png" alt="휴대폰번호"></label><input type="text" id="tel" class="mem-ip-num" name="phone1" maxlength="4"> -<input type="text" class="mem-ip-num" name="phone2" maxlength="4"> -<input type="text" class="mem-ip-num" name="phone3" onKeyDown="inputSendit(1);" maxlength="4"></li>
					</ul>
					<p class="find-btn"><a href="javascript:idpwsearch(1);"><img src="/image/members/btn_find.png"></a></p>
				</div>
			</div>
			</form>

			<div class="find-account-r">
			<form method="post" name="idsearch_form2" id="idsearch_form2" onsubmit="idpwsearch(2);event.returnValue = false;">
			<input type="hidden" name="find_mode" value="2">
				<p class="tit">이메일 주소로 찾기</p>
				<p class="txt">가입하신 이메일 주소로 검색하여 아이디를 찾습니다.</p>
				<div class="find-form">
					<ul>
						<li><label for="email_name"><img src="/image/members/f_name.png" alt="이름"></label><input type="text" id="email_name" name="name" onKeyDown="inputSendit(2);"></li>
						<li><label for="email"><img src="/image/members/f_mail.png" alt="이메일주소"></label><input type="text" id="email" name="email" onKeyDown="inputSendit(2);"></li>
					</ul>
					<p class="find-btn"><a href="javascript:idpwsearch(2);"><img src="/image/members/btn_find.png"></a></p>
				</div>
			</form>
			</div>
		</div><!-- END Find Form -->



		<?}?>


	</div><!-- Find Account -->
</div><!-- END Member Wrap -->


<script>

function inputSendit(num) {
	if(event.keyCode==13) {
		idpwsearch(num);
	}
}


function idpwsearch(num)
{
	if(num==1){
		var form = document.idsearch_form1;

		if(form.name.value==""){
			alert("이름을 입력해주세요.");
			form.name.focus();
			return;
		}else if(form.phone1.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone1.focus();
			return;
		}else if(form.phone2.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone2.focus();
			return;
		}else if(form.phone3.value==""){
			alert("휴대폰번호를 입력해주세요.");
			form.phone3.focus();
			return;
		}

	}else if(num==2){

		var form = document.idsearch_form2;
		if(form.name.value==""){
			alert("이름을 입력해주세요.");
			form.name.focus();
			return;
		}else if(form.email.value==""){
			alert("이메일을 입력해주세요.");
			form.email.focus();
			return;
		}
	}

		form.submit();
}


</script>