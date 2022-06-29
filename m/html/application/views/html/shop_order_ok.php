<?
	$PageName = "SHOP_ORDER_OK";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!-- Mirae Log Analysis Conversion Script Ver 1.0   -->
<script type='text/javascript'>
var mi_type = 'order';
var mi_val = '<?=$trade_stat->price?>';
var mi_order_num = '<?=$trade_code?>';
</script>
<!-- Mirae Log Analysis Conversion Script END  -->

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			주문완료
		</h1>

			<?php
			include "{$view}.php";
			?>

		<?php
		/*
				<!-- Shop Wrap -->
				<div class="shop-wrap">



					<!-- 완료 메시지 -->
					<div class="order-finish-msg">
						<p><img src="/m/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다." width="250" height="50"></p>
						<p class="mt10">주문내역은 <span class="em">[주문 배송 조회]</span>에서<br>다시 확인하실 수 있습니다.</p>
					</div>
					<!-- END 완료 메시지 -->

					<!-- 주문버튼 -->
					<div class="shop-inner align-c mb30">
						<button type="button" class="btn-border">계속 쇼핑하기</button>
					</div>
					<!-- END 주문버튼 -->

					<!-- Shop Order Wrap -->
					<div class="shop-order-wrap">
						<!-- 주문정보 -->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_receipt.png" alt="">주문 정보</h4>
						<ul class="order-field no-form">
							<li>
								<div class="of-label">주문코드</div>
								<div class="of-field">ABC123456789</div>
							</li>
							<li>
								<div class="of-label">주문일자</div>
								<div class="of-field">2016-09-07</div>
							</li>
						</ul>
						<!-- END 주문정보 -->


						<!-- 주문 상품 확인 -->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_box.png" alt="">주문 상품 확인</h4>
						<ul class="shop-cart order-cart">
							<li>
								<div class="float-wrap">
									<p class="cart-prod-name">
										CUT &amp; SWEN 팬츠
									</p>
								</div>
								<div class="cart-prod-dt mt10">
									<p class="sel-opt"><em>옵션</em> Red, M</p>
									<p class="sel-opt"><em>수량</em> 1개</p>
								</div>
								<div class="sel-price">
									<em class="label">소계금액</em>
									<span class="price">
										15,000원
									</span>
								</div>
							</li>
							<li>
								<div class="float-wrap">
									<p class="cart-prod-name">
										CUT &amp; SWEN 팬츠
									</p>
								</div>
								<div class="cart-prod-dt mt10">
									<p class="sel-opt"><em>옵션</em> Red, M</p>
									<p class="sel-opt"><em>수량</em> 1개</p>
								</div>
								<div class="sel-price">
									<em class="label">소계금액</em>
									<span class="price">
										<del>20,000원</del>
										<ins>15,000원</ins>
									</span>
								</div>
							</li>
						</ul><!-- END 주문 상품 확인 -->

						<!-- 주문 고객 정보 -->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_user.png" alt="">주문 고객 정보</h4>
						<ul class="order-field no-form">
							<li>
								<div class="of-label">주문고객명</div>
								<div class="of-field">홍길동</div>
							</li>
							<li>
								<div class="of-label">이메일</div>
								<div class="of-field">test@test.com</div>
							</li>
							<li>
								<div class="of-label">휴대폰</div>
								<div class="of-field">010-111-1111</div>
							</li>
						</ul>
						<!-- END 주문 고객 정보 -->


						<!-- 배송지 정보 -->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_delivery.png" alt="">배송지 정보</h4>
						<ul class="order-field no-form">
							<li>
								<div class="of-label">받으시는 분</div>
								<div class="of-field">홍길동</div>
							</li>
							<li>
								<div class="of-label">주소</div>
								<div class="of-field">서울 강서구 화곡동 1068-23</div>
							</li>
							<li>
								<div class="of-label">휴대폰</div>
								<div class="of-field">010-111-1111</div>
							</li>
							<li>
								<div class="of-label">전화번호</div>
								<div class="of-field">02-111-1111</div>
							</li>
							<li>
								<div class="of-label">배송요청사항</div>
								<div class="of-field"></div>
							</li>
						</ul>
						<!-- END 배송지 정보 -->


						<!-- 결제정보 -->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_card.png" alt="">결제 정보</h4>

						<ul class="order-field no-form">
							<li>
								<div class="of-label">결제수단</div>
								<div class="of-field">신용카드</div>
							</li>
							<li>
								<div class="of-label">결제상태</div>
								<div class="of-field"><em class="em">결제완료</em></div>
							</li>
							<li>
								<div class="of-label">결제금액</div>
								<div class="of-field">30,000원</div>
							</li>
							<li>
								<div class="of-label">결제일시</div>
								<div class="of-field">2016-09-07 오후 5:55:55</div>
							</li>
						</ul><!-- END 결제정보 -->


						<!-- 무통장 입금 안내-->
						<h4 class="order-field-tit"><img src="/m/image/shop/icon_money.png" alt="">무통장입금 안내</h4>
						<ul class="order-field no-form mb0">
							<li>
								<div class="of-label">입금자명</div>
								<div class="of-field">홍길동</div>
							</li>
							<li>
								<div class="of-label">입금은행</div>
								<div class="of-field">ㅇㅇ은행</div>
							</li>
							<li>
								<div class="of-label">계좌번호</div>
								<div class="of-field">1234-5678-90123</div>
							</li>
						</ul>
						<div class="order-dark shop-inner">
							<ul class="order-noti">
								<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
								<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다</li>
							</ul>
						</div>
						<!-- END 무통장 입금 안내 -->

					</div><!-- END Shop Order Wrap -->


					<!-- 주문버튼 -->
					<div class="shop-inner mt15">
						<button type="button" class="btn-emp-border field-full" onclick="location.href='orderList.php';">주문내역조회</button>
					</div>
					<!-- END 주문버튼 -->

				</div><!-- END Shop Wrap -->
		*/
		?>


	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
