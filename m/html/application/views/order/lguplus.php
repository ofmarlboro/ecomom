<?php
$CST_PLATFORM = ($shop_info['lgu_test'] == "ok")?"test":"service";
$CST_MID = $shop_info['pg_id'];

$LGD_MID = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
$LGD_OID = $TRADE_CODE;
//$LGD_AMOUNT = "1000";
//$LGD_BUYER = "강동원";
$LGD_PRODUCTINFO = $pg_goods_name;
//$LGD_BUYEREMAIL = "ombo@designhub.kr";
$LGD_TIMESTAMP = date("YmdHis");
$LGD_OSTYPE_CHECK = "P";

//$LGD_ACTIVEXYN = "N";											 //계좌이체 결제시 사용, ActiveX 사용 여부로 "N" 이외의 값: ActiveX 환경에서 계좌이체 결제 진행(IE)

$LGD_CUSTOM_SKIN = "SMART_XPAY2";
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

$CST_WINDOW_TYPE = "submit";
$LGD_WINDOW_TYPE = $CST_WINDOW_TYPE;
$LGD_CUSTOM_SWITCHINGTYPE = "SUBMIT";
$LGD_CUSTOM_PROCESSTYPE = "TWOTR";

$LGD_CASNOTEURL = "https://".$_SERVER['HTTP_HOST']."/pay/uplus/m/cas_noteurl.php";	//가상계좌리턴 값
//$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/returnurl.php";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트
$LGD_RETURNURL = "https://".$_SERVER['HTTP_HOST']."/m/html/dh_order/uplus_pay";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트

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

$seg3 = $this->uri->segment(3);
$seg4 = $this->uri->segment(4);
?>

<script language="javascript" src="https://xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
<script language="javascript" src="/_data/js/jquery.form.js" type="text/javascript"></script>
<?php
if(date("YmdHis") > '20200526105959'){
	?>
	<script type="text/javascript">
		function checkPay(){
			alert('결제 시스템 점검중입니다. 14시 이후에 주문해 주시기 바랍니다.');
		}
	</script>
	<?php
}
else{
	?>
	<script type="text/javascript">

		function checkPay(){

			var amount = $("#total_price").val();	//상품금액
			var buyer = $("#o-name").val();	//구매자성명
			var buyeremail = $("#o-email").val();	//구매자이메일
			var trade_code = $("#trade_code").val();

			var trade_method = $("input[name='trade_method']:checked").val();	//결제방식
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
					//				console.log(trade_code);
					//				console.log(buyer);
					//				console.log(amount);
					//				console.log(buyeremail);
					//				console.log(data);

					//console.log(data);

					$("#LGD_OID").val(trade_code);
					$("#LGD_BUYER").val(buyer);
					$("#LGD_AMOUNT").val(amount);
					$("#LGD_BUYEREMAIL").val(buyeremail);
					$("#LGD_CUSTOM_FIRSTPAY").val(pay_method);
					$("#LGD_HASHDATA").val(data);

				},
				complete:function(){
					//launchCrossPlatform();

					var oid = "<?=$TRADE_CODE?>";
					$.ajax({
						url:"/m/html/dh_order/pg_vali",
						type:"GET",
						cache:false,
						data:{'ajax':1,'oid':oid},
						error:function(xhr){
							console.log(xhr.responseText);
						},
						success:function(data){
							if(data >= 1){
								document.LGD_PAYINFO.target = "tmp_frame";
								document.LGD_PAYINFO.submit();
							}
							else{
								alert("주문이 기록되지 않아 새로고침을 시도합니다.");
								location.reload();
							}
						}
					});

				}
			});

		}

		var LGD_window_type = '<?= $CST_WINDOW_TYPE ?>';
		/*
		* 수정불가
		*/
		function launchCrossPlatform(){
			document.getElementById('LGD_PAYINFO').target="_self";
					lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', LGD_window_type);
		}

		//	function launchCrossPlatform(){
		//		$("#LGD_PAYINFO").ajaxSubmit({
		//			success:function(data){
		//				//console.log(data);
		//				if(data == "ok"){
		//					lgdwin = open_paymentwindow(document.getElementById('LGD_PAYINFO'), '<?= $CST_PLATFORM ?>', '<?= $CST_WINDOW_TYPE ?>');
		//				}
		//			}
		//			,error:function(xhr){
		//				console.log(xhr.responseText);
		//			}
		//		});
		//	}

		function getFormObject() {
			return document.getElementById("LGD_PAYINFO");
		}



		//	function payment_return() {
		//		var fDoc;
		//
		//			fDoc = lgdwin.contentWindow || lgdwin.contentDocument;
		//
		//			//alert(fDoc);
		//
		//
		//		if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
		//				document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
		//
		//				//alert("what's up?");
		//				document.getElementById("LGD_PAYINFO").target = "_self";
		//				document.getElementById("LGD_PAYINFO").action = "/html/dh_order/uplus_pay_ok";
		//				document.getElementById("LGD_PAYINFO").submit();
		//		} else {
		//			alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
		//			closeIframe();
		//			location.reload();
		//		}
		//	}
	</script>
	<?php
}
?>


<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="<?=cdir()?>/dh_order/uplus_paytmp">
	<input type="hidden" name="seg3" value="<?=$seg3?>">
	<input type="hidden" name="seg4" value="<?=$seg4?>">

	<input type='hidden' name='CST_PLATFORM' id='CST_PLATFORM' value='<?=$CST_PLATFORM?>'>
	<input type='hidden' name='CST_WINDOW_TYPE' id='CST_WINDOW_TYPE' value='<?=$CST_WINDOW_TYPE?>'>
	<input type='hidden' name='CST_MID' id='CST_MID' value='<?=$CST_MID?>'>
	<input type='hidden' name='LGD_MID' id='LGD_MID' value='<?=$LGD_MID?>'>
	<input type='hidden' name='LGD_OID' id='LGD_OID'>
	<input type='hidden' name='LGD_BUYER' id='LGD_BUYER'>
	<input type='hidden' name='LGD_PRODUCTINFO' id='LGD_PRODUCTINFO' value='<?=$LGD_PRODUCTINFO?>'>
	<input type='hidden' name='LGD_AMOUNT' id='LGD_AMOUNT'>
	<input type='hidden' name='LGD_BUYEREMAIL' id='LGD_BUYEREMAIL'>
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