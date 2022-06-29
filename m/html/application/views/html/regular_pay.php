<?
	$deliv_between_date = $this->input->post('recom_delivery_detail_date');
	$delivery_detail_prod = $this->input->post('recom_delivery_detail_prod');
	$delivery_detail_sunday_prod = $this->input->post('recom_delivery_detail_sunday_prod');
	$recom_delivery_week_type_arr = $this->input->post('recom_delivery_week_type');
	$delivery_week_day_count = $this->input->post('recom_delivery_week_day_count');
	$delivery_week_type_key = $this->input->post('delivery_week_type_key');

	$PageName = "REGULAR_PAY";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<script type="text/javascript" src="/js/orderPage.js"></script>

	<script type="text/javascript">
		function deliv_calendar_set(this_mon){

			var between_date = '<?=serialize($deliv_between_date)?>';

			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_result_calendar&deliv_between_date="+encodeURIComponent(between_date)+"&this_mon="+encodeURIComponent(this_mon)
				,dataType:"json"
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
	</script>

<!--Container-->

<div id="container" style="background-color:#F0F0f0">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab02.php");?>
	<h1 class="tit02">
		주문
	</h1>
	<!-- inner -->

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

	<div class="inner pb50">
		<div class="box_01">
			<div class="tblTy06">
				<table>
					<colgroup>
					<col width="30%">
					</colgroup>
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
						<th>배송기간</th>
						<td><?=$deliv_between_date[0]?> ~ <?=$deliv_between_date[count($deliv_between_date)-1]?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="box_01 hidden">
			<div class="tblTy06">
				<table>
					<colgroup>
					<col width="30%">
					</colgroup>
					<tr>
						<th>간식추가</th>
						<td>이유식과 함께 간식을 챙겨주세요!</td>
					</tr>
				</table>
			</div>

			<div class="des_slide">

				<?php
				if($gansik){
					foreach($gansik as $gs){
					?>
					<div class="item">
						<img src="/_data/file/goodsImages/<?=$gs->list_img?>" alt="" onerror="this.src='/image/default.jpg'" onclick="add_gansik('<?=$gs->idx?>')">
						<p><?=$gs->name?></p>
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
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
					<div class="item">
						<img src="/m/image/sub/001.jpg" alt="">
						<p>상품명01</p>
					</div>
				*/
				?>
			</div>
			<div class="tblTy04">
				<table>
					<colgroup>
					<col width="">
					<col width="">
					<col width="">
					<col width="18px">
					</colgroup>
					<tbody class="added_prod">

					</tbody>
					<?php
					/*
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					*/
					?>
				</table>
			</div>
		</div>

		<?php
		$show_holiinfo = false;

		foreach($deliv_between_date as $shi){
			if(in_array($shi,$holiday_arr)){
				$show_holiinfo = true;
			}
		}

		if($show_holiinfo){
		?>
		<div class="y_bg">
			<p class="tit"><img src="/m/image/sub/ng.png" alt="" class="img-mid mr5" style="height:18px;">[배송휴무일]은 배송되지 않으니 변경하세요</p>
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
					<span><strong>[마이페이지 > 메뉴/배송지/배송일변경]</strong></span>을 이용하세요.<br>
					배송일기준 <span><strong>D-2일전 PM 24:00</strong></span>까지만 변경가능합니다.
				</p>
			</div>
		</div>
		<?php
		}
		?>

		<ul class="tabMenu fp_tab">
			<li class="on">
				<a href="#">배송일정</a>
			</li>
			<li>
				<a href="#">메뉴와식단</a>
			</li>
		</ul>

		<div class="content_wrap fp">
			<div class="on">
				<div class="drawSchedule" id="start_delivery_cal">
					<?php
					include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
					?>
					<?php
					/*
						<div class="date_view">
							<span class="year">2017</span>년 <span class="month">04</span>월
							<a href="#" class="pre" title="이전">이전</a>
							<a href="#" class="next" title="다음">다음</a>
						</div>
						<div class="inner">
							<table>
								<colgroup>
								<col style="width:15%">
								<col style="width:14%">
								<col style="width:14%">
								<col style="width:14%">
								<col style="width:14%">
								<col style="width:14%">
								<col style="width:15%">
								</colgroup>
								<thead>
									<tr>
										<th scope="col" >일</th>
										<th scope="col">월</th>
										<th scope="col">화</th>
										<th scope="col">수</th>
										<th scope="col">목</th>
										<th scope="col">금</th>
										<th scope="col" >토</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="gray"><a href="">29</a></td>
										<td class="gray"><a href="">30</a></td>
										<td><a href="#" class="check">1</a></td>
										<td><a href="">2</a></td>
										<td><a href="">3</a></td>
										<td><a href="">4</a></td>
										<td ><a href="">5</a></td>
									</tr>
									<tr>
										<td ><a href="">6</a></td>
										<td><a href="">7</a></td>
										<td><a href="">8</a></td>
										<td><a href="#" class="check">9</a></td>
										<td><a href="#" class="check">10</a></td>
										<td><a href="">11</a></td>
										<td ><a href="">12</a></td>
									</tr>
									<tr>
										<td ><a href="">13</a></td>
										<td><a href="">14</a></td>
										<td><a href="">15</a></td>
										<td><a href="" class="today">16</a></td>
										<td><a href="">17</a></td>
										<td><a href="">18</a></td>
										<td ><a href="">19</a></td>
									</tr>
									<tr>
										<td ><a href="">20</a></td>
										<td><a href="">21</a></td>
										<td><a href="">22</a></td>
										<td><a href="">23</a></td>
										<td><a href="">24</a></td>
										<td><a href="">25</a></td>
										<td ><a href="">26</a></td>
									</tr>
									<tr>
										<td ><a href="">27</a></td>
										<td><a href="">28</a></td>
										<td><a href="">29</a></td>
										<td><a href="">30</a></td>
										<td><a href="">31</a></td>
										<td class="gray"><a href="">1</a></td>
										<td class="gray"><a href="">2</a></td>
									</tr>
									<tr>
										<td class="gray"><a href="">3</a></td>
										<td class="gray"><a href="">4</a></td>
										<td class="gray"><a href="">5</a></td>
										<td class="gray"><a href="">6</a></td>
										<td class="gray"><a href="">7</a></td>
										<td class="gray"><a href="">8</a></td>
										<td class="gray"><a href="">9</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					*/
					?>
				</div>
			</div>
			<div class="pt20">

				<?php
				$sunday_cnt = 0;
				foreach($deliv_between_date as $dbd){
					$standard_cnt = $food_info[$delivery_week_day_count]['delivery_week_type'][$delivery_week_type_key]['count'][$week_name_arr[date("w",strtotime($dbd))]];
					?>
					<h3 class="tit08"><?=date("m월 d일",strtotime($dbd))?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>)</h3>

					<input type="hidden" name="recom_delivery_detail_date[]" value="<?=strtotime($dbd)?>">

					<input type="hidden" name="stan_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>">
					<input type="hidden" name="chg_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>" passwd_match="<?=date("Y년 m월 d일",strtotime($dbd))?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>) 날짜에 배송 받을 상품 갯수가 일치 하지 않습니다." matching_name="stan_cnt_<?=strtotime($dbd)?>">
					<input type="hidden" name="alg_chg_cnt_<?=strtotime($dbd)?>" value="<?=$this->input->post('alg_chg_cnt_'.strtotime($dbd))?>">

					<ul class="sched_menu sched_menu02">
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
										<li class="<?=($sunday)?"sunday":"";?><?=($pcnt%3==0)?" mr0":"";?><?=($prod_cnt_arr[$prod_cnt_key] > 0)?"":" except";?>">
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
												<input type="hidden" name="<?=strtotime($deliv_date)?>_goods_idx[]" value="<?=$goods_idx?>">
												<input type="hidden" name="<?=strtotime($deliv_date)?>_sunday[]" value="<?=$sunday?>">

												<input type="text" class="cnt" title="수량" value="<?=($prod_cnt_arr[$prod_cnt_key])?$prod_cnt_arr[$prod_cnt_key]:"0";?>" name="<?=strtotime($deliv_date)?>_prod_cnt[]" data-delivdate="<?=strtotime($dbd)?>" readonly>
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
					<h3 class="tit08">3월 6일 (화)</h3>
					<ul class="sched_menu sched_menu02">
						<li class="product">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/11c6a03435ccc648f6efc0f904e33ba7.jpg" alt="준비기 이유식 6의 이미지">
								</div>
								<em class="tit">준비기 이유식 6</em>
							</div>
						</li>
						<li class="product">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/11c6a03435ccc648f6efc0f904e33ba7.jpg" alt="준비기 이유식 6의 이미지">
								</div>
								<em class="tit">준비기 이유식 6</em>
							</div>
						</li>
						<li class="product mr0 except">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/361b645b37f1ad6bfeb8cdf830ba357e.jpg" alt="준비기 이유식 8의 이미지">
								</div>
								<em class="tit">준비기 이유식 8</em>
							</div>
						</li>
					</ul>

					<h3 class="tit08">3월 6일 (화)</h3>
					<ul class="sched_menu sched_menu02">
						<li class="product">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/11c6a03435ccc648f6efc0f904e33ba7.jpg" alt="준비기 이유식 6의 이미지">
								</div>
								<em class="tit">준비기 이유식 6</em>
							</div>
						</li>
						<li class="product">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/11c6a03435ccc648f6efc0f904e33ba7.jpg" alt="준비기 이유식 6의 이미지">
								</div>
								<em class="tit">준비기 이유식 6</em>
							</div>
						</li>
						<li class="product mr0 except">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/361b645b37f1ad6bfeb8cdf830ba357e.jpg" alt="준비기 이유식 8의 이미지">
								</div>
								<em class="tit">준비기 이유식 8</em>
							</div>
						</li>
					</ul>
				*/
				?>
			</div>
		</div>
	</div>
	<!-- inner -->

	<!-- 하단 창 -->
	<div class="bottom_bar bottom_bar03">
		<a href="#" class="top_arw">
		<img src="/m/image/sub/bottom_arw.png" alt="" width="90px">
		<img src="/m/image/sub/arw02.jpg" alt="" class="arw">
		</a>
		<div class="bottm_inner">
			<div class="pay clearfix">
				<div class="fl fz16">
					총 상품금액
				</div>
				<div class="fr thr">
					<span class="fz20"><?=$this->input->post('recom_total_origin_price')?></span>원
				</div>
				<div class="fl fz16">
					할인 금액
				</div>
				<div class="fr orange">
					<span class="fz12">(<?=$this->input->post('recom_per')?>% 할인)</span><span class="fz20"><?=number_format(str_replace(",","",$this->input->post('recom_total_origin_price')) - str_replace(",","",$this->input->post('recom_price')))?></span>원
				</div>
				<div class="fl fz16">
					할인 적용가
					<input type="hidden" name="add_recom_price" value="<?=str_replace(",","",$this->input->post('recom_price'))?>">
				</div>
				<div class="fr">
					<span class="fz20"><?=$this->input->post('recom_price')?></span>원
				</div>

				<!-- <div class="fl fz16">추가 금액 (+) <input type="hidden" name="add_prod_update_price" value="0"></div>
				<div class="fr add_prod_total"><span class="fz20">0</span>원</div> -->
				<div class="fl fz16">&nbsp;</div>
				<div class="fr add_prod_total">&nbsp;</div>

				<div class="fl">총 계</div>
				<div class="fr all_price"><em><?=$this->input->post('recom_price')?></em>원</div>
			</div>
		</div>

	</div>

	</form>

	<script>
		jQuery(document).ready(function($){
			$(".des_slide").slick({
				autoplay:true,
				slidesToShow:5,
				autoplaySpeed: 7000,
				responsive: [{
					breakpoint:400,
					settings:{
						slidesToShow:3
					}
				}]
			});
		});

		var flag = null;
		$('.top_arw').on('click',function(e){
			e.preventDefault();
			if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
				$(this).parent().css('bottom', '0');
				flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
				$(this).parent().css('bottom', '-172px');
				flag = 1;
			}
		});

		$('.tabMenu a').on('click',function(e){
			e.preventDefault();
			$(this).parent().addClass('on').siblings().removeClass('on');
			n=$('.tabMenu a').index($(this));
			$('.content_wrap > div').eq(n).addClass('on').siblings().removeClass('on');
		});
	</script>

	<!-- //하단 창 -->


<div class="last_one01">
<ul class="clearfix pay_wrap">
			<li class="back">
				<a href="javascript:history.go(-1);"><img src="/m/image/sub/back.jpg" alt=""></a>
			</li>
			<li class="pay_btn">
				<a href="javascript:;" onclick="frmChk('orderfrm')"><img src="/m/image/sub/pay.jpg" alt=""></a>
			</li>
			<!-- <li class="naver_pay">
				<a href="javascript:;"><img src="/m/image/sub/n_pay.jpg" alt=""></a>
			</li> -->
		</ul>

</div>
</div>

<!--END Container-->

<? include('../include/footer.php') ?>
