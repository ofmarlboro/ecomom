<?
  if(!$this->input->get('recom_idx')){
    alert(cdir()."/dh/regular01/?recom_idx=2");
  }

  $PageName = "REGULAR01";
  $SubName = "";
  $PageTitle = "";
  include('../include/head.php');
  include('../include/header.php');
?>

	<!--Container-->
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
					$(".order_set").html(data.delivery_info);
					$(".selbox input[type='radio']").change(function(){
						loadScheduleDelivery(delivery_date);
					});
					$(".selbox input[type='radio']").click(function(){
						toggleSelBox();
					});

					$(".sched_menu_box").html(data.prod_list);

					if(data.prod_list){
						$(".alrg_chk").show();

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

						$("span.total_origin_price").text(data.price_info.total);
						$("span.set").text(data.price_info.pack_ea+"세트("+data.price_info.per+"%)");
						$("em.real_price").text(data.price_info.price);
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
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_calendar&this_mon="+encodeURIComponent(month)+"&recom_idx=<?=$recom_info->idx?>&delivery_week_day_count="+encodeURIComponent(delivery_week_day_count)+
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


<div id="container" style="background: #FAFAFA">
  <? // include("../include/top_menu.php");?>
  <?include("../include/view_tab02.php");?>

  <!-- inner -->
  <div class="pb50">
    <div class="header_img">
      <img src="/_data/file/subinfo/<?=$cate_info->upfilem?>" alt="" onerror="this.src='/image/default.jpg'">
      <span><img src="/m/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>

      <!-- 20180524 -->
      <!-- <a href="#">
        <?=($this->input->get('recom_idx')) ? $step_arr[$this->input->get('recom_idx')] : $step_arr[$this->input->get('cate_no')] ;?> 상세보기
      </a> -->
      <!-- <button type="button" class="plain" onClick="menuPop('<?=$this->input->get('recom_idx')?>');"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
      <ul class="new_list">
        <?php
        if($cate_info->foodtable_use == "Y"){ //월별 식단표 사용여부
          ?>
          <li class="list01"><a href="#" onClick="menuPop_mobile('<?=$this->input->get('recom_idx')?>');"></a></li>
          <?php
        }

        if($cate_info->moreview_use == "Y"){  //이유식 상세보기 설명 사용여부
          ?>
          <li class="list02"><a href="#" onClick="menuView01();"></a></li>
          <?php
        }
        ?>
        <li class="list03"><a href="#" onClick="menuView02();"></a></li>
      </ul>
      <!-- // 20180524 -->
    </div>



<form method="post" name="recomfrm" id="recomfrm" action="<?=cdir()?>/dh/regular_pay" autocomplete="off">
  <input type="hidden" name="recom_idx" value="<?=$this->input->get('recom_idx')?>">
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

    <?include("../include/view_tab03.php");?>

    <div class="order_opt_wrap">
      <div class="order_opt_tint">
        <div class="order_set">
          <?php
          include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.schedule_delivery_info.php";
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

          <?php
          /*
            <div class="cal_year">
              <em>2018년 04월</em>
              <button type="button" class="plain prev" title="이전달" onClick="go_calendar_set('2018-03')"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
              <button type="button" class="plain next" title="다음달" onClick="go_calendar_set('2018-05')"><img src="/image/sub/cal_next.png" alt="다음달"></button>
            </div>
            <table class="cm_cal clickable regmark">
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
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-01"><a href="javascript: ;">1</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-02"><a href="javascript: ;">2</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-03"><a href="javascript: ;">3</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-04"><a href="javascript: ;">4</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-05"><a href="javascript: ;">5</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-06"><a href="javascript: ;">6</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-07"><a href="javascript: ;">7</a></td>
                </tr>
                <tr>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-08"><a href="javascript: ;">8</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-09"><a href="javascript: ;">9</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-10"><a href="javascript: ;">10</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-11"><a href="javascript: ;">11</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-12"><a href="javascript: ;">12</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-13"><a href="javascript: ;">13</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-14"><a href="javascript: ;">14</a></td>
                </tr>
                <tr>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-15"><a href="javascript: ;">15</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-16"><a href="javascript: ;">16</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-17"><a href="javascript: ;">17</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-18"><a href="javascript: ;">18</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-19"><a href="javascript: ;">19</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-20"><a href="javascript: ;">20</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-21"><a href="javascript: ;">21</a></td>
                </tr>
                <tr>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-22"><a href="javascript: ;">22</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-23"><a href="javascript: ;">23</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-24"><a href="javascript: ;">24</a></td>
                  <td class="dimmed start_deliv" data-yoil="2018-04-25" data-date="2018-04-25"><a href="javascript: ;">25</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-26"><a href="javascript: ;">26</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-27"><a href="javascript: ;">27</a></td>
                  <td class="reg_on" data-yoil="2018-04-25" data-date="2018-04-28"><a href="javascript: loadScheduleDelivery('2018-04-28');">28</a></td>
                </tr>
                <tr>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-29"><a href="javascript: ;">29</a></td>
                  <td class="dimmed" data-yoil="2018-04-25" data-date="2018-04-30"><a href="javascript: ;">30</a></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="blank2">
                  <td colspan="7"></td>
                </tr>
              </tbody>
            </table>
          */
          ?>

        </div>
        <!-- END 첫 배송일 선택 달력 -->


      </div>
      <!-- //order_opt_tint -->


			<div class="pay pay01 clearfix">
				<div class="fl" style="color: #8a8a8a;font-size: 12px;">총 상품금액</div>
				<div class="fr thr" style="color: #8a8a8a;font-size: 14px;"><span class="fz20 total_origin_price"></span>원</div>
				<div class="pay_in clearfix">
					<div class="fr" style="font-size: 14px;"><span class="fz12 set orange"></span><!-- <span class="fz20"></span>원 --><em class="real_price"></em>원</div>
					<div class="fl" style="font-size: 12px;">할인적용가</div>
				</div>
      </div>

      <p class="ml15 mt10">
        <!-- <button type="button" class="plain menuview"></button> -->
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



          <?php
          /*
            <h5 class="htit">
              04월 25일 (수)
            </h5>
            <input type="hidden" name="recom_delivery_detail_date[]" value="2018-04-25">
            <ul class="sched_menu">
              <li class="product">
                <div class="box">
                  <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>
                  <input type="hidden" name="recom_delivery_detail_prod[]" value="14:2018-04-25:">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/11c6a03435ccc648f6efc0f904e33ba7.jpg" alt="준비기 이유식 6의 이미지"></span>
                  <span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
                  </a>
                  <em class="tit">준비기 이유식 6</em>
                </div>
              </li>
              <li class="product mr0 except">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="recom_delivery_detail_prod[]" value="16:2018-04-25:">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/361b645b37f1ad6bfeb8cdf830ba357e.jpg" alt="준비기 이유식 8의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식 8</em>
                </div>
              </li>
            </ul>
            <h5 class="htit">
              04월 28일 (토)
            </h5>
            <input type="hidden" name="recom_delivery_detail_date[]" value="2018-04-28">
            <ul class="sched_menu">
              <li class="product">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="recom_delivery_detail_prod[]" value="12:2018-04-28:">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/5e313f9868fdf0e0a0ed3a015e46e49e.jpg" alt="준비기 이유식 4의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식 4</em>
                </div>
              </li>
              <li class="product mr0">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="recom_delivery_detail_prod[]" value="13:2018-04-28:">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/6508187055181949ae53104d293f2215.jpg" alt="준비기 이유식 5의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식 5</em>
                </div>
              </li>
              <li class="product sunday">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="recom_delivery_detail_prod[]" value="13:2018-04-28:1">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/6508187055181949ae53104d293f2215.jpg" alt="준비기 이유식 5의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식 5</em>
                  <span class="added">일요일 추가분</span>
                </div>
              </li>
            </ul>
            <h5 class="htit">
              05월 02일 (수)
            </h5>
            <input type="hidden" name="recom_delivery_detail_date[]" value="2018-05-02">
            <ul class="sched_menu">
              <li class="product">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="recom_delivery_detail_prod[]" value="3:2018-05-02:">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/752ba254a83a2f4bcff94963cc0e8265.jpg" alt="준비기 이유식의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식</em>
                </div>
              </li>
              <li class="product sunday mr0">
                <div class="box">
                <span class="cart-vol">
                    <button class="vol-down" onClick="goodsCntChange('d')">감소</button>

                    <button class="vol-up" onClick="goodsCntChange('u')">추가</button>
                  </span>

                  <input type="hidden" name="">
                  <a href="javascript:void(0);" title="상세보기">
                  <span class="img"><img src="/_data/file/goodsImages/752ba254a83a2f4bcff94963cc0e8265.jpg" alt="준비기 이유식의 이미지"></span>
                  </a>
                  <em class="tit">준비기 이유식</em>
                  <span class="added">일요일 추가분</span>
                </div>
              </li>
            </ul>
          */
          ?>

        </div>
        <!-- //메뉴 선택 -->
      </div>
      <!-- //알레르기체크+메뉴 선택 -->

        <!--  <div class="order_opt_light">
            <table class="order_opt price_tbl">
              <tbody>
                <tr>
                  <th>총 상품금액</th>
                  <td><del class="total_origin_price">200,000</del>원</td>
                </tr>
                <tr class="total">
                  <th>할인적용가</th>
                  <td><em class="set">28세트(36.0%)</em>
                    <ins class="real_price">128,000</ins>원 </td>
                </tr>
              </tbody>
            </table>
            <p class="align-c mt20 mb5">
              <button type="button" class="plain" title="주문하기" onclick="location.href='regular_pay.php'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
            </p>
          </div> -->
        <!-- //order_opt_light -->

      <div class="mg50"></div>

			<input type="hidden" name="recom_deliv_addr" msg="배송지를 선택해 주세요.">
			<input type="hidden" name="deliv_info_daytype">
    </div>
    <!-- //order_opt_wrap -->

  </div>
  </form>
  <!-- //하단창 -->



  </div>
  <!-- inner -->



<!--   <div class="bottom_bar bottom_bar03 bottom_bar03_1">
    <a href="#" class="top_arw top_arw00">
    <img src="/m/image/sub/bottom_arw.png" alt="" width="90px">
    <img src="/m/image/sub/arw02.jpg" alt="" class="arw">
    </a>
    <div class="bottm_inner">


    </div>
  </div> -->
  <!-- //하단 창 -->

  <div class="last_one">

  <p class="align-c">
        <?php
				/*
        if(!$this->session->userdata('USERID')){
          ?>
          <button type="button" class="plain" title="주문하기" onclick="alert('로그인 후 이용 가능합니다.');location.href='<?=cdir()?>/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>'"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
          <?php
        }
        else{
          ?>
          <button type="button" class="plain orderbtn" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
          <?php
        }
				*/
          if($recom_overlap){
          ?>
          <button type="button" class="plain orderbtn" title="주문하기" onclick="frmChk('recomfrm','regular_order')"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
          <?php
          }
          else{
          ?>
          <button type="button" class="plain" title="주문하기" onclick="alert('현재 장바구니에 정기식단 주문건이 있습니다.\n\n정기식단 2건이상 중복주문은 안되니,\n1건씩 장바구니에 담아 주문하시기 바랍니다.');location.href='<?=cdir()?>/dh_order/shop_cart'"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
          <?php
          }
        ?>
      </p>
  </div>

</div>

<!--END Container-->

<? include('../include/footer.php') ?>


<!-- 20180524 -->
        <script>
        function menuView01(){
          $("#menu_dt_wrap01").fadeIn('fast');
        }
        function closeMenuView01(){
          $("#menu_dt_wrap01 .scroll").scrollTop(0);
          $("#menu_dt_wrap01").hide();
        }


        function menuView02(){
          $("#menu_dt_wrap02").fadeIn('fast');
        }
        function closeMenuView02(){
          $("#menu_dt_wrap02 .scroll").scrollTop(0);
          $("#menu_dt_wrap02").hide();
        }

		 function numSelect(){
          $("#numSelect").fadeIn('fast');
        }
        function closeNumSelect(){
          $("#numSelect .scroll").scrollTop(0);
          $("#numSelect").hide();
        }



        </script>


<!-- 180615 추가 -->
	<div id="numSelect" style="display:none;">
		<div class="numSelect_inner">
			<h1>수량을 추가하세요</h1>
			<div class="scroll">
				<p><span class="orange">3/7(수)메뉴</span> : 대체메뉴를 <span class="orange">'1팩'</span> 더 추가하세요.</p>
				<p><span class="orange">12/14(수)메뉴</span> : 대체메뉴를 <span class="orange">'1팩'</span> 더 추가하세요.</p>
				<p><span class="orange">12/14(수)메뉴</span> : 대체메뉴를 <span class="orange">'1팩'</span> 더 추가하세요.</p>
				<p><span class="orange">12/14(수)메뉴</span> : 대체메뉴를 <span class="orange">'31팩'</span> 더 추가하세요.</p>
			</div>
			<p>원하는 대체메뉴의 <img src="/m/image/sub/vol02.png" alt="수량추가" width="15px" style="vertical-align: -4px;margin-right: 3px;">버튼을 누르세요.</p>
			<a href="#" class="btn_w02" onclick="closeNumSelect();">확&nbsp;인</a>
		</div>
	</div>
<!-- // 180615 추가 -->




        <div id="menu_dt_wrap01" style="display: none;">
          <div id="menu_dt01">
            <h2 class="htit"><?=$cate_info->title_b?> <span>(<?=$cate_info->title_m?>)</span></h2>
            <div class="scroll">
              <?php
              if($cate_info->mobile_detail){
              ?>
              <img src="/_data/file/subinfo/<?=$cate_info->mobile_detail?>" alt="">
              <?php
              }
              ?>
            </div>
            <button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView01();">닫기</button>
          </div>
        </div>




        <div id="menu_dt_wrap02" style="display: none;">
          <div id="menu_dt02">
            <h2 class="htit">이유식 이용보관</h2>
            <div class="scroll">
			<img src="/image/sub/icenoti_m.jpg" alt="" style="margin: 20px auto;">
              <img src="/m/image/sub/noti.jpg" alt="">
            </div>
            <button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView02();">닫기</button>
          </div>
        </div>
<!--//20180524 -->

<script>

  var flag01 = null;
    $('.top_arw00').on('click',function(e){
      e.preventDefault();
      if (flag01 == 1) {
        $(this).find(".arw").css('transform', 'rotate(0deg)');
        $(this).parent().css('bottom', '0');
        flag01 = null;
      } else {

        $(this).find(".arw").css('transform', 'rotate(180deg)');
        $(this).parent().css('bottom', '-90px');



        flag01 = 1;
      }
    });

    var flag02 = null;
    $('.menuview').on('click',function(e){
      e.preventDefault();
      if (flag == 1) {
        $(this).find(".arw").css('transform', 'rotate(0deg)');
        flag02 = null;
      } else {
        $(this).find(".arw").css('transform', 'rotate(180deg)');
        flag02 = 1;
      }
    });

</script>