<?
	if(!$this->input->get('cate_no')){
		alert(cdir()."/dh/bfood_order_free1/?cate_no=1-6");
	}

	$PageName = "FREE_LIST";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<input type="hidden" name="default_select_date" value="<?=$default_select_date?>">
	<input type="hidden" name="default_start_date" value="<?=$default_select_date?>">

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript" src="/_data/js/jquery.form.js"></script>
	<script type="text/javascript">

		function change_deliv_date(){
			$(".layer_pop").fadeIn('fast');
			return false;
		}

		function closechange_deliv_date(){
			$(".layer_pop").hide();
		}

		LoadFreefood('<?=$default_select_date?>');	//선택일자가 없는 경우 오늘을 기준으로 보냄

		$(window).on('load resize', function(){

			ww=$(window).height();
			if (ww > 1300){
				$('.bottom_bar02').css('height', '1000px');
			//	$('.bottm_inner').css('height', '900px');
				var flag = null;
				$('.top_arw04').on('click',function(e){
					e.preventDefault();
					if (flag == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '0');
						flag = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '-980px');
						flag = 1;
					}
				});
				//상품보관함
				$('.bottom_bar04').css('bottom', '-945px');
				$('.bottom_bar04').css('height', '1000px');
				$('.bottm_inner04').css('height', '900px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-940px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})
			}
			else if (ww > 1200){
						$('.bottom_bar02').css('height', '850px');
				//		$('.bottm_inner').css('height', '840px');
						var flag = null;
						$('.top_arw04').on('click',function(e){
								e.preventDefault();
								if (flag == 1) {
										$(this).find(".arw").css('transform', 'rotate(0deg)');
										$(this).parent().css('bottom', '0');
										flag = null;
								} else {
										$(this).find(".arw").css('transform', 'rotate(180deg)');
										$(this).parent().css('bottom', '-830px');
										flag = 1;
					}
				});
				//상품보관함
				$('.bottom_bar04').css('bottom', '-795px');
				$('.bottom_bar04').css('height', '850px');
				$('.bottm_inner04').css('height', '840px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-790px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})

			}
			else if (ww > 1000){
						$('.bottom_bar02').css('height', '700px');
					//	$('.bottm_inner').css('height', '690px');
						var flag = null;
						$('.top_arw04').on('click',function(e){
								e.preventDefault();
								if (flag == 1) {
										$(this).find(".arw").css('transform', 'rotate(0deg)');
										$(this).parent().css('bottom', '0');
										flag = null;
								} else {
										$(this).find(".arw").css('transform', 'rotate(180deg)');
										$(this).parent().css('bottom', '-680px');
										flag = 1;
								}
						});
				//상품보관함
				$('.bottom_bar04').css('bottom', '-645px');
				$('.bottom_bar04').css('height', '700px');
				$('.bottm_inner04').css('height', '690px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-640px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})

				}

				else if (ww > 800){
					$('.bottom_bar02').css('height', '500px');
				//	$('.bottm_inner').css('height', '490px');
					var flag = null;
					$('.top_arw04').on('click',function(e){
						e.preventDefault();
						if (flag == 1) {
							$(this).find(".arw").css('transform', 'rotate(0deg)');
							$(this).parent().css('bottom', '0');
							flag = null;
						} else {
							$(this).find(".arw").css('transform', 'rotate(180deg)');
							$(this).parent().css('bottom', '-480px');
							flag = 1;
						}
					});

					//상품보관함
					$('.bottom_bar04').css('bottom', '-445px');
					$('.bottom_bar04').css('height', '500px');
					$('.bottm_inner04').css('height', '490px');

					var flag01 = null;

					$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;

						e.preventDefault();
						if (flag01 == 1) {
							$(this).find(".arw").css('transform', 'rotate(0deg)');
							$(this).parent().css('bottom', '-440px');
							flag01 = null;
						} else {
							$(this).find(".arw").css('transform', 'rotate(180deg)');
							$(this).parent().css('bottom', '0');
							flag01 = 1;
						}
					});
				}

				else if (ww > 700){
						$('.bottom_bar02').css('height', '380px');
					//	$('.bottm_inner').css('height', '350px')
						var flag = null;
						$('.top_arw04').on('click',function(e){
								e.preventDefault();
								if (flag == 1) {
										$(this).find(".arw").css('transform', 'rotate(0deg)');
										$(this).parent().css('bottom', '0');
										flag = null;
								} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '-300px');
						flag = 1;
					 }
				})
				//상품보관함
				$('.bottom_bar04').css('bottom', '-325px');
				$('.bottom_bar04').css('height', '380px');
				$('.bottm_inner04').css('height', '350px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-320px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})
			}

			else if (ww > 600){
				$('.bottom_bar02').css('height', '320px');
			//	$('.bottm_inner').css('height', '310px')
				var flag = null;
				$('.top_arw04').on('click',function(e){
					e.preventDefault();
					if (flag == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '0');
						flag = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '-300px');
						flag = 1;
					}
				});
				//상품보관함
				$('.bottom_bar04').css('bottom', '-265px');
				$('.bottom_bar04').css('height', '320px');
				$('.bottm_inner04').css('height', '310px');
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-260px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				});
			}

			else if (ww > 500){
				$('.bottom_bar02').css('height', '250px');
			//	$('.bottm_inner').css('height', '240px')
				var flag = null;
				$('.top_arw04').on('click',function(e){
					e.preventDefault();
					if (flag == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '0');
						flag = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '-230px');
						flag = 1;
					}
				});
				//상품보관함
				$('.bottom_bar04').css('bottom', '-195px');
				$('.bottom_bar04').css('height', '250px');
				$('.bottm_inner04').css('height', '240px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-190px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})
			}
			else {
				$('.bottom_bar02').css('height', '150px');
			//	$('.bottm_inner').css('height', '100px')
				var flag = null;
				$('.top_arw04').on('click',function(e){
					e.preventDefault();
					if (flag == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '0');
						flag = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '-130px');
							flag = 1;
					}
				})
				//상품보관함
				$('.bottom_bar04').css('bottom', '-95px');
				$('.bottom_bar04').css('height', '150px');
				$('.bottm_inner04').css('height', '100px')
				var flag01 = null;
				$('.top_arw00').on('click',function(e){
						var css_value = $(".bottom_bar04").css('bottom');
						flag01 = (parseInt(css_value) == 0) ? 1 : null ;
					e.preventDefault();
					if (flag01 == 1) {
						$(this).find(".arw").css('transform', 'rotate(0deg)');
						$(this).parent().css('bottom', '-90px');
						flag01 = null;
					} else {
						$(this).find(".arw").css('transform', 'rotate(180deg)');
						$(this).parent().css('bottom', '0');
						flag01 = 1;
					}
				})
			}
		});

		function move_view(src){
			$(".view img").attr('src',src);
		}

		function LoadFreefood(this_mon){	//골라담기 로딩 ajax
			if(this_mon) deliv_date = this_mon;
			else deliv_date = "";

			//알러지체크
			var allergy13 = $('input[name=allergy13]:checked').val() || '';
			var allergy12 = $('input[name=allergy12]:checked').val() || '';
			var allergy1 = $('input[name=allergy1]:checked').val() || '';
			var allergy2 = $('input[name=allergy2]:checked').val() || '';
			var allergy6 = $('input[name=allergy6]:checked').val() || '';

			// 배송지 설정
			var deliv_addr = $("input[name='deliv_addr']:checked").val() || '';

			//배송지 입력값 유지
			var zipcode = $("input[name='zipcode']").val() || '';
			var addr1 = $("input[name='addr1']").val() || '';
			var addr2 = $("input[name='addr2']").val() || '';

			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_freefood&cate_no="+encodeURIComponent("<?=$this->input->get('cate_no')?>")+"&this_mon="+encodeURIComponent(this_mon)+"&deliv_date="+encodeURIComponent(deliv_date)+
					"&allergy13="+allergy13+
					"&allergy12="+allergy12+
					"&allergy1="+allergy1+
					"&allergy2="+allergy2+
					"&allergy6="+allergy6+
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
					if (data.error){
						alert(data.error);
						return false;
					}

					//$("input[name='default_select_date']").val(deliv_date);

					if (data.free_calendar) $(".cal_wrap").html(data.free_calendar);
					if (data.select_date) $("input[name='default_select_date']").val(data.select_date);
					if (data.food_list) $(".free_menu").html(data.food_list);
					//if (data.deliv_addr_set) $(".order_set").html(data.deliv_addr_set);

					//$(".order_set input[type='radio']").change(function(){
					//	LoadFreefood($("input[name='default_select_date']").val());
					//});

					call_tmp_cart("<?=$this->session->userdata('CART')?>");
					closechange_deliv_date();
				}
			});
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
				LoadFreefood($("input[name='default_select_date']").val());
			});
		});

		function go_calendar_set(month){
			var default_select_date = $("input[name='default_select_date']").val();
			$.ajax({
				type:"GET"
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_nonerecom_calander&cate_no="+encodeURIComponent("<?=$this->input->get('cate_no')?>")+
					"&this_mon="+encodeURIComponent(month)+
					"&deliv_date="+encodeURIComponent(default_select_date)+
					"&df_st_date="+encodeURIComponent($("input[name='default_start_date']").val())
				,dataType:"json"
				,cache:false
				,success:function(data){
					console.log(data);
					if(data.free_calendar){
						$(".cal_wrap").html(data.free_calendar);
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
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=free_cart_tmp&deliv_date="+encodeURIComponent(deliv_date)+"&goods_idx="+goods_idx+"&price="+goods_price+"&goods_name="+encodeURIComponent(goods_name)+"&origin_price="+origin_price
				,dataType:"json"
				,cache:false
				,error:function(xhr){ console.log(xhr.responseText); }
				,success:function(data){
					if (data.tmp_list)
					{
						$(".order_cart").html(data.tmp_list);
						$(".top_arw00").find(".arw").css('transform', 'rotate(180deg)');
						$(".top_arw00").parent().css('bottom', '0');
					}

					if (data.tmp_total){
						$(".cart_tmp_total").text(addComma(data.tmp_total));
						//$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						//$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
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
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=call_tmp_cart&cart_id="+cart_id
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
						//$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						//$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
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
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=tmp_cart_clear&cart_id="+cart_id
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
						//$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						//$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
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
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_del&cart_id="+cart_id+"&idx="+idx
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
						//$(".orderbtn").attr('onClick',"frmChk('orderfrm')");
					}
					else{
						$(".cart_tmp_total").text("0");
						//$(".orderbtn").attr('onClick',"alert('주문하실 상품을 보관함에 담아주세요 !!')");
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
					,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_update_minus&cart_id="+cart_id+"&idx="+idx
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
				,url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cart_ea_update_plus&cart_id="+cart_id+"&idx="+idx
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

		function list_allprod(){
			$("#list_all").ajaxSubmit({
				success:function(data){
					if(data == "ok"){
						call_tmp_cart("<?=$this->session->userdata('CART')?>");
						$(".top_arw00").find(".arw").css('transform', 'rotate(180deg)');
						$(".top_arw00").parent().css('bottom', '0');
					}
					else{
						$(".top_arw00").find(".arw").css('transform', 'rotate(180deg)');
						$(".top_arw00").parent().css('bottom', '0');
					}
				},
				error:function(xhr){
					console.log(xhr);
				}
			});
		}
	</script>

<!--Container-->

<div id="container" style="background-color:#F0F0f0">
	<? // include("../include/top_menu.php");?>
	<?include("../include/view_tab02.php");?>

	<!-- inner -->
	<div class="pb50">
		<div class="header_img">
			<img src="/_data/file/subinfo/<?=$cate_info->upfilem?>" alt=""  onerror="this.src='/image/default.jpg'">

			<span><img src="/m/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>
			<!-- <button type="button" class="plain" onClick="menuPop('<?=$recom_idx?>');"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
			<ul class="new_list">
				<?php
				if($cate_info->foodtable_use == "Y"){	//월별 식단표 사용여부
					?>
					<li class="list01"><a href="#" onClick="menuPop_mobile('<?=$recom_idx?>');"></a></li>
					<?php
				}

				if($cate_info->moreview_use == "Y"){	//이유식 상세보기 설명 사용여부
					?>
					<li class="list02"><a href="#" onClick="change_deliv_date01();"></a></li>
					<?php
				}
				?>
				<li class="list03"><a href="#" onClick="change_deliv_date02();"></a></li>
			</ul>
		</div>
		<!-- <h1 class="tit04"><?=$cate_info->title_b?></h1>
		<p class="gray fz16"><b><?=$cate_info->title_m?>: </b> <?=$cate_info->title_s?></p>
		<p class="mt10">
			<?=nl2br($cate_info->info)?>
			<b><?=($cate_info->bold_text) ? $cate_info->bold_text : "" ; ?></b>
		</p> -->
		<!-- 하단 창 -->



			<!-- 탭메뉴 -->
			<div class="oe_menu order_opt">
				<div class="selbox selbox02">
					<?php
					//if( ($this->input->get('recom_idx') or $this->input->get('cate_no')) and strpos($_SERVER['REQUEST_URI'],"prod_list")===false ){
					if( strpos($_SERVER['REQUEST_URI'],"prod_list")===false and $this->input->get('recom_idx') ){
						?>
						<button type="button" onclick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=$step_arr[$this->input->get('recom_idx')]?></span></button>

						<ul>
							<li class="pe01"><input type="radio" id="pe2" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=2'"><label for="pe2"><span></span><strong>5개월 전후 </strong> 준비기</label></li>
							<li class="pe04"><input type="radio" id="pe6" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=6'"><label for="pe6"><span></span><strong>9~12개월 </strong> 후기2식</label></li>
							<li class="pe02"><input type="radio" id="pe4" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=4'"><label for="pe4"><span></span><strong>5~6개월 </strong> 초기</label></li>
							<li class="pe05"><input type="radio" id="pe1" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=1'"><label for="pe1"><span></span><strong>9~12개월 </strong> 후기3식</label></li>
							<li class="pe03"><input type="radio" id="pe5" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=5'"><label for="pe5"><span></span><strong>7~8개월 </strong> 중기</label></li>
							<li class="pe06"><input type="radio" id="pe7" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=7'"><label for="pe7"><span></span><strong>12개월~ </strong> 완료기</label></li>
							<!-- <li><label for="">&nbsp;</label></li>
							<li class="pe07"><input type="radio" id="pe3" onclick="location.href='/m/html/dh/bfood_order_regular1/?recom_idx=3'"><label for="pe3"><span></span><strong>반찬/국</strong></label></li> -->
						</ul>
						<?php
					}
					else if( strpos($_SERVER['REQUEST_URI'],"prod_list")===false and $this->input->get('cate_no') ){
						?>
						<button type="button" onclick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=$step_arr[$this->input->get('cate_no')]?></span></button>
						<ul>
							<li class="pe01"><input type="radio" id="pe1" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-6'"><label for="pe1"><span></span><strong>5개월 전후 </strong> 준비기</label></li>
							<li class="pe04"><input type="radio" id="pe7" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-9'"><label for="pe7"><span></span><strong>7~8개월 </strong> 중기</label></li>
							<li class="pe02"><input type="radio" id="pe3" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-7'"><label for="pe3"><span></span><strong>5~6개월 </strong> 초기</label></li>
							<li class="pe05"><input type="radio" id="pe2" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-10'"><label for="pe2"><span></span><strong>9~12개월 </strong> 후기</label></li>
							<li class="pe03"><input type="radio" id="pe5" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-8'"><label for="pe5"><span></span><strong>7~8개월 </strong> 중기준비기</label></li>
							<li class="pe06"><input type="radio" id="pe4" onclick="location.href='/m/html/dh/bfood_order_free1/?cate_no=1-11'"><label for="pe4"><span></span><strong>12개월~ </strong> 완료기</label></li>
							<!-- <li class="pe07"><input type="radio" id="pe6" onclick="location.href='/m/html/dh/free_list/?cate_no=2-12'"><label for="pe6"><span></span><strong>반찬 </strong> </label></li> -->

							<!-- <li class="pe07"><input type="radio" id="pe8" onclick="location.href='/m/html/dh/free_list/?cate_no=2-13'"><label for="pe8"><span></span><strong>국</strong></label></li> -->
						</ul>
						<?php
					}

					/*
					<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=($this->input->get('recom_idx')) ? $step_arr[$this->input->get('recom_idx')] : $step_arr[$this->input->get('cate_no')] ;?></span></button>

					<ul>
						<?php
						foreach($step_arr as $sa_key=>$sa){
							?>
							<li><input type="radio" id="pe<?=$sa_key?>" onclick="location.href='<?=cdir()?>/dh/<?=($this->input->get('recom_idx')) ? "bfood_order_regular1" : "free_list" ;?>/?<?=($this->input->get('recom_idx')) ? "recom_idx" : "cate_no" ;?>=<?=$sa_key?>'"><label for="pe<?=$sa_key?>"><span></span><?=$sa?></label></li>
							<?php
						}
						?>
					</ul>
					*/

					else{
						if($SubName=="K0704"){	//산골야시장
							?>
							<button type="button" style="background:#BCA061;"><span class="week_day_count_span">산골야시장</span></button>
							<?php
						}
						else{
							if($cate_stat1->title){
								?>
								<button type="button" style="background:#BCA061;"><span class="week_day_count_span"><?=$cate_stat1->title?></span></button>
								<?php
							}
							else{
								if($PageName == "SALE_LIST"){
									?>
									<button type="button" style="background:#BCA061;"><span class="week_day_count_span">특가상품세트</span></button>
									<?php
								}
							}
						}
					}
					?>

				</div>

			</div>
			<script type="text/javascript" src="/js/orderPage.js"></script>
			<!-- //탭메뉴  -->

		<div class="bottm_inner freelist_btn">
			<a href="javascript:;" onclick="list_allprod()" class="btn_black">전체상품 보관함 담기</a>
			<a href="javascript:;" onClick="change_deliv_date();" class="btn_black mt10">배송일 변경/추가하기</a>
			<p class="gray mb20 mt10"> ※낱개배송은 3팩 이상 주문시 구매가능합니다.<br>
				※배송일을 기준으로 주문하실 수 있으니, 참고해주세요.<br>
				※정기배송을 이용중이면, 무료배송일자를 선택하실 수 있습니다. </p>
			<!-- <span>알레르기 체크</span> -->
			<ul class="alrg_list clearfix">
				<?php
				foreach($allergy_arr as $key => $val){
				?>
				<li><input type="checkbox" id="alrg<?=$key?>" value="<?=$key?>" class="allergy" name="allergy<?=$key?>"><label for="alrg<?=$key?>"><?=$val?></label></li>
				<?php
				}
				?>
			</ul>
			<div class="food_list free_menu mb50">
				<?php
				/*
				<h3>3월 7일 (수)</h3>
				<ul class="clearfix">
					<li>
						<img src="/m/image/sub/img01.jpg" alt="">
						<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>알러지 마크
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>
					</li>
					<li class="mr0">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>

					</li>
				</ul>
				<h3>3월 7일 (수)</h3>
				<ul class="clearfix">
					<li>
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>
					</li>
					<li class="mr0">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>
					</li>
				</ul>
				<h3>3월 7일 (수)</h3>
				<ul class="clearfix">
					<li>
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>
					</li>
					<li class="mr0">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>a05.단호박보미</p>
						<a href="#" class="btn_g">상품선택</a>
						<a href="pro_view.php" class="btn_y">상세보기</a>
					</li>
				</ul>
				*/
				?>
			</div>
		</div>


	</div>
	<!-- inner -->



	<!-- 상품선택보관함 -->

	<form action="<?=cdir()?>/dh/free_pay" method="post" name="sendfrm" id="orderfrm">
	<input type="hidden" name="cate_no" value="<?=$this->input->get('cate_no')?>">
	<input type="hidden" name="deliv_addr" value="home">

	<div class="bottom_bar bottom_bar04">
		<a href="#" class="top_arw top_arw00">
			<img src="/m/image/sub/bt_arw02.png" alt="" width="80px">
			<img src="/m/image/sub/arw05.jpg" alt="" class="arw">
		</a>
		<h1 class="tit02">
			상품선택보관함
		</h1>
		<div class="bottm_inner04 fp">

			<div class="tblTy04 order_cart">

				<?php
				/*
					<div class="mb20">
						<table>
							<colgroup>
							<col width="">
							<col width="">
							<col width="">
							<col width="18px">
							</colgroup>
							<tr>
								<th colspan="4">[3월 5일 화요일]</th>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="bg al">상품금액</th>
								<td class="orange bg">3개품목(수량 6개)</td>
								<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
							</tr>
						</table>
					</div>
					<div class="mb20">
						<table>
							<colgroup>
							<col width="">
							<col width="">
							<col width="">
							<col width="18px">
							</colgroup>
							<tr>
								<th colspan="4">[3월 5일 화요일]</th>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="bg al">상품금액</th>
								<td class="orange bg">3개품목(수량 6개)</td>
								<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
							</tr>
						</table>
					</div>
					<div class="mb20">
						<table>
							<colgroup>
							<col width="">
							<col width="">
							<col width="">
							<col width="18px">
							</colgroup>
							<tr>
								<th colspan="4">[3월 5일 화요일]</th>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="bg al">상품금액</th>
								<td class="orange bg">3개품목(수량 6개)</td>
								<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
							</tr>
						</table>
					</div>
				*/
				?>

			</div>

			<hr>

			<div class="pay clearfix mt20 mb70">
				<div class="fl">
					총 상품금액
				</div>
				<div class="fr">
					<em class='cart_tmp_total'><!-- Ajax in --></em> 원
				</div>
			</div>

		</div>
	</div>

	</form>
	<!-- //상품선택보관함 -->



<!-- 03배송일변경-->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<div class="inner clearfix">
				<div class="drawSchedule cal_wrap">

					<?php
					/*
							<div class="date_view">
								<span class="year">2017</span>년 <span class="month">04</span>월
								<a href="#" class="pre" title="이전">이전</a><a href="#" class="next" title="다음">다음</a>
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


			<button type="button" class="w100 close01" title="취소" onclick='closechange_deliv_date();'>닫기</button>
				<!-- <button type="button" class="w50 close" title="변경">변경</button> -->

		</div>
	</div>
	<!-- END 배송일변경 -->






	<!-- //하단 창 -->

	<div class="last_one">
		<p class="align-c">
			<?php
			if(!$this->session->userdata('USERID')){
				?>
				<button type="button" class="plain orderbtn" onclick="alert('로그인 후 이용 가능합니다.');location.href='/m/html/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>'"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
				<?php
			}
			else{
				?>
				<button type="button" class="plain orderbtn" onclick="order_cnt_chk()"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>
				<?php
			}
			?>
		</p>
	</div>

</div>
<!--END Container-->

	<script type="text/javascript">
		function order_cnt_chk(){
			if(parseInt($('#prod_all_cnt').val()) >= 3){
				frmChk('orderfrm');
			}
			else{
				alert('3팩이상 주문시 구매 가능합니다.');
			}
		}
	</script>


<!-- 20180524 -->
				<script>
				function change_deliv_date01(){
					$("#menu_dt_wrap01").fadeIn('fast');
				}
				function closechange_deliv_date01(){
					$("#menu_dt_wrap01 .scroll").scrollTop(0);
					$("#menu_dt_wrap01").hide();
				}


				function change_deliv_date02(){
					$("#menu_dt_wrap02").fadeIn('fast');
				}
				function closechange_deliv_date02(){
					$("#menu_dt_wrap02 .scroll").scrollTop(0);
					$("#menu_dt_wrap02").hide();
				}


				</script>

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
						<button type="button" class="plain btn_close02" title="닫기" onclick="closechange_deliv_date01();">닫기</button>
					</div>
				</div>




				<div id="menu_dt_wrap02" style="display: none;">
					<div id="menu_dt02">
						<h2 class="htit">이유식 데우는 법</h2>
						<div class="scroll">
							<img src="/m/image/sub/noti.jpg" alt="">
						</div>
						<button type="button" class="plain btn_close02" title="닫기" onclick="closechange_deliv_date02();">닫기</button>
					</div>
				</div>
<!--//20180524 -->


<? include('../include/footer.php') ?>
