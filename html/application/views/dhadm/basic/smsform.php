<style type="text/css">
	.sms-table { width:80%; }
	.sms-table td { border-top:none;border-bottom:none;text-align:center; }
</style>
<script type="text/javascript">
	$(function(){
		byte_check('sms_text1','sms_1');
		byte_check('sms_text2','sms_2');
		byte_check('sms_text3','sms_3');
		byte_check('sms_text4','sms_4');
	});
</script>

<h3 class="icon-pen">SMS 기본설정</h3>

<form method="post" name="smsfrm" id="smsfrm">
<table class="adm-table">
	<tr>
		<th>아이코드 토큰키</th>
		<td>
			<?php
			help_info("아이코드에서 제공하는 토큰키를 입력합니다.<br>아이코드 > 토큰키생성 > 사이트 도메인 입력후 토큰키를 발급받아 입력해주세요.<br>");
			?>
			<input type="text" class="width-xl" name="icode_key" value="<?=$shop_info['icode_key']?>">
		</td>
	</tr>
	<tr>
		<th>회신번호</th>
		<td>
			<?php
			help_info("회신받을 번호를 입력해 주세요.<br>");
			?>
			<input type="text" class="width-l" name="callbackno" value="<?=$shop_info['callbackno']?>">
		</td>
	</tr>
	<tr>
		<th>
			공통 프리셋
		</th>
		<td>
			{이름}, {주문번호}, {주문금액}, {회사명}, {백배회사}, {운송장번호}
		</td>
	</tr>
	<tr>
		<th>sms 발송설정</th>
		<td>
			<table class="sms-table">
				<tr>
					<td>
						<input type="checkbox" name="sms1" value="1" id="sms1" <?=($shop_info['sms1'])?"checked":"";?>><label for="sms1">주문시</label>
					</td>
					<td>
						<input type="checkbox" name="sms2" value="1" id="sms2" <?=($shop_info['sms2'])?"checked":"";?>><label for="sms2">상품배송시</label>
					</td>
					<td>
						<input type="checkbox" name="sms3" value="1" id="sms3" <?=($shop_info['sms3'])?"checked":"";?>><label for="sms3">주문취소시</label>
					</td>
					<td>
						<input type="checkbox" name="sms4" value="1" id="sms4" <?=($shop_info['sms4'])?"checked":"";?>><label for="sms4">주문완료시</label>
					</td>
				</tr>
				<tr>
					<td>
						<textarea name="sms_text1" id="sms_text1" cols="16" rows="6" onkeyup="byte_check('sms_text1','sms_1')"><?=$shop_info['sms_text1']?></textarea><div id="sms_1">0 / 80 bytes</div>
					</td>
					<td>
						<textarea name="sms_text2" id="sms_text2" cols="16" rows="6" onkeyup="byte_check('sms_text2','sms_2')"><?=$shop_info['sms_text2']?></textarea><div id="sms_2">0 / 80 bytes</div>
					</td>
					<td>
						<textarea name="sms_text3" id="sms_text3" cols="16" rows="6" onkeyup="byte_check('sms_text3','sms_3')"><?=$shop_info['sms_text3']?></textarea><div id="sms_3">0 / 80 bytes</div>
					</td>
					<td>
						<textarea name="sms_text4" id="sms_text4" cols="16" rows="6" onkeyup="byte_check('sms_text4','sms_4')"><?=$shop_info['sms_text4']?></textarea><div id="sms_4">0 / 80 bytes</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

<div class="align-c mt50">
	<input type="button" value="확인" class="btn-l" onclick="document.smsfrm.submit()">
</div>

<script type="text/javascript">
	function byte_check(el_cont, el_byte)
	{
		var cont = document.getElementById(el_cont);
		var bytes = document.getElementById(el_byte);
		var i = 0;
		var cnt = 0;
		var exceed = 0;
		var ch = '';

		for (i=0; i<cont.value.length; i++) {
			ch = cont.value.charAt(i);
			if (escape(ch).length > 4) {
				cnt += 2;
			} else {
				cnt += 1;
			}
		}

		//byte.value = cnt + ' / 80 bytes';
		bytes.innerHTML = cnt + ' / 80 bytes';

		if (cnt > 80) {
			exceed = cnt - 80;
			alert('메시지 내용은 80바이트를 넘을수 없습니다.\r\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\r\n초과된 부분은 자동으로 삭제됩니다.');
			var tcnt = 0;
			var xcnt = 0;
			var tmp = cont.value;
			for (i=0; i<tmp.length; i++) {
				ch = tmp.charAt(i);
				if (escape(ch).length > 4) {
					tcnt += 2;
				} else {
					tcnt += 1;
				}

				if (tcnt > 80) {
					tmp = tmp.substring(0,i);
					break;
				} else {
					xcnt = tcnt;
				}
			}
			cont.value = tmp;
			//byte.value = xcnt + ' / 80 bytes';
			bytes.innerHTML = xcnt + ' / 80 bytes';
			return;
		}
	}
</script>