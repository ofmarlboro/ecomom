<?
	if(!$this->input->get('cate_no')){
		alert(cdir()."/dh/bfood_order_free1/?cate_no=1-6");
	}

	$PageName = "K02";
	$SubName = "K0202";
	include("../include/head.php");
	include("../include/header.php");
?>

	<input type="hidden" name="default_select_date" value="<?=$default_select_date?>">
	<input type="hidden" name="default_start_date" value="<?=$default_select_date?>">

	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">
		function move_view(src){
			$(".view img").attr('src',src);
		}

		function LoadFreefood(this_mon){	//골라담기 로딩 ajax
			$(".review_addfile_loading_wrap_for_ajax").show();
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
				}
				,complete:function(){
					$(".review_addfile_loading_wrap_for_ajax").hide();
				}
			});
		}

		$(window).ready(function(){	//기본설정 셋
			LoadFreefood('<?=$default_select_date?>');	//선택일자가 없는 경우 오늘을 기준으로 보냄
		});

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
			$(".review_addfile_loading_wrap").show();

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
					$(".review_addfile_loading_wrap").hide();
				}
			});
		}

		function add_tmp_cart(deliv_date,goods_idx,goods_price,goods_name,origin_price){
			var userid = "<?=$this->session->userdata('USERID')?>";
			if(!userid){
				alert("로그인 후 이용 가능합니다.");
				location.href="<?=cdir()?>/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>";
			}
			else{
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
		<?include("../include/sub_top.php");?>
		<!-- 중간 아이콘 카테고리 -->
		<div class="mid_cate_wrap">
			<div class="inner">
				<ul class="mid_cate">
					<li <?if($this->input->get('cate_no') == "1-6"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-6"><span class="icon i1"></span>
							<p class="tit"><em>5개월 전후</em>준비기</p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "1-7"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-7"><span class="icon i2"></span>
							<p class="tit"><em>5~6개월</em>초기</p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "1-8"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-8"><span class="icon i3"></span>
							<p class="tit"><em>7~8개월</em>중기 준비기</p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "1-9"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-9"><span class="icon i3"></span>
							<p class="tit"><em>7~8개월</em>중기</p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "1-10"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-10"><span class="icon i4"></span>
							<p class="tit"><em>9~12개월</em>후기</p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "1-11"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=1-11"><span class="icon i6"></span>
							<p class="tit"><em>12개월~</em>완료기</p>
						</a>
					</li>
					<!-- <li <?if($this->input->get('cate_no') == "2-12"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=2-12"><span class="icon i7"></span>
							<p class="tit"><em>반찬</em></p>
						</a>
					</li>
					<li <?if($this->input->get('cate_no') == "2-13"){?>class="on"<?}?>><a href="<?=cdir()?>/dh/bfood_order_free1/?cate_no=2-13"><span class="icon i7"></span>
							<p class="tit"><em>국</em></p>
						</a>
					</li> -->
				</ul>
			</div>
		</div>
		<!-- END 중간 아이콘 카테고리 -->

		<?include("../include/cate_info.php");?>


		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
		<form action="<?=cdir()?>/dh/bfood_order_free2" method="post" name="sendfrm" id="orderfrm">

		<input type="hidden" name="cate_no" value="<?=$this->input->get('cate_no')?>">

			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<!-- 안내 -->
				<div class="info">
					<p class="float-l">
						※ 오른쪽 달력에서 배송날짜를 선택하시면 주문가능한 상품이 표시됩니다.
					</p>
					<span class="float-r">
						<button type="button" class="plain" onclick="menuPop('<?=$recom_idx?>');"><img src="/image/sub/btn_sched.png" alt="식단표 보기"></button>
					</span>
				</div><!-- END 안내 -->

				<!-- 알러지 선택 -->
				<div class="alrg_chk float-wrap">
					<p class="tit">알레르기 체크</p>
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
				<div class="sched_menu_box free_menu">
					<?php // ajax_json, LoadFreefood() < go to dh/dh_ajax?mode ?>
				</div><!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<h4 class="h_tit">배송 받을 날짜를 선택해 주세요.</h4>
					<p class="h_desc">신선도를 유지하기 위해 배송일자에 따라 조리이유식이 달라집니다.<br> <span class="circle">주황색 동그라미 :</span>정기배송을 이용중이면 배송 받을 날짜에 무료배송이 가능합니다. </p>
					<!-- 날짜선택 달력 -->
					<?php
					/*
					<!--
						흐린색, 선택불가능한 날짜 : td.dimmed
						정기배송일 : td.reg_on (정기배송 신청 선택된 날짜/요일)
						배송시작일 : start_deliv
					-->
					*/
					?>
					<div class="cal_wrap">
						<?php // ajax_json, LoadFreefood() < go to dh/dh_ajax?mode ?>
					</div>
					<!-- END 날짜선택 달력 -->

					<input type="hidden" name="deliv_addr" value="home">

					<?php
					/*
					<div class="order_set">
						<?php
						include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.deliv_addr.php";
						?>
					</div>
					*/
					?>

					<div class="order_cart_tit">
						<p>상품선택 보관함</p>
						<button type="button" class="plain btn_del" onclick="tmp_cart_clear('<?=$this->session->userdata('CART')?>')">비우기</button>
					</div>

					<!-- 상품이 없을경우(.order_cart는 가리기) -->
					<p class="order_cart_no" style="display:none;">선택한 상품이 없습니다.</p>

					<!-- 상품이 있는경우만 노출 -->
					<div class="order_cart">
						<?php
						/*
							<div class="order_cart_head">
								<p class="prod">단계/상품명</p>
								<p class="unit">단가</p>
								<p class="cnt">수량</p>
								<p>금액</p>
							</div>

							<!-- 날짜별 반복구간 -->
							<div class="order_cart_group">
								<p class="date">[3월 5일 화요일]</p>
								<ul class="added_prod">
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
								</ul>
								<div class="total">
									<p class="tit">상품금액</p>
									<p class="float-r">
										<em class="cnt">3개품목 (수량6개)</em>
										<em class="price">28,800</em>
										<span>원</span>
									</p>
								</div>
							</div><!-- END 날짜별 반복구간 -->

							<!-- 날짜별 반복구간 -->
							<div class="order_cart_group">
								<p class="date">[3월 5일 화요일]</p>
								<ul class="added_prod">
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
									<li><div class="row">
											<p class="prod">A11. 닭가슴살보미</p>
											<p class="unit_price">3,600<span>원</span></p>
											<div class="cnt">
												<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
												<input type="text" value="1">
												<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
											</div>
											<p class="total_price">6,900<span>원</span></p>
											<button type="button" class="plain del" title="삭제"><img src="/image/sub/opt_del.png" alt="삭제"></button>
										</div>
									</li>
								</ul>
								<div class="total">
									<p class="tit">상품금액</p>
									<p class="float-r">
										<em class="cnt">3개품목 (수량6개)</em>
										<em class="price">28,800</em>
										<span>원</span>
									</p>
								</div>
							</div><!-- END 날짜별 반복구간 -->
						*/
						?>
					</div>

				</div>

				<div class="order_opt_light">
					<table class="order_opt price_tbl">
						<tbody>
							<tr class="total">
								<th>총 상품금액</th>
								<td><ins class='cart_tmp_total'></ins>원</td>
							</tr>
						</tbody>
					</table>
					<p class="align-c mt20 mb5">
						<?php
						if(!$this->session->userdata('USERID')){
							?>
							<button type="button" class="plain orderbtn" title="주문하기" onclick="alert('로그인 후 이용 가능합니다.');location.href='/html/dh_member/login/?go_url=<?=$_SERVER['REQUEST_URI']?>'"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						else{
							?>
							<button type="button" class="plain orderbtn" title="주문하기" onclick="order_cnt_chk()"><img src="/image/sub/btn_order.jpg" alt="주문하기"></button>
							<?php
						}
						?>
					</p>
				</div>
			</div><!-- END 선택 옵션영역 -->
		</form>
		</div><!-- END 주문옵션 WRAP -->
	</div><!--END Container-->

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

	<?include("../include/menu_detail.php");?>

<?include("../include/footer.php");?>
