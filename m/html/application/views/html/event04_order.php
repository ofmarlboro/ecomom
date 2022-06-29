<?
	$PageName = "EVENT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript" src="/js/orderPage.js"></script>
<script>
	function loadScheduleDelivery(deliv_date){

		var delivery_week_day_count = $('input[name=delivery_week_day_count]:checked').val() || '';
		var delivery_week_type = $('input[name=delivery_week_type]:checked').val() || '';
		var delivery_week_type_key = $('input[name=delivery_week_type]:checked').data('delivery_week_type_key') || '';
		var delivery_week_count = $('input[name=delivery_week_count]:checked').val() || '';
		var delivery_sun_type = $('input[name=delivery_sun_type]:checked').val() || '';

		var delivery_date = "";
		if(deliv_date) delivery_date = deliv_date;
		else delivery_date = "";

		// 배송지 설정
		var deliv_addr = $("input[name='deliv_addr']:checked").val() || '';

		//배송지 입력값 유지
		var zipcode = $("input[name='zipcode']").val() || '';
		var addr1 = $("input[name='addr1']").val() || '';
		var addr2 = $("input[name='addr2']").val() || '';

		$("input[name='deliv_info_daytype']").val(delivery_week_type);

		$.ajax({
			type:"GET"
			,url:"<?=cdir()?>/dh/paper_coupon_order/?ajax=1&recom_idx=<?=$recom_idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
				"&delivery_week_type="+encodeURIComponent(delivery_week_type)+
				"&delivery_week_type_key="+delivery_week_type_key+
				"&delivery_week_count="+encodeURIComponent(delivery_week_count)+
				"&delivery_sun_type="+encodeURIComponent(delivery_sun_type)+
				"&zipcode="+zipcode+
				"&addr1="+encodeURIComponent(addr1)+
				"&addr2="+encodeURIComponent(addr2)+
				"&delivery_date="+encodeURIComponent(delivery_date)+
				"&deliv_addr="+encodeURIComponent(deliv_addr)
			,dataType:"json"
			,cache:false
			,success:function(data){
				$(".order_set").html(data.delivery_info);
				$(".selbox input[type='radio']").change(function(){
					loadScheduleDelivery(delivery_date);
				});
				$(".selbox input[type='radio']").click(function(){
					toggleSelBox();
				});

				$(".sched_menu_box").html(data.prod_list);

				if(data.prod_list){
					//$(".alrg_chk").show();

					if($(".alery_view").hasClass('on') === true){
						var text = $(".alery_view").text();
						$(".alery_view").text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");
					}

					$(".alery_view").removeClass("on");
					$(".alrg_list").removeClass("on");
					$(".alrg_img").hide();

					$(".allergy").prop('checked',false);
					$(".allergy").removeClass('on');

					//form value set
					$("input[name='recom_default_deliv_start_day']").val(data.recom_data.default_deliv_start_day);
					$("input[name='recom_deliv_addr']").val(data.recom_data.deliv_addr);
					$("input[name='recom_delivery_sun_type']").val(data.recom_data.delivery_sun_type);
					$("input[name='recom_delivery_week_count']").val(data.recom_data.delivery_week_count);
					$("input[name='recom_delivery_week_day_count']").val(data.recom_data.delivery_week_day_count);
					$("input[name='recom_delivery_week_type']").val(data.recom_data.delivery_week_type);

					$("input[name='recom_total_origin_price']").val(data.price_info.total);
					$("input[name='recom_pack_ea']").val(data.price_info.pack_ea);
					$("input[name='recom_per']").val(data.price_info.per);
					$("input[name='recom_price']").val(data.price_info.price);
				}

				if (browser != "unknown") {
					$(".sched_menu_box").perfectScrollbar('destroy');
					$(".sched_menu_box").perfectScrollbar();
					$(".sched_menu_box .ps__scrollbar-x-rail").css({bottom:0});
				}

				$("#start_delivery_cal").html(data.calendar_list);
				var calendar = $("#start_delivery_cal").css("display");
				if(calendar != "none"){
					$("#start_delivery_cal").hide();
				}

			}
			,complete:function(data){

				$(".minus").click(function(){	//제품수량 조절시 -
					var cnt = $(this).siblings("input.cnt").val();
					var code = $(this).siblings("input.cnt").data('delivdate');
					var cntval = $(this).siblings("input.cnt").data('lcnt');
					var code_cnt = $("input[name='chg_cnt_"+code+"']").val();
					var alg_cnt = $("input[name='alg_chg_cnt_"+code+"']").val();
					var orderless = $(".orderless_"+code);

					if($(this).parents(".product").hasClass('alrg') === true){
						if(cnt > 0){
							var real_cnt = parseInt(cnt)-1;
							$(this).siblings("input.cnt").val(real_cnt);
							if(real_cnt == 0){
								$(this).parents('li').addClass('except');
							}
							$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)-1);
							$("input[name='alg_chg_cnt_"+code+"']").val(parseInt(alg_cnt)+1);

							$(this).parents("div.box").next("div.change").hide();

						}else{
							//alert("수량은 0 이하로 설정할 수 없습니다.");
							layer_alert('이미 제외된 식단입니다.','','','','','');
							return;
						}

						if($("input[name='chg_cnt_"+code+"']").val() != $("input[name='stan_cnt_"+code+"']").val()){
							orderless.show();
						}
						else{
							orderless.hide();
						}
					}
					else{
						if(cnt > 1){
							var real_cnt = parseInt(cnt)-1;
							$(this).siblings("input.cnt").val(real_cnt);
							if(real_cnt == 0){
								$(this).parents('li').addClass('except');
							}
							$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)-1);
						}
						else{
							layer_alert('알레르기 해당 제품이 아닌 이유식은 제외하실 수 없습니다.','','','','','');
						}
					}

				});

				$(".plus").click(function(){	//제품수량 조절시 +
					var cnt = $(this).siblings("input.cnt").val();
					var code = $(this).siblings("input.cnt").data('delivdate');
					var cntval = $(this).siblings("input.cnt").data('lcnt');
					var code_cnt = $("input[name='chg_cnt_"+code+"']").val();
					var basic_cnt = $("input[name='stan_cnt_"+code+"']").val();
					var orderless = $(".orderless_"+code);

					if(basic_cnt == code_cnt){
						//alert("배송가능 갯수를 초과 할 수 없습니다.");
						layer_alert('알레르기 대체메뉴 주문수량은 각 메뉴당 최대 2개까지만 주문가능합니다<br><br>알레르기 체크 후 <img src="/m/image/sub/vol01.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 제외하고<br>대체메뉴를 <img src="/m/image/sub/vol02.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 추가하세요<br>주문날짜별 총 수량을 맞춰주세요','','','','','');
						return;
					}else{
						var real_cnt = parseInt(cnt)+1;
						if(real_cnt > 0){
							$(this).parents('li').removeClass('except');
						}

						if(real_cnt > 2){
							layer_alert('알레르기 대체메뉴 주문수량은 각 메뉴당 최대 2개까지만 주문가능합니다','','','','','');
							return;
						}
						else{
							$(this).siblings("input.cnt").val(real_cnt);
							$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)+1);

							$(this).parents("div.box").next("div.change").show();
						}
					}

					if($("input[name='chg_cnt_"+code+"']").val() != $("input[name='stan_cnt_"+code+"']").val()){
						orderless.show();
					}
					else{
						orderless.hide();
					}

				});

			}
			,error:function(xhr){
				//console.log(xhr);
			}
		});

	}

	function go_calendar_set(month){
		var delivery_week_day_count = $('input[name=delivery_week_day_count]:checked').val() || '';
		var delivery_week_type = $('input[name=delivery_week_type]:checked').val() || '';
		var delivery_week_count = $('input[name=delivery_week_count]:checked').val() || '';
		var delivery_sun_type = $('input[name=delivery_sun_type]:checked').val() || '';
		var delivery_start_date = $('div.sel_date em').text() || '';

		if(month){
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_calendar&this_mon="+encodeURIComponent(month)+"&recom_idx=<?=$recom_idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
				"&delivery_week_type="+encodeURIComponent(delivery_week_type)+
				"&delivery_week_count="+encodeURIComponent(delivery_week_count)+
				"&delivery_start_date="+encodeURIComponent(delivery_start_date)+
				"&delivery_sun_type="+encodeURIComponent(delivery_sun_type)
				,dataType:"json"
				,success:function(data){
					console.log(data);
					if(data.calendar_list){
						$("#start_delivery_cal").html(data.calendar_list);
					}
				}
				,error:function(xhr){
					//console.log(xhr.responseText);
				}
				,complete:function(){
					//$("#start_delivery_cal").toggle();
				}
			});
		}
		else{
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_calendar&recom_idx=<?=$recom_info->idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
				"&delivery_week_type="+encodeURIComponent(delivery_week_type)+
				"&delivery_week_count="+encodeURIComponent(delivery_week_count)+
				"&delivery_start_date="+encodeURIComponent(delivery_start_date)+
				"&delivery_sun_type="+encodeURIComponent(delivery_sun_type)
				,dataType:"json"
				,success:function(data){
					console.log(data);
					if(data.calendar_list){
						$("#start_delivery_cal").html(data.calendar_list);
					}
				}
				,error:function(xhr){
					//console.log(xhr.responseText);
				}
			});
		}
	}

	$(function(){

		$(".allergy").on("click",function(){
			if($(this).prop('checked'))
			{
				$(this).addClass('on');
			}
			else{
				$(this).removeClass('on');
			}
			//loadScheduleDelivery($("input[name='recom_default_deliv_start_day']").val());

			var alg1 = $("input[name='allergy13']:checked").val() || '';
			var alg2 = $("input[name='allergy12']:checked").val() || '';
			var alg3 = $("input[name='allergy1']:checked").val() || '';
			var alg4 = $("input[name='allergy2']:checked").val() || '';
			var alg5 = $("input[name='allergy6']:checked").val() || '';

			$.ajax({
				url:"<?=cdir()?>/dh_order/ajax_allergy/?alg1="+alg1+"&alg2="+alg2+"&alg3="+alg3+"&alg4="+alg4+"&alg5="+alg5+"&time=<?=time()?>",
				type:"GET",
				dataType:"json",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					if(data == ""){
						$(".product").removeClass("alrg");
						$(".alrg_mark").hide();
						//$(".algy_btn").hide();
						$(".alrg-minus").hide();
						$(".alrg-plus").hide();
					}
					else{
						if($(this).prop('checked')){
							for(d=0;d<data.length;d++){
								$(".product").each(function(){
									var allergy = $(this).data('allergy').split("^");
									for(i=0;i<allergy.length;i++){
										$(this).find(".alrg-minus").show();
										$(this).find(".alrg-plus").show();
										if(data[d] == allergy[i]){
											$(this).addClass('alrg');
											$(this).find(".alrg_mark").show();
											//$(".algy_btn").show();
											break;
										}
									}
								});
							}
						}
						else{
							$(".product").removeClass("alrg");
							$(".alrg_mark").hide();
							for(d=0;d<data.length;d++){
								$(".product").each(function(){
									var allergy = $(this).data('allergy').split("^");
									for(i=0;i<allergy.length;i++){
										$(this).find(".alrg-minus").show();
										$(this).find(".alrg-plus").show();
										if(data[d] == allergy[i]){
											$(this).addClass('alrg');
											$(this).find(".alrg_mark").show();
											//$(".algy_btn").show();
											break;
										}
									}
								});
							}
						}
					}
				},
				complete:function(){
					order_confirm = true;

					$(".product").each(function(){
						if($(this).hasClass("alrg") === false){
							order_confirm = false;
							return false;
						}
					});

					if(order_confirm){
						layer_alert('알레르기 대체메뉴가 더 이상 없습니다<br>낱개주문을 이용하세요','','','','','');
					}
				}
			});
		});

		$(".selbox input[type='radio']").click(function(){
			toggleSelBox();
			loadScheduleDelivery();
		});

		$(".alery_view").on('click',function(){

			var chk_deliv_addr = $("input[name='deliv_addr']:radio:checked").val();

			if(chk_deliv_addr == undefined){
				layer_alert('배송지를 선택해 주세요.','','','','','');
			}
			else{
				if($(this).hasClass("on") === true){
					if(confirm("알레르기로 메뉴변경한 내용이 초기화 됩니다. 메뉴를 원래대로 사용하시겠습니까?")){
						$(this).toggleClass("on");
						$(".alrg_list").toggleClass("on");
						$(".alrg_img").toggle();

						var text = $(this).text();
						$(this).text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");

						$(".allergy").removeClass('on');
						loadScheduleDelivery();
					}
				}
				else{
					$(this).toggleClass("on");
					$(".allergy").removeClass('on');
					$(".alrg_list").toggleClass("on");
					$(".alrg_img").toggle();
					var text = $(this).text();
					$(this).text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");
				}

			}
		});

	});

	function change_bomi(time,cnt){		//쌀보미로 변경
		$cval = $("#prod_"+time+"_"+cnt);
		var prod_value = $cval.val();
		$.ajax({
			url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=bomi_call&prod_value="+encodeURIComponent(prod_value),
			type:"GET",
			cache:false,
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){

				$cval.val(data.prod_value);
				$cval.parents(".product").data('allergy','');
				$cval.siblings('a').find('img').attr('src','/_data/file/goodsImages/'+data.prod_img);
				$cval.siblings("em.tit").text("A15. 쌀보미");
				var chg_btn = "<button type=\"button\" onclick=\"return_bomi('"+time+"','"+cnt+"')\">이전으로 변경</button>";
				$cval.parents("div.box").siblings("div.change").html(chg_btn);
				$cval.parent().data('goods_idx', '199');

				$cval.parents(".product").removeClass("alrg");
				$cval.siblings('a').find(".alrg_mark").hide();

			}
		});
	}

	function return_bomi(time,cnt){		//이전으로 변경
		$cval = $("#prod_"+time+"_"+cnt);
		var prod_value = $cval.val();
		var goods_idx = $cval.parents(".product").data('goods_idx');

		$.ajax({
			url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=bomi_return&prod_value="+encodeURIComponent(prod_value)+"&goods_idx="+goods_idx+"&time="+time+"&cnt="+cnt,
			type:"GET",
			cache:false,
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){

				$cval.val(data.prod_value);
				$cval.parents("li.product").data('allergy', data.allergy);
				$cval.siblings("a").find("img").attr("src","/_data/file/goodsImages/"+data.prod_img);
				$cval.siblings("em.tit").text(data.goods_name);
				$cval.parents("div.box").siblings("div.change").html(data.chg_btn);
				$cval.parent().data('goods_idx', data.goods_idx);

				//이전으로 변경시 알러지가 체크 되있는 경우
				var alg1 = $("input[name='allergy13']:checked").val() || '';
				var alg2 = $("input[name='allergy12']:checked").val() || '';
				var alg3 = $("input[name='allergy1']:checked").val() || '';
				var alg4 = $("input[name='allergy2']:checked").val() || '';
				var alg5 = $("input[name='allergy6']:checked").val() || '';

				var alg_arr = [];

				if(alg1){ alg_arr.push(alg1); }
				if(alg2){ alg_arr.push(alg2); }
				if(alg3){ alg_arr.push(alg3); }
				if(alg4){ alg_arr.push(alg4); }
				if(alg5){ alg_arr.push(alg5); }

				//console.log(alg_arr);

				var alg = data.allergy.split("^");
				for(i=0;i<alg.length;i++){
					if(alg_arr.indexOf(alg[i]) >= 0){
						$cval.parents(".product").addClass("alrg");
						$cval.siblings('a').find(".alrg_mark").show();
						break;
					}
				}


			}
		});
	}
</script>


<!--Container-->

<style type="text/css">
	iframe{
		width: 100%;
	}
</style>

<div id="container">
	<?include("../include/top_menu.php");?>
	<div class="inner">
		<div class="coupon__order">
			<span>[<?=$recom_name?> <?=$delivery_week_count?>주]쿠폰</span>입니다. <br />
			배송요일, 배송지, 첫 배송일을 선택해주세요.
		</div>
	</div>
	<!-- inner -->

	<form method="post" name="recomfrm" id="recomfrm" action="<?=cdir()?>/dh/event04_order_ing" autocomplete="off">
		<input type="hidden" name="goods_name" value="[상품권주문]<?=$recom_name?> <?=$delivery_week_count?>주">
		<input type="hidden" name="step_code" value="<?=$step_code?>">
		<input type="hidden" name="coupon_code" value="<?=$this->input->post('coupon_code')?>">
		<input type="hidden" name="recom_idx" value="<?=$recom_idx?>">
		<input type="hidden" name="recom_default_deliv_start_day">
		<input type="hidden" name="recom_delivery_week_day_count">
		<input type="hidden" name="recom_delivery_week_count">
		<input type="hidden" name="recom_delivery_week_type">
		<input type="hidden" name="recom_delivery_sun_type">
		<input type="hidden" name="recom_total_origin_price">
		<input type="hidden" name="recom_pack_ea">
		<input type="hidden" name="recom_per">
		<input type="hidden" name="recom_price">
		<!-- 하단 창 -->
		<div class="">
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<div class="order_set">
						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.coupon.deliv.info.php";
						?>
					</div>
					<!-- //order_set -->
					<!-- 첫 배송일 선택 달력 -->
					<!--
							흐린색, 선택불가능한 날짜 : td.dimmed
							정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
							배송시작일 : start_deliv
						-->

					<div class="cal_wrap" id="start_delivery_cal">

					</div>
					<!-- END 첫 배송일 선택 달력 -->
				</div>
				<!-- //order_opt_tint -->

				<p class="ml15 mt10">
					<img src="/m/image/sub/order_menu.jpg" alt="" width="62px">
					<span class="no-ct" style="font-weight:500;color:#989898;display:block;font-size: 11px;margin-top: -5px;letter-spacing: -0.5px;">
						(상단에서 주문설정을 하시면,
						메뉴가 자동으로 표시됩니다)
					</span>
				</p>

				<!-- 알레르기체크+메뉴 선택 -->
				<div class="order_sched_wrap">
					<!-- 알레르기 체크 -->
					<div class="alrg_chk float-wrap" style="display:none;">
						<?php
						if($this->input->get('recom_idx')!="3"){
						?>
						<p class="tit"><a href="javascript:;" class="alery_view">알레르기 체크</a></p>
						<?php
						}
						?>
						<div class="alrg_img" style="display:none;"><img src="/m/image/sub/order_03.jpg" alt="" width="200px" style="margin-left: 10px;"></div>
						<ul class="alrg_list">
							<?php
							foreach($allergy_arr as $key => $val){
							?>
							<li><input type="checkbox" id="alrg<?=$key?>" value="<?=$key?>" class="allergy" name="allergy<?=$key?>"><label for="alrg<?=$key?>"><?=$val?></label></li>
							<?php
							}
							?>
						</ul>
					</div>
					<!-- //알레르기 체크 -->

					<!-- 메뉴 선택 -->
					<div class="sched_menu_box ps ps--theme_default ps--active-y" data-ps-id="5ce20253-2127-3b87-3be7-4276acf212ac">

					</div>
					<!-- //메뉴 선택 -->
				</div>
				<!-- //알레르기체크+메뉴 선택 -->
				<div class="mg50"></div>
				<input type="hidden" name="recom_deliv_addr" msg="배송지를 선택해 주세요.">
				<input type="hidden" name="deliv_info_daytype">
			</div>
			<!-- //order_opt_wrap -->
		</div>
  </form>
  <!-- //하단창 -->

  <div class="last_one">
		<p class="align-c">
			<button type="button" class="plain orderbtn" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
		</p>
  </div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
