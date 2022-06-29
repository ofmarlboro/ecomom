<script type="text/javascript">
	function recom_list_view(no){
		$('#recom_list'+no).toggle();
	}

	function view_recom_foods(idx){
		window.open("<?=cdir()?>/order/delivery/m/recom_foods_pop/?ajax=1&idx="+idx,"recom_foods","width=600,height=800");
	}

	function view_foods_list(code){
		window.open("<?=cdir()?>/order/delivery/m/foods_list/?ajax=1&code="+code,"deliv_foods","width=600,height=800");
	}

	function deliv_date_chg(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/deliv_date_update/?ajax=1&view=ok&deliv_code="+deliv_code,"deliv_date_update","width=600, height=800");
	}

	function deliv_pause(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/deliv_pause/?ajax=1&deliv_code="+deliv_code,"deliv_pause","width=800, height=600");
	}

	function update_food_list(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/food_update/?ajax=1&dcode="+deliv_code,"foods_update","width=600, height=800");
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

<h1 class="sobigdick"><?=$deliv_info->order_name?>, <?=$deliv_info->userid?>, <?=$deliv_info->order_phone?></h1>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/view/<?=$deliv_code?>/<?=$query_string.$param?>">배송상품 목록</a></th>
		<th <?if($mode == "order_change"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/order_change/<?=$deliv_code?>/<?=$query_string.$param?>">주문 변동내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/memo/<?=$deliv_code?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/send_receive/<?=$deliv_code?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>


				<!-- 제품리스트 -->
				<h3 class="icon-check">배송상품 목록</h3>

				<table class="adm-table v-line align-c">
					<caption>주문 기본정보</caption>
					<thead>
						<tr>
							<th>배송일</th>
							<th>상품명</th>
							<th>수량</th>
							<!-- <th>판매가</th>
							<th>소계</th> -->
							<th>비고</th>
						</tr>
					</thead>
					<tbody>
						<?php
						//합배송으로 머리가 아파서 그냥 배열로 해버리고 말아버리는게 정신건강에 좋을거라 판단됨
						$this_order_recom_is = false;

						foreach($list as $lt){
							if($lt->recom_idx == 0){
								$lt->recom_idx = "normal";
								$add_sql = " and date_bind = '".$lt->deliv_date."'";
							}

							$list_arr[$lt->recom_idx]['deliv_date'] = $lt->deliv_date;
							$list_arr[$lt->recom_idx]['deliv_date_name'] = numberToWeekname($lt->deliv_date);
							//$list_arr[$lt->recom_idx]['goods_name'] = $lt->goods_name;

							$trade_goods = "
								select *
								from dh_trade_goods
								where trade_code = '".$lt->trade_code."' {$add_sql}
							";

							$tg_list = $this->common_m->self_q($trade_goods,"result");

							$key_cnt = 0;

							foreach($tg_list as $tl){

								if($tl->recom_idx == $lt->recom_idx){	//정기배송
									$list_arr[$lt->recom_idx]['recom_is'] = "Y";
									$list_arr[$lt->recom_idx]['recom_delivery_sun_type'] = $tl->recom_delivery_sun_type;
									$list_arr[$lt->recom_idx]['recom_week_day_count'] = $tl->recom_week_day_count;
									$recom_week_type_arr = explode(":",$tl->recom_week_type);
									$list_arr[$lt->recom_idx]['recom_week_type1'] = $recom_week_type_arr[0];
									$list_arr[$lt->recom_idx]['recom_week_type2'] = $recom_week_type_arr[1];

									$list_arr[$lt->recom_idx]['goods_info'][$key_cnt]['name'] = $tl->goods_name;
									$list_arr[$lt->recom_idx]['goods_info'][$key_cnt]['cnt'] += $lt->prod_cnt;

									$this_order_recom_is = true;
								}

								if($tl->goods_idx == $lt->goods_idx){	//일반주문
									$list_arr[$lt->recom_idx]['goods_info'][$tl->idx]['name'] = $tl->goods_name;
									if($tl->goods_cnt > 0){
										$list_arr[$lt->recom_idx]['goods_info'][$tl->idx]['cnt'] = $tl->goods_cnt;
									}
									else{
										//옵션이 있는건가?
										if($tl->option_cnt > 0){
											//옵션검색
											$option_list = $this->common_m->self_q("select * from dh_trade_goods_option where level=2 and trade_goods_idx = '".$tl->idx."'","result");
											foreach($option_list as $ol){
												$list_arr[$lt->recom_idx]['goods_info'][$tl->goods_idx]['option_info'][$ol->trade_goods_idx][$ol->idx]['title'] = $ol->title;
												$list_arr[$lt->recom_idx]['goods_info'][$tl->goods_idx]['option_info'][$ol->trade_goods_idx][$ol->idx]['name'] = $ol->name;
												$list_arr[$lt->recom_idx]['goods_info'][$tl->goods_idx]['option_info'][$ol->trade_goods_idx][$ol->idx]['cnt'] = $ol->cnt;
											}
										}
									}
								}

								$key_cnt++;

							}
						}
						//합배송 배열처리 종료

						//pr($list_arr);

						$la_cnt = 0;
						$old_key = "";
						foreach($list_arr as $key=>$arr1){	//제품 유형 ( 정기 or 일반 ) 첫 구분
							foreach($arr1['goods_info'] as $goods_info){	//제품 정보로 2depth 구분
								$rowspan = count($arr1['goods_info']);	//행 병합 갯수 카운트
								?>
								<tr>
									<?php
									if($key != $old_key){	//첫번째 키 값이 지난 키 값과 같지 않을경우만 1번 작성
									?>
									<td rowspan="<?=$rowspan?>">
										<?php
										//추천식단인경우
										if($arr1['recom_is']){
											?>
											주 <?=$arr1['recom_week_type1']?>회 배송 <br> (<?=$arr1['recom_week_type2']?>)
											<?php
										}
										else{
											?>
											<?=$arr1['deliv_date']?> (<?=$arr1['deliv_date_name']?>)
											<?php
										}
										?>
									</td>
									<?php
									}
									?>
									<td>
										<?=$goods_info['name']?> <?=($arr1['recom_delivery_sun_type'])?"<br>일요일 추가 : ".numberToWeekname($arr1['recom_delivery_sun_type'])."요일":"";	//추천식단인경우?>
									</td>
									<td>
										<?php
										if($goods_info['option_info']){	//옵션이 있는경우
											?>
											<div style="text-align:left;width:100%">
											<?php
											foreach($goods_info['option_info'] as $key=>$option_info){	//옵션 배열항목 돌리고
												foreach($option_info as $options){
													?>
														<?=$options['title']?> : <?=$options['name']?> x <?=$options['cnt']?>개<br>
													<?php
												}
												echo "<br>";
											}
											?>
											</div>
											<?php
										}
										else{	//옵션 없는 제품의 경우
										?>
											<?=$goods_info['cnt']?> <?=($arr1['recom_is'])?"팩":"개";	//추천식단은 팩 , 일반상품은 갯수?>
										<?php
											if($arr1['recom_is']){
											?>
											<span class="pl15"></span>
											<input type="button" value="식단정보확인" onclick="view_foods_list('<?=$deliv_code?>')">
											<?php
											}
										}
										?>
									</td>
									<td>
										<!-- <div style="width:20px;height:20px;background:#ff00aa;color:#fff">!</div> -->
									</td>
								</tr>
								<?php
								$old_key = $key;	//지난 키값 물려줌
							}
						}
						?>
					</tbody>
				</table>

<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/delivery/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
	</div>
	<div class="float-r">
		<?php
		if($this_order_recom_is){
			?>
			<button type="button" class="btn-xl btn-cancel" onclick="update_food_list('<?=$deliv_code?>')">식단정보 수정</button>
			<?php
		}
		?>
		<button type="button" class="btn-alert btn-xl" onclick="deliv_date_chg('<?=$deliv_code?>')">배송일 변경</button>
		<!-- <button type="button" class="btn-special btn-xl" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/send_receive/<?=$this->uri->segment(5)?>'">배송지 변경</button> -->
		<button type="button" class="btn-special btn-xl" onclick="deliv_addr_change('<?=$deliv_code?>','recom')">배송지 변경</button>
		<?php
		list($trade_code, $deliv_time) = explode("-",$deliv_code);
		$today_time = strtotime(date("Y-m-d"));
		$limit_time = strtotime("+3 day",$deliv_time);
		if($limit_time > $today_time and $this_order_recom_is){
		?>
		<button type="button" class="btn-etc btn-xl" onclick="deliv_pause('<?=$deliv_code?>')">배송일시정지 / 재시작</button>
		<?php
		}
		?>
		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>

