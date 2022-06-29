<?php
if(!$payReqMap){
	echo "유효하지 않은 요청 입니다.";
	return;
}
?>

<html>
<head>
	<script type="text/javascript">

		function setLGDResult() {
			parent.payment_return();
			try {
			} catch (e) {
				alert(e.message);
			}
		}

	</script>
</head>
<body onload="setLGDResult()">
<?php
  $payReqMap['LGD_RESPCODE'] = $LGD_RESPCODE;
  $payReqMap['LGD_RESPMSG']	=	$LGD_RESPMSG;

  if($LGD_RESPCODE == "0000"){
	  $payReqMap['LGD_PAYKEY'] = $LGD_PAYKEY;
  }
  else{
	  echo "LGD_RESPCODE:" + $LGD_RESPCODE + " ,LGD_RESPMSG:" + $LGD_RESPMSG; //인증 실패에 대한 처리 로직 추가
  }
?>
<form method="post" name="LGD_RETURNINFO" id="LGD_RETURNINFO">
<?php
	  foreach ($payReqMap as $key => $value) {
      echo "<input type='hidden' name='$key' id='$key' value='$value'>";
    }
?>
</form>
</body>
</html>