<?
	$PageName = "RCMD";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			추천인 정보
		</h1>
		<p class="orderedit_top"> 추천인 결제로 받은 보유 적립금은 <span class="blue"><?=number_format($total_point->ttp)?></span>원 입니다. </p>
		<div class="tblTy02">
			<table>
				<colgroup>
					<col style="width:15%">
					<col style="width:20%">
					<col>
					<col style="width:25%">
					<col style="width:20%">
				</colgroup>
				<tr>
					<th>추천인</th>
					<th>주문일</th>
					<th>주문<br>내역</th>
					<th>결제<br>
						금액</th>
					<th>추천<br>
						적립금</th>
					<!-- <th>적립금<br>
						누계</th> -->
				</tr>
				<!-- <tr>
					<td>애기맘마</td>
					<td>2015년 2월 20일</td>
					<td>이유식 외 8건</td>
					<td>12,000원</td>
					<td>5,000원</td>
					<td>50,000원</td>
				</tr> -->
				<?php
				if($list){
					foreach($list as $lt){
					?>
					<tr>
						<td><?=$lt->name?></td>
						<td><?=date("Y년 m월 d일",strtotime($lt->trade_day))?></td>
						<td><?=$lt->gname?> <?=($lt->gt > 1)?"외 ".($lt->gt-1):"";?></td>
						<td><?=number_format($lt->total_price)?>원</td>
						<td><?=number_format($lt->point)?>원</td>
						<!-- <td>50,000원</td> -->
					</tr>
					<?php
					}
				}
				?>
			</table>
		</div>
		<p title="페이지 이동하기" class="board-pager align-c mt10">
			<button type="button"><img alt="맨 앞으로" src="/image/board_img/arrow_l_end.gif"></button>
			<button type="button"><img alt="이전" src="/image/board_img/arrow_l.gif"></button>
			<a class="on" href="#">1</a>
			<a href="#">2</a>
			<button type="button"><img alt="다음" src="/image/board_img/arrow_r.gif"></button>
			<button type="button"><img alt="맨 뒤로" src="/image/board_img/arrow_r_end.gif"></button>
		</p>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
