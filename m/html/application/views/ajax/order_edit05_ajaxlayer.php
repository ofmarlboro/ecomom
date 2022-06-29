	<div class="layer_pop_inner">
		<h1>
			배송 몰아받기
		</h1>
		<div class="inner clearfix">
			<p class="blue mt10">
				※ 배송일이 동일한 다른 주문건이 있습니다.<br>&nbsp;&nbsp;&nbsp;
					 배송비 정책에 의하여 배송 몰아받기 바로 신청 하실 수 없습니다.
			</p>

			<p class="jung">
				배송일이 중복된 주문 내용입니다.
			</p>

			<ul class="jung02">
				<?php
				foreach($dup_list as $dl){
				?>
				<li><?=date("m/d",strtotime($dl->deliv_date))?> (<?=numberToWeekname($dl->deliv_date)?>) <?=$dl->prod_name?> (<?=$dl->trade_code?>)</li>
				<?php
				}
				?>
			</ul>

		</div>
		<button type="button" class="w50 close01" title="주문취소" onclick="fkk_none()">몰아받기 요청</button>
		<button type="button" class="w50 close" title="닫기" onclick="closecancel_layer()">닫기</button>
	</div>