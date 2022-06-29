<script type="text/javascript">
	function recom_list_view(no){
		$('#recom_list'+no).toggle();
	}

	function view_recom_foods(idx,deliv_code_front){
		window.open("<?=cdir()?>/order/lists/m/recom_foods_pop/?ajax=1&idx="+idx+"&dcodef="+deliv_code_front,"recom_foods","width=600,height=800,scrollbars=yes");
	}

	function view_foods_list(code){
		window.open("<?=cdir()?>/order/lists/m/foods_list/?ajax=1&code="+code,"deliv_foods","width=600,height=800,scrollbars=yes");
	}

	function update_food_list(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/food_update/?ajax=1&dcode="+deliv_code,"foods_update","width=600, height=800, scrollbars=yes");
	}

	function deliv_date_chg(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/deliv_date_update/?ajax=1&deliv_code="+deliv_code,"deliv_date_update","width=600, height=800");
	}

	function deliv_addr_change(deliv_code,od_type){
		window.open("<?=cdir()?>/dh_order/order_edit/?mode=deliv_addr_chg&deliv_code="+encodeURIComponent(deliv_code)+"&od_type="+od_type ,"deliv_change" ,'scrollbar=no, width=460, height=600');
	}
</script>

<style type="text/css">
	.adm-tab{
		border-bottom:2px solid #000;
	}
	.adm-tab th{
		padding:10px;
	}
	.adm-tab th.on{
		border-top:2px solid #000;
		background:#eee;
	}
	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/od.view.meminfo.top.php";
?>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/view/<?=$trade_idx?>/<?=$query_string.$param?>">주문상품목록</a></th>
		<th <?if($mode == "payment"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/payment/<?=$trade_idx?>/<?=$query_string.$param?>">주문결제내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/memo/<?=$trade_idx?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/send_receive/<?=$trade_idx?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>


				<!-- 제품리스트 -->
				<h3 class="icon-check">주문 기본정보</h3>

				<div>
					주문번호 : <?=$trade_stat->trade_code?>
				</div>
				<table class="adm-table v-line align-c">
					<caption>주문 기본정보</caption>
					<thead>
						<tr>
							<th>배송일</th>
							<th>상품명</th>
							<th>수량</th>
							<th>배송일정</th>
							<th>상태</th>
							<th>판매가</th>
							<th>소계</th>
							<th>취소액</th>
							<th>쿠폰</th>
							<th>포인트</th>
							<th>네이버 포인트</th>
							<th>배송비</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($goods_list){
							$rowcnt = 0;
							foreach($goods_list as $lt){

								if($lt->cate_no == "recom"){
									$rowcnt++;
								}


								$make_deliv_code = $lt->trade_code."_".$rowcnt;

								if($lt->recom_idx){	//정기배송일경우
									$recom_week_type_arr = explode(":",$lt->recom_week_type);
									?>
									<tr id="order_list<?=$rowcnt?>" class="order_list">
										<td data-value="<?=$rowcnt?>">
											<?=$lt->trade_code?> [<?=$trade_stat->mobile ? "M" : "PC" ;?>]<br>
											<?=$lt->recom_week_day_count?> 일분<br>
											<?if($lt->recom_week_day_count == 7){?>일요일 추가분 : <?=numberToweekname($lt->recom_delivery_sun_type)?>요일<?}?><br>
											<?=$lt->recom_week_count?> 주<br>
											주 <?=$recom_week_type_arr[0]?>회<br>
											<?=$recom_week_type_arr[1]?>배송
										</td>
										<td>
											<?=$lt->goods_name?><br>
										</td>
										<td><?=$lt->recom_pack_ea?>팩<br><input type="button" value="식단정보" onclick="view_recom_foods('<?=$lt->idx?>','<?=$make_deliv_code?>')"></td>
										<td><?=date("Y-m-d",$lt->recom_start_date)?> ~ <?=date("Y-m-d",$lt->recom_end_date)?><br><input type="button" value="배송일정보기" onclick="recom_list_view('<?=$rowcnt?>')"></td>
										<td><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></td>
										<td><?=number_format($lt->goods_price)?></td>
										<td><?=number_format($lt->goods_price*$lt->goods_cnt)?></td>
										<td>-</td>
										<td><?=number_format($trade_stat->use_coupon)?></td>
										<td><?=number_format($trade_stat->use_point)?></td>
										<td><?=number_format($trade_stat->npointPayAmount)?></td>
										<td>-</td>
										<td>
											<!-- <div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div> -->
										</td>
									</tr>

									<tr id="recom_list<?=$rowcnt?>" style="display:@none;" class="recom_list">
										<td colspan="12">
											<table class="adm-table">
												<tr>
													<th>배송일정</th>
													<th>송장번호</th>
													<th>받는 분</th>
													<th>받는 분 연락처</th>
													<th>주소</th>
													<th>식단</th>
													<th>상태</th>
													<th>배송내용수정</th>
													<th>비고</th>
													<th>AL</th>
												</tr>
												<?php
												foreach($recom_deliv as $rd){
													if(strpos($rd->deliv_code,$make_deliv_code)!==false){
														$ttprdcnt += $rd->total_prod_cnt;
													?>
													<tr style="background-color:<?=$rd->deliv_stat == 4 ? "#ececec" : ( $rd->deliv_stat == 5 ? "#fdebf3" : ( $rd->deliv_stat == 6 ? "#d0d8ff" : "" ) ) ;?>;">
														<td>
															<a href="/html/order/delivery/m/view/<?=$rd->deliv_code?>" target="_blank"><?=$rd->deliv_date?> (<?=numberToWeekname($rd->deliv_date)?>)</a>
														</td>
														<td><?=$rd->invoice_no?></td>
														<td><?=$rd->recv_name?></td>
														<td><?=$rd->recv_phone?></td>
														<td><?=$rd->addr1." ".$rd->addr2?></td>
														<td>
															<!-- <?=$rd->total_prod_cnt?> 팩 -->
															<!-- <input type="button" value="식단수정" onclick="view_foods_list('<?=$rd->deliv_code?>')"> -->
															<input type="button" value="식단수정" onclick="update_food_list('<?=$rd->deliv_code?>')">
														</td>
														<td><?=$deliv_stat_arr[$rd->deliv_stat]?></td>
														<td>
															<input type="button" class="btn-sm btn-alert" value="배송일변경" onclick="deliv_date_chg('<?=$rd->deliv_code?>')">
															<input type="button" class="btn-sm" value="배송지변경" onclick="deliv_addr_change('<?=$rd->deliv_code?>','recom')">
														</td>
														<td>
															<?php
															if($rd->log_count > 0){
															?>
															<a href="javascript:window.open('<?=cdir()?>/order/delivery/m/order_change/<?=$rd->deliv_code?>');">
																<div style="background:#a60000;color:#fff;width:15px;display:inline-block;text-align:center;">!</div>
															</a>
															<?php
															}
															?>
														</td>
														<td><?=$rd->allergy?"O":"X";?></td>
													</tr>
													<?php
													}
												}
												?>
												<!-- <tr>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td><?=$ttprdcnt?> 팩</td>
													<td></td>
													<td></td>
												</tr> -->
											</table>
										</td>
									</tr>
									<?php
								}
								else{	//정기배송이 아닌경우
								?>
								<tr>
									<td data-value=<?=strtotime($lt->date_bind)?>><?=$lt->date_bind?> (<?=numberToWeekname($lt->date_bind)?>)</td>
									<td style="text-align:left;padding-left:20px;" <?= $lt->option_cnt > 0 ? "colspan='2'" : "" ; ?>><?=$lt->goods_name?><br>
										<?php
										if($lt->option_cnt>0){
											$option_cnts = 0;
											$option_price = 0;
											for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){

												if(${'option_arr'.$lt->idx}[$i]['price'] > 0){
													$plus="+";
												}
												$title = ${'option_arr'.$lt->idx}[$i]['title'];
												$name = ${'option_arr'.$lt->idx}[$i]['name'];
												$price = ${'option_arr'.$lt->idx}[$i]['price'];
												$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
												$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
												?>
												<em style="padding-left:20px;"><?=$title?></em> : <?=$name?>
												<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>) <?}?>
												<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
												<?php
												echo "<BR>";

												$option_cnts += $cnt;
												$option_price += ($lt->goods_price+$price)*$cnt;
											}
										}
										?>
									</td>
									<?php
									if($lt->option_cnt > 0){
									}
									else{
									?>
									<td><?=($lt->option_cnt>0)?number_format($option_cnt):number_format($lt->goods_cnt)?></td>
									<?php
									}
									?>
									<td> - </td>
									<td><?=$shop_info['trade_stat'.$trade_stat->trade_stat]?></td>
									<td><?=number_format($lt->goods_price)?></td>
									<td><?=($lt->option_cnt>0)?number_format($option_price):number_format($lt->goods_price*$lt->goods_cnt);?></td>
									<td>-</td>
									<td><?=number_format($trade_stat->use_coupon)?></td>
									<td><?=number_format($trade_stat->use_point)?></td>
									<td><?=number_format($trade_stat->npointPayAmount)?></td>
									<td>-</td>
									<td>
										<!-- <div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div> -->
									</td>
								</tr>
								<?php
								}

							}
						}
						?>
						<!-- <tr>
							<td>주 2회<br>수,토배송</td>
							<td>5~6개월 초기</td>
							<td>배송시작일 ~ 배송종료일<br><input type="button" value="배송일정보기"></td>
							<td>- 모든배송은 개별상태 사용</td>
							<td>24팩<br><input type="button" value="식단정보"></td>
							<td>단가</td>
							<td>단가 * 수량</td>
							<td>- (어디서 입력??)</td>
							<td>0 (쿠폰 할인액만 ?<br>아니면 쿠폰정보 포함? )</td>
							<td>0 (사용한 포인트?)</td>
							<td>- (0이면 무료로 표기)</td>
							<td>
								<div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div>
							</td>
						</tr>

						<tr>
							<td colspan="12">
								<table class="adm-table">
									<tr>
										<th>배송일정</th>
										<th>송장번호</th>
										<th>받는 분</th>
										<th>받는 분 연락처</th>
										<th>주소</th>
										<th>식단</th>
										<th>상태</th>
										<th>비고</th>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
									<tr>
										<td>배송일정</td>
										<td>송장번호</td>
										<td>받는 분</td>
										<td>받는 분 연락처</td>
										<td>주소</td>
										<td>식단</td>
										<td>상태</td>
										<td>비고</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td>배송날짜<br>(요일)</td>
							<td>제품명</td>
							<td></td>
							<td>- 모든배송은 개별상태 사용</td>
							<td>수량</td>
							<td>단가</td>
							<td>단가 * 수량</td>
							<td>- (어디서 입력??)</td>
							<td>0 (쿠폰 할인액만 ?<br>아니면 쿠폰정보 포함? )</td>
							<td>0 (사용한 포인트?)</td>
							<td>- (0이면 무료로 표기)</td>
							<td>
								<div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div>
							</td>
						</tr>
						<tr>
							<td>배송날짜<br>(요일)</td>
							<td>제품명</td>
							<td></td>
							<td>- 모든배송은 개별상태 사용</td>
							<td>수량</td>
							<td>단가</td>
							<td>단가 * 수량</td>
							<td>- (어디서 입력??)</td>
							<td>0 (쿠폰 할인액만 ?<br>아니면 쿠폰정보 포함? )</td>
							<td>0 (사용한 포인트?)</td>
							<td>- (0이면 무료로 표기)</td>
							<td>
								<div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div>
							</td>
						</tr>
						<tr>
							<td>배송날짜<br>(요일)</td>
							<td>제품명</td>
							<td></td>
							<td>- 모든배송은 개별상태 사용</td>
							<td>수량</td>
							<td>단가</td>
							<td>단가 * 수량</td>
							<td>- (어디서 입력??)</td>
							<td>0 (쿠폰 할인액만 ?<br>아니면 쿠폰정보 포함? )</td>
							<td>0 (사용한 포인트?)</td>
							<td>- (0이면 무료로 표기)</td>
							<td>
								<div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div>
							</td>
						</tr> -->
					</tbody>
				</table>

				<div class="float-wrap mt40">
					<div class="float-l">
						<a href="<?=cdir()?>/order/lists/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
					</div>
					<div class="float-r">

						<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
						<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
						<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
					</div>
				</div>

				<?php
				if($deliv_log){
				?>
				<h3 class="icon-pen mt50">주문별 배송 기록 수정내역</h3>
				<table class="adm-table align-c">
					<tr>
						<th>구분</th>
						<th>내용</th>
						<th>배송일</th>
						<th>날짜</th>
						<th>시행자</th>
					</tr>
					<?php
					foreach($deliv_log as $log){
						$dcodetmp = explode("-",$log->deliv_code);
					?>
					<tr>
						<td><?=$log->type?></td>
						<td class="title"><?=$log->msg?></td>
						<td><?=date("Y-m-d",$dcodetmp[1])?></td>
						<td><?=$log->wdate?></td>
						<td><?=$log->writer?></td>
					</tr>
					<?php
					}
					?>
				</table>
				<?php
				}
				?>

<script type="text/javascript">
<!--
	$(".order_list").rowspan(0);
//-->
</script>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>

