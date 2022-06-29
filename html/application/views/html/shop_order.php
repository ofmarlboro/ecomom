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
				<h3 class="hidden">주문/결제</h3>
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
					<h2><span class="so-step so-step2 on">주문결제</span></h2>
					<span class="so-arr"></span>
					<span class="so-step so-step3">주문완료</span>
				</div><!-- END 상단 step -->


				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<h3 class="order-tit">주문리스트 확인</h3>

					<table class="shop-cart">
						<caption>주문 상품 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">상품코드</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<th class="col-df">적립금</th>
								<th class="col-wide">쿠폰</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>12345678</td>
								<td class="col-thumb"><img src="/image/shop/prod1.jpg" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name">CUT & SWEN 팬츠</p>
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
								<td><!-- 회원구매시<br> -->1,230 P</td>
								<td>[봄맞이 3% 할인쿠폰]</td>
							</tr>
							<tr>
								<td>12345678</td>
								<td class="col-thumb"><img src="/image/shop/prod1.jpg" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name">CUT & SWEN 팬츠</p>
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
								<td><!-- 회원구매시<br> -->1,230 P</td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<!-- 총 주문금액 -->
					<div class="order-total-box">
						<div class="each-price-box">
							<p class="total-tit"><img src="/image/shop/total_tit.png" alt="총 주문 금액"></p>
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
							총 주문 금액 <span class="tt-price"><em>35,000</em> 원</span>
						</div>
					</div><!-- END 총 주문금액 -->


					<!-- 주문고객 정보 -->
					<h3 class="order-tit">주문고객 정보</h3>
					<table class="order-field">
						<caption>주문고객 정보</caption>
						<tbody>
							<tr>
								<th><label for="ou-name">주문고객명</label></th>
								<td><input type="text" id="ou-name"></td>
							</tr>
							<tr>
								<th><label for="ou-email">이메일</label></th>
								<td><input type="text" id="ou-email"> @
									<input type="text">
									<select name="email_sel">
										<option value="a">직접입력</option>
										<option value="naver.com">naver.com</option>
										<option value="daum.net">daum.net</option>
										<option value="gmail.com">gmail.com</option>
										<option value="hanmail.net">hanmail.net</option>
										<option value="hotmail.com">hotmail.com</option>
									</select>
									<small class="ml10">주문정보를 이메일로 발송해드립니다.</small>
								</td>
							</tr>
							<tr>
								<th>주소</th>
								<td>
									<p><label for="ou-post" class="label-out">우편번호</label><input type="text" class="field-s mr5" id="ou-post"><button type="button" class="btn-border-s">우편번호찾기</button></p>
									<p class="mt5">
										<input type="text" class="field-l">
										<label for="ou-addr-dt" class="label-out">상세주소</label>
										<input type="text" class="field-l" id="ou-addr-dt">
									</p>
								</td>
							</tr>
							<tr>
								<th><label for="ou-phone">휴대폰</label></th>
								<td><input type="text" class="field-xs" id="ou-phone"> - <input type="text" class="field-xs"> - <input type="text" class="field-xs">
									<small class="ml10">주문정보를 SMS로 발송해드립니다.</small>
								</td>
							</tr>
							<tr>
								<th><label for="ou-tel">전화번호</label></th>
								<td><input type="text" class="field-xs" id="ou-tel"> - <input type="text" class="field-xs"> - <input type="text" class="field-xs"></td>
							</tr>
						</tbody>
					</table>
					<!-- END 주문고객 정보 -->

					<!-- 배송지 정보 -->
					<h3 class="order-tit">배송지 정보</h3>
					<table class="order-field">
						<caption>배송지 정보</caption>
						<tbody>
							<tr>
								<th>배송지 선택</th>
								<td>
									<input type="radio" name="info-comp" id="info-same"><label for="info-same">주문고객 정보와 동일</label>
									<input type="radio" name="info-comp" id="info-new"><label for="info-new">새로운 주소</label>
									<input type="radio" name="info-comp" id="info-addr-list"><label for="info-addr-list">배송지 목록에서 선택</label>
									<button	type="button" class="btn-border-s" onclick="window.open('address_list.php', 'addr', 'width=760, height=500, scrollbars=yes');">배송지 목록</button>
								</td>
							</tr>
							<tr>
								<th><label for="du-name">받으시는 분</label></th>
								<td><input type="text" id="du-name"></td>
							</tr>
							<tr>
								<th>주소</th>
								<td>
									<p><label for="du-post" class="label-out">우편번호</label><input type="text" class="field-s mr5" id="du-post"><button type="button" class="btn-border-s">우편번호찾기</button></p>
									<p class="mt5">
										<input type="text" class="field-l">
										<label for="du-addr-dt" class="label-out">상세주소</label>
										<input type="text" class="field-l" id="du-addr-dt">
									</p>
								</td>
							</tr>
							<tr>
								<th><label for="du-phone">휴대폰</label></th>
								<td><input type="text" class="field-xs" id="du-phone"> - <input type="text" class="field-xs"> - <input type="text" class="field-xs"></td>
							</tr>
							<tr>
								<th><label for="du-tel">전화번호</label></th>
								<td><input type="text" class="field-xs" id="du-tel"> - <input type="text" class="field-xs"> - <input type="text" class="field-xs"></td>
							</tr>
							<tr>
								<th><label for="du-msg">배송시 요청사항</label></th>
								<td><div class="deliv-msg">
										<input type="text" class="field-xl" id="du-msg">
										<ul class="deliv-msg-ex">
											<li>부재시 경비실에 맡겨주세요.</li>
											<li>배송 전 연락바랍니다.</li>
											<li>파손 위험이 있는 상품이니 조심히 다뤄주세요.</li>
											<li>경비실에 맡겨주세요.</li>
											<li>택배함에 넣어주세요.</li>
											<li>부재시 핸드폰으로 연락바랍니다.</li>
										</ul>
									</div>
									<small class="ml5">사전에 협의되지 않은 지정일 배송은 불가능합니다.</small>
								</td>
							</tr>
						</tbody>
					</table>

					<script type="text/javascript">
					jQuery(document).ready(function($){
						//배송시 요청사항
						$("#du-msg").on("click focusin", function(){
							$(".deliv-msg-ex").height("auto");
						}).keyup(function(){
							if ($(this).val()=="") $(".deliv-msg-ex").height("auto");
						}).on("focusout", function(){
							setTimeout(function(){$(".deliv-msg-ex").height(0);},200);
						});

						$(".deliv-msg-ex li").on("click", function(e){
							$("#du-msg").val($(this).text()).focus();
							$(".deliv-msg-ex").height(0);
							return false;
						});
					});
					</script>

					<!-- END 배송지 정보 -->


					<!-- 할인/결제 -->
					<div class="order-price-wrap">
						<!-- 좌 -->
						<div class="order-price-left">
							<!-- 할인/결제금액 정보 -->
							<h3 class="order-tit">할인 정보</h3>
							<table class="order-field discount-tbl mb15"><!-- 할인/결제 유의사항이 없을 경우 mb15 삭제 -->
								<caption>할인 정보</caption>
								<tbody>
									<tr>
										<th>쿠폰 종류 선택</th>
										<td><input type="radio" name="coupon-type" id="coupon-no" checked>
											<label for="coupon-no">사용 안함</label>
											<input type="radio" name="coupon-type" id="coupon-type1">
											<label for="coupon-type1">보너스 쿠폰</label>
											<input type="radio" name="coupon-type" id="coupon-type2">
											<label for="coupon-type2">상품 쿠폰</label>
										</td>
									</tr>
									<tr>
										<th>쿠폰 선택</th>
										<td>
											<select disabled>
												<option value="">쿠폰을 선택하세요.</option>
												<option value="">신규회원 할인(-1,000원) [~ 2016-08-18]</option>
												<option value="">봄맞이 할인 쿠폰(3% 할인) [~ 2016-05-18]</option>
												<option value="">리뉴얼 기념 쿠폰(-1,000원) [~ 2016-08-18]</option>
											</select>

											<small class="ml15 bl-noti">사용 가능 쿠폰 : <strong class="em">3장</strong></small>
										</td>
									</tr>
									<tr>
										<th>추가 할인 쿠폰</th>
										<td>
											<select>
												<option value="">쿠폰을 선택하세요.</option>
												<option value="">리뉴얼 기념 무료배송</option>
											</select>
											<small class="ml15 bl-noti">사용 가능 쿠폰 : <strong class="em">1장</strong></small>
										</td>
									</tr>
									<tr>
										<th><label for="use-point">포인트 사용</label></th>
										<td><input type="text" value="0" id="use-point" class="field-s"> P
											<small class="ml15 bl-noti">보유포인트 : <strong class="em">1,000 P</strong></small>
										</td>
									</tr>
								</tbody>
							</table>

							<ul class="order-noti mb50">
								<li>적립금은 상품금액 30,000원 이상 결제시 사용 가능합니다.</li>
								<li>포인트/ 쿠폰 할인에 대한 유의사항이 들어갑니다.</li>
								<li>포인트/ 쿠폰 할인에 대한 유의사항이 들어갑니다.</li>
								<li>포인트/ 쿠폰 할인에 대한 유의사항이 들어갑니다.</li>
								<li>포인트/ 쿠폰 할인에 대한 유의사항이 들어갑니다.</li>
							</ul>
							<!-- END 할인/결제금액 정보 -->
						</div><!-- END 좌 -->

						<!-- 우 -->
						<div class="order-price-right">
							<!-- 결제금액 -->
							<h3 class="order-tit em">결제 금액</h3>
							<div class="pay-total-box">
								<ul class="each-price">
									<li><span>상품 총 금액</span>
										<em>30,000원</em>
									</li>
									<li><span>배송비</span>
										<em>2,500원</em>
									</li>
									<li><span>쿠폰할인</span>
										<em class="em">-1,000원</em>
									</li>
									<li><span>적립금 사용</span>
										<em class="em">-1,000P</em>
									</li>
								</ul>
								<div class="total-price">
									총 결제 금액 <span class="tt-price"><em>35,000</em> 원</span>
								</div>
							</div>
							<!-- END 결제금액 -->

						</div><!-- END 우 -->
					</div><!-- END 할인/결제 -->


					<h3 class="order-tit">결제 수단</h3>
					<table class="order-field mb0">
						<caption>결제 수단 선택</caption>
						<tr>
							<th>결제 수단 선택</th>
							<td>
								<input type="radio" name="pay-way" id="pay-way-card" checked>
								<label for="pay-way-card">신용카드</label>

								<input type="radio" name="pay-way" id="pay-way-transf">
								<label for="pay-way-transf">실시간 계좌이체</label>

								<input type="radio" name="pay-way" id="pay-way-deposit">
								<label for="pay-way-deposit">무통장 입금</label>

								<input type="radio" name="pay-way" id="pay-way-phone">
								<label for="pay-way-phone">휴대폰 결제</label>
							</td>
						</tr>
					</table>

					<!-- 카드결제 안내사항 -->
					<table class="order-field pay-info" id="pay-noti-card">
						<caption>카드결제 안내사항</caption>
						<tr>
							<td>
								<p class="mt5">신용카드 결제 시 화면 아래 [결제하기] 버튼을 클릭하시면 신용카드 결제 창이 나타납니다.</p>
								<p class="mt10">신용카드 결제 창을 통해 입력되는 고객님의 카드 정보는 안전하게 암호화되어 전송되며, 승인 처리 후 카드 정보는 승인 성공·실패 여부에 상관없이 자동으로 폐기되므로, 안전합니다.</p>
								<p class="mt10">신용카드 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</p>

								<p class="pay-info-tit mt15">유의사항</p>
								<ul class="order-noti">
									<li>신용카드/실시간 이체는 결제 후, 무통장입금은 입금확인 후 배송이 이루어집니다.</li>
									<li>국내 모든 카드 사용이 가능하며 해외에서 발행된 카드는 해외카드 3D 인증을 통해 사용 가능합니다.</li>
								</ul>
							</td>
							<td class="col-pay-noti"></td>
						</tr>
					</table>
					<!-- END 카드결제 안내사항 -->


					<!-- 실시간 계좌이체 안내사항 -->
					<table class="order-field pay-info" id="pay-noti-transf">
						<caption>실시간 계좌이체 안내사항</caption>
						<tr>
							<td colspan="2">
								<p class="mt5">실시간 이체 결제 시 화면 아래 '결제하기'버튼을 클릭하시면 실시간 이체 결제 창이 나타납니다.</p>
								<p class="mt10">실시간 이체 결제 창을 통해 입력되는 고객님의 정보는 안전하게 암호화되어 전송되며 승인 처리 후 정보는 승인 성공/실패 여부에 상관없이 자동으로 폐기됩니다.</p>
								<p class="mt10">실시간 이체 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</p>
							</td>
							<td class="col-pay-noti" rowspan="3">
								<p class="pay-info-tit">실시간 계좌이체 안내</p>
								<ul class="order-noti">
									<li>실시간 계좌 이체 서비스는 은행계좌만 있으면 누구나 이용하실 수 있는 서비스로, 별도의 신청 없이 그 대금을 자신의 거래은행의 계좌로부터 바로 지불하는 서비스입니다.</li>
									<li>결제 시 공인인증서가 반드시 필요합니다.</li>
									<li>결제 후 1시간 이내에 확인되며, 입금 확인 후 배송이 이루어 집니다.</li>
									<li>은행 이용가능 서비스 시간은 은행사정에 따라 다소 변동될 수 있습니다.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th rowspan="2">현금영수증</th>
							<td>
								<input type="radio" name="cash-receipt1" id="transf-receipt-no" checked>
								<label for="transf-receipt-no">발급안함</label>
								<input type="radio" name="cash-receipt1" id="transf-receipt-p">
								<label for="transf-receipt-p">소득 공제용</label>
								<input type="radio" name="cash-receipt1" id="transf-receipt-c">
								<label for="transf-receipt-c">지출 증빙용</label>
							</td>
						</tr>
						<tr>
							<td>
								<p class="pay-info-tit">휴대폰번호 / 현금영수증카드 / 사업자번호</p>
								<p><input type="text" class="field-m"> <span class="ml10">'-' 를 빼고 입력하세요.</span></p>
								<ul class="order-noti mt10">
									<li>사업자, 현금영수증카드, 휴대폰번호가 유효하지 않으면 발급되지 않습니다.</li>
									<li>2016년 7월부터 10만원 이상 무통장 거래건에 대해, 출고후 2일내에 발급하지 않으시면 출고 3일후 자진 발급 합니다. 국세청 홈텍스 사이트에서 현금영수증 자진발급분 소비자 등록 메뉴로 수정 가능합니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 실시간 계좌이체 안내사항 -->


					<!-- 무통장입금 안내사항 -->
					<table class="order-field pay-info" id="pay-noti-deposit">
						<caption>무통장입금 안내사항</caption>
						<tr>
							<th>입금하실 은행</th>
							<td>
								<p>
									<select>
										<option value="">입금하실 은행을 선택하세요</option>
									</select>
									<span class="ml10">예금주 : 관리자설정 예금주명</span>
								</p>
								<p class="mt5">계좌번호는 다음단계인 [주문완료] 페이지에서 확인하실 수 있으며 SMS 문자로도 안내해 드립니다. 타은행에서 입금하실 때 송금수수료가 부과될 수 있습니다.</p>
							</td>
							<td class="col-pay-noti" rowspan="4">
								<p class="pay-info-tit">무통장입금 안내</p>
								<ul class="order-noti">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
									<li>계좌번호는 주문완료 페이지에서 확인 가능하며, SMS로도 안내 드립니다.</li>
								</ul>
							</td>
						</tr>
						<tr>
							<th><label for="deposit-name">입금자명</label></th>
							<td><input type="text" id="deposit-name" class="field-m"></td>
						</tr>
						<tr>
							<th rowspan="2">현금영수증</th>
							<td>
								<input type="radio" name="cash-receipt2" id="deposit-receipt-no" checked>
								<label for="deposit-receipt-no">발급안함</label>
								<input type="radio" name="cash-receipt2" id="deposit-receipt-p">
								<label for="deposit-receipt-p">소득 공제용</label>
								<input type="radio" name="cash-receipt2" id="deposit-receipt-c">
								<label for="deposit-receipt-c">지출 증빙용</label>
							</td>
						</tr>
						<tr>
							<td>
								<p class="pay-info-tit">휴대폰번호 / 현금영수증카드 / 사업자번호</p>
								<p><input type="text" class="field-m"> <span class="ml10">'-' 를 빼고 입력하세요.</span></p>
								<ul class="order-noti mt10">
									<li>사업자, 현금영수증카드, 휴대폰번호가 유효하지 않으면 발급되지 않습니다.</li>
									<li>2016년 7월부터 10만원 이상 무통장 거래건에 대해, 출고후 2일내에 발급하지 않으시면 출고 3일후 자진 발급 합니다. 국세청 홈텍스 사이트에서 현금영수증 자진발급분 소비자 등록 메뉴로 수정 가능합니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 무통장입금 안내사항 -->

					<!-- 휴대폰 결제 안내사항 -->
					<table class="order-field pay-info" id="pay-noti-tel">
						<caption>휴대폰결제 안내사항</caption>
						<tr>
							<td>
								<ul class="order-noti">
									<li class="mb10">휴대폰으로 결제하신 금액은 익월 휴대폰 요금에 함께 청구되며 별도의 수수료는 부과되지 않습니다.</li>
									<li class="mb10">휴대폰 소액결제로 구매하실 경우 현금영수증이 발급되지 않습니다.</li>
									<li class="mb10">다음의 경우에는 휴대폰 결제를 이용하실 수 없습니다.
										<ul class="order-noti-dash mt5">
											<li>- 미납/체납중인 휴대폰 요금이 있을 경우</li>
											<li>- 이동통신사 가입기간(번호이동포함) 6개월 이하인 경우</li>
											<li>- 외국인, 미성년자 요금제, 법인휴대폰, 선불요금제인 경우</li>
											<li>- LGT 이용자 중 통신사로 [자동결제] 차단 신청하신 경우</li>
										</ul>
									</li>
									<li class="mb10">휴대폰 소액결제로 결제하신 상품을 취소할 경우 결제하신 당월 말까지 가능합니다.</li>
									<li class="mb10">휴대폰 결제로 구매하신 상품의 취소/반품은 처리완료 시점에 따라 다음과 같이 이루어집니다.
										<ul class="order-noti-dash mt5">
											<li>- 결제하신 당월에 취소/반품 처리가 완료되는 경우 휴대폰 이용요금에 부과예정이던 금액이 취소됩니다.</li>
											<li>- 결제하신 당월이 지난 후 취소/반품처리가 완료되는 경우, 환불액이 고객님의 계좌로 현금 입금해 드립니다.</li>
										</ul>
									</li>
								</ul>
							</td>
							<td class="col-pay-noti">
								<p class="pay-info-tit">이통사별 휴대폰 결제 정책</p>
								<ul class="order-noti">
									<li class="mb10"><strong>KT</strong> : 한달 결제액 기준 최고 30만원까지 가능<br>
										이용내역 조회 : <a href="http://cs.show.co.kr" target="_blank">http://cs.show.co.kr</a>
									</li>
									<li class="mb10"><strong>SKT</strong> : 다음 요금제에 해당되는 고객은 사용불가<br>
										(아이니/아이니플러스/TTL ting 요금제, 선불이동 전화고객)<br>
										이용내역 조회 : <a href="http://www.tworld.co.kr" target="_blank">http://www.tworld.co.kr</a>
									</li>
									<li class="mb10"><strong>LGT</strong> : 한달 결제액 기준 최고 30만원까지 가능<br>
										이용내역 조회 <a href="http://www.uplus.co.kr" target="_blank">http://www.uplus.co.kr</a>
									</li>
								</ul>
							</td>
						</tr>
					</table>
					<!-- END 휴대폰 결제 안내사항 -->

				</div><!-- END 주문 Wrap -->


				<!-- 하단 버튼 -->
				<div class="align-c">
					<button type="button" class="btn-normal">이전 페이지로</button>
					<button type="button" class="btn-emp" onclick="location.href='shop_order_ok.php';">결제하기</button>
				</div><!-- END 하단 버튼 -->

			</div><!-- END Shop Wrap -->
			*/
			?>
		</div><!-- END Inner -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
