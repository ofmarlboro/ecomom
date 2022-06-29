<table class="order_opt">
	<tbody>
		<tr>
			<th>배송지</th>
			<td><div class="selbox">
					<button type="button" onclick="toggleSelBox(this, event);"><span><?if($deliv_addr){ echo $member_addr_key_arr[$deliv_addr].$member_addr_arr[$deliv_addr]; }else{?>배송지를 선택하세요.<?}?></span></button>
					<ul>
						<?php
						foreach($member_addr_arr as $key=>$maa){
						?>
						<li><input type="radio" name="deliv_addr" msg="배송지를" id="deliv_addr_<?=$key?>" value="<?=$key?>" <?if($deliv_addr == $key){?>checked<?}?>><label for="deliv_addr_<?=$key?>"><?=$member_addr_key_arr[$key]?><?=$maa?></label></li>
						<?php
						}
						?>
					</ul>
				</div>
			</td>
		</tr>
		<?php
		if($deliv_addr == "self"){
		?>
		<tr>
			<th>배송지 입력</th>
			<td>
				<div class="new_addr">
					<p>
						<label for="address1" class="hidden">신규주소</label>
						<input type="hidden" name="zipcode" id="zipcode1" value="<?=$zipcode?>">
						<input type="text" name="addr1" id="address1" readonly value="<?=$addr1?>">
						<button type="button" class="plain" title="새창" onclick="sample6_execDaumPostcode()">우편번호 선택</button>
					</p>
					<p class="mt5"><label for="address2" class="hidden">신규상세주소</label>
						<input type="text" name="addr2" id="address2" class="full" value="<?=$addr2?>">
					</p>
				</div>
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>