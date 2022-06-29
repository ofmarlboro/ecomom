<?
	$deliv_between_date = $this->input->post('recom_delivery_detail_date');
	$delivery_detail_prod = $this->input->post('recom_delivery_detail_prod');
	$delivery_detail_sunday_prod = $this->input->post('recom_delivery_detail_sunday_prod');
	$recom_delivery_week_type_arr = $this->input->post('recom_delivery_week_type');
	$delivery_week_day_count = $this->input->post('recom_delivery_week_day_count');
	$delivery_week_type_key = $this->input->post('delivery_week_type_key');

	$PageName = "K03";
	$SubName = "K0301";
	include("../include/head.php");
	include("../include/header.php");
?>

	<script type="text/javascript" src="/js/orderPage.js"></script>

	<script type="text/javascript">
	<!--
		function deliv_calendar_set(this_mon){

			var between_date = '<?=serialize($deliv_between_date)?>';

			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_result_calendar&deliv_between_date="+encodeURIComponent(between_date)+"&this_mon="+encodeURIComponent(this_mon)
				,dataType:"json"
				,cache:false
				,error:function(xhr){console.log(xhr.responseText);}
				,success:function(data){
					if(data.calnedar){
						$("#start_delivery_cal").html(data.calnedar);
					}
				}
			});
		}

		$(function(){
			$(".minus").click(function(){
				var cnt = $(this).siblings("input.cnt").val();
				var code = $(this).siblings("input.cnt").data('delivdate');
				var code_cnt = $("input[name='chg_cnt_"+code+"']").val();

				if(cnt > 0){
					var real_cnt = parseInt(cnt)-1;
					$(this).siblings("input.cnt").val(real_cnt);
					if(real_cnt == 0){
						$(this).parents('li').addClass('except');
					}
					$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)-1);
				}else{
					alert("수량은 0 이하로 설정할 수 없습니다.");
					return;
				}

			});

			$(".plus").click(function(){
				var cnt = $(this).siblings("input.cnt").val();
				var code = $(this).siblings("input.cnt").data('delivdate');
				var code_cnt = $("input[name='chg_cnt_"+code+"']").val();
				var basic_cnt = $("input[name='stan_cnt_"+code+"']").val();

				if(basic_cnt == code_cnt){

					alert("배송가능 갯수를 초과 할 수 없습니다.");
					return;

				}else{

					var real_cnt = parseInt(cnt)+1;
					$(this).siblings("input.cnt").val(real_cnt);
					if(real_cnt > 0){
						$(this).parents('li').removeClass('except');
					}
					$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)+1);

				}

			});
		});

	//-->
	</script>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
		<form name="sendfrm" id="orderfrm" method="post" action="<?=cdir()?>/dh_order/recom_cart">

		<input type="hidden" name="recom_idx" value="<?=$this->input->post('recom_idx')?>">
		<input type="hidden" name="recom_default_deliv_start_day" value="<?=$this->input->post('recom_default_deliv_start_day')?>">
		<input type="hidden" name="recom_deliv_addr" value="<?=$this->input->post('recom_deliv_addr')?>">
		<input type="hidden" name="recom_delivery_sun_type" value="<?=$this->input->post('recom_delivery_sun_type')?>">
		<input type="hidden" name="recom_delivery_week_count" value="<?=$this->input->post('recom_delivery_week_count')?>">
		<input type="hidden" name="recom_delivery_week_day_count" value="<?=$this->input->post('recom_delivery_week_day_count')?>">
		<input type="hidden" name="recom_delivery_week_type" value="<?=$this->input->post('recom_delivery_week_type')?>">
		<input type="hidden" name="recom_total_origin_price" value="<?=$this->input->post('recom_total_origin_price')?>">
		<input type="hidden" name="recom_pack_ea" value="<?=$this->input->post('recom_pack_ea')?>">
		<input type="hidden" name="recom_per" value="<?=$this->input->post('recom_per')?>">
		<input type="hidden" name="recom_price" value="<?=$this->input->post('recom_price')?>">

			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<h4 class="plain_tit mt0">배송일정</h4>

				<!-- 배송일정 -->
				<div class="cal_tintbox">
					<div class="cal_wrap mt15" id="start_delivery_cal">
						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
						?>
					</div>
					<!-- END 배송일정 -->
				</div>

				<h4 class="plain_tit">메뉴와 식단</h4>
				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box static">
					<?php
					$sunday_cnt = 0;
					foreach($deliv_between_date as $dbd){	//배송날짜 배열
						//배송일 기준 배송갯수 기본값
						$standard_cnt = $food_info[$delivery_week_day_count]['delivery_week_type'][$delivery_week_type_key]['count'][$week_name_arr[date("w",strtotime($dbd))]];
					?>
					<h5 class="htit"><?=$dbd?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>)</h5>

					<input type="hidden" name="recom_delivery_detail_date[]" value="<?=strtotime($dbd)?>">

					<input type="hidden" name="stan_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>">
					<input type="hidden" name="chg_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>" passwd_match="<?=date("Y년 m월 d일",strtotime($dbd))?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>) 날짜에 배송 받을 상품 갯수가 일치 하지 않습니다." matching_name="stan_cnt_<?=strtotime($dbd)?>">

					<ul class="sched_menu">
						<?php
						$pcnt = 0;
						foreach($delivery_detail_prod as $rddp){	//요일별 배송상품 배열
							$pcnt++;
							$rddp_arr = explode(":",$rddp);	//배열값 자르기
							$goods_idx = $rddp_arr[0];
							$deliv_date = $rddp_arr[1];
							$sunday = $rddp_arr[2];
							if($deliv_date == $dbd){	//배송날짜와 같은경우
								foreach($goods as $g){	//모든 상품리스트 정보
									if($g->idx == $goods_idx){	//상품 인덱스 검색
										?>
										<li class="<?=($sunday)?"sunday":"";?><?=($pcnt%3==0)?" mr0":"";?>">
											<div class="box">
												<span class="img"><img src="/_data/file/goodsImages/<?=$g->list_img?>" alt="<?=$g->name?>의 이미지" onerror="this.src='/image/default.jpg'"></span>
												<em class="tit"><?=$g->name?></em>
												<?php
												if($sunday){
												?>
												<span class="added">일요일 추가분</span>
												<?php
												}
												?>
												<input type="text" class="cnt" title="수량" value="1" name="<?=strtotime($deliv_date)?>_prod_cnt[]" data-delivdate="<?=strtotime($dbd)?>">
												<input type="hidden" name="<?=strtotime($deliv_date)?>_goods_idx[]" value="<?=$goods_idx?>">
												<input type="hidden" name="<?=strtotime($deliv_date)?>_sunday[]" value="<?=$sunday?>">

												<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
												<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
											</div>
										</li>
										<?php
									}
								}
							}
						}
						?>
					</ul>
					<?php
					}
					?>
				</div><!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_light">
					<table class="order_opt">
						<tbody>
							<tr>
								<th>단계명</th>
								<td><?=$recom_info->recom_name?></td>
							</tr>
							<tr>
								<th>배송수량</th>
								<?php
								$get_day_name = explode(":",$food_info[$delivery_week_day_count]['delivery_week_type'][$delivery_week_type_key]['val']);
								?>
								<td><?=$this->input->post('recom_pack_ea')?>세트 (<?=$this->input->post('recom_delivery_week_count')?>주 / <?=$get_day_name[1]?>)</td>
							</tr>
							<tr>
								<th>배송지</th>
								<?php
								if($this->input->post('recom_deliv_addr') == "self"){
								?>
								<td><?=$this->input->post('addr1')?> <?=$this->input->post('addr2')?></td>
								<?php
								}
								else{
								?>
								<td><?=$member_addr_key_arr[$this->input->post('recom_deliv_addr')].$member_addr_arr[$this->input->post('recom_deliv_addr')]?></td>
								<?php
								}
								?>
							</tr>
							<tr>
								<th>배송기간 <?=$deliv_between_date_tcnt?></th>
								<td><?=$deliv_between_date[0]?>(<?=$week_name_arr[date("w",strtotime($deliv_between_date[0]))]?>) ~ <?=$deliv_between_date[count($deliv_between_date)-1]?>(<?=$week_name_arr[date("w",strtotime($deliv_between_date[count($deliv_between_date)-1]))]?>)</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="order_opt_tint">
					<table class="order_opt">
						<tbody>
							<tr>
								<th>간식추가</th>
								<td>이유식과 함께 간식을 챙겨주세요!</td>
							</tr>
						</tbody>
					</table>

					<!-- 추가가능한 간식 리스트 -->
					<div class="add_prod_list">
						<?php
						if($gansik){
							foreach($gansik as $gs){
							?>
							<div class="item">
								<a href="javascript:;" onclick="add_gansik('<?=$gs->idx?>')">
									<img src="/_data/file/goodsImages/<?=$gs->list_img?>" alt="" onerror="this.src='/image/default.jpg'">
									<em><?=$gs->name?></em>
								</a>
							</div>
							<?php
							}
						}
						else{
						?>
						<div class="no_ct">추가 가능한 상품이 없습니다.</div>
						<?php
						}
						?>

						<?php
						/*
							<!-- <div class="no_ct">추가 가능한 상품이 없습니다.</div> -->
							<div class="item">
								<a href="#">
									<img src="/image/sub/snack1.jpg" alt="">
									<em>호박쌀참</em>
								</a>
							</div>
							<div class="item">
								<a href="#">
									<img src="/image/sub/snack2.jpg" alt="">
									<em>사과당근쌀참</em>
								</a>
							</div>
							<div class="item">
								<a href="#">
									<img src="/image/sub/snack3.jpg" alt="">
									<em>사과과일참</em>
								</a>
							</div>
							<div class="item">
								<a href="#">
									<img src="/image/sub/snack3.jpg" alt="">
									<em>사과과일참</em>
								</a>
							</div>
						*/
						?>
					</div>
					<!-- END 추가가능한 간식 리스트 -->

					<!-- 선택한 간식 -->
					<ul class="added_prod">
						<?php
						/*
							<li><div class="row">
									<p class="prod">산골알밤</p>
									<div class="cnt">
										<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
										<input type="text" value="1">
										<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
									</div>
									<p class="total_price">6,900</p>
									<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
								</div>
							</li>
							<li><div class="row">
									<p class="prod">제품명이 길어질 경우엔 이렇게</p>
									<div class="cnt">
										<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
										<input type="text" value="1">
										<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
									</div>
									<p class="total_price">6,900</p>
									<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
								</div>
							</li>
						*/
						?>
					</ul><!-- END 선택한 간식 -->

				</div>
				<div class="order_opt_light">
					<table class="order_opt price_tbl">
						<tbody>
							<tr>
								<th>총 상품금액</th>
								<td><del><?=$this->input->post('recom_total_origin_price')?></del>원</td>
							</tr>
							<tr>
								<th>할인금액</th>
								<td class="sale">
									<span>(<?=$this->input->post('recom_per')?>% 할인)</span>
									<em><?=number_format(str_replace(",","",$this->input->post('recom_total_origin_price')) - str_replace(",","",$this->input->post('recom_price')))?></em>원
								</td>
							</tr>
							<tr class="total">
								<th>할인적용가
									<input type="hidden" name="add_recom_price" value="<?=str_replace(",","",$this->input->post('recom_price'))?>">
								</th>
								<td><ins><?=$this->input->post('recom_price')?></ins>원</td>
							</tr>

							<tr>
								<td colspan="2"><hr></td>
							</tr>

							<tr>
								<th>
									추가 금액 (+)
									<input type="hidden" name="add_prod_update_price" value="0">
								</th>
								<td class="add_prod_total">
									0 원
								</td>
							</tr>

							<tr>
								<th>총 계</th>
								<td class="all_price">
									<?=$this->input->post('recom_price')?> 원
								</td>
							</tr>
						</tbody>
					</table>
					<p class="align-c mt20 mb5">
						<button type="button" class="plain" title="주문하기" onclick="frmChk('orderfrm')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
					</p>
				</div>
			</div><!-- END 선택 옵션영역 -->
		</form>
		</div><!-- END 주문옵션 WRAP -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
