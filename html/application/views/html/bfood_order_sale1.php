<?
	$PageName = "K02";
	$SubName = "K0203";
	include("../include/head.php");
	include("../include/header.php");
?>
	<input type="hidden" name="default_select_date" value="<?=$default_select_date?>">
	<input type="hidden" name="default_start_date" value="<?=$default_select_date?>">

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">
	<!--
		function move_view(src){
			$(".view img").attr('src',src);
		}

		function Loadsalesfood(this_mon){
			if(this_mon) deliv_date = this_mon;
			else deliv_date = "";

			// 배송지 설정
			var deliv_addr = $("input[name='deliv_addr']:checked").val() || '';

			//배송지 입력값 유지
			var zipcode = $("input[name='zipcode']").val() || '';
			var addr1 = $("input[name='addr1']").val() || '';
			var addr2 = $("input[name='addr2']").val() || '';

			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_salesfood&cate_no=6&this_mon="+encodeURIComponent(deliv_date)+
					"&deliv_date="+encodeURIComponent(deliv_date)+
					"&zipcode="+zipcode+
					"&addr1="+encodeURIComponent(addr1)+
					"&addr2="+encodeURIComponent(addr2)+
					"&deliv_addr="+encodeURIComponent(deliv_addr)+
					"&df_st_date="+encodeURIComponent($("input[name='default_start_date']").val())
				,dataType:"json"
				,cache:false
				,error:function(xhr){console.log(xhr.responseText)}
				,success:function(data){
					console.log(data);
					if (data.error)
					{
						alert(data.error);
						return false;
					}

					if (data.sales_calendar) $(".cal_wrap").html(data.sales_calendar);	//달력
					if (data.select_date) $("input[name='default_select_date']").val(data.select_date);	//선택 날짜
					if (data.food_list) $("#dgroup1").html(data.food_list);	//제품리스트
					//if (data.deliv_addr_set) $(".order_set").html(data.deliv_addr_set);	//배송지리스트

					//$(".order_set input[type='radio']").change(function(){
					//	Loadsalesfood($("input[name='default_select_date']").val());
					//});

					call_tmp_cart("<?=$this->session->userdata('CART')?>");
				}
			});
		}

		$(window).ready(function(){	//기본설정 셋
			Loadsalesfood('<?=$default_select_date?>');	//선택일자가 없는 경우 오늘을 기준으로 보냄
		});

		function go_calendar_set(month){
			var default_select_date = $("input[name='default_select_date']").val();
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_nonerecom_calander&cate_no=6"+
					"&this_mon="+encodeURIComponent(month)+
					"&deliv_date="+encodeURIComponent(default_select_date)+
					"&df_st_date="+encodeURIComponent($("input[name='default_start_date']").val())
				,dataType:"json"
				,cache:false
				,success:function(data){
					console.log(data);
					if(data.sales_calendar){
						$(".cal_wrap").html(data.sales_calendar);
					}
				}
				,error:function(xhr){
					console.log(xhr.responseText);
				}
				,complete:function(){
				}
			});
		}

		function add_tmp_cart(deliv_date,goods_idx,goods_price,goods_name,origin_price){
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=sales_cart_tmp&deliv_date="+encodeURIComponent(deliv_date)+"&goods_idx="+goods_idx+"&price="+goods_price+"&goods_name="+encodeURIComponent(goods_name)+"&origin_price="+origin_price
				,dataType:"json"
				,cache:false
				,error:function(xhr){ console.log(xhr.responseText); }
				,success:function(data){
					console.log(data);
					if (data.tmp_list)
					{
						$(".order_cart").html(data.tmp_list);
					}

					if (data.tmp_total){
						$(".cart_tmp_total").text(addComma(data.tmp_total));
						$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
					}

					if (data.tmp_total <= 0)
					{
						$(".order_cart").hide();
						$(".order_cart_no").show();
					}
					else{
						$(".order_cart").show();
						$(".order_cart_no").hide();
					}
				}
			});
		}

		function call_tmp_cart(cart_id){
			//새로고침시 페이지 유지를 위해
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=call_tmp_cart&cart_id="+cart_id+"&submode=sales"
				,dataType:"json"
				,cache:false
				,error:function(xhr){ console.log(xhr.responseText); }
				,success:function(data){
					if(data.tmp_list){
						$(".order_cart").html(data.tmp_list);
					}

					if (data.tmp_total){
						$(".cart_tmp_total").text(addComma(data.tmp_total));
						$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
					}

					if (data.tmp_total <= 0)
					{
						$(".order_cart").hide();
						$(".order_cart_no").show();
					}
					else{
						$(".order_cart").show();
						$(".order_cart_no").hide();
					}
				}
			});
		}

		function tmp_cart_clear(cart_id){
			if (confirm("선택된 상품을 전부 지우시겠습니까?"))
			{
				$.ajax({
					type:"GET"
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=tmp_cart_clear&cart_id="+cart_id+"&submode=sales"
					,dataType:"json"
					,cache:false
					,error:function(xhr){ console.log(xhr.responseText); }
					,success:function(data){
						if (data.tmp_list)
						{
							$(".order_cart").html(data.tmp_list);
						}

					if (data.tmp_total){
						$(".cart_tmp_total").text(addComma(data.tmp_total));
						$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
					}

						if (data.tmp_total <= 0)
						{
							$(".order_cart").hide();
							$(".order_cart_no").show();
						}
						else{
							$(".order_cart").show();
							$(".order_cart_no").hide();
						}
					}
				});
			}
		}

		function cart_ea_del(cart_id,idx){
			if (confirm("선택된 상품을 지우시겠습니까?"))
			{
				$.ajax({
					type:"GET"
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_del&cart_id="+cart_id+"&idx="+idx+"&submode=sales"
					,dataType:"json"
					,cache:false
					,error:function(xhr){ console.log(xhr.responseText); }
					,success:function(data){

						console.log(data);

						if (data.tmp_list)
						{
							$(".order_cart").html(data.tmp_list);
						}

					if (data.tmp_total){
						$(".cart_tmp_total").text(addComma(data.tmp_total));
						$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
					}


						if (data.tmp_total <= 0)
						{
							$(".order_cart").hide();
							$(".order_cart_no").show();
						}
						else{
							$(".order_cart").show();
							$(".order_cart_no").hide();
						}
					}
				});
			}
		}

		function prd_minus(cart_id,idx){

			var prd_cnt = $("#prd_cnt"+idx).val();

			if (prd_cnt == 1)
			{
				alert("1개 이하로 수량을 줄일 수 없습니다.");
				return;
			}
			else{
				$.ajax({
					type:"GET"
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_update_minus&cart_id="+cart_id+"&idx="+idx+"&submode=sales"
					,dataType:"json"
					,cache:false
					,error:function(xhr){ console.log(xhr.responseText); }
					,success:function(data){

						console.log(data);

						if (data.tmp_list)
						{
							$(".order_cart").html(data.tmp_list);
						}

						if (data.tmp_total)	$(".cart_tmp_total").text(addComma(data.tmp_total));
						else	$(".cart_tmp_total").text("0");
					}
				});
			}
		}

		function prd_plus(cart_id,idx){
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_update_plus&cart_id="+cart_id+"&idx="+idx+"&submode=sales"
				,dataType:"json"
				,cache:false
				,error:function(xhr){ console.log(xhr.responseText); }
				,success:function(data){

					console.log(data);

					if (data.tmp_list)
					{
						$(".order_cart").html(data.tmp_list);
					}

					if (data.tmp_total)	$(".cart_tmp_total").text(addComma(data.tmp_total));
					else	$(".cart_tmp_total").text("0");
				}
			});
		}
	//-->
	</script>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>
		<?include("../include/cate_info.php");?>

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
		<form action="<?=cdir()?>/dh/bfood_order_sale2" method="post" name="sendfrm" id="orderfrm">

			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box mt0">
					<div class="day_group" id="dgroup1">
						<?php // ajax_json, Loadsalesfood() < go to dh/dh_ajax?mode ?>
					</div>
				</div><!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<h4 class="h_tit">배송 받을 날짜를 선택해 주세요.</h4>
					<p class="h_desc">신선도를 유지하기 위해 배송일자에 따라 조리이유식이 달라집니다.<br> <span class="circle">주황색 동그라미 :</span>정기배송을 이용중이면 배송 받을 날짜에 무료배송이 가능합니다. </p>
					<!-- 날짜선택 달력 -->
					<!--
						흐린색, 선택불가능한 날짜 : td.dimmed
						정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
						배송시작일 : start_deliv
					-->
					<div class="cal_wrap">
						<?php // ajax_json, Loadsalesfood() < go to dh/dh_ajax?mode ?>
					</div><!-- END 날짜선택 달력 -->

					<?php
					/*
					<div class="order_set">
						<?php
						//include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.sales.deliv_addr.php";
						?>
					</div>
					*/
					?>
					<input type="hidden" name="deliv_addr" value="home">

					<div class="order_cart_tit">
						<p>상품선택 보관함</p>
						<button type="button" class="plain btn_del" onclick="tmp_cart_clear('<?=$this->session->userdata('CART')?>')">비우기</button>
					</div>

					<!-- 상품이 없을경우(.order_cart는 가리기) -->
					<p class="order_cart_no" style="display:none;">선택한 상품이 없습니다.</p>

					<!-- 상품이 있는경우만 노출 -->
					<div class="order_cart">
						<?php // ajax_json, add_tmp_cart() < go to dh/dh_ajax?mode ?>
					</div>
				</div>
				<div class="order_opt_light">
					<table class="order_opt price_tbl">
						<tbody>
							<tr class="total">
								<th>총 상품금액</th>
								<td><ins class="cart_tmp_total"></ins>원</td>
							</tr>
						</tbody>
					</table>
					<p class="align-c mt20 mb5">
						<button type="button" class="plain orderbtn" title="주문하기" onclick="frmChk('orderfrm')"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
					</p>
				</div>
			</div><!-- END 선택 옵션영역 -->

		</form>
		</div><!-- END 주문옵션 WRAP -->
	</div><!--END Container-->

	<?include("../include/menu_detail.php");?>

<?include("../include/footer.php");?>
