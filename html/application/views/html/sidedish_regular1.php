<?
	if(!$this->input->get('recom_idx')){
		alert(cdir()."/dh/sidedish_regular1/?recom_idx=3");
	}
	$PageName = "K03";
	$SubName = "K0301";
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

			// 배송지 설정
			var deliv_addr = $("input[name='deliv_addr']:checked").val() || '';

			//배송지 입력값 유지
			var zipcode = $("input[name='zipcode']").val() || '';
			var addr1 = $("input[name='addr1']").val() || '';
			var addr2 = $("input[name='addr2']").val() || '';

			//if(delivery_week_day_count && delivery_week_type && delivery_week_type_key && delivery_week_count){

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
						$(".order_set").html(data.delivery_info);	//설정부분 ( 수량 주기 요일 )
						$(".selbox input[type='radio']").change(function(){	//설정 부분 변경시
							loadScheduleDelivery(delivery_date);
						});
						$(".selbox input[type='radio']").click(function(){	//설정 부분 클릭시
							toggleSelBox();
							//loadScheduleDelivery(delivery_date);
						});

						$(".sched_menu_box").html(data.prod_list);	//제품리스트

						if(data.prod_list){	//제품 리스트 로드 완료 시
							//$(".alrg_chk").show();

							$(".alery_view").removeClass("on");
							$(".alrg_chk").removeClass("on");

							$(".allergy").prop('checked',false);
							$(".allergy").removeClass('on');
							$(".info").show();

							$("del.total_origin_price").text(data.price_info.total);
							$("em.set").text(data.price_info.pack_ea+"세트("+data.price_info.per+"%)");
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
							var orderless = $(".orderless_"+code);

							if(cnt > 0){
								var real_cnt = parseInt(cnt)-1;
								$(this).siblings("input.cnt").val(real_cnt);
								if(real_cnt == 0){
									$(this).parents('li').addClass('except');
								}
								$("input[name='chg_cnt_"+code+"']").val(parseInt(code_cnt)-1);

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
								layer_alert('알레르기 체크 후 <img src="/m/image/sub/vol01.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 제외하고<br>대체메뉴를 <img src="/m/image/sub/vol02.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼으로 추가하세요<br>주문날짜별 총 메뉴 수량을 맞춰주세요','','','','','');
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

			if(month){
				$.ajax({
					type:"GET"
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_calendar&this_mon="+encodeURIComponent(month)+"&recom_idx=<?=$recom_info->idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
					"&delivery_week_type="+encodeURIComponent(delivery_week_type)+
					"&delivery_week_count="+encodeURIComponent(delivery_week_count)+
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
						console.log(data);
						if(data == ""){
							$(".product").removeClass("alrg");
							$(".alrg_mark").hide();
							$(".algy_btn").hide();
						}
						else{
							if($(this).prop('checked')){
								for(d=0;d<data.length;d++){
									$(".product").each(function(){
										var allergy = $(this).data('allergy').split("^");
										for(i=0;i<allergy.length;i++){
											if(data[d] == allergy[i]){
												$(this).addClass('alrg');
												$(this).find(".alrg_mark").show();
												$(".algy_btn").show();
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
											if(data[d] == allergy[i]){
												$(this).addClass('alrg');
												$(this).find(".alrg_mark").show();
												$(".algy_btn").show();
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
				//loadScheduleDelivery($("input[name='recom_default_deliv_start_day']").val());
			});


			$(".alery_view").on('click',function(){

				var chk_deliv_addr = $("input[name='deliv_addr']:radio:checked").val();

				//console.log(chk_deliv_addr);

				if(chk_deliv_addr == undefined){
					layer_alert('배송지를 선택해 주세요.','','','','','');
				}
				else{
					$(this).toggleClass("on",function(){
						if($(this).hasClass("on") === false){
							loadScheduleDelivery();
						}
					});
					$(".alrg_chk").toggleClass("on");
				}
			});

		});

		$(window).load(function(){
			//$(".alrg_chk").hide();
			//loadScheduleDelivery();
		});


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
					<li <?if($this->input->get('recom_idx') == 3){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_regular1/?recom_idx=3"><span class="icon i7"></span>
							<p class="tit"><em>반찬/국</em></p>
						</a>
					</li>
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
						<!-- <li><input type="checkbox" id="alrg1" class="on" checked><label for="alrg1">소고기</label></li>
						<li><input type="checkbox" id="alrg2"><label for="alrg2">닭고기</label></li>
						<li><input type="checkbox" id="alrg3"><label for="alrg3">달걀</label></li>
						<li><input type="checkbox" id="alrg4"><label for="alrg4">우유</label></li>
						<li><input type="checkbox" id="alrg5"><label for="alrg5">콩</label></li> -->
					</ul>
				</div><!-- END 알러지 선택 -->

				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box">

					<div class="no-ct">
						우측에서 주문설정을 하시면,<br>
						메뉴가 자동으로 표시됩니다
					</div>

				<?php
				/*
					<h5 class="htit">3월 7일 (수)</h5>
					<!--
						*3n개째 li.mr0
						*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
						*제외됐을 때 li.except
						*일요일추가분 li.sunday
					-->
					<ul class="sched_menu">
						<li class="alrg sunday"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
								<span class="added">일요일 추가분</span>
							</div>
						</li>
						<li class="sunday"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>

								<span class="added">일요일 추가분</span>
							</div>
						</li>
						<li class="mr0"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
					</ul>

					<h5 class="htit">3월 8일 (수)</h5>
					<ul class="sched_menu">
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li class="except alrg sunday"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
									<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>

								<span class="added">일요일 추가분</span>
							</div>
						</li>
						<li class="mr0"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
					</ul>

					<h5 class="htit">3월 9일 (목)</h5>
					<ul class="sched_menu">
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li class="mr0"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
					</ul>

					<h5 class="htit">3월 10일 (금)</h5>
					<ul class="sched_menu">
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li class="mr0"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
					</ul>

					<h5 class="htit">3월 11일 (토)</h5>
					<ul class="sched_menu">
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
						<li class="mr0"><div class="box">
								<a href="#" class="link_dt" title="상세보기">
									<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
								</a>
								<em class="tit">A09. 한우보미</em>

								<input type="text" class="cnt" title="수량" value="1">

								<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
								<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
							</div>
						</li>
					</ul>
				*/
				?>
				</div>
				<!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 제품 / 주문설정 경계 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<?php
					/*
						<table class="order_opt">
							<tbody>
								<tr>
									<th>1주 이유식수량</th>
									<td>
										<div class="selbox">
											<button type="button" onclick="toggleSelBox(this, event);"><span class="week_day_count_span">7일분(21팩)</span></button>
											<ul>
												<?php

												$i = 0;
												$search_idx = 0;
												$search_count = 0;

												foreach($food_info as $info){
													if(!isset($info['use'])) continue;

													if (($delivery_week_day_count && $delivery_week_day_count==$info['val'] . ':' . $info['count']) || (!$delivery_week_day_count && $i==0)) {
														$search_idx = $info['val'];
														$search_count = $info['count'];
														$delivery_price = $info['price_origin'] ? $info['price_origin'] : 0;
													}
													?>
													<li><input type="radio" onclick="week_day_count('<?=$info['val']?>','<?=$info['count']?>')" name="cnt_week" id="cnt_week<?=$i?>"><label for="cnt_week<?=$i?>"><?=$info['val']?>일분 (<?=$info['count']?>팩)</label></li>
													<?php
													$i++;
												}
												?>
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<th>배송요일</th>
									<td>
										<div class="selbox">
											<button type="button" onclick="toggleSelBox(this, event);"><span class="week_type_span">수,토(주2회) <em class="week_type_em">(2.1% 추가할인)</em></span></button>
											<ul>
												<?php
												$search_delivery_week_type = '';
												if($search_idx){
													$i = 0;
													foreach($food_info[$search_idx]['delivery_week_type'] as $info){
														if(!isset($info['use'])) continue;
														$arr_delivery_week_type = explode(':', $info['val']);
														if (($delivery_week_type && $delivery_week_type==$info['val']) || (!$delivery_week_type && $i==0)) $delivery_type_price = $info['price'] ? $info['price'] : 0;
														?>
														<li><input type="radio" onclick="week_type('<?=$arr_delivery_week_type[0]?>','<?=$arr_delivery_week_type[1]?>','<?=$info['price_per']?>')" name="day_week" id="day_week<?=$i?>"><label for="day_week<?=$i?>"><?=$arr_delivery_week_type[1]?>(주<?=$arr_delivery_week_type[0]?>회) <?if($info['price_per']){?><em>(<?=$info['price_per']?>% 추가할인)</em><?}?></label></li>
														<?php
														$i++;
													}
												}
												?>
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<th>총 배송기간</th>
									<td><div class="selbox">
											<button type="button" onclick="toggleSelBox(this, event);"><span><em>1주</em><strong> (7세트)</strong>35,000 → <strong>33,000원</strong> <em>(5% 할인)</em></span></button>
											<ul>
												<?php
												if($search_idx){
													$i = 0;
													$len = count($food_info[$search_idx]['delivery_week_count']);
													foreach($food_info[$search_idx]['delivery_week_count'] as $info){
														$i++;
														if(!isset($info['use'])) continue;
														if(($delivery_week_count && $delivery_week_count==$info['val']) || (!$delivery_week_count && $i==$len)){
															$delivery_week_price = $info['price'] ? $info['price'] : 0;
															$delivery_week = $info['val'];
														}
														?>
														<li><input type="radio" name="deliv_term" id="deliv_term<?=$i?>"><label for="deliv_term<?=$i?>"><em><?=$info['val']?>주</em><strong> (<?=number_format($search_idx * $info['val'])?>세트)</strong><?=number_format($delivery_price)?> → <strong><?=number_format($delivery_price - $delivery_week_price)?>원</strong> <em>(<?=$info['price_per']?>% 할인)</em></label></li>
														<?php
													}
												}
												?>
											</ul>
										</div>
									</td>
								</tr>
								<tr class="deliv_sunday">
									<th>일요일분<br>메뉴선택
										<!-- <div class="tooltip">
											<button type="button" class="plain btn" title="설명보기"><img src="/image/sub/icon_qmark.png" alt="설명보기"></button>
											<div class="txt">
												<p class="tit">일요일분 배송요일 안내</p>
												<div class="desc">
													일요일에 먹을 이유식 세트를 어느 메뉴로 받을 지 정할 수 있습니다.<br>
													ex) 금요일식단세트 금요일에 받기 : 금요일에 나오는 이유식 메뉴를 받습니다.
												</div>
											</div>
										</div> -->
									</th>
									<td><div class="selbox">
											<button type="button" onclick="toggleSelBox(this, event);"><span><em>목요일식단</em> 세트로 토요일에 받기</span></button>
											<ul>
												<?php
												$i=0;
												foreach($food_config['delivery_sun'] as $key => $val){
												?>
												<li><input type="radio" name="menu_sunday" id="menu_sunday<?=$i?>"><label for="menu_sunday<?=$i?>"><em><?=$val?>요일식단</em> 세트로 토요일에 받기</label></li>
												<?php
													$i++;
												}
												?>
												<!-- <li><input type="radio" name="menu_sunday" id="menu_sunday1"><label for="menu_sunday1"><em>목요일식단</em> 세트로 토요일에 받기</label></li>
												<li><input type="radio" name="menu_sunday" id="menu_sunday2"><label for="menu_sunday2"><em>금요일식단</em> 세트로 토요일에 받기</label></li>
												<li><input type="radio" name="menu_sunday" id="menu_sunday3"><label for="menu_sunday3"><em>토요일식단</em> 세트로 토요일에 받기</label></li> -->
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<th>배송지</th>
									<td><div class="selbox">
											<button type="button" onclick="toggleSelBox(this, event);"><span>배송지를 선택하세요.</span></button>
											<ul>
												<li><input type="radio" name="deliv_addr" id="deliv_addr1"><label for="deliv_addr1">자택:인천 서구 검암동</label></li>
												<li><input type="radio" name="deliv_addr" id="deliv_addr2"><label for="deliv_addr2">시댁:서울 관악구 봉천동</label></li>
												<li><input type="radio" name="deliv_addr" id="deliv_addr3"><label for="deliv_addr3">친정:서울 강서구 화곡동</label></li>
												<li><input type="radio" name="deliv_addr" id="deliv_addr4"><label for="deliv_addr4">보모:서울 관악구 봉천동</label></li>
												<li><input type="radio" name="deliv_addr" id="deliv_addr5"><label for="deliv_addr5">직접입력</label></li>
											</ul>
										</div>
									</td>
								</tr>
								<tr>
									<th>배송지 입력</th>
									<td><div class="new_addr">
											<p><label for="address_input1" class="hidden">신규주소</label>
												<input type="text" id="address_input1" value="인천 서구 검암동" disabled>
												<button type="button" class="plain" title="새창" onclick="">우편번호 선택</button>
											</p>
											<p class="mt5"><label for="address_input2" class="hidden">신규상세주소</label>
												<input type="text" id="address_input2" class="full">
											</p>
										</div>
									</td>
								</tr>
								<tr>
									<th>첫 배송일</th>
									<td><div class="sel_date">
											<em>2018-03-14</em>
											<button type="button" class="plain" onclick="$('#start_delivery_cal').toggle();">첫배송일 변경</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="cal_wrap mt15" id="start_delivery_cal" style="display:none;">
							<div class="cal_year">
								<em>2018년 3월</em>
								<button type="button" class="plain prev" title="이전달"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
								<button type="button" class="plain next" title="다음달"><img src="/image/sub/cal_next.png" alt="다음달"></button>
							</div>
							<table class="cm_cal clickable">
								<thead>
									<tr>
										<th>일</th>
										<th>월</th>
										<th>화</th>
										<th>수</th>
										<th>목</th>
										<th>금</th>
										<th>토</th>
									</tr>
								</thead>
								<tbody>
									<tr class="blank1">
										<td colspan="7"></td>
									</tr>
									<tr>
										<!-- <td class="dimmed">25</td>
										<td class="dimmed">26</td>
										<td class="dimmed">27</td>
										<td class="dimmed">28</td> -->
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><a href="#">1</a></td>
										<td><a href="#">2</a></td>
										<td><a href="#">3</a></td>
									</tr>
									<tr>
										<td><a href="#">4</a></td>
										<td><a href="#">5</a></td>
										<td><a href="#">6</a></td>
										<td><a href="#">7</a></td>
										<td><a href="#">8</a></td>
										<td><a href="#">9</a></td>
										<td><a href="#">10</a></td>
									</tr>
									<tr>
										<td><a href="#">11</a></td>
										<td><a href="#">12</a></td>
										<td><a href="#">13</a></td>
										<td class="start_deliv"><a href="#">14</a></td>
										<td><a href="#">15</a></td>
										<td><a href="#">16</a></td>
										<td><a href="#">17</a></td>
									</tr>
									<tr>
										<td><a href="#">18</a></td>
										<td><a href="#">18</a></td>
										<td><a href="#">20</a></td>
										<td><a href="#">21</a></td>
										<td><a href="#">22</a></td>
										<td><a href="#">23</a></td>
										<td><a href="#">24</a></td>
									</tr>
									<tr>
										<td><a href="#">25</a></td>
										<td><a href="#">26</a></td>
										<td><a href="#">27</a></td>
										<td><a href="#">28</a></td>
										<td><a href="#">29</a></td>
										<td><a href="#">30</a></td>
										<td><a href="#">31</a></td>
									</tr>
									<tr class="blank2">
										<td colspan="7"></td>
									</tr>
								</tbody>
							</table>
						</div><!-- END 첫 배송일 선택 달력 -->
					*/
					?>

					<div class="order_set">
						<?php
						//추천식단 주문 설정 값
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.schedule_delivery_info.php";
						?>
					</div>

					<!-- 첫 배송일 선택 달력 -->
					<!--
						흐린색, 선택불가능한 날짜 : td.dimmed
						정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
						배송시작일 : start_deliv
					-->

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

					<p class="align-c mt20 mb5">
						<?php
						if(!$this->session->userdata('USERID')){
							?>
							<button type="button" class="plain" title="주문하기" onclick="alert('로그인 후 이용 가능합니다.');location.href='/html/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						else{
							if($recom_overlap){
							?>
							<button type="button" class="plain" title="주문하기" onclick="frmChk('recomfrm')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
							}
							else{
							?>
							<button type="button" class="plain" title="주문하기" onclick="alert('장바구니에 정기배송이 1건 담겨있습니다.\n\n추가 주문을 원하시는경우 주문을 진행하신 후 구매 부탁드리며\n변경을 원하시는경우 장바구니에서 삭제후 주문해 주시기 바랍니다.');location.href='/html/dh_order/shop_cart'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
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
