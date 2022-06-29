<?php
$email_arr = explode("@",$row->email);
?>
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

		var form = document.info_form;

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
			$.get("<?=cdir()?>/dh_member/join/recomid_chk/?recomid="+recomid.val(),function(data){
				console.log(data);
				if(data){
					alert("추천인 아이디가 확인 되었습니다.");
				}
				else{
					alert("존재하지 않는 아이디 입니다.");
					return;
				}
			});
		}
	}
</script>

	<div class="inner mypage join">
	<form name="info_form" id="info_form" method="post">
	<input type="hidden" name="idx" value="<?=$row->idx?>">
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
				if($row->regist_type == "sns"){
					$sns_arr = explode("_",$row->userid);
				?>
				<input type="hidden" name="passwd" value="<?=$sns_arr[1]?>">
				<?php
				}
				else{
				?>
				<tr>
					<th>아이디</th>
					<td><?=$row->userid?></td>
				</tr>
				<tr>
					<th>기존<br>비밀번호</th>
					<td><input type="password" size="16" name="passwd" msg="비밀번호를"></td>
				</tr>
				<tr>
					<th>새 비밀번호</th>
					<td class="clearfix">
						<p><input type="password" size="16" name="new_passwd"></p>
						<p class="fs12 gray mt10"> ※ 비밀번호 변경을 원하실경우 입력하세요. </p>
					</td>
				</tr>
				<tr>
					<th>새 비밀번호<br>확인</th>
					<td><input type="password" size="16" name="passwd_check" passwd_match="비밀번호가 일치하지 않습니다. 다시 한번 확인해 주세요." matching_name="new_passwd"></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<th>이름</th>
					<td><?=$row->name?></td>
				</tr>
				<?php
				/*
				<tr>
					<th>전화번호</th>
					<td>
								<select name="tel1">
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
								</select>
								<script type="text/javascript">
								<!--
									var tel1 = document.info_form.tel1;
									for(i=0;i<tel1.length;i++){
										if(tel1.options[i].value == "<?=$row->tel1?>"){
											tel1.options[i].selected = true;
										}
									}
								//-->
								</script>
								-
								<input type="text" size="4" name="tel2" maxlength="4" msg="전화번호를" onkeyup="noSpaceForm(this)" value="<?=$row->tel2?>"> -
								<input type="text" size="4" name="tel3" maxlength="4" msg="전화번호를" onkeyup="noSpaceForm(this)" value="<?=$row->tel3?>">
					</td>
				</tr>
				*/
				?>
				<tr>
					<th>휴대폰<br>번호</th>
					<td>
								<select name="phone1">
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
								</select>
								<script type="text/javascript">
								<!--
									var phone1 = document.info_form.phone1;
									for(i=0;i<phone1.length;i++){
										if(phone1.options[i].value == "<?=$row->phone1?>"){
											phone1.options[i].selected = true;
										}
									}
								//-->
								</script>
								-
								<input type="number" pattern="\d*" class="hj_size" name="phone2" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" value="<?=$row->phone2?>"> -
								<input type="number" pattern="\d*" class="hj_size" name="phone3" maxlength="4" msg="휴대폰번호를" onkeyup="noSpaceForm(this)" value="<?=$row->phone3?>">
					</td>
				</tr>
				<tr>
							<th>생년월일</th>
							<td>
								<input type="number" pattern="\d*" class="hj_size03" name="birth_year" maxlength="4" msg="생년월일을" onkeyup="noSpaceForm(this)" value="<?=$row->birth_year?>"> 년
								<input type="number" pattern="\d*" class="hj_size" name="birth_month" maxlength="2" msg="생년월일을" onkeyup="noSpaceForm(this)" value="<?=$row->birth_month?>"> 월
								<input type="number" pattern="\d*" class="hj_size" name="birth_date" maxlength="2" msg="생년월일을" onkeyup="noSpaceForm(this)" value="<?=$row->birth_date?>"> 일
							</td>
				</tr>
				<tr>
					<th>자택주소</th>
					<td><p>
							<input type="text" size="10" id="zipcode1" name="zip1" readonly msg="우편번호를" value="<?=$row->zip1?>">
						</p>
						<p class="mt10">
							<a href="javascript:sample6_execDaumPostcode();" class="btn_g">우편번호검색</a>
							<a href="<?=cdir()?>/dh/adrs_adm" class="btn_g">배송지 관리</a>
						</p>
						<p class="mt10">
							<input type="text" size="16" name="add1" id="address1" readonly msg="주소를" value="<?=$row->add1?>">
						</p>
						<p class="mt10">
							<input type="text" size="16" name="add2" id="address2" msg="상세주소를" value="<?=$row->add2?>">
						</p>
						<!-- <p class="fs12 gray mt10"> ※ 가입 후 마이페이지 > 배송지관리에서 시댁, 친정 등 배송지를 추가로 관리할 수 있습니다. </p> -->
					</td>
				</tr>
				<tr>
					<th>마케팅<br>
						수신동의</th>
					<td><p class="fs12 gray"> ※ 수신동의시 가격할인, 이벤트 등 다양한 혜택 알림서비스를 안내 받으실 수 있습니다. </p>
						<p class="fs12 gray mt10"> ※ 주문 및 배송안내, 약관안내, 주요 정책 변경에 따른 안내는 수신 동의 여부와 상관없이 발송됩니다. </p>
						<p class="mt10">
							<input type="checkbox" id="SMS" name="resms" value="1" <?if($row->resms == '1'){?>checked<?}?>>
							<label for="SMS">SMS 수신 동의</label>
						</p>
						<p>
							<input type="checkbox" id="EMAIL" name="mailing" value="1" <?if($row->mailing == '1'){?>checked<?}?>>
							<label for="EMAIL">이메일 수신 동의</label>
					</td>
						</p>
				</tr>
				<tr>
					<th>이메일</th>
					<td><input type="text" class="hj_size02" name="email1" msg="이메일을" onkeyup="noSpaceForm(this)" value="<?=$email_arr[0]?>">
						@
						<input type="text" class="hj_size02" name="email2" id="email2" msg="이메일을" onkeyup="noSpaceForm(this)" value="<?=$email_arr[1]?>">
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
								<script type="text/javascript">
								<!--
									var email_sel = document.info_form.email_sel;
									for(i=0;i<email_sel.length;i++){
										if(email_sel.options[i].value == "<?=$email_arr[1]?>"){
											email_sel.options[i].selected = true;
										}
									}
								//-->
								</script>
						</p></td>
				</tr>
				<tr>
					<th>추천인<br>아이디</th>
					<td><input type="text" size="16" name="recomid" onkeyup="noSpaceForm(this)" value="<?=$row->recomid?>" readonly>
						<!-- <a href="javascript: recomid_search();" class="btn_gg">검색</a> -->
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
							<input type="text" size="9" name="baby1_name" id="join_baby_name1" value="<?=$row->baby1_name?>">
						</p>
						<p>
							<label for="baby_fst_birth">생년월일</label>
							<input type="text" name="baby1_birth" id="baby_fst_birth" value="<?=$row->baby1_birth?>" size="11">
							<a href="javascript: $('#baby_fst_birth').focus();" class="cal">
							<img src="/image/sub/small-calendar.png" alt="">
							</a>
						</p>
						<p>
							<label for="baby1_gender">성별</label>
							<select name="baby1_gender" id="baby1_gender">
								<option value="여아" <?=($row->baby1_gender == "여아")?"selected":"";?>>여아</option>
								<option value="남아" <?=($row->baby1_gender == "남아")?"selected":"";?>>남아</option>
							</select>
						</p></td>
				</tr>
				<tr>
					<th>둘째<br>
						아기</th>
					<td><p>
							<label for="join_baby_name2">이름</label>
							<input type="text" size="9" name="baby2_name" id="join_baby_name2" value="<?=$row->baby2_name?>">
						</p>
						<p>
							<label for="baby_sec_birth">생년월일</label>
							<input type="text" name="baby2_birth" id="baby_sec_birth" value="<?=$row->baby2_birth?>" size="11">
							<a href="javascript: $('#baby_sec_birth').focus();" class="cal">
							<img src="/image/sub/small-calendar.png" alt="">
							</a>
						</p>
						<p>
							<label for="baby2_gender">성별</label>
							<select name="baby2_gender" id="baby2_gender">
								<option value="여아" <?=($row->baby2_gender == "여아")?"selected":"";?>>여아</option>
								<option value="남아" <?=($row->baby2_gender == "남아")?"selected":"";?>>남아</option>
							</select>
						</p></td>
				</tr>
				<tr>
					<th>셋째<br>
						아기</th>
					<td><p>
							<label for="join_baby_name3">이름</label>
							<input type="text" size="9" name="baby3_name" id="join_baby_name3" value="<?=$row->baby3_name?>">
						</p>
						<p>
							<label for="baby_thd_birth">생년월일</label>
							<input type="text" name="baby3_birth" id="baby_thd_birth" value="<?=$row->baby3_birth?>" size="11">
							<a href="javascript: $('#baby_thd_birth').focus();" class="cal">
							<img src="/image/sub/small-calendar.png" alt="">
							</a>
						</p>
						<p>
							<label for="baby3_gender">성별</label>
							<select name="baby3_gender" id="baby3_gender">
								<option value="여아" <?=($row->baby3_gender == "여아")?"selected":"";?>>여아</option>
								<option value="남아" <?=($row->baby3_gender == "남아")?"selected":"";?>>남아</option>
							</select>
						</p></td>
				</tr>
			</table>
		</div>
		<div class="ac mt10">
			<a href="javascript: frmChk('info_form');" class="btn_g fz16">
			정보수정
			</a>
			<!-- <a href="#" class="btn_g fz16">
			취소
			</a> -->
		</div>
	</form>
	</div>