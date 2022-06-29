<?
	$PageName = "ORDER_FREE";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<script type="text/javascript">
		function menuView(deliv_code){
			$.ajax({
				url:"<?=cdir()?>/dh_order/order_prod/?deliv_code="+encodeURIComponent(deliv_code),
				type:"GET",
				dataType:"json",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					$(".layer_pop").html(data.get_pop);
				},
				complete:function(){
					$(".layer_pop").fadeIn('fast');
				}
			});
		}

		function closeMenuView(){
			$(".layer_pop .scroll").scrollTop(0);
			$(".layer_pop").hide();
		}

		function search_deliv(ivno){
			window.open("https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?displayHeader=N&sid1="+ivno,"search_deliv","width=720, height=900, scrollbars=yes");
		}

		function log_view(deliv_code){

			$.ajax({
				url:"<?=cdir()?>/dh_order/deliv_log/?deliv_code="+encodeURIComponent(deliv_code),
				type:"GET",
				dataType:"json",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					$(".layer_pop").html(data.get_pop);
				},
				complete:function(){
					$(".layer_pop").fadeIn('fast');
				}
			});

		}
	</script>

	<!--Container-->
	<div id="container">
		<?include("../include/my_top.php");?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">
				<div>
					<div class="my_tit">주문 정보</div>
					<div class="tblTy02">
						<table>
							<tr>
								<th>주문상품</th>
								<td><?=$goods_list[0]->goods_name?> <?if(count($goods_list) > 1){?>외 <?=count($goods_list)-1?>건<?}?></td>

								<th>주문일자</th>
								<td><?=date("Y-m-d",strtotime($trade_stat->trade_day))?> (<?=$week_name_arr[date("w",strtotime($trade_stat->trade_day))]?>)</td>
							</tr>
							<tr>
								<th>주문코드</th>
								<td><?=$trade_stat->trade_code?></td>

								<th>결제방법</th>
								<td><?=$shop_info['trade_method'.$trade_stat->trade_method]?></td>
							</tr>
						</table>
					</div>
				</div>

				<?
				//정기배송일 경우
				if($trade_stat->trade_stat <= 4){
					if($trade_stat->recom_is == "Y"){
						$recom_days_arr = array();	//배송일만 갖는 배열
						$recom_days_n_stat_arr = array();	//배송일과 배송상태값을 갖는 배열
						//pr($deliv_info);

						$show_holiinfo = false;

						foreach($deliv_info as $keey=>$mk_arr){	//배열 작성
							$recom_days_arr[] = $mk_arr->deliv_date;

							$dcode_arr = explode("-",$mk_arr->deliv_code);

							if($mk_arr->deliv_stat == 6){
								$show_holiinfo = true;
							}

							if($mk_arr->recom_idx){
								$recom_days_n_stat_arr[$dcode_arr[0]]['prod_name'] = $mk_arr->prod_name;
								$recom_days_n_stat_arr[$dcode_arr[0]][$dcode_arr[1]]['date'] = $mk_arr->deliv_date;
								$recom_days_n_stat_arr[$dcode_arr[0]][$dcode_arr[1]]['deliv_stat'] = $mk_arr->deliv_stat;
								$recom_days_n_stat_arr[$dcode_arr[0]][$dcode_arr[1]]['deliv_code'] = $mk_arr->deliv_code;
							}
						}
						?>
						<div class="clearfix">
							<div class="my_tit">
								배송일정 / 식단
							</div>
							<div class="tblTy01">
								<table>
									<tr>
										<th class="al pl10">
											<p class="red mb5" style="font-size: 20px;">※ 일자를 선택하시면 배송 식단을 확인하실 수 있습니다.</p>
											<p>※ 주문하신 메뉴, 배송일, 배송장소를 변경하시려면 우측의 변경 버튼을 클릭하세요. </p>
										</th>
										<th><a href="<?=cdir()?>/dh_order/order_edit" class="btn_green">
											메뉴/배송지/배송일 변경
											</a>
										</th>
									</tr>
								</table>
							</div>

							<?php
							if($show_holiinfo){
							?>
							<div class="y_bg">
								<p class="tit"><img src="/m/image/sub/ng.png" alt="" class="img-mid mr10">[배송휴무일]은 배송되지 않으니 변경하세요</p>
								<div class="wit_bg">
									<p class="sub">
										배송휴무일은 정기주문건으로, 주문내역에서 [확인]은 되나
										실제 배송이 가지 않습니다.
									</p>
									<p class="sub mb15"><strong>배송휴무일을 [마이페이지]에서 고객님이 원하는 배송날짜로 변경하세요.<br>
									고객님이 변경을 하지 않으실 경우,<br>
									맨 마지막 <span>배송일 뒤로 자동배정되며 메뉴도 자동변경</span>됩니다.
									</strong></p>
									<p class="sub_small">
										<span><strong>[마이페이지 > 메뉴/배송지/배송일변경]</strong></span>을 이용하세요.<br>
										배송일기준 <span><strong>D-2일전 PM 24:00</strong></span>까지만 변경가능합니다.
									</p>
								</div>
							</div>
							<?php
							}
							?>

							<!-- //공지 레이어 -->

							<div class="cal_wrap mt15">
								<table class="cm_cal">
									<thead>
										<tr>
											<th>일</th>
											<th>월</th>
											<th>화</th>
											<th>수</th>
											<th>목</th>
											<th>금</th>
											<th>토</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$calendar_arr = array();	//달력 생성값 배열 선언
										foreach($recom_days_arr as $rda){	//상단에 선언한 정기배송 리스트를 기준으로 달력 배열 생성
											//일,월,화,수,목,금,토
											$calendar_arr[date("W",strtotime($rda))]['0'] = date("Y-m-d",strtotime('sunday last week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['1'] = date("Y-m-d",strtotime('monday this week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['2'] = date("Y-m-d",strtotime('tuesday this week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['3'] = date("Y-m-d",strtotime('wednesday this week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['4'] = date("Y-m-d",strtotime('thursday this week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['5'] = date("Y-m-d",strtotime('friday this week',strtotime($rda)));
											$calendar_arr[date("W",strtotime($rda))]['6'] = date("Y-m-d",strtotime('saturday this week',strtotime($rda)));
										}

										//$deliv_count = 0;	//배송 회차값
										foreach($calendar_arr as $ca){	//달력 주차로 먼저 반복돌림
										?>
										<tr>
											<?php
											foreach($ca as $day){	//배열안에 일자값으로 반복돌림
												$month = date("m",strtotime($day));	//당월 선언
												$cal_day = ($month != $old_month)?date("m/d",strtotime($day)):date("d",strtotime($day));	//달력 표기 날짜값 - 월이 바뀌면 값을 변형해준다.
											?>
											<td>
												<?//정기배송날짜 배열에서 당일 날짜 검색하여 스크립트 동작 시킴 (값 추가로 넘길시 주문번호-strtotime으로 전달하여 해당 배송코드에 담긴 상품 리스트 가져온다?>
												<!-- <a href="javascript:;" <?if(in_array($day,$recom_days_arr)){?>onclick="menuView('<?=$trade_stat->trade_code."-".strtotime($day)?>');"<?}?>><?=$cal_day?></a> -->
												<a href="javascript:;"><?=$cal_day?></a>

												<?php
												$rd_cnt = 0;
												foreach($recom_days_n_stat_arr as $key=>$rd_arr_value){	//날짜+배송상태 배열로 반복돌림
													$rd_cnt++;
													foreach($rd_arr_value as $keys=>$rd_arr){
														if($day == $rd_arr['date']){	//날짜가 달력상 날짜와 동일할 경우
															${'delivert_cnt'.$rd_cnt}++;	//회차 추가 해주고
														?>
														<span class="num <?=$rd_arr['deliv_stat'] == 1 ?"num_b" : ( $rd_arr['deliv_stat'] ? "bor_red" : "" ) ;?>" onclick="menuView('<?=$rd_arr['deliv_code']?>')" style="cursor:pointer;"><?=${'delivert_cnt'.$rd_cnt}?></span> <!-- 배송휴무일시 class명 "bor_red" 입니다. -->
														<span class="bb <?=$rd_arr['deliv_stat'] == 1 ?"bb_b" : ( $rd_arr['deliv_stat'] ? "red" : "" ) ;?>" onclick="menuView('<?=$rd_arr['deliv_code']?>')" style="cursor:pointer;"><?=$deliv_stat_arr[$rd_arr['deliv_stat']]?></span> <!-- 배송휴무일시 class명 "red" 입니다. -->
														<?php
														}
													}
												}
												?>
											</td>
											<?php
												$old_month = $month;	//과거 값 담아서 반복문 처음으로 돌려준다
											}
											?>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
							<div class="mt15 sch">
								<div class="my_tit02">
									배송 일정표
								</div>
								<div class="tblTy04">
									<?php
									$rdnsa_cnt = 0;
									foreach($recom_days_n_stat_arr as $rdnsa){
										$rdnsa_cnt++;
										?>
										<div class="my_tit02"><?=$rdnsa['prod_name']?></div>
										<table>
										<?php
										foreach($rdnsa as $key=>$rd){
											if($key != "prod_name"){
												${'dcnt'.$rdnsa_cnt}++;
												?>
												<tr>
													<td><?=${'dcnt'.$rdnsa_cnt}?>회차</td>
													<td><?=$rd['date']?></td>
													<td class="<?=$rd['deliv_stat'] == 1 ? "dh_blue" : ($rd['deliv_stat'] == 6 ? "red" : "") ;?>"><?=$deliv_stat_arr[$rd['deliv_stat']]?></td> <!-- 배송휴무일시 class명 "red" 입니다. -->
												</tr>
												<?php
											}
										}
										?>
										</table>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<div>
							<div class="my_tit">
								주문확인/배송목록
							</div>
							<div class="tblTy01">
								<table>
									<tr>
										<th>배송일정</th>
										<th colspan="2">송장번호</th>
										<th colspan="2">주소</th>
										<th colspan="2">비고</th>
									</tr>
									<?php
									foreach($deliv_info as $dit){	//뭐 이리 정보 표기 하는 부분이 많은건지 잘 모르겠숴요
									?>
									<tr>
										<td>
											<?=date("Y.m.d",strtotime($dit->deliv_date))?>(<?=$week_name_arr[date('w',strtotime($dit->deliv_date))]?>)
											<?php
											//echo "<BR>".str_replace(",","<br>",$dit->prod_name);
											?>
										</td>
										<td><?=$dit->invoice_company?> : <?=$dit->invoice_no?></td>
										<td>
											<?php
											if($dit->deliv_stat > 0 && $dit->invoice_no){
												if(strtoupper($dit->invoice_company) == "CJ"){
													?>
													<a href="https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=<?=$dit->invoice_no?>" target="_blank" class="btn_gg">배송조회</a>
													<?php
												}
												else{
													?>
													<a href="https://service.epost.go.kr/trace.RetrieveDomRigiTraceList.comm?displayHeader=N&sid1=<?=$dit->invoice_no?>" target="_blank" class="btn_gg">배송조회</a>
													<?php
												}
											}
											?>
										</td>
										<td><?=$dit->addr1."".$dit->addr2?></td>
										<td>
											<?php
											if($dit->deliv_stat == 0 || $dit->deliv_stat == 6){
											?>
											<a href="<?=cdir()?>/dh_order/order_edit" class="btn_gg">배송지 변경</a>
											<?php
											}
											?>
										</td>
										<td><?=$deliv_stat_arr[$dit->deliv_stat]?></td>
										<td>
											<?php
											if($dit->log_count > 0){
											?>
											<a href="javascript: log_view('<?=$dit->deliv_code?>');" class="alarm"></a>
											<?php
											}
											?>
										</td>
									</tr>
									<?php
									}
									?>

								<?php
								/*
									<tr>
										<td>2016.02.02(화)</td>
										<td>우체국:0336223622336</td>
										<td><a href="" class="btn_gg">
											배송조회
											</a></td>
										<td>자택:서울시 강서구 화곡로 119 동인빌딩 4층</td>
										<td><a href="" class="btn_gg">
											배송지 변경
											</a></td>
										<td>배송완료</td>
										<td><a href="" class="alarm">
											</a></td>
									</tr>
									<tr>
										<td>2016.02.02(화)</td>
										<td>우체국:0336223622336</td>
										<td><a href="" class="btn_gg">
											배송조회
											</a></td>
										<td>자택:서울시 강서구 화곡로 119 동인빌딩 4층</td>
										<td><a href="" class="btn_gg">
											배송지 변경
											</a></td>
										<td>배송대기</td>
										<td><a href="" class="a_noti">
											</a></td>
									</tr>
								*/
								?>
								</table>
							</div>
						</div>
						<?php
					}
					else{
						//일반배송일 경우
						if(count($deliv_info) > 0){
							?>
							<div>
								<div class="my_tit">상품 확인 / 배송 목록</div>
								<div class="tblTy03 deliv_list">
									<?php
									foreach($deliv_info as $di){
										?>
										<div class="my_tit"><?=$di->ct_subgroup?></div>
										<table class="mb30">
											<thead>
												<colgroup>
													<col>
													<col width="220px">
													<col>
													<col>
													<!-- <col> -->
													<col>
													<col width="15%">
												</colgroup>
												<tr>
													<th>배송일정</th>
													<th>주문 상품 정보</th>
													<th>수량</th>
													<th>상품금액</th>
													<!-- <th>배송비</th> -->
													<th colspan="2">비고</th>
												</tr>
											</thead>

											<tbody>
												<?php
												foreach($deliv_list as $dl){
													if($di->deliv_code == $dl->deliv_code){
													?>

													<tr>

														<td class="br" data-value="<?=strtotime($di->deliv_date)?>">
															<?=$di->deliv_date?> (<?=$week_name_arr[date('w',strtotime($di->deliv_date))]?>)
															<?php
															if($log_cnt > 0){
															?>
															<a href="" class="alarm"></a>
															<?php
															}
															?>
														</td>
														<td>
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
														<td class='align-c'>
															<?php
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
														<td class='align-c'>
															<?php
															echo number_format($dl->total_price);
															?>
															원
														</td>
														<!-- <td class="br" data-value="<?=strtotime($di->deliv_date)?>-<?=$di->deliv_price?>">
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
														<td data-value="<?=strtotime($di->deliv_date)?>-<?=$di->deliv_price?>"><?=$deliv_stat_arr[$di->deliv_stat]?>
															<?php
															if($di->invoice_no){
															?>
															<p class="blue"><?=$di->invoice_company?>: <?=$di->invoice_no?></p>
															<?php
															}
															?>
														</td>
														<td class="ac" data-value="<?=strtotime($di->deliv_date)?>-<?=$di->deliv_price?>">
															<?php
															if( $di->deliv_stat > 0 ){
																if( $di->deliv_stat == 2 ){
																?>
																<a href="<?=$shop_info['delivery_url1']?>" target="_blank" class="btn_yy">배송조회</a>
																<?php
																}
																else if( $di->deliv_stat == 3 ){
																?>
																<a href="javascript:;" class="btn_gg">배송완료</a>
																<!-- <a href="#" class="btn_rr">교환/반품요청</a> -->
																<?php
																}
															}
															?>

														</td>

													</tr>

													<?php
													}
												}
												?>
											</tbody>
										</table>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
				}
				?>

				<div>
					<div class="my_tit">
						배송지 정보
					</div>
					<div class="tblTy02">
						<table>
							<tr>
								<th>보내시는 분</th>
								<td colspan="3"><?=$trade_stat->name?></td>
							</tr>
							<tr>
								<!-- <th>보내시는 분 전화번호</th>
								<td>010-2125-8217</td> -->
								<th>보내시는 분 핸드폰</th>
								<td colspan="3"><?=$trade_stat->phone?></td>
							</tr>
							<?php
							if(count($deliv_info) > 0){
								?>
								<tr>
									<th>받으시는 분 이름</th>
									<td colspan="3"><?=$trade_stat->send_name?></td>
								</tr>
								<tr>
									<!-- <th>받으시는 분 전화번호</th>
									<td><?=$trade_stat->send_tel?></td> -->
									<th>받으시는 분 핸드폰</th>
									<td colspan="3"><?=$trade_stat->send_phone?></td>
								</tr>
								<tr>
									<th>배송지</th>
									<td colspan="3">(<?=$trade_stat->zip1?>) <?=$trade_stat->addr1?> <?=$trade_stat->addr2?></td>
								</tr>
								<!-- <tr>
									<th>공동 출입문 비밀번호</th>
									<td colspan="3">비밀번호 : 1234</td>
									<td colspan="3">비밀번호 없음</td>
								</tr> -->
								<tr>
									<th>배송 요청사항</th>
									<td colspan="3"><?=$trade_stat->send_text?></td>
								</tr>
								<?php
							}
							?>

						</table>
					</div>
				</div>
				<div>
					<div class="my_tit">
						결제 정보
					</div>
					<div class="tblTy02">
						<table>
							<tr>
								<th>결제 수단</th>
								<td><?=$shop_info['trade_method'.$trade_stat->trade_method]?>
									<?php
									if($trade_stat->trade_method == '4'){
										echo "<BR>(".$trade_stat->enter_bank." : ".$trade_stat->enter_account.")";
									}
									?>
								</td>
								<th>결제 상태</th>
								<td><?=$trade_stat->trade_stat==2&&count($deliv_info) > 0?$shop_info['trade_stat'.$trade_stat->trade_stat]:"입금 완료"?></td>
							</tr>
							<tr>
								<th>총 구매금액</th>
								<td><?=$trade_stat->trade_method==8?"상품권결제":number_format($trade_stat->goods_price)."원"?></td>
								<th>배송비</th>
								<td><?=($trade_stat->delivery_price > 0) ? number_format($trade_stat->delivery_price)."원" : "무료" ;?></td>
							</tr>
							<tr>
								<th style="display:<?=($trade_stat->use_coupon)?"":"none";?>;">쿠폰 사용</th>
								<td style="display:<?=($trade_stat->use_coupon)?"":"none";?>;"><? if($trade_stat->coupon_idx ){?>-<?=number_format($trade_stat->use_coupon)?>원 [ <?=$coupon_stat->name?> ]<?}?></td>
								<th style="display:<?=($trade_stat->use_point)?"":"none";?>;">포인트 사용</th>
								<td style="display:<?=($trade_stat->use_point)?"":"none";?>;"><? if($trade_stat->use_point){?>- <?=number_format($trade_stat->use_point)?>원<?}else{?>0원<?}?></td>
							</tr>
							<tr>
								<th>실제 결제 금액</th>
								<td><?=number_format($trade_stat->total_price)?>원</td>
								<th>추천인 아이디</th>
								<td><?=($member_stat->recomid)?$member_stat->recomid:"-";?></td>
							</tr>

						</table>
					</div>
				</div>

				<? if($trade_stat->trade_method==2){ ?>
				<div>
					<div class="my_tit">
						무통장 입금정보
					</div>
					<div class="tblTy02">
						<table>
							<tr>
								<th>입금자명</th>
								<td><?=$trade_stat->enter_name?></td>

							</tr>
							<tr>
								<th>입금은행</th>
								<td><?=$trade_stat->enter_bank?> <?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>

							</tr>
							<tr>
								<th>무통장 입금 안내</th>
								<td>무통장 주문 후 3일 이내에 입금이 완료되지 않으면 취소 처리됩니다.</td>

							</tr>
						</table>
					</div>
				</div>
				<?}?>

				<? if($trade_stat->trade_method==4){ ?>
				<div>
					<div class="my_tit">
						가상계좌 입금정보
					</div>
					<div class="tblTy02">
						<table>
							<tr>
								<th>입금자명</th>
								<td><?=$trade_stat->enter_name?></td>
							</tr>
							<tr>
								<th>입금은행</th>
								<td><?=$trade_stat->enter_bank?> <?=$trade_stat->enter_account?> (예금주: <?=$trade_stat->enter_info?>)</td>
							</tr>
						</table>
					</div>
				</div>
				<?}?>

				<!-- 팝업-->
				<div class="layer_pop" style="display:none;">
					<?php
					/*
					<div class="layer_pop_inner">
						<h1>
							2월 13일 배송상품
						</h1>
						<!-- Scroll Contents -->
						<div class="scroll">
							<ul class="bu_list01">
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
								<li>
									당근양배추죽
								</li>
							</ul>
						</div>
						<!-- END Scroll Contents -->
						<a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a>
					</div>
					*/
					?>
				</div>
				<!-- END 팝업 -->
			</div>
		</div>


	</div><!--END Container-->

<script type="text/javascript">
<!--
	$(function(){
		$('.deliv_list table tbody').rowspan(0);
		$('.deliv_list table tbody').rowspan(4);
		$('.deliv_list table tbody').rowspan(5);
		$('.deliv_list table tbody').rowspan(6);
	});
//-->
</script>

<? include('../include/footer.php') ?>

