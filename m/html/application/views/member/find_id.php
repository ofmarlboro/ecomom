

		<!-- MEMBER Wrap -->
		<div class="member-wrap">
			<div class="member-inner mem-tinted-bg">


		<!-- Join -->
		<div class="join-wrap">
			<h3 class="join-tit"><img src="/m/image/members/tit_find.png" alt="아이디/비밀번호 찾기" width="250" height="26"></h3>

			<!-- Tab of Find Type -->
			<ul class="find-type">
				<li class="on"><a href="<?=cdir()?>/dh_member/find_id">아이디 찾기</a></li>
				<li><a href="<?=cdir()?>/dh_member/find_pw">비밀번호 찾기</a></li>
			</ul><!-- END Tab of Find Type -->


		<? if($find_cnt==1 && isset($findRow->idx)){ ?>


					<p class="mb20">고객님의 아이디를 알려드립니다.<br>비밀번호가 기억나지 않는 경우, [비밀번호 찾기] 에서 확인하실 수 있습니다. </p>
						<ul class="mem-form mt10 mb20">
							<li>

								<div class="mem-field">
								아이디 : <?=$findRow->userid?>
								</div>
							</li>
						</ul>
						<p class="align-c">
							<button type="button" class="mem-btn-ok field-full" onclick="javascript:location.href='<?=cdir()?>/dh_member/login';">로그인하기</button>
						</p>

		<?}else{?>


					<p class="mb20">아래 인증수단 중 한가지로 인증을 받으시면 정확한 아이디를 확인하실 수 있습니다.</p>

						<form method="post" name="idsearch_form1" id="idsearch_form1" onsubmit="idpwsearch(1);event.returnValue = false;">
						<input type="hidden" name="find_mode" value="1">
						<div class="mem-form-wrap">
						<h4 class="member-tit icon-fphone">휴대폰 번호로 찾기</h4>

						<ul class="mem-form mt10 mb20">
							<li>
								<div class="mem-label"><label for="user-name1">이름</label></div>
								<div class="mem-field">
									<input type="text" class="field-full" id="user-name1" name="name" onKeyDown="inputSendit(1);">
								</div>
							</li>
							<li>
								<div class="mem-label"><label for="user-phone">휴대폰번호</label></div>
								<div class="mem-field">
									<input type="text" class="field-tel" id="user-phone" name="phone1" maxlength="4"> -
									<input type="text" class="field-tel" name="phone2" maxlength="4"> -
									<input type="text" class="field-tel" name="phone3" maxlength="4" onKeyDown="inputSendit(1);">
								</div>
							</li>
						</ul>
						<p class="align-c">
							<button type="button" class="mem-btn-ok field-full" onclick="javascript:idpwsearch(1);">찾기</button>
						</p>
						</form>

						<form method="post" name="idsearch_form2" id="idsearch_form2" onsubmit="idpwsearch(2);event.returnValue = false;">
						<input type="hidden" name="find_mode" value="2">
						<h4 class="member-tit icon-fmail mt40">이메일 주소로 찾기</h4>
						<ul class="mem-form mt10 mb20">
							<li>
								<div class="mem-label"><label for="user-name2">이름</label></div>
								<div class="mem-field">
									<input type="text" class="field-full" id="user-name2" name="name" onKeyDown="inputSendit(2);">
								</div>
							</li>
							<li>
								<div class="mem-label"><label for="user-email">이메일</label></div>
								<div class="mem-field">
									<input type="text" class="field-full" id="user-email" name="email" onKeyDown="inputSendit(2);">
								</div>
							</li>
						</ul>
					</div>
					<p class="align-c">
						<button type="button" class="mem-btn-ok field-full" onclick="javascript:idpwsearch(2);">찾기</button>
					</p>
					</form>


		<?}?>

		</div><!-- END Join -->

			</div><!-- End Member Inner -->
		</div><!-- END MEMBER Wrap -->

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