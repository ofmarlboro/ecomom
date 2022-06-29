<?
	$PageName = "ORDERLIST";
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
			<h1>주문배송조회</h1>
			<h2>최근주문내역</h2>
			<div class="red ac">최근 주문내역 변경이 적용되었습니다.</div>
			<div class="tblTy01 mt10">
				<table>
					<tr>
						<th>주문서번호</th>
						<td><a href="shop_order_detail.php"><span class="blue">20156225522155</span><br>자유배송[후기]외 8건</a></td>
						<td colspan="2"><em>100,000</em>원</td>
					</tr>
					<tr>
						<td class="bg link" colspan="3">
							<span class="link01 on">
							<img src="/image/sub/link01.png" alt="" class="icon">입금대기중<img src="/image/sub/arw01.png" alt="" class="arw">
							</span>
							<span class="link02"><img src="/image/sub/link02.png" alt="" class="icon">배송준비중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
							<span class="link03"><img src="/image/sub/link03.png" alt="" class="icon">배송중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
							<span class="link04"><img src="/image/sub/link04.png" alt="" class="icon">배송완료</span>
						</td>
					</tr>
					<tr>
						<th>운송장번호</th>
						<td colspan="2"><span class="blue">우체국 : 20156225522155</span></td>
					</tr>
					<tr>
						<th>배송일시</th>
						<td colspan="2">17-05-21</td>
					</tr>
				</table>
			</div>
			<div class="tblTy01 mt10">
				<table>
					<tr>
						<th>주문서번호</th>
						<td><a href="shop_order_detail.php"><span class="blue">20156225522155</span><br>정기배송[후기]외 8건</a></td>
						<td colspan="2"><em>100,000</em>원</td>
					</tr>
					<tr>
						<td class="bg link" colspan="3">
							<span class="link01 on"><img src="/image/sub/link01.png" alt="" class="icon">입금대기중 <img src="/image/sub/arw01.png" alt="" class="arw">	</span>
							<span class="link02"><img src="/image/sub/link02.png" alt="" class="icon">배송준비중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
							<span class="link03"><img src="/image/sub/link03.png" alt="" class="icon">배송중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
							<span class="link04"><img src="/image/sub/link04.png" alt="" class="icon">배송완료</span>
						</td>
					</tr>
				</table>
			</div>
		</div>
	*/
	?>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
