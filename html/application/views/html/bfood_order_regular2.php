<?
	$deliv_between_date = $this->input->post('recom_delivery_detail_date');
	$delivery_detail_prod = $this->input->post('recom_delivery_detail_prod');
	$delivery_detail_sunday_prod = $this->input->post('recom_delivery_detail_sunday_prod');
	$recom_delivery_week_type_arr = $this->input->post('recom_delivery_week_type');
	$delivery_week_day_count = $this->input->post('recom_delivery_week_day_count');
	$delivery_week_type_key = $this->input->post('delivery_week_type_key');

	$PageName = "K02";
	$SubName = "K0201";
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

		/*
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
		*/
	//-->
	</script>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>
		<!-- 중간 아이콘 카테고리 -->
		<div class="mid_cate_wrap">
			<div class="inner">
				<ul class="mid_cate">
					<li <?if($this->input->post('recom_idx') == 2){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=2"><span class="icon i1"></span>
							<p class="tit"><em>5개월 전후</em>준비기</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 4){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=4"><span class="icon i2"></span>
							<p class="tit"><em>5~6개월</em>초기</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 5){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=5"><span class="icon i3"></span>
							<p class="tit"><em>7~8개월</em>중기</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 6){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=6"><span class="icon i4"></span>
							<p class="tit"><em>9~12개월</em>후기2식</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 1){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=1"><span class="icon i5"></span>
							<p class="tit"><em>9~12개월</em>후기3식</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 7){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=7"><span class="icon i6"></span>
							<p class="tit"><em>12개월~</em>완료기</p>
						</a>
					</li>
					<li <?if($this->input->post('recom_idx') == 3){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=3"><span class="icon i7"></span>
							<p class="tit"><em>반찬/국</em></p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- END 중간 아이콘 카테고리 -->

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
		<form name="sendfrm" id="orderfrm" method="post" action="<?=cdir()?>/dh_order/recom_cart">

		<input type="hidden" name="recom_idx" value="<?=$this->input->post('recom_idx')?>">
		<input type="hidden" name="recom_default_deliv_start_day" value="<?=$this->input->post('recom_default_deliv_start_day')?>">
		<input type="hidden" name="recom_deliv_addr" value="<?=$this->input->post('recom_deliv_addr')?>">
		<input type="hidden" name="recom_zipcode" value="<?=$this->input->post('zipcode')?>">
		<input type="hidden" name="recom_addr1" value="<?=$this->input->post('addr1')?>">
		<input type="hidden" name="recom_addr2" value="<?=$this->input->post('addr2')?>">
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
				<h4 class="plain_tit mt0" style="display: inline-block; vertical-align:top;">배송일정</h4>

				<?php
				$show_holiinfo = false;

				foreach($deliv_between_date as $shi){
					if(in_array($shi,$holiday_arr)){
						$show_holiinfo = true;
					}
				}


				if($show_holiinfo){
				?>
				<div class="gon_txt ml20" style="display: inline-block;">
					<p class="red mb5" style="font-size:18px;"><strong>[필독] 배송휴무일에 배송이 가지 않습니다</strong></p>
					<p style="font-size: 15px; line-height: 25px;">
						[배송휴무일]은 주문 시, 정기주문건으로 [주문내역]은 확인되나<br>
						<span class="red">실제로 배송되지 않으며,[배송일 변경]을 하세요</span><br>
						배송일 변경을 진행하지 않으실 경우, <u>맨 마지막 배송일 뒤로 자동배정됩니다</u><br>
						메뉴는 변경된 일정에 따라 달라집니다<br>
						<u>변경방법 > 배송일기준 D-2일 24:00까지 마이페이지를 통해 변경하세요</u>
					</p>
				</div>
				<?php
				}
				?>

				<!-- 배송일정 -->
				<!--
					흐린색, 선택불가능한 날짜 : td.dimmed
					정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
					배송시작일 : start_deliv
				-->
				<div class="cal_tintbox mt15">
					<div class="cal_wrap mt15" id="start_delivery_cal">
						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
						?>
					</div>
					<!-- END 배송일정 -->
				</div>

				<h4 class="plain_tit">메뉴와 식단</h4>
				<!-- 안내 -->
				<div class="info">
					<!-- <p class="float-l">
						<img src="/image/sub/btn_minus1.png" alt="-" class="img-mid mr5">
						<img src="/image/sub/btn_plus1.png" alt="+" class="img-mid mr10">
						버튼으로 메뉴 대체가 가능해요
					</p> -->
				</div>
				<!-- END 안내 -->
				<!-- 메뉴 리스트 -->
				<?php
				/*
				<!--
					*3n개째 li.mr0
					*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
					*제외됐을 때 li.except
				-->
				*/
				?>
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
					<input type="hidden" name="alg_chg_cnt_<?=strtotime($dbd)?>" value="<?=$this->input->post('alg_chg_cnt_'.strtotime($dbd))?>">

					<ul class="sched_menu">
						<?php
						$pcnt = 0;

						$prod_cnt_key = 0;
						$prod_cnt_arr = $this->input->post(strtotime($dbd).'_prod_cnt');

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
										<li class="<?=($sunday)?"sunday":"";?><?=($pcnt%3==0)?" mr0":"";?><?=($prod_cnt_arr[$prod_cnt_key] > 0)?"":" except";?>" data-dumme="<?=$pcnt-1?>" data-dumme2="<?=$prod_cnt_key?>">
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
												<input type="text" class="cnt" title="수량" value="<?=($prod_cnt_arr[$prod_cnt_key])?$prod_cnt_arr[$prod_cnt_key]:"0";?>" name="<?=strtotime($deliv_date)?>_prod_cnt[]" data-delivdate="<?=strtotime($dbd)?>" readonly>
												<input type="hidden" name="<?=strtotime($deliv_date)?>_goods_idx[]" value="<?=$goods_idx?>">
												<input type="hidden" name="<?=strtotime($deliv_date)?>_sunday[]" value="<?=$sunday?>">

												<!-- <button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
												<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button> -->
											</div>
										</li>
										<?php
										$prod_cnt_key++;
									}
								}
							}
						}
						?>
					</ul>
					<?php
					}
					?>

					<?php
					/*
						<h5 class="htit">3월 7일 (수)</h5>
						<ul class="sched_menu">
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="mr0"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
						</ul>

						<h5 class="htit">3월 8일 (수)</h5>
						<ul class="sched_menu">
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="except"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="mr0"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
						</ul>

						<h5 class="htit">3월 9일 (목)</h5>
						<ul class="sched_menu">
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="mr0"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
						</ul>

						<h5 class="htit">3월 10일 (금)</h5>
						<ul class="sched_menu">
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="mr0"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
						</ul>

						<h5 class="htit">3월 11일 (토)</h5>
						<ul class="sched_menu">
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
							<li class="mr0"><div class="box">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<em class="tit">A09. 한우보미</em>
									<input type="text" class="cnt" title="수량" value="1" disabled>
								</div>
							</li>
						</ul>
					*/
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
								<td><?=$this->input->post('recom_pack_ea')?>팩 (<?=$this->input->post('recom_delivery_week_count')?>주 / <?=$get_day_name[1]?>)</td>
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
								<th>배송기간 <?//=$deliv_between_date_tcnt?></th>
								<td><?=$deliv_between_date[0]?>(<?=$week_name_arr[date("w",strtotime($deliv_between_date[0]))]?>) ~ <?=$deliv_between_date[count($deliv_between_date)-1]?>(<?=$week_name_arr[date("w",strtotime($deliv_between_date[count($deliv_between_date)-1]))]?>)</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="order_opt_tint hidden">
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
								<th>
									할인적용가
									<input type="hidden" name="add_recom_price" value="<?=str_replace(",","",$this->input->post('recom_price'))?>">
								</th>
								<td><ins><?=$this->input->post('recom_price')?></ins>원</td>
							</tr>

							<tr>
								<td colspan="2"><hr></td>
							</tr>

							<tr class="hidden">
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
