<?
	$PageName = "SALE_PAY";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');

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

<div id="container" style="background-color:#F0F0f0">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab02.php");?>
	<h1 class="tit02">
		주문
	</h1>
	<!-- inner -->
	<form name="sendfrm" id="orderfrm" method="post" action="<?=cdir()?>/dh_order/recom_cart">

	<input type="hidden" name="sales_deliv_addr" value="<?=$this->input->post('deliv_addr')?>">
	<input type="hidden" name="sales_zipcode" value="<?=$this->input->post('zipcode')?>">
	<input type="hidden" name="sales_addr1" value="<?=$this->input->post('addr1')?>">
	<input type="hidden" name="sales_addr2" value="<?=$this->input->post('addr2')?>">
	<div class="inner pb50">
		<div class="box_01">

				<?php
				$menu_and_date = array();
				foreach($deliv_between_date as $dbd){
					$make_date = strtotime('-1 day',strtotime($dbd));
					foreach($result_prod_info as $k=>$v){

						$v_arr = explode(":",$v);
						$deliv_date = $v_arr[0];
						$goods_name = $v_arr[1];
						$goods_price = $v_arr[2];
						$goods_img = $v_arr[3];
						$goods_idx = $v_arr[4];
						$goods_orgin_price = $v_arr[5];

						if($deliv_date == $dbd){
							$menu_and_date[$dbd][$k]['goods_name'] = $goods_name;
							$menu_and_date[$dbd][$k]['goods_price'] = $goods_price;
							$menu_and_date[$dbd][$k]['goods_cnt'] = $prod_cnts[$k];
						}
					}
				}
				?>


			<?php
			$deliv_total_price = 0;
			foreach($menu_and_date as $date=>$values){
				$date_time = strtotime($date);
			?>
			<h2 class="tit03">
				[<?=date("m월 d일",$date_time)?> <?=numberToWeekname($date)?>요일]
			</h2>
			<div class="tblTy06">
				<table>
					<colgroup>
					<col width="30%">
					</colgroup>
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
					<tr style="display:none;">
						<th>배송지</th>
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
					</tr>
				</table>
			</div>
			<?php
				$deliv_total_price += $date_total_price;
			}
			?>
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
				</table>
			</div>
		</div>
		<ul class="tabMenu fp_tab">
			<li class="on">
				<a href="javascript:;">배송일정</a>
			</li>
			<li>
				<a href="javascript:;">메뉴와식단</a>
			</li>
		</ul>
		<div class="content_wrap fp">
			<div class="on">
				<div class="drawSchedule" id="start_delivery_cal">

						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
						?>

				</div>
			</div>
			<div class="pt20">

				<?php
				$menu_and_date = array();
				foreach($deliv_between_date as $dbd){
					$make_date = strtotime('-1 day',strtotime($dbd));
				?>
				<input type="hidden" name="sales_deliv_date[]" value="<?=strtotime($dbd)?>">
				<h3 class="tit08"><?=date("m월 d일",strtotime($dbd))?> (<?=numberToWeekname($dbd)?>)</h3>
				<ul class="sched_menu sched_menu02">
					<?php
					foreach($result_prod_info as $k=>$v){

						$v_arr = explode(":",$v);
						$deliv_date = $v_arr[0];
						$goods_name = $v_arr[1];
						$goods_price = $v_arr[2];
						$goods_img = $v_arr[3];
						$goods_idx = $v_arr[4];
						$goods_orgin_price = $v_arr[5];

						if($deliv_date == $dbd){
							$menu_and_date[$dbd][$k]['goods_name'] = $goods_name;
							$menu_and_date[$dbd][$k]['goods_price'] = $goods_price;
							$menu_and_date[$dbd][$k]['goods_cnt'] = $prod_cnts[$k];
						?>

						<li class="product <?=(($k+1)%3==0)?" mr0":"";?>">
							<div class="box">
								<div class="img">
									<img src="/_data/file/goodsImages/<?=$goods_img?>" alt="<?=$goods_name?>의 이미지" onerror="this.src='/image/default.jpg'">
								</div>
								<em class="tit"><?=$goods_name?></em>
								<input type="text" class="cnt" title="수량" value="<?=$prod_cnts[$k]?>" name="<?=strtotime($dbd)?>_sales_goods_cnt[]" readonly>
								<input type="hidden" name="<?=strtotime($dbd)?>_sales_goods_name[]" value="<?=$goods_name?>">
								<input type="hidden" name="<?=strtotime($dbd)?>_sales_goods_price[]" value="<?=$goods_price?>">
								<input type="hidden" name="<?=strtotime($dbd)?>_sales_goods_origin_price[]" value="<?=$goods_orgin_price?>">
								<input type="hidden" name="<?=strtotime($dbd)?>_sales_goods_idx[]" value="<?=$goods_idx?>">
							</div>
						</li>
						<?php
						}
					}
					?>
				</ul>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	</form>
	<!-- inner -->

	<!-- 하단 창 -->
	<div class="bottom_bar bottom_bar01">
		<a href="#" class="top_arw">
		<img src="/m/image/sub/bottom_arw.png" alt="" width="90px">
		<img src="/m/image/sub/arw02.jpg" alt="" class="arw">
		</a>
		<div class="bottm_inner">
			<div class="pay clearfix">
				<div class="fl">
					총 상품금액
					<input type="hidden" name="add_recom_price" value="<?=$deliv_total_price?>">
				</div>
				<div class="fr">
					<em><?=number_format($deliv_total_price)?></em>원
				</div>

				<div class="fl fz16"><!-- 추가 금액 (+) <input type="hidden" name="add_prod_update_price" value="0"> -->&nbsp;</div>
				<div class="fr add_prod_total"><!-- 0 원 -->&nbsp;</div>

				<div class="fl fz16"><!-- 총 계 -->&nbsp;</div>
				<div class="fr all_price"><!-- <?=number_format($deliv_total_price)?> 원 -->&nbsp;</div>
			</div>
		</div>
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
			  $(this).parent().css('bottom', '-95px');
				flag = 1;
			}
        })

		$('.tabMenu a').on('click',function(e){
			 e.preventDefault();
			 $(this).parent().addClass('on').siblings().removeClass('on');
			 n=$('.tabMenu a').index($(this));
			 $('.content_wrap > div').eq(n).addClass('on').siblings().removeClass('on');
		 })


	</script>

	<!-- //하단 창 -->

</div>

<!--END Container-->

<? include('../include/footer.php') ?>
