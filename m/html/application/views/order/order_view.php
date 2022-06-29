<?
	if($trade_stat->userid){
		if($trade_stat->userid != $this->session->userdata('USERID')){
			alert('/','잘못된 접근입니다.');
			exit;
		}
	}
?>

<script type="text/javascript">
<!--
		function search_deliv(ivno){
			window.open("https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?displayHeader=N&sid1="+ivno,"search_deliv","");
		}
//-->
</script>

	<div class="inner mypage">
		<h1>주문배송조회</h1>
		<h2>주문 정보</h2>
		<div class="tblTy02">
			<table>
				<tr>
					<th>주문상품</th>
					<th>주문일자</th>
				</tr>
				<tr>
					<td>
						<?php
						if($trade_stat->recom_is == "Y"){
							echo "정기배송";
						}
						else if($trade_stat->sample_is == "Y"){
							echo "샘플신청";
						}
						else{
							echo "일반주문";
						}
						?>

						<?php
						if(strpos($goods_list[0]->goods_name,":")!==false){
							$goods_name_arr = explode(":",$goods_list[0]->goods_name);
							echo "[".trim($goods_name_arr[1])."]";
						}
						else{
							echo $goods_list[0]->goods_name;
						}
						?>

						<?php
						if(count($goods_list) > 1){
						?>
						외 <?=count($goods_list)-1?>건
						<?php
						}
						?>
					</td>
					<td><?=date("Y. m. d",strtotime($trade_stat->trade_day))?> (<?=$week_name_arr[date("w",strtotime($trade_stat->trade_day))]?>)</td>
				</tr>
				<tr>
					<th>주문코드</th>
					<th>결제방법</th>
				</tr>
				<tr>
					<td><?=$trade_stat->trade_code?></td>
					<td><?=$shop_info['trade_method'.$trade_stat->trade_method]?>
						<?php
						if($trade_stat->trade_method == '4'){
							echo "<BR>(".$trade_stat->enter_bank." : ".$trade_stat->enter_account.")";
						}
						?>
					</td>
				</tr>
			</table>
		</div>

		<?php
		if($trade_stat->trade_stat <= 4){
			if($trade_stat->recom_is == "Y"){
				?>
				<h2 class="mt30">배송일정/식단</h2>
				<div class="tblTy01 mt10">
					<table>
						<tr>
							<th>※일자를 선택하시면 배송 식단을 확인하실 수 있습니다.<br>※주문하신 메뉴, 배송일, 배송장소를 변경하시려면 하단의 변경 버튼을 클릭하세요.
							<p class="mt10 ac"><a class="btn_green" href="<?=$ORDER_EDIT->url?>">메뉴/배송지/배송일 변경</a></p></th>
						</tr>
					</table>
				</div>
				<p class="ar mt20">
					<a href="javascript:;" class="btn_b" onclick="deliv_daylist('<?=$trade_stat->trade_code?>');">배송 일정표 보기</a>
				</p>

				<?php
				$show_holiinfo = false;

				foreach($deliv_info as $dis){
					if($dis->deliv_stat == 6){
						$show_holiinfo = true;
					}
				}

				if($show_holiinfo){
				?>
				<div class="y_bg">
					<p class="tit"><img src="/m/image/sub/ng.png" alt="" class="img-mid mr5" style="height:16px;">[배송휴무일]은 배송되지 않으니 변경하세요</p>
					<div class="wit_bg">
						<p class="sub">
							배송휴무일은 정기주문건으로, 주문내역에서 [확인]은 되나
							실제 배송이 가지 않습니다.
						</p>
						<p class="sub mb15"><strong>배송휴무일을 [마이페이지]에서<br>고객님이 원하는 배송날짜로 변경하세요.<br>
						고객님이 변경을 하지 않으실 경우,<br>
						맨 마지막 <span>배송일 뒤로 자동배정되며 메뉴도 자동변경</span>됩니다.
						</strong></p>
						<p class="sub_small">
							<span>- <strong><u>[마이페이지 > 메뉴/배송지/배송일변경]</u></strong></span>을 이용하세요.<br>
							- 배송일기준 <span><strong><u>D-2일전 PM 24:00</u></strong></span>까지만 변경가능합니다.
						</p>
					</div>
				</div>
				<?php
				}
				?>


				<!-- //공지 레이어 -->

				<div class="s-list">
					<?php
					foreach($deliv_info as $key=>$di){
						?>
						<h6 class="faq-q float-wrap">
							<p class='float-l' style="line-height: 40px;">
								<span><?=date("m월 d일",strtotime($di->deliv_date))?> <?=numberToWeekname($di->deliv_date)?>요일</span>
								<span class="<?=$di->deliv_stat == 2 ? "blue" : ($di->deliv_stat == 6 ? "red" : "g8") ;?>">&nbsp;<?=$deliv_stat_arr[$di->deliv_stat]?></span> <!-- 배송휴무일시 class명 "red" 입니다. -->

							</p>
							<p class="float-r">
								<!-- <?if($di->invoice_no){?><button type="button" class="btn_b" onclick="search_deliv('<?=$di->invoice_no?>')">배송조희</button><?}?> -->
								<?php
								if($di->invoice_no){
									if(strtoupper($di->invoice_company) == "CJ"){
										?>
										<button type="button" class="btn_b" onclick="window.open('https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=<?=$di->invoice_no?>')">배송조희</button>
										<?php
									}
									else{
										?>
										<button type="button" class="btn_b" onclick="window.open('https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?displayHeader=N&sid1=<?=$di->invoice_no?>')">배송조희</button>
										<?php
									}
								}
								?>

							</p>
							<!-- <br>
							<span><?=$di->prod_name?></span> -->
						</h6>
						<div class="faq-a">
							<ul class="bu_list01">
								<?php
								foreach($deliv_list as $dl){
									if($di->deliv_code == $dl->deliv_code){
										if($dl->prod_cnt > 0){
											?>
											<li><?=$dl->goods_name?> x <?=$dl->prod_cnt?></li>
											<?php
										}
										else{
											if($dl->option_cnt > 0){
												$oprow = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '".$dl->trade_code."' and level = '2' and goods_idx = '".$dl->goods_idx."'","row");
												?>
												<li><?=$dl->goods_name?><?=$oprow->name?> x <?=$oprow->cnt?></li>
												<?php
											}
										}
									}
								}
								?>


								<!-- 주소 -->
								<li class="order__address" style="border-top: 1px solid #aaa;">
									<p class="address__head">주소</p>
									<p class="address__data">
										<?=$di->addr1?> <?=$di->addr2?>
									</p>
								</li>



							</ul>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			else{
				if(count($deliv_info) > 0){
					?>
					<h2 class="mt30">상품 확인 / 배송 목록</h2>
					<div class="tblTy02 deliv_list">

						<?php
						foreach($deliv_info as $tk=>$di){
							?>
							<h2 class="mt30 align-l" style="font-weight:600;"><?=$di->ct_subgroup?></h2>
							<table class="mb30">
								<colgroup>
									<col width="25%">
									<col width="">
									<col width="10%">
									<col width="20%">
									<!-- <col width="25%"> -->
								</colgroup>
								<thead>
									<tr>
										<th>배송일정</th>
										<th>주문 상품 정보</th>
										<th>수량</th>
										<th>상품금액</th>
										<!-- <th>배송비</th> -->
									</tr>
								</thead>

								<tbody>
									<?php
									foreach($deliv_list as $key=>$dl){
										if($di->deliv_code == $dl->deliv_code){
											?>
											<tr>
												<td data-value="<?=strtotime($di->deliv_date)?>">
													<p><?=$di->deliv_date?> (<?=$week_name_arr[date('w',strtotime($di->deliv_date))]?>)</p>
													<?php
													if($log_cnt > 0){
													?>
													<a href="" class="alarm"></a>
													<?php
													}
													?>
												</td>
												<td class='align-l'>
													<?=$goods_info[$dl->goods_idx]->name?>
													<?php
													if($dl->option_cnt > 0){	//옵션이 있을경우
														foreach($option_list as $op){
															if($op->goods_idx == $dl->goods_idx and $op->trade_goods_idx == $dl->tg_idx){
																$plus = "+";
																if($op->price < 0) $plus = "-";

																echo "<br> - ".$op->title.":".$op->name."(".$plus.$op->price.") x ".$op->cnt;
															}
														}
													}
													?>
												</td>
												<td>
													<?php
													//수량
													if($dl->option_cnt > 0){
														foreach($option_list as $op){
															if($op->goods_idx == $dl->goods_idx and $op->trade_goods_idx == $dl->tg_idx){
																$plus = "+";
																if($op->price < 0) $plus = "-";

																echo "<br>".$op->cnt;
															}
														}
													}
													else{
														echo $dl->prod_cnt;
													}
													?>
												</td>
												<td>
													<?php
													//상품금액
													echo number_format($dl->total_price);
													?>
													원
												</td>
												<!-- <td data-value="<?=strtotime($di->deliv_date)?>-<?=$di->deliv_price?>">
													<?
													if($di->deliv_price > 0){
														echo number_format($di->deliv_price)."원";
													}
													else if($di->order_type == "9011" or $di->order_type == "9012" or $di->order_type == "9013" or $di->order_type == "9014"){
														echo number_format("3000")."원";
													}
													else{
														echo "무료";
													}
													?>
												</td> -->
											</tr>
											<?php
										}
									}
									?>
									<tr>
										<td data-value="<?=strtotime($di->deliv_date)?>"></td>
										<td colspan="4"><?=$deliv_stat_arr[$di->deliv_stat]?>
											<?php
											if($di->invoice_no){
											?>
											<span class="blue mb10"><?=$di->invoice_company?> : <?=$di->invoice_no?></span>
											<?php
											}
											?>

											<?php
											if( $di->deliv_stat > 0 ){
												if( $di->deliv_stat == 2 ){
													if(strtoupper($di->invoice_company) == "CJ"){
														?>
														<a href="https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=<?=$di->invoice_no?>" target="_blank" class="btn_y ml10">배송조회</a>
														<?php
													}
													else{
														?>
														<a href="https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?displayHeader=N&sid1=<?=$di->invoice_no?>" target="_blank" class="btn_y ml10">배송조회</a>
														<?php
													}
												}
												else if( $di->deliv_stat == 3 ){
												?>
												<a href="javascript:;" class="btn_gg">배송완료</a>
												<!-- <a href="#" class="btn_rr">교환/반품요청</a> -->
												<?php
												}
											}
											?>

											<!-- <a href="" class="btn_y ml10">배송조회</a> -->
											<!--버튼들
											<a href="" class="btn_g">배송완료</a>
											<a href="" class="btn_g">교환완료</a>
											<a href="" class="btn_g">반품완료</a>
											<a href="" class="btn_r">교환/반품요청</a>
											-->
										</td>
									</tr>
								</tbody>
							</table>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
		}
		?>


	<section id="sod_fin_orderer" class="mt30">
            <h2>주문하신 분</h2>

            <div class="tblTy02">
                <table>
                <colgroup>
                    <col width="80px">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row">이 름</th>
                    <td><?=$trade_stat->name?></td>
                </tr>
                <!-- <tr>
                    <th scope="row">전화번호</th>
                    <td><?=$trade_stat->phone?></td>
                </tr> -->
                <tr>
                    <th scope="row">핸드폰</th>
                    <td><?=$trade_stat->phone?></td>
                </tr>
                <!-- <tr>
                    <th scope="row">주 소</th>
                    <td>(<?=$trade_stat->zip1?>) <?=$trade_stat->addr1?> <?=$trade_stat->addr2?></td>
                </tr> -->
                <tr>
                    <th scope="row">E-mail</th>
                    <td><?=$trade_stat->email?></td>
                </tr>
                </tbody>
                </table>
            </div>
        </section>

				<?php
				if(count($deliv_info) > 0){
					?>
					<section id="sod_fin_receiver" class="mt30">
							<h2>받으시는 분</h2>

							<div class="tblTy02">
									<table>
									<colgroup>
											<col width="80px">
											<col>
									</colgroup>
									<tbody>
									<tr>
											<th scope="row">이 름</th>
											<td><?=$trade_stat->send_name?></td>
									</tr>
									<!-- <tr>
											<th scope="row">전화번호</th>
											<td><?=$trade_stat->send_tel?></td>
									</tr> -->
									<tr>
											<th scope="row">핸드폰</th>
											<td><?=$trade_stat->send_phone?></td>
									</tr>
									<tr>
											<th scope="row">주 소</th>
											<td>(<?=$trade_stat->zip1?>) <?=$trade_stat->addr1?> <?=$trade_stat->addr2?></td>
									</tr>
																	</tbody>
									</table>
							</div>
					</section>
					<?php
				}
				?>

				<?php
				if($trade_stat->send_text){
				?>
				<section id="sod_fin_dvr" class="mt30">
					<h2>배송시 요청사항</h2>

						<div class="tblTy02">
								<table>
								<colgroup>
										<col width="80px">
										<col>
								</colgroup>
								<tbody>
																<tr>
										<td class="empty_table" colspan="2"><?=nl2br($trade_stat->send_text)?></td>
								</tr>
																</tbody>
								</table>
						</div>
				</section>
				<?php
				}
				?>



	</div>










			<script>
			$(function(){
				$('.deliv_list table tbody').rowspan(0);
				$('.deliv_list table tbody').rowspan(4);
			});

			function cancel(trade_code,trade_method,tno)
			{
				if(confirm("주문을 취소하시겠습니까?")){

					if(trade_method==1){
						card_cancel(trade_code,tno);
					}else{
						location.href="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/list/<?=$query_string.$param?>";
					}
				}
			}
			</script>

<? include $shop_info['pg_company']."_cancel.php"; ?>