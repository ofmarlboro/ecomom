<?
$this_page_full_url = (@$_SERVER['HTTPS']) ? "https://":"http://";
$this_page_full_url .= $_SERVER['HTTP_HOST'];
$this_page_full_url .= $_SERVER['REQUEST_URI'];
$option_cnt=0;

//$default_select_date = strtotime('+2 day');
//while(true){
//	if(date('w',$default_select_date) < 2){
//		$default_select_date = strtotime('+1 day',$default_select_date);
//	}
//
//	if(date('w',$default_select_date) >= 2){
//		break;
//	}
//}
//
//$default_select_date = date("Y-m-d",$default_select_date);
?>
<script>
	$(function() {
		//뒤로가기 했을 경우 폼 재정의
		$("#total_price").val('<? if($row->option_use=="1"){?>0<?}else{?><?=$row->{"shop_price".$this->session->userdata('LEVEL')}?><?}?>');
		$("#option_cnt").val(0);
		$("#option_sel").val("/");
		$("#option_sel_cnt").val("/");
		$("#option_flag").val(0);
		$("#option_flag").val(0);
		$("input[name='date_bind']").val('');
		$(".ecomom_option option:eq(0)").attr("selected", "selected");
		$("input[name='deliv_date']").prop('checked',false);
	});

	$(document).on("pageload",function(){
		window.location.reload(true);
	});

	function option_select(idx){
		$('.review_addfile_loading_wrap').show();
		if(idx){

			var cnt = $("#option_cnt").val();
			var option_sel = $("#option_sel").val();

			$.ajax({
					url: "/html/dh_product/prod_view/<?=$row->idx?>",
					data: {ajax: 1, option_idx: idx},
					async: true,
					cache: false,
					error: function(xhr){	},
					success: function(data){

						if(cnt == 0){
							$(".prod-selected").show();
						}

						<?
						if($row->idx=="543" || $row->idx=="504" || $row->idx=="540" || $row->idx=="552" || $row->idx=="553" || $row->idx=="561" || $row->idx=="562"  || $row->idx=="575"  || $row->idx=="576"
							|| $row->idx == '584' || $row->idx == '585'
							|| $row->idx == '818'
							|| $row->idx == '837'
							|| $row->idx == '847'
							|| $row->idx == '855'
						){
							?>
							var option_size = $(".prod-selected ul li").size();
							var position = option_sel.indexOf("/"+idx+"/");

							if(position <= -1 && option_size < 1){
								$(".prod-selected ul").append(data);
								$("#option_cnt").val(parseInt(cnt)+1);
								$("#option_sel").val(option_sel+idx+"/");
							}
							else{
								alert("옵션은 하나만 선택 가능합니다.");
								$('.review_addfile_loading_wrap').hide();
								return;
							}
							<?
						}
						else{
							?>
							var position = option_sel.indexOf("/"+idx+"/");

							if(position <= -1){
								$(".prod-selected ul").append(data);
								$("#option_cnt").val(parseInt(cnt)+1);
								$("#option_sel").val(option_sel+idx+"/");
							}
							<?
						}
						?>
						/*
						var option_size = $(".prod-selected ul li").size();
						var position = option_sel.indexOf("/"+idx+"/");

						if(position <= -1 && option_size < 1){
							$(".prod-selected ul").append(data);
							$("#option_cnt").val(parseInt(cnt)+1);
							$("#option_sel").val(option_sel+idx+"/");
						}
						else{
							alert("옵션은 하나만 선택 가능합니다.");
							return;
						}
						*/


						//console.log(option_index);

						//$(".prod-selected ul .option"+idx).remove();

						$('.review_addfile_loading_wrap').hide();

					}
			});

		}
		else{
			alert("옵션을 선택해주세요.");
			$('.review_addfile_loading_wrap').hide();
			return;
		}
	}

	function onView(imgName){
		$(".prod-img-zoom img").attr("src","/_data/file/addImages/"+imgName);
	}


	function option_del(idx,price){
		if(idx)
		{
			var cnt = $("#option_cnt").val();
			var option_sel = $("#option_sel").val();
			var total_price = $("#total_price").val();
			var optionCnt = $("#optionCnt"+idx).val();
			price = parseInt(price)*parseInt(optionCnt);

			if(cnt > 0){

				total_price = parseInt(total_price)-parseInt(price);

				$("#total_price").val(total_price);
				$(".total_price").html(number_format(0,total_price));

				option_sel = option_sel.replace("/"+idx+"/","/");
				$("#option_sel").val(option_sel);
				$("#option_cnt").val(parseInt(cnt)-1);
				$(".prod-selected ul .option"+idx).remove();

				if(cnt==1){
					$(".prod-selected").hide();
				}

				if(total_price==0){
					$(".total_price").html(number_format(0,<?=$row->shop_price?>));
					document.prod_form.reset();
				}

			}
		}
	}


	function sendOrder(mode){

		var option_cnt=0;

		<? if($row->unlimit==0 && $row->number == 0){?>

			alert("품절상품 입니다.");
			return;

		<?}?>

		<? if($row->option_use==1){ ?> //옵션사용일경우

			<?
			for($i=1;$i<=3;$i++){
				if($row->{'option_check'.$i}==1){
			?>
				if($("#option<?=$i?>").val()==""){
					alert("<?=${'option_row'.$i}->title?>을(를) 선택해주세요.");
					$("#option<?=$i?>").focus();
					return;
				}
			<?
				}
			}
			?>

			var option_sel = $("#option_sel").val();
			option_sel = option_sel.split("/");
			var option_sel_cnt = $("#option_sel_cnt").val();


			for(i=0;i<option_sel.length;i++){
				if(option_sel[i]){
					option_sel_cnt = option_sel_cnt + $("#optionCnt"+option_sel[i]).val() + "/";
				}
			}
			$("#option_sel_cnt").val(option_sel_cnt);


		<?}?>

		if(document.prod_form.date_bind.value == ""){
			alert("배송일을 입력해주세요.");
			return;
		}

		if($("#total_price").val()==0){
			$("#total_price").val(<?=$row->shop_price?>);
		}

		if(mode == "buy"){
			document.prod_form.action = "/html/dh_order/shop_order";
			document.prod_form.submit();
			$(".orderbtn").attr("onclick",'');
			$(".orderbtn").prop('disabled',true);
		}
		else{
			document.prod_form.submit();
			$(".orderbtn").attr("onclick",'');
			$(".orderbtn").prop('disabled',true);
		}


		//	if(mode=="buy") //바로구매
		//	{
		//		document.prod_form.action="<?=cdir()?>/dh_order/shop_order";
		//	}else if(mode=="cart"){
		//		document.prod_form.action="<?=cdir()?>/dh_order/shop_cart";
		//	}else if(mode=="wish"){
		//		<? if(!$this->session->userdata('USERID')){ ?>
		//			alert('로그인이 필요합니다.');
		//			location.href='<?=cdir()?>/dh_member/login/?go_url=<?=cdir()?>/dh_product/prod_view/<?=$row->idx?>/?cate_no=<?=$row->cate_no?>';
		//			return;
		//
		//		<?}else{?>
		//
		//		document.prod_form.action="<?=cdir()?>/dh_order/wishlist";
		//
		//		<?}?>
		//	}

	}

	function cntChange(idx,price,mode,unlimit,number){
		var total_price = $("#total_price").val();
		var opCnt = $("#optionCnt"+idx).val();

		if(mode=="u"){
			if(unlimit==0 && number==0){
				alert("품절상품 입니다.");
				return;
			}else if(unlimit==0 && number==opCnt ){
				alert("상품 재고수량이 부족합니다.");
				return;
			}
			opCnt = parseInt(opCnt)+1;
			total_price = parseInt(total_price)+parseInt(price);
		}else if(mode=="d"){
			if(opCnt > 1){
				opCnt = parseInt(opCnt)-1;
			total_price = parseInt(total_price)-parseInt(price);
			}else{
				alert("수량은 1개 이상부터 가능합니다.");
				return;
			}
		}
		$("#optionCnt"+idx).val(opCnt);

		$("#total_price").val(total_price);
		$(".total_price").html(number_format(0,total_price));

	}

	function goodsCntChange(mode){
		var goods_cnt = $("#goods_cnt").val();
		var shop_price = <?=$row->shop_price?>;
		var number = <?=$row->number?>;

		if(mode=="u"){

			<? if($row->unlimit == 0 && $row->number > 0){?>

			if(number==goods_cnt){
				alert("상품 재고수량이 부족합니다.");
				return;
			}

			<?}?>
			goods_cnt = parseInt(goods_cnt)+1;
			shop_price = parseInt(shop_price)*goods_cnt;

		}else if(mode=="d"){
			if(goods_cnt==1){
				alert("수량은 1개 이상부터 가능합니다.");
				return;
			}else{
				goods_cnt = parseInt(goods_cnt)-1;
				shop_price = parseInt(shop_price)*goods_cnt;
			}
		}

		$("#goods_cnt").val(goods_cnt);
		$("#total_price").val(shop_price);
		$(".total_price").html(addComma(shop_price));
	}

	function bbs_load(code,PageNumber){
		var goods_idx = "<?=$row->idx?>";
		if(!PageNumber){ PageNumber = 1; }
		$.ajax({
			url: "<?=cdir()?>/dh_board/lists/"+code,
			data: {ajax : "1", PageNumber : PageNumber, goods_idx : goods_idx},
			async: true,
			cache: false,
			error: function(xhr){
			},
			success: function(data){
				$("."+code+"_list").html(data);
			}
		});
	}

	function view_on(idx){
		$(".view"+idx).toggle();
	}

	//	function move_view(src){
	//
	//		//console.log('/_data/file/addImages/'+src);
	//
	//		$("#prod_img_big").attr("src","/_data/file/addImages/"+src);
	//	}

	function sns_share(sns, url, title){	//sns 공유하기 페북 , 트윗 , 구글플러스
		var sns_url = "";
		if(sns == "facebook"){
			sns_url = "https://www.facebook.com/sharer/sharer.php?u="+url+"&p="+title;
		}else if(sns == "twitter"){
			sns_url = "https://twitter.com/share?url="+url+"&text="+title;
		}else if(sns == "googleplus"){
			sns_url = "https://plus.google.com/share?url="+url;
		}

		window.open(sns_url,"SNS_SHARE","width=600,height=800,top=100,left=100");

	}

	<?
	if($row->delivery_date_use == "admin"){	//관리자 지정 배송일
	?>
		var holis = Get_holidays('<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_deliv_date&goods_idx=<?=$row->idx?>');

		function holidays(date){	//관리자 지정일 datepicker에 적용하기
			for (var i = 0; i < holis.length; i++) {
				var _dates = new Date(holis[i]);
				if (date - _dates == 0) {
					return [true, 'delivday'];
				}
			}

			return [false,''];
		}
	<?
	}
	else{	//사용자 자율 배송일
	?>
		var holis = Get_holidays('<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=get_Holiday_for_js');

		function holidays(date){	//배송휴일 datepicker에 적용하기
			for (var i = 0; i < holis.length; i++) {
				var _dates = new Date(holis[i]);
				if (date - _dates == 0) {
					return [false, 'holiday'];
				}
			}

			if (date.getDay() == 0) return [true, 'sunday'];
			else if (date.getDay() == 6) return [true, 'saturday'];
			else return [true, ''];
		}
	<?
	}
	?>

	$(function(){
		$(".sel-wrap input[type=radio]").change(function(){
			if($(this).val() == "selec"){
				$(".date-sel").show();
				<?
				if($row->delivery_date_use != "admin"){
					?>
					$(".date_bind_pic").val('');
					<?
				}
				?>

			}
			else{
				$(".date-sel").hide();
				$(".date_bind_pic").val($(this).val());
				$("input[name='relation_trade_code']").val($(this).data('tradecode'));
			}

			var text = $(this).siblings('label').text();
			$("#deliv_btn").html(text);
			toggleSelBox($(this).parents('button'), event);

		});

		$(".date_bind_pic").datepicker( "refresh" );
		$(".date_bind_pic").datepicker({
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd', //형식(20120303)
			defaultDate: "<?=$default_select_date?>",
			minDate: '+2d;',
			maxDate: '+90d;',
			beforeShowDay: holidays,
			autoSize: true, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			showMonthAfterYear: true//년 뒤에 월 표시
		});
	});
</script>

			<!-- Shop wrap -->
			<div class="shop-wrap">

				<script type="text/javascript" src="/js/product_view.js"></script>

				<!-- 제품상단 -->
				<div class="prod-top">

					<!-- 제품이미지 -->
					<div class="prod-img">
						<div class="prod-img-zoom">
							<img src="/_data/file/goodsImages/<?=$row->list_img?>" alt="제품 확대이미지" onerror="this.src='/image/default.jpg'">
						</div>
						<div class="prod-img-sm">
							<?php
							if($file_list){
							?>
							<ul class="prod-thumbs">
								<?php
								foreach($file_list as $fl){
								?>
								<li><a href="/_data/file/addImages/<?=$fl->file_name?>"><img src="/_data/file/addImages/<?=$fl->file_name?>" onerror="this.src='/image/default.jpg'"></a></li>
								<?php
								}
								?>
							</ul>
							<?php
							}
							?>
						</div>
					</div><!-- END 제품이미지 -->

					<!-- 제품정보 -->
					<div class="prod-info-wrap">
						<h3 class="prod-name"><?=$row->name?></h3>

						<!-- 우측 스티커 -->
						<div class="prod-share">
							<span>SNS 공유하기</span>
							<a href="javascript: sns_share('facebook','<?=urlencode($this_page_full_url)?>','<?=urlencode($PageTitle." - 에코맘 산골이유식")?>');" target="_blank"><img src="/image/sub/icon_fb.png" alt="Facebook"></a>
							<a href="javascript: sns_share('twitter','<?=urlencode($this_page_full_url)?>','<?=urlencode($PageTitle." - 에코맘 산골이유식")?>');"><img src="/image/sub/icon_twt.png" alt="Twitter"></a>
							<a href="javascript: sns_share('googleplus','<?=urlencode($this_page_full_url)?>','<?=urlencode($PageTitle." - 에코맘 산골이유식")?>');"><img src="/image/sub/icon_google.png" alt="Google Plus"></a>
						</div><!-- END 우측 스티커 -->

						<!-- 제품설명 -->
						<div class="prod-desc-wrap">
							<div class="prod-desc">
								<?php
								echo nl2br($row->detail);
								?>
							</div>
						</div>
						<!-- END 제품설명 -->

					<?php
					/*************************************************************************************
					*
					*		2022-05-18 산골야시장 체험신청 직접 DB 수집을 위한 작업 영역 (모바일도 봐야된다)
					*		신청하기 클릭시 페이지를 다른곳으로 옮겨줬으면함
					*		경로 : /html/dh_product/exp_apply
					*
					*************************************************************************************/
					if($row->night_market_tuto){	//산골야시장 체험신청일 경우 신청서 작성
						?>
						<p class="mt20">
							<button type="button" class="plain" <?php if(!$this->session->userdata('USERID')){?>onclick="alert('로그인 후 이용해주세요.')"<?php }else{?>onclick="location.href='/html/dh/exp_apply/<?=$row->idx?>'"<?php }?>>
								<img src="/image/sub/btn_order_etc.jpg" alt="신청thㅓ 작성하기">
							</button>
						</p>
						<?php
					}
					/*************************************************************************************
					*
					*		2022-05-18 산골야시장 체험신청 직접 DB 수집을 위한 작업 영역 종료
					*
					*************************************************************************************/
					else{
						?>
						<!-- 제품정보 -->
						<form name="prod_form" id="prod_form" method="post" action="<?=cdir()?>/dh_order/recom_cart" autocomplete="off">
						<input type="hidden" name="goods_idx" value="<?=$row->idx?>">
						<input type="hidden" name="cate_no" value="<?=$row->cate_no?>">
						<input type="hidden" name="total_price" id="total_price" value="<? if($row->option_use=="1"){?>0<?}else{?><?=$row->shop_price?><?}?>">
						<input type="hidden" name="option_cnt" id="option_cnt" value="0">
						<input type="hidden" name="option_sel" id="option_sel" value="/">
						<input type="hidden" name="option_sel_cnt" id="option_sel_cnt" value="/">
						<input type="hidden" name="option_flag" id="option_flag" value="0">

						<input type="hidden" name="deliv_grp" id="deliv_grp" value="<?=$row->deliv_grp?>">

						<input type="hidden" name="goods_origin_price" value="<?=($row->option_use == '1')?"":$row->old_price;?>">
						<input type="hidden" name="goods_price" value="<?=$row->shop_price?>">
						<input type="hidden" name="goods_name" value="<?=$row->name?>">
						<input type="hidden" name="deliv_addr" value="home">

						<?php
						if($row->option_use == '1'){
							for($i=1;$i<=3;$i++){
								if($row->{'option_check'.$i} == '1'){
									$option_cnt++;
								?>
								<div class="option_select option_select01">
									<p class="name"><?=${'option_row'.$i}->title?></p>
									<select id="option<?=$i?>" <? if(${'option_row'.$i}->flag==1){?>name="option<?=$i?>"<?}?> <? if(${'option_row'.$i}->flag!=1){?>onchange="option_select(this.value)"<?}?> msg="옵션을" class="ecomom_option">
										<option value="">선택해주세요</option>
										<?php
										foreach(${'option_list'.$i} as $opList){
											$price = explode("-",$opList->price);
											$plus="";
											if(count($price)<2){ $plus="+"; }
										?>
										<option value="<?=$opList->idx?>" <?if($opList->unlimit==0 && $opList->number==0){?>disabled<?}?>>
										<?=$opList->name?> <?if($opList->price!=0){?>(<?=$plus?><?=number_format($opList->price)?>)<?}?>
										<?if($opList->unlimit==0 && $opList->number==0){?> | 품절
										<?}else if($opList->unlimit==0 && $opList->number>0){?><?if($row->idx != '933'){?> | 재고 : <?=$opList->number?><?}?>
										<?}else{?><?}?>
										</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="prod-selected" style="display:none;">
									<ul>

									</ul>
								</div>
								<?php
								}
							}
						}
						else{
						?>
						<div class="prod-view-cnt pr_hj">
							<p class="name"><?=$row->name?></p>
							<div class="float-r float-wrap">
								<div class="cnt">
									<?php
									if($row->idx == "452" || $row->cate_no == "10"){
										?>
										<button type="button" class="plain" title="1개 감소" onclick="alert('수량조절이 불가능한 상품입니다.')"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
										<input type="text" name="goods_cnt" id="goods_cnt" value="1" readonly>
										<button type="button" class="plain" title="1개 추가" onclick="alert('수량조절이 불가능한 상품입니다.')"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
										<?php
									}
									else{
										?>
										<button type="button" class="plain" title="1개 감소" onclick="goodsCntChange('d')"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
										<input type="text" name="goods_cnt" id="goods_cnt" value="1" readonly>
										<button type="button" class="plain" title="1개 추가" onclick="goodsCntChange('u')"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
										<?php
									}
									?>
								</div>
								<p class="price">
									<?if($row->old_price){?><del><?=number_format($option_row->price+$row->old_price)?></del> <span class="unit">원</span> <img src="/image/sub/ar.jpg" alt=""><?}?>
									<em class='total_price'><?=number_format($row->shop_price)?></em> <span class="unit">원</span>
								</p>
							</div>
						</div>
						<?php
						}
						?>
						<!-- END 제품정보 -->

						<!-- 총 가격 -->
						<div class="prod-total">
							<div class="deliv">
								<?php
								if( $row->deliv_grp == "무료배송"
									|| $row->idx=="452" || $row->idx=="487" || $row->idx=="485" || $row->idx=="543" || $row->idx=="505"
									|| $row->idx=="554"
									|| $row->idx=="878"
								){
									?>
									<em>무료배송</em>
									<?php
								}
								else{
									if($row->cate_no == "10"){
										?>
										배송비 : <em><?=number_format($shop_info['express_money'])?></em>원
										<?php
									}
									else if($row->idx == '868' || $row->idx == '875'){
										?>
										배송비 : <em><?=number_format($shop_info['express_money'])?></em>원
										<?php
									}
									else{
										?>
										배송비 : <em><?=number_format($shop_info['express_money'])?></em>원<br><em><?=number_format($shop_info['express_free'])?></em>원 이상 무료배송
										<?php
									}
								}
								?>
								<!-- <p>
									<input type="checkbox" name="not_deliv" id="not_deliv" value="1"> <label for="not_deliv">제주 / 도서산간 지방으로 배송되는 경우 체크 해 주세요.</label>
								</p> -->
							</div>
							<div class="price">
								<span class="label">총 상품금액</span>
								<em class='total_price'><?=number_format($row->shop_price)?></em> <span class="unit">원</span>
							</div>
						</div><!-- END 총 가격 -->

						<!-- 배송날짜선택 -->
						<div class="prod-deliv-date">
							<?php
							if($row->delivery_date_use == "admin"){
								$deliv_days_arr = explode("@",$row->deliv_days);
								$deliv_day = "";
								foreach($deliv_days_arr as $dda){
									if($dda >= date("Y-m-d")){
										$deliv_day = $dda;
										break;
									}
								}
							?>
							<div class="tit">
								<em><img src="/image/sub/icon_cal.png" alt="" class="img-mid mr5">배송일 선택</em>
								<div class="sel-wrap">
									<button type="button" class="plain btn" onclick="toggleSelBox(this, event);" id="deliv_btn">지정된 배송일에 발송되는 상품</button>
									<ul>
										<li><input type="radio" name="deliv_date" value="selec" id="deliv_date0"><label for="deliv_date0">===배송일 직접 선택===</label></li>
									</ul>
								</div>
							</div>
							<?php
							}
							else{
							?>
							<div class="tit">
								<em><img src="/image/sub/icon_cal.png" alt="" class="img-mid mr5">예약배송에 추가</em>
								<div class="sel-wrap">
									<button type="button" class="plain btn" onclick="toggleSelBox(this, event);" id="deliv_btn"><?=($this->session->userdata('USERID'))?"일정에 추가 또는 정기배송에 추가":"로그인 후에 주문하실 수 있습니다.";?></button>
									<ul>
										<li><input type="radio" name="deliv_date" value="selec" id="deliv_date0"><label for="deliv_date0">===배송일 직접 선택===</label></li>
										<?php
										if($cart_deliv_arr){	//장바구니 담긴상품 있을때
											$cd_cnt = 0;
											foreach($cart_deliv_arr as $date=>$val){
												$cd_cnt++;
												$val_cnt = count($val['text']);
												$val_text = ($val_cnt > 1) ? " 외"  : "" ;
												$text_in_radio = date("m월 d일",strtotime($date))." ".$val['text'][0].$val_text;
											?>
											<li><input type="radio" name="deliv_date" value="<?=$date?>" id="deliv_date<?=$cd_cnt?>"><label for="deliv_date<?=$cd_cnt?>">[장바구니] <?=$text_in_radio?></label></li>
											<?php
											}
										}

										if($order_deliv_arr){	//배송내역에 기록된 DB가 있을때
											$oda_cnt = 0;
											//foreach($order_deliv_arr as $recom_date=>$recom_val){
											//
											//	$view_date = date("m월 d일",strtotime($recom_date));
											//
											//
											//	foreach($recom_val as $r){
											//		foreach($r as $v){
											//			$oda_cnt++;
													?>
													<!-- <li><input type="radio" name="deliv_date" value="<?=$recom_date?>" id="recom_date<?=$oda_cnt?>"><label for="recom_date<?=$oda_cnt?>"><?=$view_date?> <?=$v?></label></li> -->
													<?php
											//		}
											//	}
											//
											//}

											foreach($order_deliv_arr as $oda){
												$oda_cnt++;
												$prod_name_tmp = explode("]",$oda['prod_name']);
												?>
												<li>
													<input type="radio" name="deliv_date" value="<?=$oda['deliv_date']?>" id="recom_date<?=$oda_cnt?>" data-tradecode="<?=$oda['trade_code']?>">
													<label for="recom_date<?=$oda_cnt?>">[정기배송] <?=$oda['deliv_count']?>회차 <?=date("m월 d일",strtotime($oda['deliv_date']))?> <?=trim($prod_name_tmp[1])?> (<?=$oda['trade_code']?>)</label>
												</li>
												<?php
											}

										}
										?>

										<?php
										/*
										<li><input type="radio" name="deliv_date" value="2018-02-22" id="deliv_date1"><label for="deliv_date1">[장바구니] 2월 22일 중기 추천식단 외</label></li>
										<li><input type="radio" name="deliv_date" value="2018-03-22" id="deliv_date2"><label for="deliv_date2">[장바구니] 2월 12일 간식 외</label></li>
										<li><input type="radio" name="deliv_date" value="2018-04-22" id="deliv_date6"><label for="deliv_date6">[정기배송] 2월 22일 후기 3회차</label></li>
										<li><input type="radio" name="deliv_date" value="2018-05-22" id="deliv_date7"><label for="deliv_date7">[정기배송] 2월 22일 후기 4회차</label></li>
										<li><input type="radio" name="deliv_date" value="2018-06-22" id="deliv_date12"><label for="deliv_date12">[정기배송] 3월 22일 반찬/국 1회차</label></li>
										<li><input type="radio" name="deliv_date" value="2018-07-22" id="deliv_date13"><label for="deliv_date13">[정기배송] 3월 22일 반찬/국 2회차</label></li>
										*/
										?>
									</ul>
								</div>
							</div>
							<?php
							}
							?>

							<input type="hidden" name="relation_trade_code">

							<div class="date-sel" style="display:none;">
								<strong><a href="javascript:$('input[name=date_bind]').focus();">배송일 선택</a></strong>
								<input type="text" name="date_bind" class="date_bind_pic" readonly>
							</div>
						</div><!-- END 배송날짜선택 -->

						<div class="order_pop">
							<img src="/image/sub/yangyang_popup.png" alt="" class="popup" onclick="$(this).parent().hide()">
						</div>

						<p class="mt20">
							<?php
							if($row->cate_no == '10'){	//구매제한
								if($buy_cnt <= 0 && $cart_cnt <= 0){
									if($succ_order){
										?>
										<button type="button" class="plain" onclick="<?if($this->session->userdata('USERID')){?>sendOrder('cart')<?}else{?>alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login'<?}?>">
											<img src="/image/sub/btn_order2.jpg" alt="주문하기">
										</button>
										<?php
									}
								}
								else{
									?>
									<button type="button" class="plain" onclick="<?if($this->session->userdata('USERID')){?>$('.order_pop').show();<?}else{?>alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login'<?}?>">
										<img src="/image/sub/btn_order2.jpg" alt="주문하기">
									</button>
									<?php
								}
							}
							else{
								?>
								<button type="button" class="plain orderbtn" onclick="<?if($this->session->userdata('USERID')){?>sendOrder('cart')<?}else{?>alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login'<?}?>">
									<img src="/image/sub/btn_order2.jpg" alt="주문하기">
								</button>
								<?php
							}
							?>
						</p>

						</form>
						<?php
					}
					?>

					</div><!-- END 제품정보 -->

				</div><!-- END 제품상단 -->


				<!-- 제품상세탭 -->
				<ul class="shop-tab">
					<li class="on"><a href="#detail1">상세정보</a></li>
					<li><a href="#detail2">배송 및 교환/환불</a></li>
				</ul>
				<!-- END 제품상세탭 -->

				<!-- 상세정보 -->
				<div class="shop-tab-ct" id="detail1">
					<div class="u-editor">
						<?php
						if($row->idx == "485"){	//2020 햅쌀
							?>

							<!-- 2020햅쌀 시작 -->
							<script type="text/javascript">
							jQuery(document).ready(function($){

								setScrollIndex();	//스크롤 인덱스 셋팅
							});
							</script>
							<div class="ac">
								<ul class="scroll_nav scroll_nav2 clearfix ">
									<li class=" on"><a href="#cts01">엄마도 맛보세요</a></li>
									<li class=""><a href="#cts02">산골농부님 말씀</a></li>
									<li class=""><a href="#cts03">둠벙쌀 알아보기</a></li>
								</ul>


								<!-- 엄마도 -->
								<div id="cts01" class="pt90">
									<img src="/image/sub/oh_ssal_2020_02.jpg" alt="">
								</div><!-- END 엄마도 -->

								<!-- 산골농부님 -->
								<div id="cts02" class="pt90">
									<img src="/image/sub/oh_ssal_2020_03.jpg" alt="">
									<img src="/image/sub/oh_ssal_2020_04.jpg" alt="">
									<!-- <img src="/image/sub/oh_ssal_2020_05.jpg" alt=""> -->
									<div class="mg60">

									<iframe width="860" height="315" src="https://www.youtube.com/embed/OOuKpKWp0Nk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									</div>

									<img src="/image/sub/oh_ssal_2020_06.jpg" alt="">
								</div><!-- END 산골농부님 -->

								<!-- 둠벙쌀 -->
								<div id="cts03" class="pt90">
									<img src="/image/sub/oh_ssal_2020_07.jpg" alt="">
									<img src="/image/sub/oh_ssal_2020_08.jpg" alt="">

									<img src="/image/sub/oh_ssal_2020_2_04.jpg" alt="">
								</div><!-- END 둠벙쌀 -->

							</div>







							<!-- 2020햅쌀 종료 -->

							<?php
						}
						else if($row->idx == "504"){	//의기양양픽
							?>
							<!-- 의기양양픽 -->

							<script type="text/javascript">
							jQuery(document).ready(function($){

								setScrollIndex();	//스크롤 인덱스 셋팅
							});
							</script>
							<div class="ac YANG">
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class=" on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>


								<!-- 의기양양픽 -->
								<div id="cts01" class="pt90 ">
									<!-- <div class="">- 1인1세트만 신청가능하며, 추가신청시 전체자동 취소됩니다. <br>다른 맘님을 위해 꼭 1인 1세트 신청만 부탁드립니다.</div>
									 -->

									<img src="/_data/attach/plupload/yangyangpick_01.jpg" title="yangyangpick_01.jpg">

									<img src="/image/sub/yangyangpick_02_01.jpg" title="">
									<a target="_blank" href="https://www.instagram.com/sangol.kitchen/"><img src="/image/sub/yangyangpick_02_02.jpg" title=""></a>
									<img src="/image/sub/yangyangpick_02_03.jpg" title="">
								</div><!-- END 의기양양픽 -->

								<!-- 농사 -->
								<div id="cts02" class="">
									<img src="/_data/attach/plupload/yangyangpick_03.jpg" title="yangyangpick_03.jpg">

									<iframe width="560" height="315" src="https://www.youtube.com/embed/080n-dxyBUk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick_05.jpg" title="yangyangpick_05.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/S3K4_sfrDqw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									<img src="/_data/attach/plupload/yangyangpick_07.jpg" title="yangyangpick_07.jpg">

									<!-- <div class="mg60">

									<iframe width="860" height="315" src="https://www.youtube.com/embed/OOuKpKWp0Nk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									</div> -->

								</div><!-- END 농사 -->

								<!-- 레시피 -->
								<div id="cts03" class="">
									<img src="/_data/attach/plupload/yangyangpick2_01.jpg" title="yangyangpick2_01.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/8xrobH-v8Qc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									<img src="/_data/attach/plupload/yangyangpick2_03.jpg" title="yangyangpick2_03.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/UQPNktdc5mY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									<img src="/_data/attach/plupload/yangyangpick2_05.jpg" title="yangyangpick2_05.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/QvB6-HAWXTA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick2_07.jpg" title="yangyangpick2_07.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/chVrfNzPyq0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick2_09_1.jpg" title="yangyangpick2_09_1.jpg">
								</div><!-- END 레시피 -->

							</div>



							<!-- End 의기양양픽 -->
							<?php
						}
						else if($row->idx == "540"){	//4월 의기양양픽
							?>
							<!-- 	//4월 의기양양픽 -->

							<script type="text/javascript">
							jQuery(document).ready(function($){

								setScrollIndex();	//스크롤 인덱스 셋팅
							});
							</script>
							<div class="ac YANG">
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class=" on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>






								<!-- 의기양양픽 -->
								<div id="cts01" class="pt90 ">


									<img src="/_data/attach/plupload/yangyangpick4_01.jpg" title="yangyangpick4_01.jpg">
									<img src="/_data/attach/plupload/yangyangpick4_02.jpg" title="yangyangpick4_02.jpg">
									<a href="https://ecomommeal.co.kr/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/image/sub/yangyangpick4_04.jpg" alt="">
									</a>
									<a target="_blank" href="https://www.instagram.com/sangol.kitchen/"><img src="/_data/attach/plupload/yangyangpick4_03.jpg" title="yangyangpick4_03.jpg"></a>


								</div><!-- END 의기양양픽 -->

								<!-- 농사 -->
								<div id="cts02" class="">


								<img src="/_data/attach/plupload/yangyangpick4_04_1.jpg" title="yangyangpick4_04_1.jpg">

								<iframe width="560" height="315" src="https://www.youtube.com/embed/no6cOJfwe6I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								<img src="/image/sub/yangyangpick4_06.jpg" title="yangyangpick4_06_1.jpg">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/S3K4_sfrDqw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								<img src="/_data/attach/plupload/yangyangpick4_08.jpg" title="yangyangpick4_08.jpg">




								</div><!-- END 농사 -->

								<!-- 레시피 -->
								<div id="cts03" class="">

									<img src="/_data/attach/plupload/yangyangpick4_2_01.jpg" title="yangyangpick4_2_01.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/89_cnl6ss6E" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick4_2_03.jpg" title="yangyangpick4_2_03.jpg">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/wJpBbyJWKcA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick4_2_05_1.jpg" title="yangyangpick4_2_05_1.jpg">
									<img src="/_data/attach/plupload/yangyangpick4_2_06.jpg" title="yangyangpick4_2_06.jpg">
									<a href="http://ecomommeal.co.kr/html/dh_product/prod_view/504"><img src="/_data/attach/plupload/yangyangpick4_2_07.jpg" title="yangyangpick4_2_07.jpg"></a>

								</div><!-- END 레시피 -->

							</div>



							<!-- End 의기양양픽 -->



							<!-- 	//4월 의기양양픽 end  -->
							<?php
						}	//4월 의기양양픽
						else if($row->idx == "552"){	//5월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class=" on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>



								<div class="cts01 pt90 ac" id="cts01">
									<img src="/_data/attach/plupload/yangyangpick5_01.jpg" title="yangyangpick5_01.jpg">
									<a href="/html/dh_product/prod_view/553">
										<img src="/_data/attach/plupload/yangyangpick5_02.jpg" title="yangyangpick5_02.jpg">
									</a>
									<a href="/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/_data/attach/plupload/yangyangpick5_03_1.jpg" title="yangyangpick5_03_1.jpg">
									</a>

									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick5_04.jpg" title="yangyangpick5_04.jpg">
									</a>
									<img src="/_data/attach/plupload/yangyangpick5_05.jpg" title="yangyangpick5_05.jpg">

								</div>


								<div class="cts02 ac" id="cts02">
									<img src="/_data/attach/plupload/yangyangpick5_06.jpg" title="yangyangpick5_06.jpg"><br style="clear:both;">

									<iframe width="560" height="315" src="https://www.youtube.com/embed/PwiTE2tpZWw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


									<img src="/_data/attach/plupload/yangyangpick5_08.jpg" title="yangyangpick5_08.jpg">
								</div>


								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick5_2_01_2.jpg" title="yangyangpick5_2_01_2.jpg"><br style="clear:both;">


									<iframe width="560" height="315" src="https://www.youtube.com/embed/aDByWpRVhgI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>


									<img src="/_data/attach/plupload/yangyangpick5_2_03_2.jpg" title="yangyangpick5_2_03_2.jpg"><br style="clear:both;">


									<iframe width="560" height="315" src="https://www.youtube.com/embed/ccmZ-WtWDoQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									<img src="/_data/attach/plupload/yangyangpick5_2_05_1.jpg" title="yangyangpick5_2_05_1.jpg"><br style="clear:both;">

									<a href="/html/dh_product/prod_view/540">
										<img src="/_data/attach/plupload/yangyangpick5_2_06.jpg" title="yangyangpick5_2_06.jpg">
									</a>

									<a href="/html/dh_product/prod_view/504">
										<img src="/_data/attach/plupload/yangyangpick4_2_07.jpg" title="yangyangpick5_2_06.jpg">
									</a>
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "556"){	//6월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<img src="/_data/attach/plupload/yangyangpick6_01.jpg">
									<!-- 첫구매맘 이동 -->
									<a href="/html/dh_product/prod_view/557">
										<img src="/_data/attach/plupload/yangyangpick6_02.jpg">
									</a>
									<!-- 낱개주문 이동 -->
									<a href="/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/_data/attach/plupload/yangyangpick6_03.jpg">
									</a>
									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick6_04.jpg">
									</a>
									<img src="/_data/attach/plupload/yangyangpick6_05.jpg">
								</div>

								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
									<img src="/_data/attach/plupload/yangyangpick6_06_2.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/0vnSQ_q8AFE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick6_08_2.jpg">
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick6_2_01_1.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/E9QBk8RMgIQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick6_2_03_1.jpg"><br style="clear:both;">

									<a href="/html/dh_product/prod_view/552" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick6_2_04.jpg">
									</a>
									<a href="/html/dh_product/prod_view/540" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick5_2_06.jpg">
									</a>
									<a href="/html/dh_product/prod_view/504" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick4_2_07.jpg">
									</a>
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "562"){	//7월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<img src="/_data/attach/plupload/yangyangpick7_01_3.jpg" title="yangyangpick7_01_3.jpg">
									<!-- 첫구매맘 이동 -->
									<a href="/html/dh_product/prod_view/561?&cate_no=10">
										<img src="/_data/attach/plupload/yangyangpick7_02_1.jpg" title="yangyangpick7_02_1.jpg">
									</a>
									<!-- 낱개주문 이동 -->
									<a href="/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/_data/attach/plupload/yangyangpick7_03_2.jpg" title="yangyangpick7_03_2.jpg">
									</a>
									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick7_04_1.jpg" title="yangyangpick7_04_1.jpg">
									</a>
									<img src="/_data/attach/plupload/yangyangpick7_05_1.jpg" title="yangyangpick7_05_1.jpg">
								</div>

								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
									<img src="/_data/attach/plupload/yangyangpick7_06_3.jpg" title="yangyangpick7_06_3.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/dkmGveXAbEQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick7_08_2.jpg" title="yangyangpick7_08_2.jpg">
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick7_2_01.jpg" title="yangyangpick7_2_01.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/1FKRCsjfAeU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick7_2_03.jpg" title="yangyangpick7_2_03.jpg"><br style="clear:both;">


									<!-- <a href="/html/dh_product/prod_view/552" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick6_2_04.jpg">
									</a>
									<a href="/html/dh_product/prod_view/540" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick5_2_06.jpg">
									</a>
									<a href="/html/dh_product/prod_view/504" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick4_2_07.jpg">
									</a> -->
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "576"){	//2020년 8월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<img src="/_data/attach/plupload/yangyangpick8_01_5.jpg" title="yangyangpick8_01_5.jpg">

									<!-- 첫구매맘 이동 -->
									<a href="/html/dh_product/prod_view/575?&cate_no=10">
										<img src="/_data/attach/plupload/yangyangpick8_02.jpg" title="yangyangpick8_02.jpg">
									</a>
									<!-- 낱개주문 이동 -->
									<a href="/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/_data/attach/plupload/yangyangpick8_03.jpg" title="yangyangpick8_03.jpg">
									</a>
									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick8_04.jpg" title="yangyangpick8_04.jpg">
									</a>
									<img src="/_data/attach/plupload/yangyangpick8_05.jpg" title="yangyangpick8_05.jpg">
								</div>



								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
									<img src="/_data/attach/plupload/yangyangpick8_06_1.jpg" title="yangyangpick8_06_1.jpg"><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick8_07.jpg" title="yangyangpick8_07.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/8NkIV4rcWk4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick8_09.jpg" title="yangyangpick8_09.jpg"><br style="clear:both;">
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick8_2_01.jpg" title="yangyangpick8_2_01.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/cqTiF5jsGjk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick8_2_03.jpg" title="yangyangpick8_2_03.jpg"><br style="clear:both;">

								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "584"){	//2020년 9월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<!-- 영상추가 2020 09 07 -->
									<div>
										<img src="/m/image/sub/new_a01.jpg" alt="">
									</div>

									<iframe width="560" height="315" src="https://www.youtube.com/embed/Cel_cuCu210" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

									<div>
										<img src="/m/image/sub/new_a02.jpg" alt="">
									</div>
									<!-- $영상추가 2020 09 07 -->






									<img src="/_data/attach/plupload/yangyangpick9_01.jpg" title="yangyangpick9_01.jpg">

									<!-- 첫구매맘 이동 -->
									<a href="/html/dh_product/prod_view/585?&cate_no=10">
										<img src="/_data/attach/plupload/yangyangpick9_02.jpg" title="yangyangpick9_02.jpg">
									</a>
									<!-- 낱개주문 이동 -->
									<a href="https://ecomommeal.co.kr/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/image/sub/yangyangpick9_03.jpg" title="yangyangpick9_03.jpg">
									</a>
									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick9_04.jpg" title="yangyangpick9_04.jpg">
									</a>
									<img src="/_data/attach/plupload/yangyangpick9_05.jpg" title="yangyangpick9_05.jpg">
								</div>



								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
									<img src="/image/sub/yangyangpick9_06_1.jpg" title="yangyangpick9_06_1.jpg"><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick9_07.jpg" title="yangyangpick9_07.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/gvlUBtnTNUw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick9_09.jpg" title="yangyangpick9_09.jpg"><br style="clear:both;">
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick9-2_01.jpg" title="yangyangpick9_2_01.jpg"><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/JhJ64JuI8QI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/image/sub/yangyangpick9-2_03.jpg" title="yangyangpick9_2_03.jpg"><br style="clear:both;">

								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "803"){	//2020년 10월 의기양양픽
							?>

							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">
								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<!-- 인트로 추가 2020 10 06 -->
                                    <img src="/_data/attach/plupload/Untitled-2_01.jpg" alt="">
                                    <a href="/html/dh_product/prod_view/805">
                                        <img src="/_data/attach/plupload/Untitled-2_02.jpg" alt="">
                                    </a>

                                    <a href="/html/dh_product/prod_view/806/?cate_no=3">
                                        <img src="/image/sub/Untitled-2_03.jpg" alt="">
                                    </a>

                                    <a href="/m/html/dh/intro_forest">
                                        <img src="/_data/attach/plupload/Untitled-2_04.jpg" alt="">
                                    </a>
									<!-- $인트로 추가 2020 10 06 -->


									<img src="/_data/attach/plupload/yangyangpick10_%25EC%2588%2598%25EC%25A0%25952_01.jpg" alt="">

									<!-- 첫구매맘 이동 -->
									<a href="/html/dh_product/prod_view/804?&cate_no=10">
                                        <img src="/_data/attach/plupload/yangyangpick10_%25EC%2588%2598%25EC%25A0%25952_02.jpg" alt="">
									</a>
									<!-- 낱개주문 이동 -->
									<a href="/html/dh/bfood_order_free1/?cate_no=1-10">
										<img src="/_data/attach/plupload/yangyangpick10_03.jpg" alt="">
									</a>
									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
										<img src="/_data/attach/plupload/yangyangpick10_04.jpg" alt="">
									</a>
									<img src="/image/sub/yangyangpick10_05.jpg" alt="">
								</div>



								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
                                    <img src="/image/sub/yangyangpick10_06.jpg" alt=""><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick10_06.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/bqzTzeBJtDw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick10-2_01.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/T1syWV6fZaI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick10-2_03.jpg" alt=""><br style="clear:both;">
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "818"){	//2020년 11월 의기양양픽
							?>
							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">

								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<a href="/html/dh/event03"><img src="/image/sub/top_event_11ekyy.jpg" alt=""></a>
                                    <img src="https://ecomommeal.co.kr/_data/attach/plupload/yangyangpick12_01_2.jpg" alt="">

									<!-- 낱개주문 이동 -->
                                    <a href="/html/dh/bfood_order_free1/?cate_no=1-10">
                                        <img src="/_data/attach/plupload/yangyangpick11_02_1.jpg" alt="">
                                    </a>

									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
                                        <img src="/_data/attach/plupload/yangyangpick11_03.jpg" alt="">
                                    </a>

                                    <img src="/_data/attach/plupload/yangyangpick11_04.jpg" alt="">



								</div>



								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
                                    <img src="/_data/attach/plupload/yangyangpick11_05.jpg" alt=""><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick11_06.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/dIzri1rwfbg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick11_08.jpg" alt=""><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick11_09.jpg" alt=""><br style="clear:both;">
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick11-2_01.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/OOrQTFqsCMw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick11-2_03.jpg" alt=""><br style="clear:both;">
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else if($row->idx == "837"){	//2020년 12월 의기양양픽
							?>
							<script type="text/javascript">
								jQuery(document).ready(function($){

									setScrollIndex();	//스크롤 인덱스 셋팅
								});
							</script>

							<div class="YANG">

								<!-- 퍼블리싱 시작 -->
								<ul class="scroll_nav scroll_nav3 clearfix ">
									<li class="on"><a href="#cts01">의기양양픽</a></li>
									<li class=""><a href="#cts02">농사 픽</a></li>
									<li class=""><a href="#cts03">레시피 픽</a></li>
								</ul>

								<!-- 1번 섹션 -->
								<div class="cts01 pt90 ac" id="cts01">
									<a href="/html/dh/event03"><img src="/image/sub/yangyangpick12_01.jpg" alt="" class="mb15"></a>
									<a href="/html/dh_product/prod_view/835?&type=nmk&cate_no=3" ><img src="/image/sub/yasijang_banner.jpg" alt="" class="mb15"></a>
                                    <img src="/_data/attach/plupload/yangyangpick12_01_2.jpg" alt="">

									<!-- 낱개주문 이동 -->
                                    <a href="/html/dh/bfood_order_free1/?cate_no=1-10">
                                        <img src="/_data/attach/plupload/yangyangpick12_02.jpg" alt="">
                                    </a>

									<!-- 인스타그램 이동 -->
									<a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
                                        <img src="/_data/attach/plupload/yangyangpick12_03.jpg" alt="">
                                    </a>

                                    <img src="/_data/attach/plupload/yangyangpick12_04_01.jpg" alt="">



								</div>



								<!-- 2번 섹션 -->
								<div class="cts02 ac" id="cts02">
                                    <img src="/_data/attach/plupload/yangyangpick12_05_1.jpg" alt=""><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick12_05.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/HddxyNPuy7Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick12_07_2.jpg" alt=""><br style="clear:both;">
									<img src="/_data/attach/plupload/yangyangpick12_08.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/xBErPuhCSvI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>

								<!-- 3번 섹션 -->
								<div class="cts03 ac" id="cts03">
									<img src="/_data/attach/plupload/yangyangpick12-2_01.jpg" alt=""><br style="clear:both;">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/BN8fCanVHgE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<img src="/_data/attach/plupload/yangyangpick12-2_03.jpg" alt=""><br style="clear:both;">
								</div>

							</div>
							<!-- 퍼블리싱 종료 -->

							<?php
						}
						else{
							echo $row->content1;
						}
						?>
					</div>

					<?php
					/*
					<table class="cm_tbl align-c">
						<colgroup>
							<col style="width:20%;">
							<col style="width:30%;">
							<col style="width:20%;">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th>제품소재</th>
								<td>상품페이지 참고</td>
								<th>세탁방법 및 취급시 주의사항</th>
								<td>상품페이지 참고</td>
							</tr>
							<tr>
								<th>색상</th>
								<td>상품페이지 참고</td>
								<th>제조연월</th>
								<td>상품페이지 참고</td>
							</tr>
							<tr>
								<th>치수</th>
								<td>상품페이지 참고</td>
								<th>품질보증기준</th>
								<td>상품페이지 참고</td>
							</tr>
							<tr>
								<th>제조자</th>
								<td>상품페이지 참고</td>
								<th>A/S책임자와 전화번호</th>
								<td>상품페이지 참고</td>
							</tr>
						</tbody>
					</table>
					*/
					?>
				</div>
				<!-- END 상세정보 -->


				<!-- 제품상세탭 -->
				<ul class="shop-tab">
					<li><a href="#detail1">상세정보</a></li>
					<li class="on"><a href="#detail2">배송 및 교환/환불</a></li>
				</ul>
				<!-- END 제품상세탭 -->

				<!-- 반품 및 교환 -->
				<div class="shop-tab-ct" id="detail2">
					<div class="u-editor">
						<?=$row->delivery?>
					</div>
				</div>
				<!-- END 반품 및 교환 -->
				<hr>

				<p class="align-c mt50">
					<?php
					if($row->idx == '972' || $row->idx == '973'){
						?>
						<a href="<?=cdir()?>/dh/preview02#set05" class="btn-normal">목록으로</a>
						<?php
					}
					else if($row->cate_no == '7'){
						?>
						<a href="<?=cdir()?>/dh/preview" class="btn-normal">목록으로</a>
						<?php
					}
					else{
						?>
						<a href="<?=cdir()?>/dh_product/prod_list/<?=$qst?>" class="btn-normal">목록으로</a>
						<?php
					}
					?>
				</p>

				<script type="text/javascript">
					  kakaoPixel('5114912039431747532').viewContent({
							id: "<?=$row->idx?>"
					  });
				</script>


			</div><!-- END Shop wrap -->