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

$LGD_CASNOTEURL = "https://".$_SERVER['HTTP_HOST']."/pay/uplus/cas_noteurl.php";	//가상계좌리턴 값
//$LGD_CASNOTEURL = "http://".$_SERVER['HTTP_HOST']."/html/dh_order/uplus_bank";	//가상계좌리턴 값
//$LGD_RETURNURL = "http://".$_SERVER['HTTP_HOST']."/pay/uplus/returnurl.php";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트
$LGD_RETURNURL = "https://".$_SERVER['HTTP_HOST']."/html/dh_order/uplus_pay";	//반드시 현재 페이지와 동일한 프로트콜 및 호스트

$configPath = $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom";	//환경파일("/conf/lgdacom.conf") 위치 지정.

//세그먼트 설정 ( 샘플신청의 경우 )
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
			var buyer = $("#ou-name").val();	//구매자성명
			var buyeremail = $("#ou-email").val()+"@"+$("#email2").val();	//구매자이메일
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
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					//				console.log(trade_code);
					//				console.log(buyer);
					//				console.log(amount);
					//				console.log(buyeremail);
					//				console.log(data);

					$("#LGD_OID").val(trade_code);
					$("#LGD_BUYER").val(buyer);
					$("#LGD_AMOUNT").val(amount);
					$("#LGD_BUYEREMAIL").val(buyeremail);
					$("#LGD_CUSTOM_USABLEPAY").val(pay_method);
					$("#LGD_HASHDATA").val(data);

				},
				complete:function(){
					launchCrossPlatform();
				}
			});

		}

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

		function payment_return() {
			var fDoc;

				fDoc = lgdwin.contentWindow || lgdwin.contentDocument;

				//alert(fDoc);


			if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
					document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;

					//alert("what's up?");
					document.getElementById("LGD_PAYINFO").target = "_self";
					document.getElementById("LGD_PAYINFO").action = "/html/dh_order/uplus_pay_ok";
					document.getElementById("LGD_PAYINFO").submit();
			} else {
				alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
				closeIframe();
				location.reload();
			}
		}
	</script>
	<?php
}
?>

<form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="<?=cdir()?>/dh_order/uplus_paytmp">
	<input type="hidden" name="seg3" value="<?=$seg3?>">
	<input type="hidden" name="seg4" value="<?=$seg4?>">

	<input type="hidden" name="CST_PLATFORM" id="CST_PLATFORM" value="<?=$CST_PLATFORM?>">
	<input type="hidden" name="LGD_WINDOW_TYPE" id="LGD_WINDOW_TYPE" value="<?=$LGD_WINDOW_TYPE?>">
	<input type="hidden" name="CST_MID" id="CST_MID" value="<?=$CST_MID?>">
	<input type="hidden" name="LGD_MID" id="LGD_MID" value="<?=$LGD_MID?>">
	<input type="hidden" name="LGD_OID" id="LGD_OID">
	<input type="hidden" name="LGD_BUYER" id="LGD_BUYER">
	<input type="hidden" name="LGD_PRODUCTINFO" id="LGD_PRODUCTINFO" value="<?=$LGD_PRODUCTINFO?>">
	<input type="hidden" name="LGD_AMOUNT" id="LGD_AMOUNT">
	<input type="hidden" name="LGD_BUYEREMAIL" id="LGD_BUYEREMAIL">
	<input type="hidden" name="LGD_CUSTOM_SKIN" id="LGD_CUSTOM_SKIN" value="<?=$LGD_CUSTOM_SKIN?>">
	<input type="hidden" name="LGD_CUSTOM_PROCESSTYPE" id="LGD_CUSTOM_PROCESSTYPE" value="<?=$LGD_CUSTOM_PROCESSTYPE?>">
	<input type="hidden" name="LGD_TIMESTAMP" id="LGD_TIMESTAMP" value="<?=$LGD_TIMESTAMP?>">
	<input type="hidden" name="LGD_HASHDATA" id="LGD_HASHDATA" value="<?=$LGD_HASHDATA?>">
	<input type="hidden" name="LGD_RETURNURL" id="LGD_RETURNURL" value="<?=$LGD_RETURNURL?>">
	<input type="hidden" name="LGD_VERSION" id="LGD_VERSION" value="<?=$LGD_VERSION?>">
	<input type="hidden" name="LGD_CUSTOM_USABLEPAY" id="LGD_CUSTOM_USABLEPAY">
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