<?
	$PageName = "SHOP_CART";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<div class="inner mypage">
		<h1>
			장바구니
		</h1>

		<!-- Shop Wrap -->
		<?php
		/*
			<div class="shop-wrap mt10">
				<div class="tblTy02 tblTy02_1">
					<table>
						<colgroup>
						<col>
						<col>
						<col>
						<col width="70px">
						<col width="45px">
						</colgroup>
						<tr>
							<th><input type="checkbox" checked id=""></th>
							<th>배송일</th>
							<th>상품명</th>
							<th>총수량</th>
							<th>&nbsp;</th>
						</tr>
						<tr class="al">
							<td><input type="checkbox" checked id=""></td>
							<td class="al">주2회 배송<br>
								수,토</td>
							<td class="al">[추천식단] 5개월 전후: 준비기<br>
								(2018-05-19 ~ 2018-06-23)<br>
								소계: 29,350원</td>
							<td>28팩
								<a href="" class="btn_y" style="display: block; padding: 3px;">식단보기</a></td>
							<td><a href="" class="btn_lg">삭제</a></td>
						</tr>
						<tr>
							<td><input type="checkbox" checked id=""></td>
							<td class="al">주2회 배송<br>
								수,토</td>
							<td class="al">[추천식단] 5개월 전후: 준비기<br>
								(2018-05-19 ~ 2018-06-23)<br>
								소계: 29,350원</td>
							<td style="position: relative;"><div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
									<!-- <button type="button" class="cart-btn1 mt10">바로주문</button> -->
								</div>
								<a href="" class="btn_green" style="display: block; padding: 3px;font-size: 12px;">적용하기</a></td>
							<td><a href="" class="btn_lg">삭제</a></td>
						</tr>
					</table>
				</div>
				<div class="shop-cart-wrap">
					<div class="ac">
						<a href="#" class="ch_del">선택삭제</a>
					</div>
					<!-- 총 가격 -->
					<div class="order-price-box">
						<ul class="order-price">
							<li>
								<div class="shop-inner">
									<span class="l">총 상품금액(2개)</span>
									<span class="r">30,000원</span>
								</div>
							</li>
							<li>
								<div class="shop-inner">
									<span class="l">배송비</span>
									<span class="r">2,500원</span>
								</div>
							</li>
							<li class="order-total" style="background: #eee;">
								<div class="shop-inner">
									<em class="l">총 주문금액</em>
									<div class="r">
										<span class="total-price">32,500원</span>
										<span class="save-point">적립 포인트 325P</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- END 총 가격 -->

				</div>
				<!-- END Shop Cart Wrap -->

				<!-- 주문버튼 -->
				<div class="mt20">
					<a href="shop_order.php" class="ch_order">선택상품 주문하기</a>
					<a href="shop_order.php" class="all_order">전체상품 주문하기</a>
				</div>
				<!-- END 주문버튼 -->
				<a href="" class="keep_shop">쇼핑계속하기</a>
			</div>
		*/
		?>
		<!-- END Shop Wrap -->

		<?php
		include "{$view}.php";
		?>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
