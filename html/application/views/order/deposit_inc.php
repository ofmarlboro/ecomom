        <div class="deposit-popup">
          <button type="button" class="deposit__close"><img src="/image/sub/deposit_close.png" alt=""></button>

          <p class="deposit__tit">예치금 충전</p>

          <div class="deposit__input">
            <input type="text" placeholder="금액을 입력해주세요." name="charge" id="charge" onkeyup="chk_chargemoney(this.value); inputNumberFormat(this)">
            <button type="button" class="deposit__reset" onclick="reset_charge()"><img src="/image/sub/deposit_reset_btn.png" alt=""></button>
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
				 <form id="SendPayForm_id" name="SendPayForm" method="POST">
					<input type="hidden" name="version" value="1.0" >
					<input type="hidden" id="mid" name="mid" value="" >
					<input type="hidden" id="goodname" name="goodname" value="" >
					<input type="hidden" id="oid" name="oid" value="<?php echo $TRADE_CODE ?>" >
					<input type="hidden" id="send_price" name="price" value="" >
					<input type="hidden" id="currency" name="currency" value="WON" >
					<input type="hidden" id="buyername" name="buyername" value="<?=$member_info->name?>" >
					<input type="hidden" id="buyertel" name="buyertel" value="<?=$member_info->phone1."-".$member_info->phone2."-".$member_info->phone3?>" >
					<input type="hidden" id="buyeremail" name="buyeremail" value="<?=$member_info->email?>" >
					<input type="hidden" id="timestamp" name="timestamp" value="" >
					<input type="hidden" id="signature" name="signature" value="" >
					<input type="hidden" id="returnUrl" name="returnUrl" value="<?=ssl_check()?>://<?php echo $_SERVER['HTTP_HOST'] ?><?=cdir()?>/dh_order/ini_vbank" >
					<input type="hidden" id="mKey" name="mKey" value="" >

					<input type="hidden" id="gopaymethod" name="gopaymethod" value="" >
					<input type="hidden" name="offerPeriod" value="2015010120150331" >
					<input type="hidden" name="acceptmethod" value="" >
					<input type="hidden" name="languageView" value="" >
					<input type="hidden" name="charset" value="" >
					<input type="hidden" name="payViewType" value="" >
					<input type="hidden" name="closeUrl" value="<?php echo $siteDomain ?>/close.php" >
					<input type="hidden" name="popupUrl" value="<?php echo $siteDomain ?>/popup.php" >
					<input type="hidden" name="nointerest" id="nointerest" value="" >
					<input type="hidden" name="quotabase" id="quotabase" value="" >
					<input type="hidden" name="vbankRegNo" value="" >
					<input type="hidden" name="merchantData" value="<?=$member_info->userid?>" >
				 </form>


          <button type="button" class="deposit__sumbit" onclick="checkPay()">충전하기</button>
        </div>

        <div class="deposit__dim"></div>

				<? if($shop_info['pg_id'] == "INIpayTest"){?>
				<script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
				<?}else{?>
				<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
				<?}?>

				<script>
					function pay(){
						$(".review_addfile_loading_wrap").hide();
						INIStdPay.pay('SendPayForm_id');
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

						$(".review_addfile_loading_wrap").show();

						tenth = total_price/10000;
						document.SendPayForm.goodname.value = "예치금 "+tenth+"만원 충전";
						var gopaymethod = "Vbank";
						document.SendPayForm.acceptmethod.value = "va_receipt:vbank(<?=$vbank_limit_date?>):below1000";

						$.ajax({
								url: "<?=cdir()?>/dh_order/ini_vbank",
								type: "POST",
								data: {mode:"request",total_price: total_price, TRADE_CODE: "<?=$TRADE_CODE?>",userid:'<?=$member_info->userid?>'},
								async: true,
								cache: false,
								error: function(xhr){ console.log(xhr); },
								success: function(data){

									if(data){

										var text = data.split("@@");
										var mid = text[0];
										var price = text[1];
										var signature = text[2];
										var mKey = text[3];
										var timestamp = text[4];
										var nointerest = text[5];
										var quotabase = text[6];

										$("#mid").val(mid);
										$("#send_price").val(price);
										$("#signature").val(signature);
										$("#mKey").val(mKey);
										$("#timestamp").val(timestamp);
										$("#nointerest").val(nointerest);
										$("#quotabase").val(quotabase);
										$("#gopaymethod").val(gopaymethod);

										setTimeout("pay()",1000);

									}
								}
						});


					}

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
				</script>