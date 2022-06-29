<!doctype html>
<html lang="ko">
<head>
	<title>단계변경 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1300">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?php echo time(); ?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/js/common.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script type="text/javascript">
	<!--
		$(function(){
			$(".layer_pop_inner").css('top','0');
			$('html').css('overflow-x','hidden');
		});

		function calc_price(val){
			$.ajax({
				url:"<?=cdir()?>/dh_order/change_grade/?time=<?=time()?>&deliv_code="+encodeURIComponent("<?=$this->input->get('deliv_code')?>")
					+"&change_recom_idx="+val
					+"&recom_idx=<?=$row->recom_idx?>&deliv_count=<?=$reverse_recom_date[$row->deliv_date]?>",
				type:"GET",
				dataType:"json",
				cache:false,
				error:function(xhr){
					console.log(xhr);
				},
				success:function(data){
					console.log(data);
					$(".before_name").html(data.before_grade_name);
					$(".after_name").html(data.after_grade_name);
					$(".deff_price").html(addComma(data.price));
					$(".info_view").show();
					//document.print(data);

//					if(parseInt(data.price) > parseInt(data.total_point)){
//						$(".point_pay").hide();
//					}

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
			var pm_text = "";
			if(pay_method == "card"){
				pm_text = "신용카드";
			}
			else if(pay_method == "bank"){
				pm_text = "계좌이체";
			}
			//alert("선택된 결제방식은 "+pm_text+" 입니다.");

			if(confirm("변경 하시겠습니까?")){
				//PG사로 보낸다.
				//임의로 넘긴다.
				//$("input[name='pay_method']").val(pay_method);
				//$("#grade_frm").submit();
			}
		}
	//-->
	</script>
</head>
<body>
	<div id="wrap" class="layout_type2 sub_layout">
		<div id="container">
			<div class="layer_pop_inner layer_pop_inner02">

				<h1>
					<span class="btn_yy" style="margin-right:10px">단계변경</span>단계 변경
				</h1>

				<form name="grade_frm" id="grade_frm" method="post">
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

				<div class="bg">
					<!-- 단계변경 step01 -->
					<p class="bu03"><?=$reverse_recom_date[$row->deliv_date]?>회차 <?=$row->deliv_date?> <?=numberToWeekname($row->deliv_date)?>요일부터 적용됩니다.</p>
					<span class="btn_green mt20">단계선택</span>
					<select name="sel_grade" id="sel_grade" class="sel" onchange="calc_price(this.value)">
						<option value="">- 단계 선택 -</option>
						<?php
						if($upgrade_recom_list){
							foreach($upgrade_recom_list as $url){
							?>
							<option value="<?=$url->idx?>"><?=$url->recom_name?></option>
							<?php
							}
						}
						?>

						<!-- <option value="">변경하실 단계를 선택하여 주세요.</option>
						<option value="">변경하실 단계를 선택하여 주세요.</option>
						<option value="">변경하실 단계를 선택하여 주세요.</option>
						<option value="">변경하실 단계를 선택하여 주세요.</option> -->
					</select>
					<p class="blue fs12 mt20">※ 아이의 식단에 맞게 단계를 변경하실 수 있습니다.</p>
					<p class="blue fs12 mt10">※ 상위 단계로 변경하시면 추가 결제가 필요합니다.</p>
					<p class="blue fs12 mt10">※ 차액금액(환불)이 발생할 경우 포인트로만 적립됩니다.</p>
					<div class="info_view" style="display:none;">
						<p class="bu03 mt20">“<em class='before_name'>초기</em>”에서 “<em class='after_name'>후기 3식</em>” (으)로 변경 안내입니다.</p>
						<p>
							<a href="javascript:;" class="btn_green mt10 change_g" style="width:80%">단계 변경 차액 : <em class='deff_price'></em> 원</a><br><br>
							<a href="javascript:;" class="btn_w" onclick="checkPay('1')">신용카드</a>
							<a href="javascript:;" class="btn_w" onclick="checkPay('3')">계좌이체</a>
							<!-- <a href="javascript:;" class="btn_w point_pay" onclick="pay_point()">전액포인트결제</a> -->
						</p>
					</div>
					<div class="ac bd">
						<a href="javascript:;" class="btn_big" onclick="alert('단계 변경 차액을 결제해 주세요.')">변경</a>
						<a href="javascript:;" class="btn_big" onclick="self.close()">취소</a>
					</div>
					<!-- 단계변경 step01 -->
				</div>
				<a href="javascript:;" class="btn_close" onclick='self.close();'><span style="display:none;">X</span></a>

				<?php
					$CST_PLATFORM = ($shop_info['lgu_test'] == "ok")?"test":"service";
					$CST_MID = $shop_info['pg_id'];

					$LGD_MID = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
					//$LGD_OID = $TRADE_CDOE;
					//$LGD_AMOUNT = "1000";
					//$LGD_BUYER = $this->session->userdata('NAME');
					$LGD_PRODUCTINFO = $pg_goods_name;
					//$LGD_BUYEREMAIL = "ombo@designhub.kr";
					$LGD_TIMESTAMP = date("YmdHis");
					$LGD_OSTYPE_CHECK = "P";

					//$LGD_ACTIVEXYN = "N";											 //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)

					$LGD_CUSTOM_SKIN = "red";
					//$LGD_CUSTOM_USABLEPAY = "SC0010";
					/*
					<option value="SC0010">신용카드</option>
					<option value="SC0030">계좌이체</option>
					<option value="SC0040">무통장입금</option>
					<option value="SC0060">휴대폰</option>
					<option value="SC0070">유선전화결제</option>
					<option value="SC0090">OK캐쉬백</option>
					<option value="SC0111">문화상품권</option>
					<option value="SC0112">게임문화상품권</option>
					*/
					$LGD_WINDOW_VER = "2.5";
					$LGD_WINDOW_TYPE = "iframe";
					$LGD_CUSTOM_SWITCHINGTYPE = "IFRAME";
					$LGD_CUSTOM_PROCESSTYPE = "TWOTR";

					$LGD_CASNOTEURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/cas_noteurl.php";	//가상계좌리턴 값
					//$LGD_CASNOTEURL = "http://".$_SERVER['HTTP_HOST']."/html/dh_order/uplus_bank";	//가상계좌리턴 값
					//$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/returnurl.php";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트
					$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/html/dh_order/uplus_pay";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트

					$configPath = $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom";	//환경파일("/conf/lgdacom.conf") 위치 지정.

					$change_trade_code = "grdchg".time().rand(0000,9999);
				?>

				<script language="javascript" src="https://xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
				<script language="javascript" src="/_data/js/jquery.form.js" type="text/javascript"></script>
				<script type="text/javascript">
					var LGD_window_type = '<?= $LGD_WINDOW_TYPE ?>';

					function launchCrossPlatform(){
						$("#LGD_PAYINFO").ajaxSubmit({
							success:function(data){
								//console.log(data);
								if(data == "ok"){
									lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type, null, "", "");
								}
							}
							,error:function(xhr){
								console.log(xhr.responseText);
							}
						});
						//lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type, null, "", "");
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
								document.grade_frm.pay_method.value = 'card';
							}
							else if(trade_method == "3"){	//계좌이체
								pay_method = "SC0030";
								document.grade_frm.pay_method.value = 'bank';
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
							cache:false,
							error:function(xhr){
								console.log(xhr.responseText);
							},
							success:function(data){

								$("#LGD_CUSTOM_USABLEPAY").val(pay_method);
								$("#LGD_HASHDATA").val(data);

							},
							complete:function(){
								launchCrossPlatform();
							}
						});

					}

					function payment_return() {
						var fDoc;

							fDoc = lgdwin.contentWindow || lgdwin.contentDocument;

							//alert(fDoc);


						if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
								document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;

								//alert("what's up?");
								//document.getElementById("LGD_PAYINFO").target = "_self";
								document.getElementById("LGD_PAYINFO").action = "/html/dh_order/grade_change_pay_ok";
								document.getElementById("LGD_PAYINFO").submit();
						} else {
							alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
							closeIframe();
							location.reload();
						}
					}
				</script>

				<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="<?=cdir()?>/dh_order/uplus_paytmp">
					<input type="hidden" name="pay_type" id="pay_type" value="grade_change">
					<input type="hidden" name="CST_PLATFORM" id="CST_PLATFORM" value="<?=$CST_PLATFORM?>">
					<input type="hidden" name="LGD_WINDOW_TYPE" id="LGD_WINDOW_TYPE" value="<?=$LGD_WINDOW_TYPE?>">
					<input type="hidden" name="CST_MID" id="CST_MID" value="<?=$CST_MID?>">
					<input type="hidden" name="LGD_MID" id="LGD_MID" value="<?=$LGD_MID?>">
					<input type="hidden" name="LGD_OID" id="LGD_OID" value="<?=$change_trade_code?>">
					<input type="hidden" name="LGD_BUYER" id="LGD_BUYER" value="<?=$member_info->name?>">
					<input type="hidden" name="LGD_PRODUCTINFO" id="LGD_PRODUCTINFO" <?//스크립트로 삽입 calc_price() ?>>
					<input type="hidden" name="LGD_AMOUNT" id="LGD_AMOUNT" <?//스크립트로 삽입 calc_price() ?>>
					<input type="hidden" name="LGD_BUYEREMAIL" id="LGD_BUYEREMAIL" value="<?=$member_info->email?>">
					<input type="hidden" name="LGD_CUSTOM_SKIN" id="LGD_CUSTOM_SKIN" value="<?=$LGD_CUSTOM_SKIN?>">
					<input type="hidden" name="LGD_CUSTOM_PROCESSTYPE" id="LGD_CUSTOM_PROCESSTYPE" value="<?=$LGD_CUSTOM_PROCESSTYPE?>">
					<input type="hidden" name="LGD_TIMESTAMP" id="LGD_TIMESTAMP" value="<?=$LGD_TIMESTAMP?>">
					<input type="hidden" name="LGD_HASHDATA" id="LGD_HASHDATA" value="<?=$LGD_HASHDATA?>">
					<input type="hidden" name="LGD_RETURNURL" id="LGD_RETURNURL" value="<?=$LGD_RETURNURL?>">
					<input type="hidden" name="LGD_VERSION" id="LGD_VERSION" value="<?=$LGD_VERSION?>">
					<input type="hidden" name="LGD_CUSTOM_USABLEPAY" id="LGD_CUSTOM_USABLEPAY" <?//스크립트로 삽입 checkPay() ?>>
					<input type="hidden" name="LGD_CUSTOM_SWITCHINGTYPE" id="LGD_CUSTOM_SWITCHINGTYPE" value="<?=$LGD_CUSTOM_SWITCHINGTYPE?>">
					<input type="hidden" name="LGD_OSTYPE_CHECK" id="LGD_OSTYPE_CHECK" value="<?=$LGD_OSTYPE_CHECK?>">
					<input type="hidden" name="LGD_WINDOW_VER" id="LGD_WINDOW_VER" value="<?=$LGD_WINDOW_VER?>">
					<input type="hidden" name="LGD_CASNOTEURL" id="LGD_CASNOTEURL" value="<?=$LGD_CASNOTEURL?>">
					<input type="hidden" name="LGD_RESPCODE" id="LGD_RESPCODE" value="">
					<input type="hidden" name="LGD_RESPMSG" id="LGD_RESPMSG" value="">
					<input type="hidden" name="LGD_PAYKEY" id="LGD_PAYKEY" value="">
					<input type="hidden" name="LGD_ENCODING" id="LGD_ENCODING" value="UTF-8">
					<input type="hidden" name="LGD_ENCODING_NOTEURL" id="LGD_ENCODING_NOTEURL" value="UTF-8">
					<input type="hidden" name="LGD_ENCODING_RETURNURL" id="LGD_ENCODING_RETURNURL" value="UTF-8">
				</form>
			</div>
		</div>
	</div>
</body>
</html>