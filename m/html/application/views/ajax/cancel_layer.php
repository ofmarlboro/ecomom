	<div class="layer_pop_inner">
		<h1>
			주문 취소
		</h1>
		<div class="inner clearfix">
			<p> <?=$date_day_name?>요일 <?=$step_name?> 주문/배송 내역입니다. </p>
			<p class="mt10">
				<!-- <select name="" id="" style="width:100%" class="sel">
					<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
					<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
					<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
				</select> -->
				<?=$deliv_list_select?>
			</p>
			<p class="blue mt10"> ※주문취소는 30분 이내로 적용되며, 쿠폰 및 사용하신 적립금은 다시 복구됩니다. </p>

			<?php
			if($return_price > 0){
			?>
			<div class="tblTy05 mt0">
				<table>
					<tr>
						<td>취소완료 후 환불 받으실 금액은 <span class="fz18"><?=number_format($return_price)?></span>원 입니다.</td>
					</tr>
				</table>
			</div>
			<?php
			}
			?>

			<?php
			if($dup_deliv_info){
			?>
			<p class="bu03 mt20">
				배송 일정에 포함된 배송건들이 있습니다.
			</p>
			<div class="tblTy05 mt0" style="height:90px;overflow:scroll;">
				<table>
					<?php
					$db_deliv_code = "";
					foreach($dup_deliv_info as $ddi){
						foreach($ddi as $ddi){
							$db_deliv_code .= $ddi['deliv_code']."^";
						?>
						<tr><td style="text-align:left;padding-left:15px"><?=date("m/d",strtotime($ddi['deliv_date']))?> <?=numberToWeekname($ddi['deliv_date'])?> <?=$ddi['prod_name']?> (주문번호 : <?=$ddi['trade_code']?>)</td></tr>
						<?php
						}
					}
					?>
				</table>
			</div>
			<?php
			}
			?>

			<!-- <div class="tblTy05 mt0">
				<table>

						<td>취소완료 후 환불 받으실 금액은 <span class="fz18">38,000</span>원 입니다.</td>
				</table>
			</div> -->
			<p class="mt20"> 취소사유를 적어 주시면 더 나은 서비스 제공을 위해 노력하겠습니다. </p>
			<p class="ac">
				<textarea name="cancel_comment" id="cancel_comment" class="cancel_area"></textarea>
			</p>
		</div>
		<button type="button" class="w50 close01" title="주문취소" onclick="order_cancel('<?=$deliv_code?>','<?=$recom_is?>','<?=$trade_info->trade_method?>','<?=$trade_info->tno?>','<?=$return_price?>','<?=urlencode($db_deliv_code)?>')">주문취소</button>
		<button type="button" class="w50 close" title="닫기" onclick="closecancel_layer()">닫기</button>
	</div>