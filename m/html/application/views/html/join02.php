<?
	$PageName = "";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>

		<?php
		include "{$view}.php";
		?>

		<?php
		/*
			<div class="inner mypage join">
				<h1>
					기본 정보
				</h1>
				<div class="tblTy03">
					<table>
						<tr>
							<th>이름</th>
							<td><input type="text" size="16"></td>
						</tr>
						<tr>
							<th>닉네임</th>
							<td><input type="text" size="16"></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td class="clearfix"><p>
									<input type="password" size="16">
								</p>
								<p class="fs12 gray mt10"> ※ 영문과 숫자 조합으로
									6자이상 16자 이하로 가능합니다. </p></td>
						</tr>
						<tr>
							<th>비밀번호<br>
								확인</th>
							<td><input type="password" size="16"></td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><select name="" id="">
									<option value="">010</option>
								</select>
								-
								<input type="text" size="4">
								-
								<input type="text" size="4"></td>
						</tr>
						<tr>
							<th>휴대폰<br>
								번호</th>
							<td><select name="" id="">
									<option value="">010</option>
								</select>
								-
								<input type="text" size="4">
								-
								<input type="text" size="4"></td>
						</tr>
						<tr>
							<th>자택주소</th>
							<td><p>
									<input type="text" size="10">
								</p>
								<p class="mt10">
									<a href="#" class="btn_g">
									자택주소
									</a>
									<a href="#" class="btn_g">
									배송지 관리
									</a>
								</p>
								<p class="mt10">
									<input type="text" size="26">
								</p>
								<p class="mt10">
									<input type="text" size="26">
								</p>
								<p class="fs12 gray mt10"> ※ 가입 후 마이페이지 > 배송지관리에서 시댁, 친정 등 배송지를 추가로 관리할 수 있습니다. </p></td>
						</tr>
						<tr>
							<th>마케팅<br>
								수신동의</th>
							<td><p class="fs12 gray"> ※ 수신동의시 가격할인, 이벤트 등 다양한 혜택 알림서비스를 안내 받으실 수 있습니다. </p>
								<p class="fs12 gray mt10"> ※ 주문 및 배송안내, 약관안내, 주요 정책 변경에 따른 안내는 수신 동의 여부와 상관없이 발송됩니다. </p>
								<p class="mt10">
									<input type="checkbox" id="SMS">
									<label for="SMS">SMS 수신 동의</label>
								</p>
								<p>
									<input type="checkbox" id="EMAIL">
									<label for="EMAIL">이메일 수신 동의</label>
							</td>
								</p>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text" size="10">
								@
								<input type="text" size="10">
								<p class="mt10">
									<select name="" id="">
										<option value="">직접입력</option>
										<option value="">naver.com</option>
										<option value="">hanmail.net</option>
									</select>
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
									<label for="b_name">이름</label>
									<input type="text" size="9" id="b_name">
								</p>
								<p>
									<label for="birth">생년월일</label>
									<input type="text" id="birth" size="11">
									<a href="#" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="gen">성별</label>
									<select name="" id="gen">
										<option value="">여아</option>
										<option value="">남아</option>
									</select>
								</p></td>
						</tr>
						<tr>
							<th>둘째<br>
								아기</th>
							<td><p>
									<label for="b_name">이름</label>
									<input type="text" size="9" id="b_name">
								</p>
								<p>
									<label for="birth">생년월일</label>
									<input type="text" id="birth" size="11">
									<a href="#" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="gen">성별</label>
									<select name="" id="gen">
										<option value="">여아</option>
										<option value="">남아</option>
									</select>
								</p></td>
						</tr>
						<tr>
							<th>셋째<br>
								아기</th>
							<td><p>
									<label for="b_name">이름</label>
									<input type="text" size="9" id="b_name">
								</p>
								<p>
									<label for="birth">생년월일</label>
									<input type="text" id="birth" size="11">
									<a href="#" class="cal">
									<img src="/image/sub/small-calendar.png" alt="">
									</a>
								</p>
								<p>
									<label for="gen">성별</label>
									<select name="" id="gen">
										<option value="">여아</option>
										<option value="">남아</option>
									</select>
								</p></td>
						</tr>
					</table>
				</div>
				<div class="ac mt10">
					<a href="join_ok.php" class="btn_g fz16">
					회원가입
					</a>
					<a href="join01.php" class="btn_g fz16">
					취소
					</a>
				</div>
			</div>
		*/
		?>
	<!-- inner -->

	</div>
	<!--END Container-->
	<div class="mg95"></div>





<? include('../include/footer.php') ?>


