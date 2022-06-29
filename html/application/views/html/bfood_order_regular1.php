<?
	if(!$this->input->get('recom_idx')){
		alert(cdir()."/dh/bfood_order_regular1/?recom_idx=2");
	}

	$PageName = "K02";
	$SubName = "K0201";
	include("../include/head.php");
	include("../include/header.php");
?>

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">

		function closeNumSelect(){
			$("#numSelect").hide();
		}

		function move_view(src){
			$(".view img").attr('src',src);
		}

		function loadScheduleDelivery(deliv_date){

			var delivery_week_day_count = $('input[name=delivery_week_day_count]:checked').val() || '';
			var delivery_week_type = $('input[name=delivery_week_type]:checked').val() || '';
			var delivery_week_type_key = $('input[name=delivery_week_type]:checked').data('delivery_week_type_key') || '';
			var delivery_week_count = $('input[name=delivery_week_count]:checked').val() || '';
			var delivery_sun_type = $('input[name=delivery_sun_type]:checked').val() || '';

			var delivery_date = "";
			if(deliv_date) delivery_date = deliv_date;
			else delivery_date = "";

			console.log('delivery_week_day_count : '+delivery_week_day_count);
			console.log('delivery_week_type : '+delivery_week_type);
			console.log('delivery_week_type_key : '+delivery_week_type_key);
			console.log('delivery_week_count : '+delivery_week_count);
			console.log('delivery_sun_type : '+delivery_sun_type);

			// 배송지 설정
			var deliv_addr = $("input[name='deliv_addr']:checked").val() || '';

			//배송지 입력값 유지
			var zipcode = $("input[name='zipcode']").val() || '';
			var addr1 = $("input[name='addr1']").val() || '';
			var addr2 = $("input[name='addr2']").val() || '';

			$("input[name='deliv_info_daytype']").val(delivery_week_type);

			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_schedule_delivery_item&recom_idx=<?=$recom_info->idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
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
					console.log(data);
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

						$("del.total_origin_price").text(data.price_info.total);
						$("em.set").text(data.price_info.pack_ea+"팩("+data.price_info.per+"%)");
						$("ins.real_price").text(data.price_info.price);

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
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_calendar&this_mon="+encodeURIComponent(month)+"&recom_idx=<?=$recom_info->idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
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
	<div id="container">
		<?include("../include/sub_top.php");?>
		<!-- 중간 아이콘 카테고리 -->
		<div class="mid_cate_wrap">
			<div class="inner">
				<ul class="mid_cate">
					<li <?if($this->input->get('recom_idx') == 2){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=2"><span class="icon i1"></span>
							<p class="tit"><em>5개월 전후</em>준비기</p>
						</a>
					</li>
					<li <?if($this->input->get('recom_idx') == 4){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=4"><span class="icon i2"></span>
							<p class="tit"><em>5~6개월</em>초기</p>
						</a>
					</li>
					<li <?if($this->input->get('recom_idx') == 5){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=5"><span class="icon i3"></span>
							<p class="tit"><em>7~8개월</em>중기</p>
						</a>
					</li>
					<li <?if($this->input->get('recom_idx') == 6){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=6"><span class="icon i4"></span>
							<p class="tit"><em>9~12개월</em>후기2식</p>
						</a>
					</li>
					<li <?if($this->input->get('recom_idx') == 1){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=1"><span class="icon i5"></span>
							<p class="tit"><em>9~12개월</em>후기3식</p>
						</a>
					</li>
					<li <?if($this->input->get('recom_idx') == 7){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=7"><span class="icon i6"></span>
							<p class="tit"><em>12개월~</em>완료기</p>
						</a>
					</li>
					<!-- <li <?if($this->input->get('recom_idx') == 3){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=3"><span class="icon i7"></span>
							<p class="tit"><em>반찬/국</em></p>
						</a>
					</li> -->
				</ul>
			</div>
		</div>
		<!-- END 중간 아이콘 카테고리 -->

		<?include("../include/cate_info.php");?>

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">

		<form method="post" name="recomfrm" id="recomfrm" action="<?=cdir()?>/dh/bfood_order_regular2">

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

					<?php
					//우측 메뉴 조건 설정 이후 ajax 를 통해서 json 으로 호출된 페이지를 표기함
					?>

					<div class="no-ct">
						우측에서 주문설정을 하시면,<br>
						메뉴가 자동으로 표시됩니다
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
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.schedule_delivery_info.php";
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
					<table class="order_opt price_tbl">
						<tbody>
							<tr>
								<th>총 상품금액</th>
								<td><del class="total_origin_price"></del>원</td>
							</tr>
							<tr class="total">
								<th>할인적용가</th>
								<td><em class="set"></em>
									<ins class="real_price"></ins>원
								</td>
							</tr>
						</tbody>
					</table>

					<input type="hidden" name="recom_idx" value="<?=$this->input->get('recom_idx')?>">
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
						<?php
						/*
						if(!$this->session->userdata('USERID')){
							?>
							<button type="button" class="plain" title="주문하기" onclick="alert('로그인 후 이용 가능합니다.');location.href='/html/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						else{
							?>
							<button type="button" class="plain" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						*/

						if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
							?>
							<button type="button" class="plain" title="주문하기" onclick="frmChk('recomfrm','regular_order_test')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						else{
							if($recom_overlap){
								?>
								<button type="button" class="plain" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
								<?php
							}
							else{
								?>
								<button type="button" class="plain" title="주문하기" onclick="alert('현재 장바구니에 정기식단 주문건이 있습니다.\n\n정기식단 2건이상 중복주문은 안되니,\n1건씩 장바구니에 담아 주문하시기 바랍니다.');location.href='/html/dh_order/shop_cart'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
								<?php
							}
						}
						?>
					</p>
				</div>
			</div><!-- END 선택 옵션영역 -->
		</form>
		</div><!-- END 주문옵션 WRAP -->
	</div><!--END Container-->

	<?include("../include/menu_detail.php");?>

<?include("../include/footer.php");?>
