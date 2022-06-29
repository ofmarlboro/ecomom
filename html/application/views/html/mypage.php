<?
	$PageName = "MYPAGE";
	$SubName = "";
	$PageTitle = "회원정보수정";
	include('../include/head.php');
	include('../include/header.php');
?>

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
		<div class="my_cont clearfix">
			<div>
				<div class="my_tit">
					기본 정보
				</div>
				<div class="tblTy02">
					<table>
						<colgroup>
						<col width="140px">
						<col width="380px">
						<col width="140px">
						<col>
						</colgroup>
						<tr>
							<th>이름</th>
							<td><input type="" style="width:100px">
								<a href="" class="btn_gg">
								중복확인
								</a></td>
							<th>닉네임</th>
							<td><input type="" style="width:100px">
								<a href="" class="btn_gg">
								중복확인
								</a></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td class="clearfix"><p>
									<input type="password" size="16">
								</p>
								<p class="fs12 gray">
									※ 영문과 숫자 조합으로
									6자이상 16자 이하로 가능합니다.
								</p></td>
							<th>전화번호</th>
							<td><select name="" id="reg_sel02">
								<option value="">010</option>
								</select>
								-
								<input type="" size="4">
								-
								<input type="" size="4"></td>
						</tr>
						<tr>
							<th>비밀번호 확인</th>
							<td><input type="password" size="16"></td>
							<th>휴대폰 번호</th>
							<td><select name="" id="reg_sel02">
								<option value="">010</option>
								</select>
								-
								<input type="" size="4">
								-
								<input type="" size="4"></td>
						</tr>
						<tr>
							<th>자택주소</th>
							<td colspan="3"><p>
									<input type="">
									<a href="" class="btn_gg">
									자택주소
									</a>
									<a href="" class="btn_gg">
									배송지 관리
									</a>
								</p>
								<p class="mt10">
									<input type="" size="50">
									<input type="" size="30">
								</p>
								<p class="fs12 gray mt10">
									※ 가입 후 마이페이지 > 배송지관리에서 시댁, 친정 등 배송지를 추가로 관리할 수 있습니다.
								</p></td>
						</tr>
						<tr>
							<th>마케팅 수신 동의</th>
							<td colspan="3"><p class="fs12 gray">
									※ 수신동의시 가격할인, 이벤트 등 다양한 혜택 알림서비스를 안내 받으실 수 있습니다.
								</p>
								<p class="fs12 gray mb10">
									※ 주문 및 배송안내, 약관안내, 주요 정책 변경에 따른 안내는 수신 동의 여부와 상관없이 발송됩니다.
								</p>
								<input type="checkbox" id="SMS">
								<label for="SMS">SMS 수신 동의</label>
								<input type="checkbox" id="EMAIL" style="margin-left:10px">
								<label for="EMAIL">이메일 수신 동의</label></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td colspan="3"><input type="">
								<a href="" class="btn_gg">
								중복확인
								</a></td>
						</tr>
						<tr>
							<th>추천인 아이디</th>
							<td colspan="3"><input type="">
								<a href="" class="btn_gg">
								검색
								</a>
								<p class="fs12 gray mt10">
									※ 추천인과 피추천인 모두 결제금액의 10%를 적립금으로 드립니다.
								</p></td>
						</tr>
					</table>
				</div>
			</div>
			<div>
				<div class="my_tit">
					자녀 정보
				</div>
				<div class="tblTy02">
					<table>
						<colgroup>
							<col width="15%">
						</colgroup>
						<tr>
							<th>첫째 아기</th>
							<td><label for="">이름</label>
								<input type="">
								<label for="" style="margin-left:10px">생년월일</label>
								<input type="">
								<a href="" class="cal"><img src="/image/sub/small-calendar.png" alt=""></a>
								<label for="" style="margin-left:10px">성별</label>
								<select name="" id="reg_sel02">
									<option value="">여아</option>
									<option value="">남아</option>
								</select></td>
						</tr>
						<tr>
							<th>둘째 아기</th>
							<td><label for="">이름</label>
								<input type="">
								<label for="" style="margin-left:10px">생년월일</label>
								<input type="">
								<a href="" class="cal"><img src="/image/sub/small-calendar.png" alt=""></a>
								<label for="" style="margin-left:10px">성별</label>
								<select name="" id="reg_sel02">
									<option value="">여아</option>
									<option value="">남아</option>
								</select></td>
						</tr>
						<tr>
							<th>셋째 아기</th>
							<td><label for="">이름</label>
								<input type="">
								<label for="" style="margin-left:10px">생년월일</label>
								<input type="">
								<a href="" class="cal"><img src="/image/sub/small-calendar.png" alt=""></a>
								<label for="" style="margin-left:10px">성별</label>
								<select name="" id="reg_sel02">
									<option value="">여아</option>
									<option value="">남아</option>
								</select></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="ac">
				<a href="" class="btn_big">가입 완료</a>
			</div>
		</div>
		*/
		?>

	</div>
</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
