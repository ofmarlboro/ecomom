<h3 class="icon-pen">배송불가 지역관리</h3>

<form method="post" name="smsfrm" id="smsfrm">
<table class="adm-table">
	<tr>
		<th>배송 불가 지역 키워드</th>
	</tr>
	<tr>
		<td>
			<?php
			$info_text = "- 배송이 안되는 지역명을 필터링 할 키워드를 입력해 주세요. 입력 단위는 ^ 입니다. EX) 제주^강화^울릉^독도<br>
			- 키워드를 기준으로 필터링을 하기때문에 예상치 못한 주소가 필터링 될수도 있는 부분을 감안 해 주시기 바랍니다.<br>
			- 정확한 배송 불가 지역 설정을 해주세요. 잘못된 입력값이 있는 경우 홈페이지에 알 수 없는 에러가 발생 할 수 있습니다.";
			help_info($info_text);
			?>
		</td>
	</tr>
	<tr>
		<td>
			<textarea name="not_deliv_value" cols="30" rows="10"><?=$row->not_deliv?></textarea>
		</td>
	</tr>
</table>
</form>

<div class="align-c mt50">
	<input type="button" value="확인" class="btn-l" onclick="document.smsfrm.submit()">
</div>