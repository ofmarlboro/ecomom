<?
$this_page_full_url = (@$_SERVER['HTTPS']) ? "https://":"http://";
$this_page_full_url .= $_SERVER['HTTP_HOST'];
$this_page_full_url .= $_SERVER['REQUEST_URI'];
$option_cnt=0;

$default_select_date = strtotime('+2 day');
while(true){
	if(date('w',$default_select_date) < 2){
		$default_select_date = strtotime('+1 day',$default_select_date);
	}

	if(date('w',$default_select_date) >= 2){
		break;
	}
}

$default_select_date = date("Y-m-d",$default_select_date);
?>
<script>
	$(function() {
		$("input[name='deliv_date']").prop('checked',false);
	});

	function option_select(idx){
		$('.review_addfile_loading_wrap').show();
		if(idx){

			var cnt = $("#option_cnt").val();
			var option_sel = $("#option_sel").val();

			$.ajax({
					url: "<?=cdir()?>/dh_product/prod_view/<?=$row->idx?>",
					data: {ajax: 1, option_idx: idx},
					async: true,
					cache: false,
					error: function(xhr){	},
					success: function(data){

						if(cnt == 0){
							$(".prod-selected").show();
						}

						<?
						if($row->idx=="543" || $row->idx=="504" || $row->idx=="540" || $row->idx == "552" || $row->idx == "553" || $row->idx == "556" || $row->idx == "557" || $row->idx=="561" || $row->idx=="562"  || $row->idx=="575"  || $row->idx=="576"
							|| $row->idx=="584"  || $row->idx=="585"
							|| $row->idx=="818"
							|| $row->idx=="837"
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
			alert("배송일을 입력해 주세요.");
			return;
		}

		if($("#total_price").val()==0){
			$("#total_price").val(<?=$row->shop_price?>);
		}

		if(checkForm('prod_form')){
			if(mode == "buy"){
				document.prod_form.action = "/m/html/dh_order/shop_order";
				document.prod_form.submit();
			}
			else{
				document.prod_form.submit();
			}
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

	function move_view(src){
		$(".prod-img-zoom img").attr('src','/data/file/addImages/'+src);
	}

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

	/*
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
	*/

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

		<h1 class="pro_tit">
			<?=$row->name?>
		</h1>
		<p class="gray">
								<?php
								echo nl2br($row->detail);
								?>
		</p>
		<div class="prod-top">

			<!-- 제품이미지 -->
			<div class="prod-img">
				<div class="prod-img-zoom">
					<img src="/_data/file/goodsImages/<?=$row->list_img?>" alt="제품 확대이미지" onerror="this.src='/image/default.jpg'">
				</div>
				<?php
				if($file_list){
				?>
				<div class="prod-img-sm">
					<ul class="prod-thumbs">
						<?php
						foreach($file_list as $fl){
						?>
						<li>
							<a href="javascript:onView('<?=$fl->file_name?>');"><img src="/_data/file/addImages/<?=$fl->file_name?>" onerror="this.src='/image/default.jpg'"></a>
						</li>
						<?php
						}
						?>
					</ul>
				</div>
				<?php
				}
				?>
			</div>
			<!-- END 제품이미지 -->

		<?php
		if($row->idx == "545"){
			?>
			</div>

			<p class="mt20 align-c">
				<button type="button" class="plain" onclick="window.open('https://forms.gle/eqUkS4XjUuq8KfATA')">
					<img src="/image/sub/btn_order_etc.jpg" alt="신청서 작성하기">
				</button>
			</p>
			<?php
		}
		else{
			?>
			<!-- 제품정보 -->
			<form name="prod_form" id="prod_form" method="post" action="<?=cdir()?>/dh_order/recom_cart" autocomplete="off">

				<input type="hidden" name="userid" value="<?=$member_info->userid?>">
				<input type="hidden" name="name" value="<?=$member_info->name?>">
				<input type="hidden" name="phone" value="<?=$member_info->phone1."-".$member_info->phone2."-".$member_info->phone3?>">
				<input type="hidden" name="goods_idx" value="<?=$row->idx?>">
				<input type="hidden" name="goods_name" value="<?=$row->name?>">

			<div class="prod-info-wrap prod_hj">
				<!-- 제품정보 -->
				<div class="option_select">
					<p class="name">단계 선택</p>
					<select name="cate">
						<option value="">선택해주세요</option>
						<option value="초기">초기</option>
						<option value="중기">중기</option>
						<option value="후기">후기</option>
						<option value="완료기">완료기</option>
					</select>
				</div>
				<!-- END 제품정보 -->
			</div>
			</form>
			<!-- END 제품정보 -->

		</div>

		<div class="order_pop" id="none_buyit" style="top:330px;z-index:999;">
			<img src="/image/sub/yangyang_popup.png" alt="" class="popup" onclick="$(this).parent().hide()">
		</div>

		<p class="mt20 align-c">
			<?php
			if(strtotime($row->apply_sdate) <= time() && strtotime($row->apply_edate) >= time()){	//시간 설정
				if($buy_cnt || $apply_cnt){
					?>
					<button type="button" class="plain" onclick="<?if($this->session->userdata('USERID')){?>$('#none_buyit').show();<?}else{?>alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login?go_url=<?=$_SERVER['REQUEST_URI']?>'<?}?>">
						<img src="/image/sub/btn_apply.jpg" alt="신청하기">
					</button>
					<?php
				}
				else{
					?>
					<button type="button" class="plain" id="apply_submit" onclick="<?if($this->session->userdata('USERID')){?>ajax_frmsend()<?}else{?>alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login?go_url=<?=$_SERVER['REQUEST_URI']?>'<?}?>">
						<img src="/image/sub/btn_apply.jpg" alt="신청하기">
					</button>
					<?php
				}
			}
			else{
				?>
				<button type="button" class="plain" onclick="alert('신청 가능한 일시가 아닙니다.');">
					<img src="/image/sub/btn_apply.jpg" alt="신청하기">
				</button>
				<?php
			}
			?>
		</p>

			<?php
		}
		?>
	</div>
	<!-- inner -->

	<div class="order_pop" id="success_apply" style="top:520px;z-index:999;">
		<img src="/image/sub/success_apply.jpg" alt="" class="popup" onclick="location.reload();">
	</div>

	<script type="text/javascript">
		function ajax_frmsend(){
			frm = document.prod_form;
			$("#apply_submit").prop('disabled',true);
			if(frm.cate.value == ''){
				alert("단계를 선택해주세요.");
				$("#apply_submit").prop('disabled',false);
				return;
			}

			frm_data = $("#prod_form").serialize();

			$.ajax({
				url:"<?=cdir()?>/dh_order/order_apply",
				type:"POST",
				cache:false,
				data:frm_data,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(res){
					if(res == "ok"){
						$("#success_apply").show();
					}
					else{
						alert("DB 입력에 오류가 발생하였습니다. 다시 시도해주세요.");
					}
				}
			});
		}
	</script>


		<ul class="tabMenu mt30">
			<li class="on">
				<a href="#">상품상세정보</a>
			</li>
			<li>
				<a href="#">배송 및 교환/환불</a>
			</li>
		</ul>
		<div class="content_wrap mb50">
			<div class="on">

				<?php
				if($row->idx == "485"){	//2020 햅쌀
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202001.php";
				}
				else if($row->idx == "504"){	//의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202002.php";
				}
				else if($row->idx == "540"){	//4월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202004.php";
				}
				else if($row->idx == "552"){	//5월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202005.php";
				}
				else if($row->idx == "556"){	//6월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202006.php";
				}
				else if($row->idx == "562"){	//7월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202007.php";
				}
				else if($row->idx == "576"){	//2020 8월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202008.php";
				}
				else if($row->idx == "584"){	//2020 9월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202009.php";
				}
				else if($row->idx == "803"){	//2020 10월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202010.php";
				}
				else if($row->idx == "818"){	//2020 11월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202011.php";
				}
				else if($row->idx == "837"){	//2020 12월 의기양양픽
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202012.php";
				}
				else if($row->idx == "847"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202101.php";
				}
				else if($row->idx == "855"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202102.php";
				}
				else if($row->idx == "870"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202103.php";
				}
				else if($row->idx == "879"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202104.php";
				}
				else if($row->idx == "893"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202105.php";
				}
				else if($row->idx == "908"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202106.php";
				}
				else if($row->idx == "914"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202107.php";
				}
				else if($row->idx == "925"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202108.php";
				}
				else if($row->idx == "934"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202109.php";
				}
				else if($row->idx == "948"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202110.php";
				}
				else if($row->idx == "954"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202111.php";
				}
				else if($row->idx == "961"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202112.php";
				}
				else if($row->idx == "1283"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202201.php";
				}
				else if($row->idx == "1289"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202202.php";
				}
				else if($row->idx == "1298"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202203.php";
				}
				else if($row->idx == "1304"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202204.php";
				}
				else if($row->idx == "1313"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202205.php";
				}
				else if($row->idx == "1359"){
					include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/yangyang/202206.php";
				}
				else{
					echo $row->content1;
				}
				?>
			</div>
			<div>
				<?=$row->delivery?>
			</div>
		</div>
		<script>
			$('.tabMenu a').on('click',function(e){
				e.preventDefault();
				$(this).parent().addClass('on').siblings().removeClass('on');
				var n = $(this).index();
				$('.content_wrap > div').eq(n).addClass('on').siblings().removeClass('on');
			});
		</script>
		<hr>
		<p class="ac mt40">
			<a href="<?=cdir()?>/dh_product/prod_list/<?=$qst?>" class="btn_g fz16">목록으로</a>
		</p>

		<script type="text/javascript">
			  kakaoPixel('5114912039431747532').viewContent({
					id: "<?=$row->idx?>"
			  });
		</script>