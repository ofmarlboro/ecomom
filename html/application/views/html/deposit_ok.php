<?
	$PageName = "SHOP";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

<script type="text/javascript">
	function copy_bank_account(){
		const t = document.createElement("textarea");
		document.body.appendChild(t);
		t.value = '<?=$trade_stat->enter_account?>';
		t.select();
		document.execCommand('copy');
		document.body.removeChild(t);

		alert("복사 되었습니다.");
	}
</script>

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
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<div class="order-finish-msg" style="display: none;">
						<p><img src="/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다."></p>
						<p class="mt15">주문내역은 [주문 배송 조회]에서 다시 확인하실 수 있습니다.</p>
					</div>


					<!-- 완료 메시지 *2022 06 24 수정 -->
					<div class="order-finish-msg deposit">
						<p><img src="/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다." width="70" height="78"></p>
						<h1><?=$trade_stat->name?>님의 무통장 입금 계좌입니다. <br> 충전금액을 이체해주세요.</h1>
						<div class="order-acount">
							<p>
								<?=$trade_stat->enter_bank?> <br>
								<?=$trade_stat->enter_account?>
							</p>

							<a href="javascript:void(0)" onclick="copy_bank_account()">계좌복사</a>
						</div>
					</div>
					<!-- END 완료 메시지 -->



					<!-- 주문 정보 -->
					<h3 class="order-tit">주문 정보</h3>
					<table class="order-field">
						<caption>주문 정보 확인</caption>
						<tr>
							<th>주문코드</th>
							<td><?=$trade_code?></td>
						</tr>
						<tr>
							<th>주문일자</th>
							<td><?=substr($trade_stat->trade_day,0,10)?></td>
						</tr>
					</table>
					<!-- END 주문 정보 -->

					<!-- 주문리스트 -->
					<h3 class="order-tit">주문 상품 리스트</h3>
					<table class="shop-cart mb50">
						<caption>주문 상품 리스트</caption>
						<thead>
							<tr>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-df">수량</th>
								<th class="col-df">소계금액</th>
								<th class="col-df">주문상태</th>
							</tr>
						</thead>
						<tbody>
							<? foreach($goods_list as $lt){?>
							<tr>
								<?php
								if($lt->goods_idx){
								?>
								<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$goods_info[$lt->goods_idx]->list_img?>" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
										<p class="prod-op">
										<? if($lt->option_cnt > 0){
											for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
												$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
												$plus="";
												if(count($price)<2){ $plus="+"; }
												$title = ${'option_arr'.$lt->idx}[$i]['title'];
												$name = ${'option_arr'.$lt->idx}[$i]['name'];
												$price = ${'option_arr'.$lt->idx}[$i]['price'];
												$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
												$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
												if($flag==1){ $ltFlag=$flag; }
										?>
											<p class="prod-op">
											<em><?=$title?></em> : <?=$name?>
											<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
											<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
											</p>
										<?
											}
										}?>
										</p>
									</div>
								</td>
								<?php
								}
								else{
								?>
								<td colspan='2'>
									<div class="cart-prod">
										<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
										<p class="prod-op">
										<? if($lt->option_cnt > 0){
											for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
												$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
												$plus="";
												if(count($price)<2){ $plus="+"; }
												$title = ${'option_arr'.$lt->idx}[$i]['title'];
												$name = ${'option_arr'.$lt->idx}[$i]['name'];
												$price = ${'option_arr'.$lt->idx}[$i]['price'];
												$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
												$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
												if($flag==1){ $ltFlag=$flag; }
										?>
											<p class="prod-op">
											<em><?=$title?></em> : <?=$name?>
											<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
											<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
											</p>
										<?
											}
										}?>
										</p>
									</div>
								</td>
								<?php
								}
								?>

								<td>
									<p class="cart-price">
										<? if($lt->old_price){?>
										<del><?=number_format($lt->old_price)?>원</del>
										<ins><?=number_format($lt->goods_price)?>원</ins>
										<?}else{?>
										<?=number_format($lt->goods_price)?>원
										<?}?>
									</p>
								</td>
								<td><? if($lt->goods_cnt>0){ echo $lt->goods_cnt; }?></td>
								<td><?=number_format($lt->total_price)?>원</td>
								<td><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></td>
							</tr>
							<?}?>
						</tbody>
					</table>
					<!-- END 주문리스트 -->


					<!-- 구매자 정보 -->
					<h3 class="order-tit">구매자 정보</h3>
					<table class="order-field">
						<caption>구매자 정보 확인</caption>
						<tr>
							<th>구매고객명</th>
							<td style="width:30%;"><?=$trade_stat->name?></td>
							<th>이메일</th>
							<td><?=$trade_stat->email?></td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td colspan="3"><?=$trade_stat->phone?></td>
						</tr>
					</table>
					<!-- END 구매자 정보 -->

					<!-- 결제정보 -->
					<h3 class="order-tit">결제 정보</h3>
					<table class="order-field">
						<caption>결제 정보 확인</caption>
						<tr>
							<th>결제 수단</th>
							<td style="width:30%;">
							<?=$shop_info['trade_method'.$trade_stat->trade_method]?>
							</td>
							<th>결제 상태</th>
							<td>
							<em class="em"><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></em>
							</td>
						</tr>
						<tr>
							<th>총 구매 금액</th>
							<td><?=number_format($trade_stat->price)?>원</td>
							<th>배송비</th>
							<td><?=($trade_stat->delivery_price)?number_format($trade_stat->delivery_price)."원":"무료";?></td>
						</tr>
						<tr>
							<th>결제금액</th>
							<td><?=number_format($trade_stat->total_price)?>원</td>
							<th>결제 일시</th>
							<td><?=$trade_stat->trade_day?></td>
						</tr>
					</table>
					<!-- END 결제정보 -->

					<? if($trade_stat->trade_method==2){ ?>

					<!-- 무통장 입금일 경우에만 노출 -->
					<h3 class="order-tit">무통장 입금 정보</h3>
					<table class="order-field">
						<caption>무통장 입금 정보</caption>
						<tr>
							<th>입금자명</th>
							<td><?=$trade_stat->enter_name?></td>
						</tr>
						<tr>
							<th>입금은행</th>
							<td><?=$trade_stat->enter_bank?></td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
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

					<? }else if($trade_stat->trade_method==4){ //가상계좌?>
					<h3 class="order-tit">가상계좌 정보</h3>
					<table class="order-field">
						<caption>가상계좌 입금 정보</caption>
						<tr>
							<th>입금은행</th>
							<td><?=$trade_stat->enter_bank?></td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
						</tr>
						<tr>
							<td colspan="2">
								<p class="pay-info-tit mt5">무통장입금 안내</p>
								<ul class="order-noti mb10">
									<li>가상계좌 결제는 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>가상계좌 결제는 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
								</ul>
							</td>
						</tr>
					</table>
					<?}?>


					<!-- 하단 버튼 -->
					<div class="align-c">
						<!-- !!! 비회원 조회시 shop_login.php 로 이동합니다. -->
						<? if($trade_stat->userid && $this->session->userdata('USERID')){ ?>
						<button type="button" class="btn-emp" onclick="location.href='<?=cdir()?>/dh_order/orderList';">주문 내역 보기</button>
						<?}else{?>
						<button type="button" class="btn-emp" onclick="location.href='<?=cdir()?>/dh_member/login';">주문 내역 보기</button>
						<?}?>
					</div><!-- END 하단 버튼 -->

				</div><!-- END 주문 Wrap -->

			</div><!-- END Shop Wrap -->
		</div><!-- END Inner -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
