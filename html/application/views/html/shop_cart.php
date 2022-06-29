<?
	$PageName = "SHOP";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>
	<!--Container-->
	<div id="container">
		<div class="sv <?=$PageName?>"></div>
		<div class="sub_top">
			<div class="inner float-wrap">
				<h2 class="gn_tit"><img src="/image/sub/menu_tit2.jpg" alt="산골이유식"></h2>
				<h3 class="hidden">장바구니</h3>
			</div>
		</div>

		<!-- Inner -->
		<div class="content inner">
			<?php
			include "{$view}.php";
			?>

			<?php
			/*
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 상단 step -->
				<div class="shop-order-step">
					<h2><span class="so-step so-step1 on">장바구니</span></h2>
					<span class="so-arr"></span>
					<span class="so-step so-step2">주문결제</span>
					<span class="so-arr"></span>
					<span class="so-step so-step3">주문완료</span>
				</div><!-- END 상단 step -->


				<!-- 장바구니 Wrap -->
				<div class="shop-cart-wrap">
					<p class="order-tit">장바구니에 담긴 상품</p>

					<table class="shop-cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-chk"><input type="checkbox"></th>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<th class="col-df">적립금</th>
								<th class="col-wide">쿠폰</th>
								<th class="col-df">선택</th>
							</tr>
						</thead>
						<tbody>
							<!-- <tr>
								<td colspan="10" class="no-ct">장바구니에 담긴 상품이 없습니다.</td>
							</tr> -->
							<tr>
								<td><input type="checkbox"></td>
								<td>12345678</td>
								<td class="col-thumb"><img src="/image/shop/prod1.jpg" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="#">CUT & SWEN 팬츠</a></p>
										<p class="prod-op"><em>옵션</em> : Red, M</p>
									</div>
								</td>
								<td>
									<p class="cart-price">
										15,000원
										<!-- <del>20,000원</del>
										<ins>15,000원</ins> -->
									</p>
								</td>
								<td>
									<div class="cart-vol-wrap">
										<div class="cart-vol">
											<input type="text" value="1">
											<button class="vol-up">추가</button>
											<button class="vol-down">감소</button>
										</div>
										<button type="button" class="cart-btn2">적용</button>
									</div>
								</td>
								<td>123,000원</td>
								<td><!-- 회원구매시<br> -->1,230 P</td>
								<td>[봄맞이 3% 할인쿠폰]</td>
								<td class="cart-edit">
									<button type="button" class="cart-btn1">바로주문</button><br>
									<button type="button" class="cart-btn2">위시담기</button><br>
									<button type="button" class="cart-btn3">삭제하기</button>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td>12345678</td>
								<td class="col-thumb"><img src="/image/shop/prod1.jpg" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="#">CUT & SWEN 팬츠</a></p>
										<p class="prod-op"><em>옵션</em> : Red, M</p>
									</div>
								</td>
								<td>
									<p class="cart-price">
										<del>20,000원</del>
										<ins>15,000원</ins>
									</p>
								</td>
								<td>
									<div class="cart-vol-wrap">
										<div class="cart-vol">
											<input type="text" value="1">
											<button class="vol-up">추가</button>
											<button class="vol-down">감소</button>
										</div>
										<button type="button" class="cart-btn2">적용</button>
									</div>
								</td>
								<td>123,000원</td>
								<td><!-- 회원구매시<br> -->1,230 P</td>
								<td></td>
								<td class="cart-edit">
									<button type="button" class="cart-btn1">바로주문</button><br>
									<button type="button" class="cart-btn2">위시담기</button><br>
									<button type="button" class="cart-btn3">삭제하기</button>
								</td>
							</tr>
						</tbody>
						<!-- <tfoot>
							<tr>
								<td colspan="10">
									<div class="cart-total">
										상품 합계금액 : <em>30,000</em>원 + 배송비 <em>2,500</em>원 = 총 합계 <em>32,500</em>원
									</div>
								</td>
							</tr>
						</tfoot> -->
					</table>

					<!-- 옵션버튼 -->
					<p class="cart-op-btns">
						<button type="button" class="cart-btn2">전체선택</button>
						<button type="button" class="cart-btn1">선택상품 위시리스트 추가</button>
						<button type="button" class="cart-btn3">선택상품 삭제</button>
					</p><!-- END 옵션버튼 -->

					<!-- 총 주문금액  -->
					<div class="order-total-box">
						<div class="each-price-box">
							<p class="total-tit"><img src="/image/shop/total_tit.png" alt="총 주문금액"></p>
							<ul class="each-price">
								<li><span>상품 총 금액</span>
									<em>30,000원</em>
								</li>
								<li><span>배송비</span>
									<em>2,500원</em>
								</li>
							</ul>
						</div>
						<div class="total-price">
							<span class="acc-p">( 적립예정 포인트 : 300P )</span>
							결제 예정 금액 <span class="tt-price"><em>35,000</em> 원</span>
						</div>
					</div><!-- END 총 주문금액 -->

				</div><!-- END 장바구니 Wrap -->


				<!-- 하단 버튼 -->
				<div class="float-wrap">
					<div class="float-l">
						<button type="button" class="btn-border">계속 쇼핑하기</button>
					</div>
					<div class="float-r">
						<button type="button" class="btn-normal" onclick="location.href='/html/dh/shop_order;">선택상품 주문</button>
						<button type="button" class="btn-emp" onclick="location.href='/html/dh/shop_order';">전체 주문</button>
					</div>
				</div><!-- END 하단 버튼 -->

			</div><!-- END Shop Wrap -->
			*/
			?>
		</div><!-- END Inner -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
