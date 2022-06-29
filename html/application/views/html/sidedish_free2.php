<?
	$PageName = "K03";
	$SubName = "K0302";
	include("../include/head.php");
	include("../include/header.php");

	$deliv_between_date = $this->input->post('result_deliv_date');
	$result_prod_info = $this->input->post('result_prod_info');
	$prod_cnts = $this->input->post('prod_cnts');
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
					console.log(data);
					if(data.calnedar){
						$("#start_delivery_cal").html(data.calnedar);
					}
				}
			});
		}
	//-->
	</script>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>
		<!-- 중간 아이콘 카테고리 -->
		<div class="mid_cate_wrap">
			<div class="inner">
				<ul class="mid_cate">
					<li <?if($cate_no == "2-12"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=2-12"><span class="icon i7"></span>
							<p class="tit"><em>반찬</em></p>
						</a>
					</li>
					<li <?if($cate_no == "2-13"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=2-13"><span class="icon i7"></span>
							<p class="tit"><em>국</em></p>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- END 중간 아이콘 카테고리 -->

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
		<form name="sendfrm" id="orderfrm" method="post" action="<?=cdir()?>/dh_order/recom_cart">

		<input type="hidden" name="free_cate_no" value="<?=$this->input->post('cate_no')?>">
		<input type="hidden" name="free_deliv_addr" value="<?=$this->input->post('deliv_addr')?>">
		<input type="hidden" name="free_zipcode" value="<?=$this->input->post('zipcode')?>">
		<input type="hidden" name="free_addr1" value="<?=$this->input->post('addr1')?>">
		<input type="hidden" name="free_addr2" value="<?=$this->input->post('addr2')?>">

			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<h4 class="plain_tit mt0">배송일정</h4>

				<!-- 배송일정 -->
				<!--
					흐린색, 선택불가능한 날짜 : td.dimmed
					정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
					배송시작일 : start_deliv
				-->
				<div class="cal_tintbox">
					<div class="cal_wrap mt15" id="start_delivery_cal">
						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
						?>
					</div><!-- END 배송일정 -->
				</div>

				<h4 class="plain_tit">메뉴와 식단</h4>
				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box static">

					<?php
					$menu_and_date = array();
					foreach($deliv_between_date as $dbd){
						$make_date = strtotime('-1 day',strtotime($dbd));
					?>
					<input type="hidden" name="free_deliv_date[]" value="<?=strtotime($dbd)?>">
					<div class="day_group" id="dgroup1">
						<h5 class="htit"><?=date("m월 d일",strtotime($dbd))?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>) <span class="desc"><?=date("m월 d일",$make_date)?> <?=$week_name_arr[date("w",$make_date)]?>요일에 조리하여 <?=date("m월 d일",strtotime($dbd))?> <?=$week_name_arr[date("w",strtotime($dbd))]?>요일에 배송됩니다.</span></h5>
						<!--
							*3n개째 li.mr0
							*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
							*제외됐을 때 li.except
						-->
						<ul class="sched_menu">
							<?php
							foreach($result_prod_info as $k=>$v){

								$v_arr = explode(":",$v);
								$deliv_date = $v_arr[0];
								$goods_name = $v_arr[1];
								$goods_price = $v_arr[2];
								$goods_img = $v_arr[3];
								$goods_idx = $v_arr[4];

								if($deliv_date == $dbd){
									$menu_and_date[$dbd][$k]['goods_name'] = $goods_name;
									$menu_and_date[$dbd][$k]['goods_price'] = $goods_price;
									$menu_and_date[$dbd][$k]['goods_cnt'] = $prod_cnts[$k];
								?>
								<li class="<?=(($k+1)%3==0)?"mr0":"";?>">
									<div class="box">
										<span class="img"><img src="/_data/file/goodsImages/<?=$goods_img?>" alt="<?=$goods_name?>의 이미지" onerror="this.src='/image/default.jpg'"></span>
										<em class="tit"><?=$goods_name?></em>
										<input type="text" class="cnt" title="수량" value="<?=$prod_cnts[$k]?>" name="<?=strtotime($dbd)?>_free_goods_cnt[]" readonly>
										<input type="hidden" name="<?=strtotime($dbd)?>_free_goods_name[]" value="<?=$goods_name?>">
										<input type="hidden" name="<?=strtotime($dbd)?>_free_goods_price[]" value="<?=$goods_price?>">
										<input type="hidden" name="<?=strtotime($dbd)?>_free_goods_origin_price[]" value="<?=$goods_orgin_price?>">
										<input type="hidden" name="<?=strtotime($dbd)?>_free_goods_idx[]" value="<?=$goods_idx?>">
									</div>
								</li>
								<?php
								}
							}
							?>
						</ul>
					</div>
					<?php
					}
					?>

					<?php
					/*
						<div class="day_group" id="dgroup1">
							<h5 class="htit">3월 7일 (수) <span class="desc">3월 4일 수요일에 조리하여 3월 5일 목요일에 배송됩니다.</span></h5>
							<!--
								*3n개째 li.mr0
								*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
								*제외됐을 때 li.except
							-->
							<ul class="sale_menu">
								<li><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod1.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">초기6팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li class="mr0"><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod2.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">중기 12팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod1.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">후기 18팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li class="mr0"><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod2.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">완료기 18팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
							</ul>
						</div>

						<div class="day_group" id="dgroup2">
							<h5 class="htit">3월 7일 (수) <span class="desc">3월 4일 수요일에 조리하여 3월 5일 목요일에 배송됩니다.</span></h5>
							<!--
								*3n개째 li.mr0
								*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
								*제외됐을 때 li.except
							-->
							<ul class="sale_menu">
								<li><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod1.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">초기6팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li class="mr0"><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod2.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="cate">[특가상품]</p>
											<p class="name">중기 12팩 set</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
							</ul>
						</div>
					*/
					?>
				</div><!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_light">
					<!-- 일자별 주문내용 -->
					<div class="daily_list">
						<?php
						$deliv_total_price = 0;
						foreach($menu_and_date as $date=>$values){
							$date_time = strtotime($date);
						?>
						<h5 class="date"><?=date("m월 d일",$date_time)?> (<?=$week_name_arr[date("w",$date_time)]?>)</h5>
						<table class="order_opt">
							<tbody>
								<tr>
									<th>주문내용</th>
									<td>
										<?php
										$date_total_price = 0;
										foreach($values as $key=>$vv){
											$date_total_price += $vv['goods_price']*$vv['goods_cnt'];
											echo $vv['goods_name']." ".number_format($vv['goods_price'])."원 x ".number_format($vv['goods_cnt'])." = ".number_format($vv['goods_price']*$vv['goods_cnt'])."원";
											if($key >= 0){
												echo "<BR>";
											}
										}
										?>
									</td>
								</tr>
								<tr>
									<th>상품금액</th>
									<td><em class="price"><?=number_format($date_total_price)?></em>원</td>
								</tr>
							</tbody>
						</table>
						<?php
							$deliv_total_price += $date_total_price;
						}
						?>
						<?php
						/*
							<h5 class="date">3월 5일 (화)</h5>
							<table class="order_opt">
								<tbody>
									<tr>
										<th>주문내용</th>
										<td>초기6팩 set 3,600원 x 1 = 7,200원<br>
											초기12팩 set 3,600원 x 1 = 7,200원
										</td>
									</tr>
									<tr>
										<th>상품금액</th>
										<td><em class="price">14,400</em>원</td>
									</tr>
								</tbody>
							</table>

							<h5 class="date">3월 6일 (수)</h5>
							<table class="order_opt">
								<tbody>
									<tr>
										<th>주문내용</th>
										<td>초기12팩 set 3,600원 x 1 = 7,200원</td>
									</tr>
									<tr>
										<th>상품금액</th>
										<td><em class="price">7,200</em>원</td>
									</tr>
								</tbody>
							</table>
						*/
						?>
					</div>
					<!-- END 일자별 주문내용 -->

					<table class="order_opt">
						<tbody>
							<tr>
								<th>배송지</th>
								<td>
									<?php
									if($this->input->post('deliv_addr') == "self"){
									?>
									<td><?=$this->input->post('addr1')?> <?=$this->input->post('addr2')?></td>
									<?php
									}
									else{
									?>
									<td><?=$member_addr_key_arr[$this->input->post('deliv_addr')].$member_addr_arr[$this->input->post('deliv_addr')]?></td>
									<?php
									}
									?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- <div class="order_opt_tint">
					<table class="order_opt">
						<tbody>
							<tr>
								<th>간식추가</th>
								<td>이유식과 함께 간식을 챙겨주세요!</td>
							</tr>
						</tbody>
					</table>

					추가가능한 간식 리스트
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
					</div>
					END 추가가능한 간식 리스트

					선택한 간식
					<ul class="added_prod">

					</ul>END 선택한 간식

				</div> -->
				<div class="order_opt_light">
					<table class="order_opt price_tbl">
						<tbody>
							<tr class="total">
								<th>총상품금액
									<input type="hidden" name="add_recom_price" value="<?=$deliv_total_price?>">
								</th>
								<td><ins><?=number_format($deliv_total_price)?></ins>원</td>
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
									<?=number_format($deliv_total_price)?> 원
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
