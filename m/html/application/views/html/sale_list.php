<?
	$PageName = "SALE_LIST";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
	<input type="hidden" name="default_select_date" value="<?=$default_select_date?>">
	<input type="hidden" name="default_start_date" value="<?=$default_select_date?>">

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">
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
					closechange_deliv_date();
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
						$(".top_arw00").find(".arw").css('transform', 'rotate(180deg)');
						$(".top_arw00").parent().css('bottom', '0');
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
	</script>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
			<?include("../include/view_tab02.php");?>

	<!-- inner -->
	<?php
	//상단 카테고리 설명
	?>
	<div class="pb50">
		<div class="header_img">
			<img src="/_data/file/subinfo/<?=$cate_info->upfile1?>" alt="" onerror="this.src='/image/default.jpg'">

			<span><img src="/m/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>
			<!-- <button type="button" class="plain" onclick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
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
		<br>
		<b><?=($cate_info->bold_text) ? $cate_info->bold_text : "" ; ?></b>
		</p> -->
		<!-- <a href="#" class="btn_gray w100 mt10">더보기+</a> -->
<?php
	//레이어 1 제품 리스트
	?>


		<?include("../include/view_tab03.php");?>


		<a href="javascript:;" onClick="change_deliv_date();" class="btn_black btn_black02">배송일 변경/추가하기</a>
		<div class="bottm_inner pt20">
<p class="gray mt10">
				- <strong>한 번에 많은양의 이유식</strong>을 구매하는 고객을 위한 상품입니다.<br>
				- 메뉴선택이 불가하며, <strong>한 메뉴당 3팩씩</strong> 중복됩니다.<br>
				- <strong>메뉴확인은</strong> 낱개배송에서 배송날짜를 선택해 확인하세요.<br>
				- 알레르기가 있다면 낱개배송을 이용하세요<br><br>

				※ 배송일을 기준으로 주문하실 수 있으니, 참고해주세요.<br>
				※ 추천상품(정기배송)을 주문하기 전에 먼저 세트상품을 경험해보세요.<br>
				※ 냉장보관 7일이내<br><br>
			</p>
			

			<div id="dgroup1">

			</div>

			<?php
			/*
				<ul class="clearfix sam_list">
					<li>
							<img src="/m/image/sub/002.png" alt="">

							<p><span>[특가상품]</span><br>이유식초기</p>
							<a href="" class="btn_g">상품선택</a>
						</li>
						<li class="mr0">
							<img src="/m/image/sub/002.png" alt="">
							<p><span>[특가상품]</span><br>이유식초기</p>
							<a href="" class="btn_g">상품선택</a>
						</li>
						<li>
							<img src="/m/image/sub/002.png" alt="">
							<p><span>[특가상품]</span><br>이유식초기</p>
							<a href="" class="btn_g">상품선택</a>
						</li>
						<li class="mr0">
							<img src="/m/image/sub/002.png" alt="">
							<p><span>[특가상품]</span><br>이유식초기</p>
							<a href="" class="btn_g">상품선택</a>
						</li>
				</ul>
			*/
			?>

			<div class="pd50"></div>
		</div>


	</div>
	<!-- inner -->

	<!-- 하단 창 -->






	<!-- 상품선택보관함 -->
	<?php
	//레이어 2 상품 보관함
	?>
	<form action="<?=cdir()?>/dh/sale_pay" method="post" name="sendfrm" id="orderfrm">
	<input type="hidden" name="deliv_addr" value="home">

	<div class="bottom_bar bottom_bar04">
		<a href="#" class="top_arw top_arw00"><img src="/m/image/sub/bt_arw02.png" alt="" width="80px"><img src="/m/image/sub/arw05.jpg" alt="" class="arw"></a>
		<h1 class="tit02">상품선택보관함</h1>
		<div class="bottm_inner04 fp">
			<div class="tblTy04 order_cart">

			</div>

			<hr>

			<div class="pay clearfix mt20">
				<div class="fl">
					총 상품금액
				</div>
				<div class="fr">
					<em class='cart_tmp_total'></em>원
				</div>
			</div>

		</div>
	</div>
	</form>
	<!-- //상품선택보관함 -->


<div class="last_one">

<p class="align-c">
				<button type="button" class="plain orderbtn" onclick="frmChk('orderfrm')"><img src="/m/image/sub/order_0_03.png" alt="주문하기">주문하기</button>


			</p>
</div>

	<script>
 function change_deliv_date(){
		$(".layer_pop").fadeIn('fast');
		return false;
	}
	function closechange_deliv_date(){
		$(".layer_pop").hide();
	}



$(window).on('load resize', function(){
    ww=$(window).height()
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
    //    $('.bottm_inner').css('height', '840px');
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
    //    $('.bottm_inner').css('height', '690px');
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
    //  $('.bottm_inner').css('height', '490px');
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
		$('.bottm_inner04').css('height', '490px')
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
		})
    }
    else if (ww > 700){
        $('.bottom_bar02').css('height', '380px');
      //  $('.bottm_inner').css('height', '350px')
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
		$('.bottm_inner04').css('height', '310px')
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
		})

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



	</script>




	<!-- //하단 창 -->

</div>

<!--END Container-->



<!-- 03배송일변경-->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<div class="inner clearfix">
				<div class="drawSchedule cal_wrap">

				</div>
			</div>
			<button type="button" class="w100 close01" title="취소" onclick='closechange_deliv_date();'>닫기</button>
		</div>
	</div>
	<!-- END 배송일변경 -->

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
