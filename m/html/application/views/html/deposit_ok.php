<?
	$PageName = "SHOP_ORDER_OK";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
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
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			무통장입금
		</h1>

<?
	if($trade_stat->userid){
		if($trade_stat->userid != $this->session->userdata('USERID')){
			alert('/','잘못된 접근입니다.');
			exit;
		}
	}
?>
		<!-- Shop Wrap -->
		<div class="shop-wrap">


			<!-- 완료 메시지 -->
			<div class="order-finish-msg" style="display: none;">
				<p><img src="/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다." width="42" height="45"></p>
				<p class="mt10">주문내역은 <span class="em">[주문 배송 조회]</span>에서<br>다시 확인하실 수 있습니다.</p>
			</div>
			<!-- END 완료 메시지 -->


			<!-- 완료 메시지 *2022 06 24 수정 -->
			<div class="order-finish-msg deposit">
				<p><img src="/image/shop/success_txt.png" alt="주문이 성공적으로 완료되었습니다." width="42" height="45"></p>
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


			<!-- Shop Order Wrap -->
			<div class="shop-order-wrap">
				<!-- 주문정보 -->
				<h4 class="order-field-tit"><img src="/m/image/shop/icon_receipt.png" alt="">주문 정보</h4>
				<ul class="order-field no-form">
					<li>
						<div class="of-label">주문코드</div>
						<div class="of-field"><?=$trade_code?></div>
					</li>
					<li>
						<div class="of-label">주문일자</div>
						<div class="of-field"><?=substr($trade_stat->trade_day,0,10)?></div>
					</li>
				</ul>
				<!-- END 주문정보 -->


				<!-- 주문 상품 확인 -->
				<h4 class="order-field-tit"><img src="/m/image/shop/icon_box.png" alt="">주문 상품 확인</h4>
				<div class="tblTy02 tblTy02_1" style="margin-top:0px;">
					<table>
						<colgroup>
						<col>
						<col>
						</colgroup>
						<tr>
							<th>상품명</th>
							<th>총수량</th>
						</tr>
						<tbody style="background:#fff;">
							<?php
							foreach($goods_list as $lt){
							?>
							<tr class="al">
								<td class="al">
									<?=$lt->goods_name?>
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
									}
									else{
										?>
										<br>
										소계: <?=number_format($lt->goods_price)?>원
										<?php
									}
									?>
								</td>

								<td style="position: relative;">
									<div class="cart-prod-quick">
										<div class="cart-vol">
										<?php
										if($lt->recom_is == "Y"){
										?>
										<?=$lt->recom_pack_ea?>팩<br>
										<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
										<?php
										}
										else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
											echo $cnt."개";
										}
										else{
											echo $lt->goods_cnt>0 ? $lt->goods_cnt : "";
										}
										?>
										</div>
									</div>
								</td>

							</tr>
							<?php
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- END 주문 상품 확인 -->

				<!-- 주문 고객 정보 -->
				<h4 class="order-field-tit"><img src="/m/image/shop/icon_user.png" alt="">주문 고객 정보</h4>
				<ul class="order-field no-form">
					<li>
						<div class="of-label">주문고객명</div>
						<div class="of-field"><?=$trade_stat->name?></div>
					</li>
					<li>
						<div class="of-label">이메일</div>
						<div class="of-field"><?=$trade_stat->email?></div>
					</li>
					<li>
						<div class="of-label">휴대폰</div>
						<div class="of-field"><?=$trade_stat->phone?></div>
					</li>
				</ul>
				<!-- END 주문 고객 정보 -->

				<!-- 결제정보 -->
				<h4 class="order-field-tit"><img src="/m/image/shop/icon_card.png" alt="">결제 정보</h4>

				<ul class="order-field no-form">
					<li>
						<div class="of-label">결제수단</div>
						<div class="of-field"><?=$shop_info['trade_method'.$trade_stat->trade_method]?></div>
					</li>
					<li>
						<div class="of-label">결제상태</div>
						<div class="of-field"><em class="em"><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></em></div>
					</li>
					<li>
						<div class="of-label">총 구매 금액</div>
						<div class="of-field"><?=number_format($trade_stat->price)?>원</div>
					</li>
					<!-- <li>
						<div class="of-label">배송비</div>
						<div class="of-field"><?=($trade_stat->delivery_price)?number_format($trade_stat->delivery_price)."원":"무료";?></div>
					</li>
					<? if($trade_stat->userid){?>
					<li style="display:<?=($trade_stat->use_point)?"":"none";?>;">
						<div class="of-label" >포인트할인</div>
						<div class="of-field"><?if($trade_stat->use_point){?>-<?=number_format($trade_stat->use_point)?>P<?}?></div>
					</li>
					<li style="display:<?=($trade_stat->use_coupon)?"":"none";?>;">
						<div class="of-label">쿠폰할인</div>
						<div class="of-field">
							<?php
							if($trade_stat->coupon_idx){
								?>
								-<?=number_format($trade_stat->use_coupon)?>원 <em class="ml10">[<?=$coupon_stat->name?>]</em>
								<?php
							}
							else{
								if($trade_stat->memo){
									?>
									-<?=number_format($trade_stat->use_coupon)?>원 (<?=$trade_stat->memo?>)
									<?php
								}
							}
							?>
						</div>
					</li>
					<?}?> -->
					<li>
						<div class="of-label">총 결제금액</div>
						<div class="of-field"><em class="em"><?=number_format($trade_stat->total_price)?>원</em></div>
					</li>
					<li>
						<div class="of-label">결제일시</div>
						<div class="of-field"><?=$trade_stat->trade_day?></div>
					</li>
				</ul><!-- END 결제정보 -->

				<?php
				if($trade_stat->trade_method==2 || $trade_stat->trade_method==4){
				?>
				<!-- 무통장 입금 안내-->
				<h4 class="order-field-tit"><img src="/m/image/shop/icon_money.png" alt="">무통장입금 안내</h4>
				<ul class="order-field no-form mb0">
					<li>
						<div class="of-label">입금자명</div>
						<div class="of-field"><?=$trade_stat->enter_name?></div>
					</li>
					<li>
						<div class="of-label">입금은행</div>
						<div class="of-field"><?=$trade_stat->enter_bank?></div>
					</li>
					<li>
						<div class="of-label">계좌번호</div>
						<div class="of-field"><?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</div>
					</li>
				</ul>
				<div class="order-dark shop-inner">
					<ul class="order-noti">
						<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
						<li>무통장 주문 후 7일 이내에 입금이 되지 않으면 주문은 자동으로 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다</li>
					</ul>
				</div>
				<!-- END 무통장 입금 안내 -->
				<?php
				}
				?>

			</div><!-- END Shop Order Wrap -->


			<!-- 주문버튼 -->
			<div class="shop-inner mt15">
				<button type="button" class="btn-emp-border field-full" onclick="location.href='<?=cdir()?>/dh_order/orderList';">주문내역조회</button>
			</div>
			<!-- END 주문버튼 -->

		</div><!-- END Shop Wrap -->

	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
