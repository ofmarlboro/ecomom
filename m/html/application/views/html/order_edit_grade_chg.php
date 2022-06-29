<!doctype html>
<html lang="ko">
	<head>
	<title>단계변경 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">
	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/m/css/@default.css?t=<?=time()?>" />
	<script type="text/javascript" src="/m/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/m/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/m/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/m/js/slick.min.js"></script>
	<script type="text/javascript" src="/m/js/setting.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/m/js/common.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script language="javascript" src="/_data/js/jquery.form.js" type="text/javascript"></script>
	<script type="text/javascript">
		function calc_price(val){
			$.ajax({
				url:"<?=cdir()?>/dh_order/change_grade/?time=<?=time()?>&deliv_code="+encodeURIComponent("<?=$this->input->get('deliv_code')?>")
					+"&change_recom_idx="+val
					+"&recom_idx=<?=$row->recom_idx?>&deliv_count=<?=$reverse_recom_date[$row->deliv_date]?>",
				type:"GET",
				dataType:"json",
				error:function(xhr){
					console.log(xhr);
				},
				success:function(data){
					console.log(data);
					$(".before_name").html(data.before_grade_name);
					$(".after_name").html(data.after_grade_name);
					$(".deff_price").html(number_format(data.price,1));
					$(".info_view").show();
					//document.print(data);

					//if(parseInt(data.price) > parseInt(data.total_point)){
					//	$(".point_pay").hide();
					//}

					$("input[name='recom_idx']").val(data.before_recom_idx);
					$("input[name='chg_recom_idx']").val(data.after_recom_idx);
					$("input[name='price']").val(data.price);
					$("input[name='recom_name']").val(data.before_name);
					$("input[name='chg_recom_name']").val(data.after_name);
					$("input[name='remain_deliv_count']").val(data.remain_deliv_count);
					$("input[name='trade_code']").val(data.trade_code);
					$("input[name='chg_recom_pack_ea']").val(data.chg_recom_pack_ea);
					$("input[name='week_day_count']").val(data.week_day_count);
					$("input[name='week_type']").val(data.week_type);
					$("input[name='deliv_sun_type']").val(data.deliv_sun_type);

					$("input[name='LGD_PRODUCTINFO']").val("단계변경:"+data.after_name);
					$("input[name='LGD_AMOUNT']").val(data.price);
				}
			});
		}

		function pay_point(){
			if(confirm("포인트로 전액을 결제합니다.\n변경 하시겠습니까?")){
				$("input[name='pay_method']").val('point');
				$("#grade_frm").submit();
			}
		}

		function pay_pg(pay_method){
			//var pm_text = "";
			//if(pay_method == "1"){
			//	pm_text = "신용카드";
			//}
			//else if(pay_method == "3"){
			//	pm_text = "계좌이체";
			//}
			//alert("선택된 결제방식은 "+pm_text+" 입니다.");

			$("input[name='pay_method']").val(pay_method);

			if(confirm("변경 하시겠습니까?")){
				//tmp에 담아두었다가 추후 결제 완료시 꺼내서 결제 처리함
				$("#grade_frm").ajaxSubmit({
					success:function(data){
						if(data == "ok"){
							checkPay(pay_method);
						}
					}
					,error:function(xhr){
						console.log(xhr.responseText);
					}
				});

			}
		}
	</script>
	<style type="text/css">
		.mask{
			width:100%;
			height:2400px;
			background:#000000;
			opacity:0.2;
		}
	</style>
	</head>
	<body>



	<?php
	$change_trade_code = "grdchg".time().rand(0000,9999);
	?>

		<form name="grade_frm" id="grade_frm" method="post">
			<input type="hidden" name="submode" value="change_tmp">
			<input type="hidden" name="change_trade_code" value="<?=$change_trade_code?>">
			<input type="hidden" name="cart_id" value="<?=$this->session->userdata('CART')?>">
			<input type="hidden" name="userid" value="<?=$this->session->userdata('USERID')?>">
			<input type="hidden" name="trade_code">
			<input type="hidden" name="deliv_code" value="<?=$row->deliv_code?>">
			<input type="hidden" name="recom_idx">
			<input type="hidden" name="chg_recom_idx">
			<input type="hidden" name="price">
			<input type="hidden" name="recom_name">
			<input type="hidden" name="chg_recom_name">
			<input type="hidden" name="pay_method">
			<input type="hidden" name="remain_deliv_count">
			<input type="hidden" name="chg_recom_pack_ea">
			<input type="hidden" name="week_day_count">
			<input type="hidden" name="week_type">
			<input type="hidden" name="deliv_sun_type">
		</form>
		<div class="inner">
			<h1 class="pl0">
				단계 변경
			</h1>
			<!-- 단계변경 step01 -->
			<p class="bu03">
				<?=$reverse_recom_date[$row->deliv_date]?>
				회차
				<?=$row->deliv_date?>
				<?=numberToWeekname($row->deliv_date)?>
				요일부터 적용됩니다.</p>
			<select name="sel_grade" id="sel_grade" class="pop_sel01" onchange="calc_price(this.value)">
				<option value="">- 단계 선택 -</option>
				<?php
					if($upgrade_recom_list){
						foreach($upgrade_recom_list as $url){
						?>
				<option value="<?=$url->idx?>">
				<?=$url->recom_name?>
				</option>
				<?php
						}
					}
					?>
			</select>
			<p class="blue fs12 mt10">※ 아이의 식단에 맞게 단계를 변경하실 수 있습니다.</p>
			<p class="blue fs12">※ 상위 단계로 변경하시면 추가 결제가 필요합니다.</p>
			<p class="blue fs12">※ 차액금액(환불)이 발생할 경우 포인트로만 적립됩니다.</p>
			<div class="info_view" style="display:none;">
				<p class="bu03 mt10">“<em class='before_name'>초기</em>”에서 “<em class='after_name'>후기 3식</em>”으로 변경 안내입니다.</p>
				<p class="ac">
					<a href="javascript:;" class="btn_green change_g">단계 변경 차액 : <em class='deff_price'>58,000</em> 원</a>
				</p>
				<p class="ac mt10">
					<a href="javascript:;" class="btn_w" onclick="pay_pg('1')">신용카드</a>
					<a href="javascript:;" class="btn_w" onclick="pay_pg('3')">계좌이체</a>
					<!-- <a href="javascript:;" class="btn_w point_pay" onclick="pay_point()">전액포인트결제</a> -->
				</p>
			</div>

			<!-- //단계변경 step01 -->

		</div>
		<div class="ac mt20">
			<button type="button" class="btn_y" title="취소" onclick='self.close()'>취소</button>
			<button type="button" class="btn_y" title="변경" onclick="alert('단계 변경 차액을 결제해 주세요.')">변경</button>
		</div>

		<?php
			$CST_PLATFORM = ($shop_info['lgu_test'] == "ok")?"test":"service";
			$CST_MID = $shop_info['pg_id'];

			$LGD_MID = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
			//$LGD_OID = $TRADE_CODE;
			//$LGD_AMOUNT = "1000";
			//$LGD_BUYER = "강동원";
			//$LGD_PRODUCTINFO = $pg_goods_name;
			//$LGD_BUYEREMAIL = "ombo@designhub.kr";
			$LGD_TIMESTAMP = date("YmdHis");
			$LGD_OSTYPE_CHECK = "P";

			//$LGD_ACTIVEXYN = "N";											 //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)

			$LGD_CUSTOM_SKIN = "SMART_XPAY2";

			$CST_WINDOW_TYPE = "submit";
			$LGD_WINDOW_TYPE = $CST_WINDOW_TYPE;
			$LGD_CUSTOM_SWITCHINGTYPE = "SUBMIT";
			$LGD_CUSTOM_PROCESSTYPE = "TWOTR";

			$LGD_CASNOTEURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/m/cas_noteurl.php";	//가상계좌리턴 값
			//$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/returnurl.php";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트
			$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/m/html/dh_order/grade_pay";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트

			$configPath = $_SERVER['DOCUMENT_ROOT']."/pay/uplus/m/lgdacom";	//환경파일("/conf/lgdacom.conf") 위치 지정.

			/*
			* ISP 카드결제 연동을 위한 파라미터(필수)
			*/
			$LGD_KVPMISPWAPURL		= "";
			$LGD_KVPMISPCANCELURL   = "";

			$LGD_MPILOTTEAPPCARDWAPURL = ""; //iOS 연동시 필수

			/*
			* 계좌이체 연동을 위한 파라미터(필수)
			*/
			$LGD_MTRANSFERWAPURL 		= "";
			$LGD_MTRANSFERCANCELURL 	= "";

			$LGD_PCVIEWYN = "";				//휴대폰번호 입력 화면 사용 여부(유심칩이 없는 단말기에서 입력-->유심칩이 있는 휴대폰에서 실제 결제)

			/*
			****************************************************
			* 모바일 OS별 ISP(국민/비씨), 계좌이체 결제 구분 값
			****************************************************
			- 안드로이드: A (디폴트)
			- iOS: N
			- iOS일 경우, 반드시 N으로 값을 수정
			*/

			$iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
			$iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
			$iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
			$Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");

			$LGD_KVPMISPAUTOAPPYN	= "A";		// 신용카드 결제
			$LGD_MTRANSFERAUTOAPPYN= "A";		// 계좌이체 결제

			if($iPod or $iPhone or $iPad){
				$LGD_KVPMISPAUTOAPPYN	= "N";		// 신용카드 결제
				$LGD_MTRANSFERAUTOAPPYN = "N";		// 계좌이체 결제
			}
		?>

		<script language="javascript" src="https://xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
		<script type="text/javascript">
			var LGD_window_type = '<?= $CST_WINDOW_TYPE ?>';
			/*
			* 수정불가
			*/
			function launchCrossPlatform(){
				document.getElementById('LGD_PAYINFO').target="_self";
						lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type);
			}

			function getFormObject() {
				return document.getElementById("LGD_PAYINFO");
			}

			function checkPay(trade_method){

				var amount = $("#LGD_AMOUNT").val();	//상품금액
				var buyer = $("#LGD_BUYER").val();	//구매자성명
				var buyeremail = $("#LGD_BUYEREMAIL").val();	//구매자이메일
				var trade_code = $("#LGD_OID").val();

				//var trade_method = $("input[name='trade_method']:checked").val();	//결제방식
				var pay_method = "";
					if(trade_method == "1"){	//신용카드
						pay_method = "SC0010";
					}
					else if(trade_method == "3"){	//계좌이체
						pay_method = "SC0030";
					}
					else if(trade_method == "7"){	//휴대폰결제
						pay_method = "SC0060";
					}

				//해쉬데이터 작성에 필요한 값
				/*
				상점아이디, 주문번호, 금액, 타임스탬프, 상점 mertKey
				*/

				$.ajax({
					url:"<?=cdir()?>/dh_order/uplus_pay_Gethash",
					type:"POST",
					data:{'mode':'hashdata','LGD_MID':"<?=$LGD_MID?>",'LGD_OID':trade_code,'LGD_AMOUNT':amount,'LGD_TIMESTAMP':"<?=$LGD_TIMESTAMP?>",'configPath':"<?=$configPath?>",'CST_PLATFORM':"<?=$CST_PLATFORM?>"},
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){

						$("#LGD_CUSTOM_FIRSTPAY").val(pay_method);
						$("#LGD_HASHDATA").val(data);

					},
					complete:function(){
						//launchCrossPlatform();
						document.LGD_PAYINFO.target = "tmp_frame";
						document.LGD_PAYINFO.submit();
					}
				});

			}
		</script>

		<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="<?=cdir()?>/dh_order/uplus_paytmp">
			<input type="hidden" name="pay_type" id="pay_type" value="grade_change">
			<input type='hidden' name='CST_PLATFORM' id='CST_PLATFORM' value='<?=$CST_PLATFORM?>'>
			<input type='hidden' name='CST_WINDOW_TYPE' id='CST_WINDOW_TYPE' value='<?=$CST_WINDOW_TYPE?>'>
			<input type='hidden' name='CST_MID' id='CST_MID' value='<?=$CST_MID?>'>
			<input type='hidden' name='LGD_MID' id='LGD_MID' value='<?=$LGD_MID?>'>
			<input type='hidden' name='LGD_OID' id='LGD_OID' value="<?=$change_trade_code?>">
			<input type='hidden' name='LGD_BUYER' id='LGD_BUYER' value="<?=$member_info->name?>">
			<input type='hidden' name='LGD_PRODUCTINFO' id='LGD_PRODUCTINFO' <?//스크립트 삽입 calc_price() ?>>
			<input type='hidden' name='LGD_AMOUNT' id='LGD_AMOUNT' <?//스크립트 삽입 calc_price() ?>>
			<input type='hidden' name='LGD_BUYEREMAIL' id='LGD_BUYEREMAIL' value="<?=$member_info->email?>">
			<input type='hidden' name='LGD_CUSTOM_SKIN' id='LGD_CUSTOM_SKIN' value='<?=$LGD_CUSTOM_SKIN?>'>
			<input type='hidden' name='LGD_CUSTOM_PROCESSTYPE' id='LGD_CUSTOM_PROCESSTYPE' value='<?=$LGD_CUSTOM_PROCESSTYPE?>'>
			<input type='hidden' name='LGD_TIMESTAMP' id='LGD_TIMESTAMP' value='<?=$LGD_TIMESTAMP?>'>
			<input type='hidden' name='LGD_HASHDATA' id='LGD_HASHDATA'>
			<input type='hidden' name='LGD_RETURNURL' id='LGD_RETURNURL' value='<?=$LGD_RETURNURL?>'>
			<input type="hidden" name="LGD_VERSION" id="LGD_VERSION" value="PHP_Non-ActiveX_SmartXPay">
			<input type='hidden' name='LGD_CUSTOM_FIRSTPAY' id='LGD_CUSTOM_FIRSTPAY'>
			<input type='hidden' name='LGD_PCVIEWYN' id='LGD_PCVIEWYN' value='<?=$LGD_PCVIEWYN?>'>
			<input type='hidden' name='LGD_CUSTOM_SWITCHINGTYPE' id='LGD_CUSTOM_SWITCHINGTYPE' value='<?=$LGD_CUSTOM_SWITCHINGTYPE?>'>
			<input type='hidden' name='LGD_MPILOTTEAPPCARDWAPURL' id='LGD_MPILOTTEAPPCARDWAPURL' value='<?=$LGD_MPILOTTEAPPCARDWAPURL?>'>
			<input type='hidden' name='LGD_KVPMISPWAPURL' id='LGD_KVPMISPWAPURL' value='<?=$LGD_KVPMISPWAPURL?>'>
			<input type='hidden' name='LGD_KVPMISPCANCELURL' id='LGD_KVPMISPCANCELURL' value='<?=$LGD_KVPMISPCANCELURL?>'>
			<input type='hidden' name='LGD_MTRANSFERWAPURL' id='LGD_MTRANSFERWAPURL' value='<?=$LGD_MTRANSFERWAPURL?>'>
			<input type='hidden' name='LGD_MTRANSFERCANCELURL' id='LGD_MTRANSFERCANCELURL' value='<?=$LGD_MTRANSFERCANCELURL?>'>
			<input type='hidden' name='LGD_KVPMISPAUTOAPPYN' id='LGD_KVPMISPAUTOAPPYN' value='<?=$LGD_KVPMISPAUTOAPPYN?>'>
			<input type='hidden' name='LGD_MTRANSFERAUTOAPPYN' id='LGD_MTRANSFERAUTOAPPYN' value='<?=$LGD_MTRANSFERAUTOAPPYN?>'>
			<input type='hidden' name='LGD_CASNOTEURL' id='LGD_CASNOTEURL' value='<?=$LGD_CASNOTEURL?>'>
			<input type='hidden' name='LGD_RESPCODE' id='LGD_RESPCODE' value=''>
			<input type='hidden' name='LGD_RESPMSG' id='LGD_RESPMSG' value=''>
			<input type='hidden' name='LGD_PAYKEY' id='LGD_PAYKEY' value=''>

			<input type="hidden" name="LGD_ENCODING" id="LGD_ENCODING" value="UTF-8">
			<input type="hidden" name="LGD_ENCODING_NOTEURL" id="LGD_ENCODING_NOTEURL" value="UTF-8">
			<input type="hidden" name="LGD_ENCODING_RETURNURL" id="LGD_ENCODING_RETURNURL" value="UTF-8">
		</form>

		<iframe name="tmp_frame" border=0 frameborder=0 style="display:none;width:100%;height;500px;"></iframe>


</body>
</html>
