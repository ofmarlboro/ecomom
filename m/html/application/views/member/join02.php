<script type="text/javascript">
	var date_picker_option = {
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd', //형식(20120303)
		autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
		changeMonth: true, //월변경가능
		changeYear: true, //년변경가능
		showMonthAfterYear: true//년 뒤에 월 표시
	};

	$(function(){
		$("#baby_fst_birth, #baby_sec_birth, #baby_thd_birth").datepicker(date_picker_option);
	});

	function userChk()
	{

		var form = document.join_form;

		if(form.userid.value==""){
			alert('아이디를 입력해주세요.');
			form.userid.focus();
			return;
		}else if(form.userid.value.length < 4 || form.userid.value.length > 21) {
			alert("아이디는 4~20자로 입력 주세요.");
			form.userid.focus();
			return;
		}else{
			$.get("<?=cdir()?>/dh_member/join/userChk/?userChkid="+form.userid.value,function(data){
				if(data==0){
					alert("사용가능한 아이디 입니다.");
					form.userid_chk.value=form.userid.value;
					form.passwd.focus();
				}else{
					alert("현재 사용중인 아이디 입니다.");
					form.userid_chk.value="";
					form.userid.focus();
				}
			});
		}
	}

	function nickname_chk(){
		var nickname = $("input[name='nick']");
		if (nickname.val() == "")
		{
			alert("닉네임을 입력해 주세요.");
			nickname.focus();
			return;
		}
		else{
			$.get("<?=cdir()?>/dh_member/join/nick_chk/?nickname="+nickname.val(),function(data){
				console.log(data);
				if (data > 0)
				{
					alert("이미 존재하는 닉네임 입니다.");
					nickname.val('').focus();
					return;
				}
				else{
					alert("사용가능한 닉네임 입니다.");
					$("input[name='nickname_chk']").val(nickname.val());
				}
			});
		}
	}

	function recomid_search(){
		var recomid = $("input[name='recomid']");
		if(recomid.val() == ""){
			alert("추천인 아이디를 입력해 주세요.");
			recomid.focus();
			return;
		}
		else{
			$.ajax({
				url:"<?=cdir()?>/dh_member/join/recomid_chk",
				type:"GET",
				data:{'ajax':1,'recomid':recomid.val()},
				dataType:"json",
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					console.log(data);
					if(data.cnt > 0){
						alert("추천인 아이디가 확인 되었습니다.");
						$("span.name").html(data.name);
						$("input[name='recomid']").attr("readonly",true);
					}
					else{
						alert("존재하지 않는 아이디 입니다.");
						$("span.name").html('');
						$("input[name='recomid']").val('');
						return;
					}
				}
			});
		}
	}

	function more_address(address){

		var display = $("#"+address).css('display');

		if(display == "none"){

			$("."+address).removeClass('btn_gg_off');
			$("."+address).addClass('btn_gg');
			$("input[name='"+address+"_use']").val('Y');

			var addr_name = "";

			if(address == "chin"){
				addr_name = "친정 ";
			}
			else if(address == "sidc"){
				addr_name = "시댁 ";
			}
			else if(address == "bomo"){
				addr_name = "보모 ";
			}

			//선택한 추가값 필수요소로 변경
			$("input[name="+address+"_zip]").attr("msg",addr_name+"우편번호를");
			$("input[name="+address+"_add1]").attr("msg",addr_name+"주소를");
			$("input[name="+address+"_add2]").attr("msg",addr_name+"상세주소를");
			$("input[name="+address+"_name]").attr("msg",addr_name+"받는분 성명을");
			$("input[name="+address+"_phone1]").attr("msg",addr_name+"받는분 연락처를");
			$("input[name="+address+"_phone2]").attr("msg",addr_name+"받는분 연락처를");
			$("input[name="+address+"_phone3]").attr("msg",addr_name+"받는분 연락처를");

		}

		else if(display == "table-row"){

			$("."+address).removeClass('btn_gg');
			$("."+address).addClass('btn_gg_off');
			$("input[name='"+address+"_use']").val('');

			//추가값 해제시 필수요소 해제
			$("input[name="+address+"_zip]").removeAttr("msg");
			$("input[name="+address+"_add1]").removeAttr("msg");
			$("input[name="+address+"_add2]").removeAttr("msg");
			$("input[name="+address+"_name]").removeAttr("msg");
			$("input[name="+address+"_phone1]").removeAttr("msg");
			$("input[name="+address+"_phone2]").removeAttr("msg");
			$("input[name="+address+"_phone3]").removeAttr("msg");

		}

		$("#"+address).toggle();

	}

	function maxLengthCheck(object){
		if (object.value.length > object.maxLength){
			object.value = object.value.slice(0, object.maxLength);
		}
	}
</script>

			<div class="inner mypage join">
				<form name="join_form" id="join_form" action="?agree=1&ok=1" method="post" autocomplete="off">

					<input type="hidden" name="dupinfo" value="<?=$this->input->post('dupinfo')?>">

				<h1>
					기본 정보
				</h1>
				<div class="tblTy03">
					<table>
						<colgroup>
							<col style="width:25%">
							<col style="width:75%">

						</colgroup>

						<?php
						if($this->input->post('sns_userid')){
						?>
							<input type="hidden" name="userid" value="<?=$this->input->post('sns_userid')?>">
							<input type="hidden" name="userid_chk" value="<?=$this->input->post('sns_userid')?>">
							<input type="hidden" name="passwd" value="<?=$this->input->post('sns_passwd')?>">
							<input type="hidden" name="passwd_check" value="<?=$this->input->post('sns_passwd')?>">
							<input type="hidden" name="regist_type" value="sns">
						<?php
						}
						else{
						?>
						<tr>
							<th>아이디</th>
							<td>
								<input type="text" size="16" name="userid" onkeyup="noSpaceForm(this);$('input[name=userid_chk]').val('')" msg="아이디를">
								<input type="hidden" name="userid_chk" msg="아이디 중복확인을 해주세요.">
								<p class="mt10"><a href="javascript:userChk();" class="btn_gg">중복확인</a></p>

							</td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td class="clearfix"><p>
									<input type="password" size="16" name="passwd" msg="비밀번호를">
								</p>
								<p class="fs12 gray mt10"> ※ 영문과 숫자 조합으로
									6자이상 16자 이하로 가능합니다. </p></td>
						</tr>
						<tr>
							<th>비밀번호<br>
								확인</th>
							<td><input type="password" size="16" name="passwd_check" msg="비밀번호를 한번더" passwd_match="비밀번호가 일치하지 않습니다. 다시 한번 확인해 주세요." matching_name="passwd"></td>
						</tr>
						<?php
						}
						?>
						<tr>
							<th>이름</th>
							<td><input type="text" size="16" name="name" msg="이름을" onkeyup="noSpaceForm(this)" <?=$this->input->post('name')?"value='".urldecode($this->input->post('name'))."' readonly":"";?>></td>
						</tr>
						<?php
						/*
						<tr>
							<th>닉네임</th>
							<td>
								<input type="text" size="16" name="nick" msg="닉네임을" onkeyup="noSpaceForm(this);$('input[name=nickname_chk]').val('');">
								<input type="hidden" name="nickname_chk" msg="닉네임 중복확인을 해주세요.">
								<a href="javascript: nickname_chk();" class="btn_gg">중복확인</a>
							</td>
						</tr>

						<tr>
							<th>전화번호</th>
							<td>
								<select name="tel1" maxlength="4">
									<option value="02">02</option>
									<option value="051">051</option>
									<option value="053">053</option>
									<option value="032">032</option>
									<option value="062">062</option>
									<option value="042">042</option>
									<option value="052">052</option>
									<option value="044">044</option>
									<option value="031">031</option>
									<option value="033">033</option>
									<option value="043">043</option>
									<option value="041">041</option>
									<option value="063">063</option>
									<option value="061">061</option>
									<option value="054">054</option>
									<option value="055">055</option>
									<option value="064">064</option>
									<option value="070">070</option>
								</select> -
								<input type="text" size="4" name="tel2" maxlength="4" msg="전화번호를" onkeyup="noSpaceForm(this)"> -
								<input type="text" size="4" name="tel3" maxlength="4" msg="전화번호를" onkeyup="noSpaceForm(this)">
							</td>
						</tr>
						*/
						?>
						<tr>
							<th>휴대폰<br>
								번호</th>
							<td>
								<?php
								if($this->input->post('mobileno')){
									if(strlen($this->input->post('mobileno')) == 11){	//휴대폰번호 자릿수 확인
										$phone1 = substr($this->input->post('mobileno'),0,3);
										$phone2 = substr($this->input->post('mobileno'),3,4);
										$phone3 = substr($this->input->post('mobileno'),7,4);
									}
									else{
										$phone1 = substr($this->input->post('mobileno'),0,3);
										$phone2 = substr($this->input->post('mobileno'),3,3);
										$phone3 = substr($this->input->post('mobileno'),6,4);
									}
									?>
									<input type="number" pattern="\d*" class="hj_size" name="phone1" maxlength="3" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" value="<?=$phone1?>" readonly> -
									<input type="number" pattern="\d*" class="hj_size" name="phone2" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" value="<?=$phone2?>" readonly> -
									<input type="number" pattern="\d*" class="hj_size" name="phone3" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" value="<?=$phone3?>" readonly>
									<?php
								}
								else{
									?>
									<select name="phone1" maxlength="4" class="reg_sel02">
										<option value="010">010</option>
										<option value="011">011</option>
										<option value="016">016</option>
										<option value="017">017</option>
										<option value="018">018</option>
										<option value="019">019</option>
									</select> -
									<input type="number" pattern="\d*" class="hj_size" name="phone2" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)"> -
									<input type="number" pattern="\d*" class="hj_size" name="phone3" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)">
									<?php
								}
								?>


							</td>
						</tr>
						<tr>
							<th>생년월일</th>
							<td>
								<?php
								if($this->input->post('birthdate')){
									$bd1 = substr($this->input->post('birthdate'),0,4);
									$bd2 = substr($this->input->post('birthdate'),4,2);
									$bd3 = substr($this->input->post('birthdate'),6,2);
								}
								?>
								<input type="number" pattern="\d*" class="hj_size" size="4" name="birth_year" maxlength="4" msg="생년월일을" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" <?=$bd1?"value='".$bd1."' readonly":"";?>> 년
								<input type="number" pattern="\d*" class="hj_size" size="2" name="birth_month" maxlength="2" msg="생년월일을" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" <?=$bd2?"value='".$bd2."' readonly":"";?>> 월
								<input type="number" pattern="\d*" class="hj_size" size="2" name="birth_date" maxlength="2" msg="생년월일을" onkeyup="noSpaceForm(this)" oninput="maxLengthCheck(this)" <?=$bd3?"value='".$bd3."' readonly":"";?>> 일
							</td>
						</tr>
						<tr>
							<th>배송지관리</th>
							<td colspan="3">
								<a href="javascript: more_address('chin');" class="btn_gg_off chin">친정주소 추가</a><br>
								<a href="javascript: more_address('sidc');" class="btn_gg_off sidc mt10">시댁주소 추가</a><br>
								<a href="javascript: more_address('bomo');" class="btn_gg_off bomo mt10">보모주소 추가</a>
								<input type="hidden" name="chin_use">
								<input type="hidden" name="sidc_use">
								<input type="hidden" name="bomo_use">
							</td>
						</tr>
						<tr>
							<th>자택주소</th>
							<td>
								<p>
									<input type="text" size="10" id="zipcode1" name="zip1" readonly msg="우편번호를">
								</p>
								<p class="mt10">
									<a href="javascript:sample6_execDaumPostcode();" class="btn_g">우편번호검색</a>
									<!-- <a href="#" class="btn_g">배송지 관리</a> -->
								</p>
								<p class="mt10">
									<input type="text" size="16" name="add1" id="address1" readonly msg="주소를">
								</p>
								<p class="mt10">
									<input type="text" size="16" name="add2" id="address2" msg="상세주소를">
								</p>
								<p class="fs12 gray mt10"> ※ 가입 후 마이페이지 > 배송지관리에서 시댁, 친정 등 배송지를 추가로 관리할 수 있습니다. </p>
							</td>
						</tr>

						<tr id="chin" style="display:none;">
							<th>친정주소</th>
							<td>

								<p>
									<input type="text" size="10" id="chin_zipcode1" name="chin_zip" readonly>
								</p>
								<p class="mt10">
									<a href="javascript:sample6_execDaumPostcode('chin');" class="btn_g">우편번호검색</a>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="chin_add1" id="chin_address1" readonly>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="chin_add2" id="chin_address2">
								</p>
								<p class="mt10">
									받는분 성명 : <input type="text" size="10" name="chin_name">
								</p>
								<p class="mt10">
									받는분 연락처 : <input type="number" pattern="\d*" class="hj_size" size="4" name="chin_phone1" maxlength="3" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="chin_phone2" maxlength="4" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="chin_phone3" maxlength="4" oninput="maxLengthCheck(this)">
								</p>

								<p class="fs12 gray mt10">
									※ 모든 항목을 입력하셔야 주소지로 추가 됩니다.
								</p>
							</td>
						</tr>
						<tr id="sidc" style="display:none;">
							<th>시댁주소</th>
							<td>
								<p>
									<input type="text" size="10" id="sidc_zipcode1" name="sidc_zip" readonly>
								</p>
								<p class="mt10">
									<a href="javascript:sample6_execDaumPostcode('sidc');" class="btn_g">우편번호검색</a>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="sidc_add1" id="sidc_address1" readonly>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="sidc_add2" id="sidc_address2">
								</p>
								<p class="mt10">
									받는분 성명 : <input type="text" size="10" name="sidc_name">
								</p>
								<p class="mt10">
									받는분 연락처 : <input type="number" pattern="\d*" class="hj_size" size="4" name="sidc_phone1" maxlength="3" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="sidc_phone2" maxlength="4" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="sidc_phone3" maxlength="4" oninput="maxLengthCheck(this)">
								</p>

								<p class="fs12 gray mt10">
									※ 모든 항목을 입력하셔야 주소지로 추가 됩니다.
								</p>
							</td>
						</tr>
						<tr id="bomo" style="display:none;">
							<th>보모주소</th>
							<td>
								<p>
									<input type="text" size="10" id="bomo_zipcode1" name="bomo_zip" readonly>
								</p>
								<p class="mt10">
									<a href="javascript:sample6_execDaumPostcode('bomo');" class="btn_g">우편번호검색</a>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="bomo_add1" id="bomo_address1" readonly>
								</p>
								<p class="mt10">
									<input type="text" size="16" name="bomo_add2" id="bomo_address2">
								</p>
								<p class="mt10">
									받는분 성명 : <input type="text" size="10" name="bomo_name">
								</p>
								<p class="mt10">
									받는분 연락처 : <input type="number" pattern="\d*" class="hj_size" size="4" name="bomo_phone1" maxlength="3" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="bomo_phone2" maxlength="4" oninput="maxLengthCheck(this)">-<input type="number" pattern="\d*" class="hj_size" size="4" name="bomo_phone3" maxlength="4" oninput="maxLengthCheck(this)">
								</p>

								<p class="fs12 gray mt10">
									※ 모든 항목을 입력하셔야 주소지로 추가 됩니다.
								</p>
							</td>
						</tr>

						<tr>
							<th>마케팅<br>
								수신동의</th>
							<td><p class="fs12 gray"> ※ 수신동의시 가격할인, 이벤트 등 다양한 혜택 알림서비스를 안내 받으실 수 있습니다. </p>
								<p class="fs12 gray mt10"> ※ 주문 및 배송안내, 약관안내, 주요 정책 변경에 따른 안내는 수신 동의 여부와 상관없이 발송됩니다. </p>
								<p class="mt10">
									<input type="checkbox" id="SMS" name="resms" value="1" checked>
									<label for="SMS">SMS 수신 동의</label>
								</p>
								<p>
									<input type="checkbox" id="EMAIL" name="mailing" value="1" checked>
									<label for="EMAIL">이메일 수신 동의</label>
							</td>
								</p>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text" size="10" name="email1" msg="이메일을" onkeyup="noSpaceForm(this)">
								@
								<input type="text" size="10" name="email2" id="email2" msg="이메일을" onkeyup="noSpaceForm(this)">
								<p class="mt10">
									<select name="email_sel" onchange="res(this.value)">
										<option value="">직접입력</option>
										<option value="naver.com">naver.com</option>
										<option value="hanmail.net">hanmail.net</option>
										<option value="nate.com">nate.com</option>
										<option value="paran.com">paran.com</option>
										<option value="empal.com">empal.com</option>
										<option value="hotmail.com">hotmail.com</option>
										<option value="gmail.com">gmail.com</option>
										<option value="dreamwiz.com">dreamwiz.com</option>
										<option value="lycos.co.kr">lycos.co.kr</option>
										<option value="yahoo.co.kr">yahoo.co.kr</option>
										<option value="korea.com">korea.com</option>
										<option value="hanmir.com">hanmir.com</option>
									</select>
								</p></td>
						</tr>
						<tr>
							<th>추천인<br>아이디</th>
							<td><input type="text" size="10" name="recomid" onkeyup="noSpaceForm(this)">
								<a href="javascript: recomid_search();" class="btn_gg">검색</a>
								<span class="name"></span>
								<p class="fs12 gray mt10">
									※ 추천인과 피추천인 모두 결제금액의 10%를 적립금으로 드립니다.
								</p></td>
						</tr>
					</table>
				</div>
				<h1 class="mt30">
					자녀 정보
				</h1>
				<div class="tblTy03 g_info">
					<table>
						<tr>
							<th>첫째<br>
								아기</th>
							<td><p>
									<label for="join_baby_name1">이름</label>
									<input type="text" size="9" id="join_baby_name1" name="baby1_name">
								</p>
								<p>
									<label for="baby_fst_birth">생년월일</label>
									<input type="text" id="baby_fst_birth" size="11" name="baby1_birth" readonly>
									<a href="javascript: $('#baby_fst_birth').focus();" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="baby1_gender">성별</label>
									<select name="baby1_gender" id="baby1_gender">
										<option value="여아">여아</option>
										<option value="남아">남아</option>
									</select>
								</p></td>
						</tr>
						<tr>
							<th>둘째<br>
								아기</th>
							<td><p>
									<label for="join_baby_name2">이름</label>
									<input type="text" size="9" id="join_baby_name2" name="baby2_name">
								</p>
								<p>
									<label for="baby_sec_birth">생년월일</label>
									<input type="text" id="baby_sec_birth" size="11" name="baby2_birth" readonly>
									<a href="javascript: $('#baby_sec_birth').focus();" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="baby2_gender">성별</label>
									<select name="baby2_gender" id="baby2_gender">
										<option value="여아">여아</option>
										<option value="남아">남아</option>
									</select>
								</p></td>
						</tr>
						<tr>
							<th>셋째<br>
								아기</th>
							<td><p>
									<label for="join_baby_name3">이름</label>
									<input type="text" size="9" id="join_baby_name3" name="baby3_name">
								</p>
								<p>
									<label for="baby_thd_birth">생년월일</label>
									<input type="text" id="baby_thd_birth" size="11" name="baby3_birth" readonly>
									<a href="javascript: $('#baby_thd_birth').focus();" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="baby3_gender">성별</label>
									<select name="baby3_gender" id="baby3_gender">
										<option value="여아">여아</option>
										<option value="남아">남아</option>
									</select>
								</p></td>
						</tr>
					</table>
				</div>
				</form>
				<div class="ac mt10">
					<a href="javascript: frmChk('join_form');" class="btn_g fz16">
					회원가입
					</a>
					<!-- <a href="join01.php" class="btn_g fz16">
					취소
					</a> -->
				</div>
			</div>