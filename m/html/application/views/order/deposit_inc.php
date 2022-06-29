    <div class="deposit-popup">
      <button type="button" class="deposit__close">
        <img src="/image/sub/deposit_close.png" alt="">
      </button>

      <p class="deposit__tit">예치금 충전</p>

      <div class="deposit__input">
        <input type="text" placeholder="금액을 입력해주세요." name="charge" id="charge" onkeyup="chk_chargemoney(this.value); inputNumberFormat(this)">
        <button type="button" class="deposit__reset" onclick="reset_charge()">
          <img src="/image/sub/deposit_reset_btn.png" alt="">
        </button>
      </div>
      <div class="deposit__charge">
        <p class="deposit__currency">현재 보유금 : <span><?=number_format($total_deposit)?></span>원</p>
        <div class="deposit__btns">
					<button type="button" onclick="add_money(10)">+10만원</button>
					<button type="button" onclick="add_money(30)">+30만원</button>
					<button type="button" onclick="add_money(50)">+50만원</button>
					<button type="button" onclick="add_money(100)">+100만원</button>
        </div>
        <p class="deposit__msg">1만원 단위 / <span>내 충전한도 : <strong>2,000,000</strong>원</span></p>
      </div>

			<p class="deposit__charge">※ 입금 후 예치금 전환까지 2-4분 정도 소요됩니다.</p>

			<?php
			$vbank_limit_date = date("Ymd",strtotime('+7 day'));
			$siteDomain = ssl_check()."://".$_SERVER['HTTP_HOST']."/pay/stdpay/INIStdPaySample"; //가맹점 도메인 입력

			mt_srand((double)microtime()*1000000);
			$TRADE_CODE=chr(mt_rand(65, 90));
			$TRADE_CODE.=chr(mt_rand(65, 90));
			$TRADE_CODE.=chr(mt_rand(65, 90));
			$TRADE_CODE.=chr(mt_rand(65, 90));
			$TRADE_CODE.=chr(mt_rand(65, 90));
			$TRADE_CODE.=time();
			?>

			<form method="post" name="trade_form" id="trade_form">
				<input type="hidden" name="P_NEXT_URL" value="<?=ssl_check()?>://<?=$_SERVER['HTTP_HOST']?>/pay/INIpay50/m/mx_vbank.php">
				<input type="hidden" name="P_INI_PAYMENT" value="VBANK">
				<input type="hidden" name="P_RESERVED" value="">

				<input type="hidden" name="P_MID" value="<?=$shop_info['pg_id']?>">
				<input type="hidden" name="P_OID" value="<?=$TRADE_CODE?>">
				<input type="hidden" name="P_GOODS" value="">
				<input type="hidden" name="P_AMT" value="">
				<input type="hidden" name="P_UNAME" value="<?=$member_info->name?>">
				<input type="hidden" name="P_EMAIL" value="<?=$member_info->email?>">
				<input type="hidden" name="P_MOBILE" value="<?=$member_info->phone1."-".$member_info->phone2."-".$member_info->phone3?>">

				<input type="hidden" name="P_NOTI_URL" value="<?=ssl_check()?>://<?=$_SERVER['HTTP_HOST']?>/m/html/dh_order/vacctinput_m">
				<input type="hidden" name="P_HPP_METHOD" value="2">
				<input type="hidden" name="P_VBANK_DT" value="<?=$vbank_limit_date?>">

				<input type="hidden" name="userid" value="<?=$this->session->userdata('USERID')?>">
			</form>

      <button type="button" class="deposit__sumbit" onclick="checkPay()">충전하기</button>
    </div>

    <div class="deposit__dim"></div>
		<script type="text/javascript">
			//충전금액 수기 입력시 한도체크
			function chk_chargemoney(val){
				var money = uncomma(val);
				if(parseInt(money) > 2000000){
					alert("최대 충전은 200만원까지 가능합니다.");
					$("#charge").val('2,000,000');
					return;
				}
			}

			//충전금액 자동입력 버튼 한도체크
			function add_money(val){
				var money = uncomma($("#charge").val())||0;

				result = parseInt(money) + (parseInt(val)*10000);
				if(result > 2000000){
					alert("최대 충전은 200만원까지 가능합니다.");
					$("#charge").val('2,000,000');
					return;
				}
				else{
					$("#charge").val(add_comma(result));
				}
			}

			//충전금액 초기화
			function reset_charge(){
				$("#charge").val('');
			}

			$(function () {
				$('.deposit-charge-btn').on('click', function(){
					$('.deposit-popup, .deposit__dim')
					.show()
					.stop()
					.animate({
						opacity: 1,
					}, 300)
				})

				$('.deposit__close, .deposit__dim').on('click', function(){
					$('.deposit-popup, .deposit__dim')
					.stop()
					.animate({
						opacity: 0,
					}, 300, function(){
						$(this).hide();
					})
				})
			})


			function inputNumberFormat(obj) {
				obj.value = add_comma(uncomma(obj.value));
			}

			function add_comma(str) {
				str = String(str);
				return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
			}

			function uncomma(str) {
				str = String(str);
				return str.replace(/[^\d]+/g, '');
			}


			function checkPay(){
				var total_price = uncomma($("#charge").val());

				if(total_price == ''){
					alert("충전하실 금액을 입력해주세요.");
					return;
				}

				if(parseInt(total_price)%10000 != 0){
					alert("충전금액은 만원단위로 입력해주세요.");
					return;
				}

				var app_scheme = "";
				var UserAgent = navigator.userAgent;
				if(UserAgent.match(/KAKAOTALK/i) != null){		//카카오톡 인앱브라우저
					app_scheme = "&app_scheme=kakaotalk://";
				}else if(UserAgent.match(/NAVER/i) != null){	//네이버 앱
					app_scheme = "&app_scheme=naversearchapp://";
				}else if(UserAgent.match(/DAUM/i) != null){		//다음 앱
					app_scheme = "&app_scheme=daumapps://";
				}else if(UserAgent.match(/FB/i) != null){			//페북 앱
					app_scheme = "&app_scheme=fb://";
				}
				$("input[name='P_RESERVED']").val("vbank_receipt=Y"+app_scheme);

				var frm = document.trade_form;

				tenth = total_price/10000;
				frm.P_GOODS.value = "예치금 "+tenth+"만원 충전";
				frm.P_AMT.value = total_price;

				frmData = $("#trade_form").serialize();
				$.ajax({
					url:"/m/html/dh/deposit_tmps",
					type:"POST",
					cache:false,
					data:frmData,
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){
						console.log(data);
						if(data=="ok"){
							frm.acceptCharset = "euc-kr";
							frm.action = "https://mobile.inicis.com/smart/payment/";
							frm.target = "_self";
							frm.submit();
						}
					}
				});
			}
		</script>