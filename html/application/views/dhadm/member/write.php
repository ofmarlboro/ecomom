
<?
if($this->uri->segment(4)=="edit"){

	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

	if(isset($row->email)){
		$email = explode("@",$row->email);
	}

}?>

<style type="text/css">
	.adm-tab{
		border-bottom:2px solid #000;
	}
	.adm-tab th{
		padding:10px;
	}
	.adm-tab th.on{
		border-top:2px solid #000;
		background:#eee;
	}

	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<script type="text/javascript">

	$(function(){
		$(".baby_birth_cal").datepicker({
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd', //형식(20120303)
			autoSize: true, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			showMonthAfterYear: true//년 뒤에 월 표시
		});
	});
</script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/member_info_top.php";
?>

<table class="adm-tab mb20 mt20">
	<tr>
		<th <?if($mode == "edit" || $mode == "write"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">회원 정보 관리</a></th>
		<th <?if($mode == "order"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/order/<?=$row->idx?>/<?=$query_string.$param?>">주문 내역</a></th>
		<th <?if($mode == "qna"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/qna/<?=$row->idx?>/<?=$query_string.$param?>">1:1 문의</a></th>
		<th <?if($mode == "point"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/point/<?=$row->idx?>/<?=$query_string.$param?>">적립금 내역</a></th>
		<th <?if($mode == "coupon"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/coupon/<?=$row->idx?>/<?=$query_string.$param?>">쿠폰 내역</a></th>
		<th <?if($mode == "deliv_place"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/deliv_place/<?=$row->idx?>/<?=$query_string.$param?>">배송지 관리</a></th>
		<th <?if($mode == "admin_memo"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/admin_memo/<?=$row->idx?>/<?=$query_string.$param?>">관리자 메모</a></th>
	</tr>
</table>

			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
				<?if($this->uri->segment(4)=="write"){?>
				<input type="hidden" name="userid_chk" value="" msg="아이디 중복확인을 해주세요.">
				<?}else{?>
				<input type="hidden" name="userid" value="<? echo isset($row->userid) ? $row->userid : "";?>">
				<?}?>

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb50">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;">
						<col style="">
					</colgroup>
					<tbody>
						<tr>
							<th> * 아이디</th>
							<td colspan="3">
								<?php
								if($this->uri->segment(4)=="write"){
								?>
								<input type="text" class="width-m" name="userid" msg="아이디를" value="">
								<input type="button" class="btn-clear" value="중복확인" onclick="id_check();">
								<?php
								}
								else{
									echo @$row->userid;
								}

								//탈퇴한 회원의 경우
								if(@$row->outmode == 1){
								?>
								<em class="dh_red ml5"> (탈퇴회원)</em>
								<?php
								}
								?>
							</td>
						</tr>
						<tr>
							<th> * 비밀번호</th>
							<td><input type="password" class="width-m" name="passwd" <? if($this->uri->segment(4)=="write"){ ?> msg="비밀번호를"<?}?>> * 수정시 입력</td>
							<th> * 비밀번호 확인</th>
							<td><input type="password" class="width-m" name="passwd_check" <? if($this->uri->segment(4)=="write"){ ?> msg="비밀번호 확인을"<?}?> passwd_match="비밀번호가 일치하지 않습니다. 다시 한번 확인해 주세요." matching_name="passwd"> * 수정시 입력</td>
						</tr>
						<tr>
							<th> * 이름</th>
							<td><input type="text" class="width-m" name="name" msg="이름을" value="<? echo isset($row->name) ? $row->name : "";?>"></td>
							<th> * 닉네임</th>
							<td>
								<?php
								if($this->uri->segment(4)=="write"){
								?>
								<input type="text" class="width-m" name="nick" msg="닉네임을">
								<input type="button" class="btn-clear" value="중복확인" onclick="nick_chk();">
								<?php
								}
								else{
									echo @$row->nick;
								}
								?>
							</td>
						</tr>
						<tr>
							<th> * 이메일</th>
							<td><input type="text" class="width-m" name="email1" msg="이메일을" value="<? echo isset($email[0]) ? $email[0] : "";?>">@<input type="text" class="width-m" name="email2" id="email2" msg="이메일을" value="<? echo isset($email[1]) ? $email[1] : "";?>">
										<select name="email_sel" onchange="res(this.value);">
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
							</td>
							<th> * 생년월일</th>
							<td>
							<input type="text" class="width-xs" name="birth_year" maxlength="4" value="<? echo isset($row->birth_year) ? $row->birth_year : "";?>"> 년
							<input type="text" class="width-xs" name="birth_month" maxlength="2" value="<? echo isset($row->birth_month) ? $row->birth_month : "";?>"> 월
							<input type="text" class="width-xs" name="birth_date" maxlength="2" value="<? echo isset($row->birth_date) ? $row->birth_date : "";?>"> 일
								<!-- <span class="ml15"></span>
								<input type="radio" id="birth01" value="1" name="birth_gubun" <?=(@$row->birth_gubun == 1)?"checked":"";?>> <label for="birth01">양력</label>
								<input type="radio" id="birth02" value="2" name="birth_gubun" <?=(@$row->birth_gubun == 2)?"checked":"";?>> <label for="birth02">음력</label> -->
							</td>
						</tr>
						<tr>
							<th> * 주소</th>
							<td colspan="3">
								<p>
									<input type="text" class="width-xs" name="zip1" id="zipcode1" value="<? echo isset($row->zip1) ? $row->zip1 : "";?>" readonly>
									<input type="button" class="btn-clear" value="우편번호찾기" onclick="sample6_execDaumPostcode()">
									<input type="text" class="width-l" name="add1" id="address1" value="<? echo isset($row->add1) ? $row->add1 : "";?>" readonly>
									<input type="text" class="width-l" name="add2" id="address2" value="<? echo isset($row->add2) ? $row->add2 : "";?>">
								</p>
							</td>
						</tr>
						<tr>
							<th> * 전화번호</th>
							<td><input type="text" class="width-xs" name="tel1" value="<? echo isset($row->tel1) ? $row->tel1 : "";?>" maxlength="3"> -
							<input type="text" class="width-xs" name="tel2" value="<? echo isset($row->tel2) ? $row->tel2 : "";?>" maxlength="4"> -
							<input type="text" class="width-xs" name="tel3" value="<? echo isset($row->tel3) ? $row->tel3 : "";?>" maxlength="4">
							</td>
							<th> * 휴대폰</th>
							<td><input type="text" class="width-xs" name="phone1" msg="휴대폰 번호를" value="<? echo isset($row->phone1) ? $row->phone1 : "";?>" maxlength="3"> -
							<input type="text" class="width-xs" name="phone2" msg="휴대폰 번호를" value="<? echo isset($row->phone2) ? $row->phone2 : "";?>" maxlength="4"> -
							<input type="text" class="width-xs" name="phone3" msg="휴대폰 번호를" value="<? echo isset($row->phone3) ? $row->phone3 : "";?>" maxlength="4">
							</td>
						</tr>
						<tr>
							<th>이메일 수신동의</th>
							<td><input type="checkbox" id="chk_mailing" name="mailing" value="1" <? echo (isset($row->mailing) && $row->mailing=="1") ? "checked" : "";?>>
									<label for="chk_mailing">메일수신에 동의하시면 체크해주세요.</label>
							</td>
							<th>sms수신동의</th>
							<td><input type="checkbox" id="chk_sms" name="resms" value="1" <? echo (isset($row->resms) && $row->resms=="1") ? "checked" : "";?>>
									<label for="chk_sms">SMS문자수신에 동의하시면 체크해주세요.</label>
							</td>
						</tr>
						<tr>
							<th>추천인 아이디</th>
							<td>
								<?php
								if($this->uri->segment(4)=="write"){
								?>
								<input type="text" class="width-m" name="recomid">
								<?php
								}
								else{
									echo @$row->recomid;
								}
								?>
							</td>
							<th>회원등급</th>
							<td>
								<select name="level">
									<? foreach ($level_row as $lv_row){ ?>
									<option value="<?=$lv_row->level?>" <? echo (isset($row->level) && $row->level==$lv_row->level) ? "selected" : "";?>><?=$lv_row->name?></option>
									<?}?>
								</select>
							</td>
						</tr>
						<!-- <tr>
							<th>sms 서비스</th>
							<td><input type="checkbox" id="chk_sms" name="resms" value="1" <? echo (isset($row->resms) && $row->resms=="1") ? "checked" : "";?>>
									<label for="chk_sms">sms수신에 동의하시면 체크해주세요.</label>
							</td>
						</tr> -->

						<? if(isset($row->userid) && $row->outmode==1){?>

						<tr>
							<th>탈퇴사유</th>
							<td>
							<?=$row->outtype?>
							</td>
						</tr>
						<tr>
							<th>요청사항</th>
							<td>
							<?=nl2br($row->outmsg)?>
							</td>
						</tr>

						<?}?>

					</tbody>
				</table>

				<h3 class="icon-pen">자녀정보입력</h3>
				<table class="adm-table">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="">
					</colgroup>
					<tbody>
						<?php
						$i_text = array("1"=>"첫쩨","2"=>"둘쩨","3"=>"셋쩨");
						for($i=1;$i<4;$i++){
						?>
						<tr>
							<th><?=$i_text[$i]?>아이</th>
							<td>
								이름 <input type="text" name="baby<?=$i?>_name" value="<?=$row->{"baby".$i."_name"}?>">
								아이생일 <input type="text" name="baby<?=$i?>_birth" class="baby_birth_cal" value="<?=$row->{"baby".$i."_birth"}?>">
								성별
								<select name="baby<?=$i?>_gender">
									<option value="">선택</option>
									<option value="여아" <?=($row->{"baby".$i."_gender"} == "여아") ? "selected":""; ?>>여아</option>
									<option value="남아" <?=($row->{"baby".$i."_gender"} == "남아") ? "selected":""; ?>>남아</option>
								</select>
							</td>
						</tr>
						<?php
						}
						/*
						if($this->uri->segment(4)=="write"){
							$key_arr = array("첫째","둘째","셋째");
							foreach($key_arr as $key=>$ka){
							?>
							<tr>
								<th><?=$key_arr[$key]?>아이</th>
								<td>
									이름 <input type="text" name="baby_name[]">
									아이생일 <input type="text" name="baby_birth[]" class="baby_birth_cal">
									성별
									<select name="baby_gender[]">
										<option value="">선택</option>
										<option value="여아">여아</option>
										<option value="남아">남아</option>
									</select>
								</td>
							</tr>
							<?php
							}
						}
						else{
							$key_arr = array("첫째","둘째","셋째");
							foreach($bbinfo as $key=>$bi){
							?>
							<tr>
								<th><?=$key_arr[$key]?>아이</th>
								<td>
									이름 <input type="text" name="baby_name[]" value="<?=$bi['name']?>">
									아이생일 <input type="text" name="baby_birth[]" value="<?=$bi['birth']?>" class="baby_birth_cal">
									성별
									<select name="baby_gender[]">
										<option value="">선택</option>
										<option value="여아" <?=($bi['gender'] == "여아")?"selected":"";?>>여아</option>
										<option value="남아" <?=($bi['gender'] == "남아")?"selected":"";?>>남아</option>
									</select>
								</td>
							</tr>
							<?php
							}
						}
						*/
						?>
					</tbody>
				</table>

				<p class="align-c mt40">
					<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:history.back(-1);">
					<input type="button" class="btn-ok btn-xl" name="writeBtn" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk('frm');">
				</p>

			</form>
			<iframe name="idcheck" frameBorder=0 width=0 height=0 scrolling=no marginwidth="0" marginheight="0"></iframe>

<script>

// 아이디 중복체크
function id_check(){

		var form=document.frm;

		if(form.userid.value=="") {
			alert("회원 아이디를 입력해 주세요.");
			form.userid.focus();
		} else {

			idcheck.location.href="?idCheck=1&userid="+form.userid.value;

		}

}

function nick_chk(){
	var nickname = $("input[name='nick']");
	if (nickname.val() == "")
	{
		alert("");
		nickname.focus();
		return;
	}
	else{
		$.get("<?=cdir()?>/member/nick_chk/?nick="+nickname.val(),function(data){

		});
	}
}


</script>