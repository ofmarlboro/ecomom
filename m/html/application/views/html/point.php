<?
	$PageName = "POINT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?include("../include/mypage_top02.php");?>

		<?php
		include "{$view}.php";
		?>

		<?php
		/*
				<div class="inner mypage">
				<h1>적립금</h1>
						<p class="orderedit_top">
							“<span>회원</span>”님의 보유 적립금은 <span class="blue">2,000</span>원 입니다.
						</p>
						<div class="tblTy02">
							<table>
								<tr>
									<th>일시</th>
									<th>내용</th>
									<th>적립금<br>획득</th>
									<th>적립금<br>사용</th>
									<th>적립금<br>누계</th>
								</tr>

									<tr>
										<td>2018년 2월 20일</td>
										<td class="al">추천인 : "애기맘마"님 결제 10% 적립</td>
										<td>100,000원</td>
										<td>5,000원</td>
										<td>12,000원</td>
									</tr>

								<!-- <tr>
									<td colspan="5">적립금 내역이 없습니다.</td>
								</tr> -->

							</table>
						</div>

						<p title="페이지 이동하기" class="board-pager align-c mt10">
								<button type="button"><img alt="맨 앞으로" src="/image/board_img/arrow_l_end.gif"></button> <button type="button"><img alt="이전" src="/image/board_img/arrow_l.gif"></button> <a class="on" href="/html/dh_order/point/?&amp;PageNumber=1">1</a> <button type="button"><img alt="다음" src="/image/board_img/arrow_r.gif"></button> <button type="button"><img alt="맨 뒤로" src="/image/board_img/arrow_r_end.gif"></button>
						</p>

				</div>
		*/
		?>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>










<? include('../include/footer.php') ?>


