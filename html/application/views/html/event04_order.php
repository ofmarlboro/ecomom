<?
if(!$this->session->userdata('USERID')){
	alert(cdir()."/dh_member/login?go_url=".$_SERVER['REDIRECT_URL'],"로그인 후 이용 가능합니다.");
}

	$PageName = "K07";
	$SubName = "K0705";
	include("../include/head.php");
	include("../include/header.php");
?>
<!--Container-->
<div id="container">
	<?include("../include/sub_top.php");?>
	<div class="inner ac pt60">
		<div class="coupon__order">
			<span>[<?=$recom_name?> <?=$delivery_week_count?>주]</span> 주문하실 수 있습니다.
		</div>
	</div>

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">
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
					$(".order_set").html(data.delivery_info);	//설정부분 ( 수량 주기 요일 )
					$(".selbox input[type='radio']").change(function(){	//설정 부분 변경시
						loadScheduleDelivery(delivery_date);
					});
					$(".selbox input[type='radio']").click(function(){	//설정 부분 클릭시
						toggleSelBox();
					});

					$(".sched_menu_box").html(data.prod_list);	//제품리스트

					if(data.prod_list){	//제품 리스트 로드 완료 시
						//$(".alrg_chk").show();

						if($(".alery_view").hasClass('on') === true){
							var text = $(".alery_view").text();
							$(".alery_view").text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");
						}

						$(".alery_view").removeClass("on");
						$(".alrg_chk").removeClass("on");

						$(".allergy").prop('checked',false);
						$(".allergy").removeClass('on');
						$(".info").show();

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


					if (browser != "unknown") {	//퍼펙트스크롤 플러그인
						$(".sched_menu_box").perfectScrollbar('destroy');
						$(".sched_menu_box").perfectScrollbar();
						$(".sched_menu_box .ps__scrollbar-x-rail").css({bottom:0});
					}

					$("#start_delivery_cal").html(data.calendar_list);	//배송일 달력
					var calendar = $("#start_delivery_cal").css("display");
					if(calendar != "none"){
						$("#start_delivery_cal").hide();
					}
				}
				,complete:function(data){

					$(".product .inbox_goodsview").on('click',function(){
						menuView($(this).data('goods_idx'));
					}).css('cursor','pointer');

					$(".minus").click(function(){	//제품수량 조절시 -
						var cnt = $(this).siblings("input.cnt").val();
						var code = $(this).siblings("input.cnt").data('delivdate');
						var cntval = $(this).siblings("input.cnt").data('lcnt');
						var code_cnt = $("input[name='chg_cnt_"+code+"']").val();
						var alg_cnt = $("input[name='alg_chg_cnt_"+code+"']").val();	//오더지개선 추가
						var orderless = $(".orderless_"+code);

						if($(this).parents(".product").hasClass('alrg') === true){
							if(cnt > 0){
								var real_cnt = parseInt(cnt)-1;
								$(this).siblings("input.cnt").val(real_cnt);
								if(real_cnt == 0){
									$(this).parents('li').addClass('except');
								}
								$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)-1);
								$("input[name='alg_chg_cnt_"+code+"']").val(parseInt(alg_cnt)+1);	//오더지개선 추가

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
								layer_alert('알레르기 해당제품이 아닌 이유식은 영양식단에선 제외할 수 없습니다.<br><br>꼭 제외해야할 경우, 낱개주문을 이용하세요','','','','','');
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
							//alert("알레르기 체크 후 -버튼으로 제외하고\n대체메뉴를 +버튼으로 추가하세요\n주문날짜별 총 메뉴 수량을 맞춰주세요");
							layer_alert('알레르기 대체메뉴 주문수량은 각 메뉴당 최대 2개까지만 주문가능합니다<br><br>알레르기 체크 후 <img src="/m/image/sub/vol01.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 제외하고<br>대체메뉴를 <img src="/m/image/sub/vol02.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 추가하세요<br>주문날짜별 총 수량을 맞춰주세요','','','','','');
							return;
						}else{
							var real_cnt = parseInt(cnt)+1;
							if(real_cnt > 0){
								$(this).parents('li').removeClass('except');
							}

							if(real_cnt > 2){
								//alert("알레르기 대체메뉴 주문수량은 각 메뉴당 최대 2개까지만 주문가능합니다");
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

					//console.log($(".sched_menu_box").html());

				}
				,error:function(xhr){
					console.log(xhr.responseText);
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
					,cache:false
					,success:function(data){
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
					,cache:false
					,success:function(data){
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
												//continue;
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
												//continue;
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
							$(".alrg_chk").toggleClass("on");

							var text = $(this).text();
							$(this).text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");

							loadScheduleDelivery();
						}
					}
					else{
						$(this).toggleClass("on");
						$(".alrg_chk").toggleClass("on");
						var text = $(this).text();
						$(this).text(text == "알레르기 체크" ? "초기화" : "알레르기 체크");
					}
				}
			});
		});
	</script>

	<!-- 주문옵션 WRAP -->
	<div class="inner order_wrap">
		<form method="post" name="recomfrm" id="recomfrm" action="<?=cdir()?>/dh/event04_order_ing">
			<input type="hidden" name="goods_name" value="[상품권주문]<?=$recom_name?> <?=$delivery_week_count?>주">
			<input type="hidden" name="step_code" value="<?=$step_code?>">
			<input type="hidden" name="coupon_code" value="<?=$this->input->post('coupon_code')?>">
			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<!-- 안내 -->
				<div class="info" style="display:none;">
					<span class="float-r">
						<button type="button" class="plain" onclick="menuPop('<?=$this->input->get('recom_idx')?>');"><img src="/image/sub/btn_sched.png" alt="식단표 보기"></button>
					</span>
					<?php
					if($this->input->get('recom_idx')!="3"){
					?>
					<p class="tit float-r"> <a class="alery_view" href="javascript:;">알레르기 체크</a></p>
					<?php
					}
					?>
				</div><!-- END 안내 -->

				<!-- 알러지 선택 -->
				<div class="alrg_chk float-wrap"><!-- default css는 display:none으로 해놨고 클래스 on 가질때 block 시켜놨습니다 -->
					<p class="tit01">
						<img src="/image/sub/btn_minus1.png" alt="-" class="img-mid mr5">
						<img src="/image/sub/btn_plus1.png" alt="+" class="img-mid mr10">
						버튼으로 메뉴 대체가 가능해요
					</p>

					<ul class="alrg_list">
						<?php
						foreach($allergy_arr as $key => $val){
						?>
						<li><input type="checkbox" id="alrg<?=$key?>" value="<?=$key?>" class="allergy" name="allergy<?=$key?>"><label for="alrg<?=$key?>"><?=$val?></label></li>
						<?php
						}
						?>
					</ul>
				</div><!-- END 알러지 선택 -->

				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box">
					<div class="no-ct">
						우측 배송요일을 선택 하시면 메뉴가 표시됩니다
					</div>
				</div>
				<!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 제품 / 주문설정 경계 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<div class="order_set">
						<?php
						//추천식단 주문 설정 값
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.coupon.deliv.info.php";
						?>
					</div>

					<div class="cal_wrap mt15" id="start_delivery_cal" style="display:none;">
						<?php
						//include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.calendar.php";
						?>
					</div>
					<!-- END 첫 배송일 선택 달력 -->
				</div>
				<div class="order_opt_light">

					<input type="hidden" name="recom_idx" value="<?=$recom_idx?>">
					<input type="hidden" name="recom_delivery_week_day_count" >
					<input type="hidden" name="recom_delivery_week_type" msg="받으실 요일을 선택하세요.">
					<input type="hidden" name="recom_delivery_week_count" msg="1주~4주 배송받을기간을 선택하세요.">
					<input type="hidden" name="recom_default_deliv_start_day">
					<!-- <input type="hidden" name="login_check" value="<?=$this->session->userdata('USERID')?>" msg="로그인 후 이용 가능합니다."> -->
					<input type="hidden" name="recom_delivery_sun_type">
					<input type="hidden" name="recom_total_origin_price">
					<input type="hidden" name="recom_pack_ea">
					<input type="hidden" name="recom_per">
					<input type="hidden" name="recom_price">
					<input type="hidden" name="recom_deliv_addr" msg="배송지를 선택해 주세요.">

					<input type="hidden" name="deliv_info_daytype">

					<p class="align-c mt20 mb5">
						<button type="button" class="plain" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
					</p>
				</div>
			</div><!-- END 선택 옵션영역 -->
		</form>
	</div><!-- END 주문옵션 WRAP -->
</div>
<!--END Container-->



<?include("../include/footer.php");?>
