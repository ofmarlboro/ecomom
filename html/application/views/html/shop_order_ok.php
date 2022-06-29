<?
	$PageName = "SHOP";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
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
		<div class="sv <?=$PageName?>"></div>
		<div class="sub_top">
			<div class="inner float-wrap">
				<h2 class="gn_tit"><img src="/image/sub/menu_tit2.jpg" alt="산골이유식"></h2>
				<h3 class="hidden">주문/결제 완료</h3>
			</div>
		</div>

		<!-- Inner -->
		<div class="inner content">
			<?php
			include "{$view}.php";
			?>

			<?php
			/*
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 상단 step -->
				<div class="shop-order-step">
					<span class="so-step so-step1">장바구니</span>
					<span class="so-arr"></span>
					<span class="so-step so-step2">주문결제</span>
					<span class="so-arr"></span>
					<h2><span class="so-step so-step3 on">주문완료</span></h2>
				</div><!-- END 상단 step -->

				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<div class="order-finish-msg">
						<p><img src="/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다."></p>
						<!-- 회원주문일 경우 -->
						<p class="mt15">주문내역은 [주문 배송 조회]에서 다시 확인하실 수 있습니다.</p>
						<!-- 비회원 주문일 경우 -->
						<!-- <p class="mt15">비회원 고객님은 <strong class="em">주문코드로 주문/배송 조회가 가능</strong>합니다.</p> -->
					</div>


					<!-- 하단 버튼 -->
					<div class="align-c mb50">
						<a href="#" class="btn-normal">계속 쇼핑하기</a>
					</div><!-- END 하단 버튼 -->



					<!-- 주문 정보 -->
					<h3 class="order-tit">주문 정보</h3>
					<table class="order-field">
						<caption>주문 정보 확인</caption>
						<tr>
							<th>주문코드</th>
							<td>ABC1234940
								<!-- 비회원일 경우 -->
								<!-- <small class="bl-noti ml15 em">비회원 고객님의 주문/배송 내역 조회시 필요합니다.</small> -->
							</td>
						</tr>
						<tr>
							<th>주문일자</th>
							<td>2016-08-18</td>
						</tr>
					</table>
					<!-- END 주문 정보 -->

					<!-- 주문리스트 -->
					<h3 class="order-tit">주문 상품 리스트</h3>
					<table class="shop-cart mb50">
						<caption>주문 상품 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-df">수량</th>
								<th class="col-df">소계금액</th>
								<th class="col-df">주문상태</th>
								<th class="col-wide">택배정보</th>
							</tr>
						</thead>
						<tbody>
							<tr>
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
								<td>1</td>
								<td>123,000원</td>
								<td>입금대기중</td>
								<td>-</td>
							</tr>
							<tr>
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
								<td>1</td>
								<td>123,000원</td>
								<td>입금대기중</td>
								<td>-</td>
							</tr>
						</tbody>
					</table>
					<!-- END 주문리스트 -->


					<!-- 구매자 정보 -->
					<h3 class="order-tit">구매자 정보</h3>
					<table class="order-field">
						<caption>구매자 정보 확인</caption>
						<tr>
							<th>구매고객명</th>
							<td style="width:30%;">홍길동</td>
							<th>이메일</th>
							<td>shop@test.com</td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td>010-000-0000</td>
							<th>전화번호</th>
							<td>02-000-0000</td>
						</tr>
					</table>
					<!-- END 구매자 정보 -->


					<!-- 배송지 정보 -->
					<h3 class="order-tit">배송지 정보</h3>
					<table class="order-field">
						<caption>배송지 정보 확인</caption>
						<tr>
							<th>받으시는 분</th>
							<td colspan="3">홍길동</td>
						</tr>
						<tr>
							<th>주소</th>
							<td colspan="3">서울시 강서구 화곡동 1068-23</td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td style="width:30%;">010-000-0000</td>
							<th>전화번호</th>
							<td>02-000-0000</td>
						</tr>
						<tr>
							<th>배송시 요청사항</th>
							<td colspan="3"></td>
						</tr>
					</table>
					<!-- END 배송지 정보 -->


					<!-- 결제정보 -->
					<h3 class="order-tit">결제 정보</h3>
					<table class="order-field">
						<caption>결제 정보 확인</caption>
						<tr>
							<th>결제 수단</th>
							<td style="width:30%;">신용카드</td>
							<th>결제 상태</th>
							<td><em class="em">결제완료</em></td>
						</tr>
						<tr>
							<th>결제 금액</th>
							<td>30,000원</td>
							<th>결제 일시</th>
							<td>2016-08-18 오후 5:56:02</td>
						</tr>
					</table>
					<!-- END 결제정보 -->

					<!-- 무통장 입금일 경우에만 노출 -->
					<h3 class="order-tit">무통장 입금 정보</h3>
					<table class="order-field">
						<caption>무통장 입금 정보</caption>
						<tr>
							<th>입금자명</th>
							<td>홍길동</td>
						</tr>
						<tr>
							<th>입금은행</th>
							<td>ㅇㅇ은행</td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td>123-456-789012 (예금주: 관리자에서 등록한 예금주)</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 무통장 입금일 경우에만 노출 -->


					<!-- 하단 버튼 -->
					<div class="align-c">
						<!-- !!! 비회원 조회시 shop_login.php 로 이동합니다. -->
						<button type="button" class="btn-emp" onclick="location.href='shop_order_list.php';">주문 배송 조회</button>
					</div><!-- END 하단 버튼 -->

				</div><!-- END 주문 Wrap -->

			</div><!-- END Shop Wrap -->
			*/
			?>
		</div><!-- END Inner -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
