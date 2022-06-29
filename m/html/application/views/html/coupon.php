<?
	$PageName = "COUPON";
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
			<h1>쿠폰</h1>
			<p class="orderedit_top"> “<span>회원</span>”님이 사용하실 수 있는 쿠폰은 <span class="blue">2</span>개 입니다. </p>
			<div class="tblTy02">
				<table>
					<tr>
						<th>쿠폰명</th>
						<th>쿠폰코드</th>
						<th>할인혜택</th>
						<th>사용조건</th>
						<th>발급일자</th>
						<th>유효기간</th>
					</tr>
					<tr>
						<td><?=$lt->name?></td>
						<td><?=$lt->code?></td>
						<td><?if($lt->type==3){?>
							배송비 전액
							<?}else{?>
							<?=number_format($lt->price)?>
							<? if($lt->discount_flag==0){?>
							원
							<?}else if($lt->discount_flag==1){?>
							%
							<?}?>
							<?}?></td>
						<td>100,000원 이상 결제시 사용</td>
						<td><?=date("Y년 m월 d일",strtotime($lt->reg_date))?></td>
						<td><?=date("Y년 m월 d일",strtotime($lt->end_date))?></td>
					</tr>

					<!-- <tr><td colspan="6">등록된 쿠폰이 없습니다.</td></tr> -->

				</table>
			</div>
			<p title="페이지 이동하기" class="board-pager align-c mt10">
				<button type="button"><img alt="맨 앞으로" src="/image/board_img/arrow_l_end.gif"></button>
				<button type="button"><img alt="이전" src="/image/board_img/arrow_l.gif"></button>
				<a class="on" href="/html/dh_order/point/?&amp;PageNumber=1">
				1
				</a>
				<button type="button"><img alt="다음" src="/image/board_img/arrow_r.gif"></button>
				<button type="button"><img alt="맨 뒤로" src="/image/board_img/arrow_r_end.gif"></button>
			</p>
		</div>
	*/
	?>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
