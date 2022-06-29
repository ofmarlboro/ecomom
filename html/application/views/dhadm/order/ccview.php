<h3 class="icon-list">취소 내역 보기 ( 주문번호 : <?=$trade_info->trade_code?> )</h3>

<table class="adm-table mt30">
	<colgroup>
		<col style="width:15%">
		<col>
	</colgroup>
	<tr>
		<th>주문정보</th>
		<td>
			<p>
				총 결제 금액 : <?=number_format($trade_info->price)?> 원
			</p>
			<?php
			if($trade_info->use_point){
			?>
			<p>
				포인트 사용 : <?=number_format($trade_info->use_point)?> P
			</p>
			<?php
			}
			?>

			<?php
			if($trade_info->use_coupon){
			?>
			<p>
				쿠폰 사용 : <?=number_format($trade_info->use_coupon)?> 원
			</p>
			<?php
			}
			?>
			<p>
				실 결제 금액 : <?=number_format($trade_info->total_price)?> 원
			</p>
		</td>
	</tr>
	<tr>
		<th>취소사유</th>
		<td>
			<?=nl2br($trade_info->cancel_msg)?>
		</td>
	</tr>
	<tr>
		<th>환불예상금액</th>
		<td>
			<?=number_format($trade_info->return_price)?> 원
		</td>
	</tr>
	<tr>
		<th> 연계된 주문내역 표시</th>
		<td>
			<?php
			foreach($deliv_relations as $dr){
			?>

			<p class="mt10">
				<?=date("Y-m-d",strtotime($dr['deliv_date']))?> <?=numberToWeekname($dr['deliv_date'])?>요일 <?=$dr['prod_name']?> (주문번호 : <?=$dr['trade_code']?>)
			</p>

			<?php
			}
			?>
		</td>
	</tr>
	<tr>
		<th>결제수단</th>
		<td>
			<?=$shop_info['trade_method'.$trade_info->trade_method]?>
		</td>
	</tr>
</table>

<p class="align-c mt40">
	<?php
	if($trade_info->trade_stat == "9"){
	?>
	<input type="button" value="목록으로" onclick="location.href='/html/order/cclist/m'">
	<?php
	}
	else{
	?>
	<input type="button" value="취소 승인" onclick="change_trade_stat('<?=$trade_info->idx?>','9')">
	<?php
	}
	?>
</p>

<script type="text/javascript">
	function change_trade_stat(idx, val){
		if(confirm('상태를 변경 하시겠습니까?\n\n※ 주문이 취소될 경우 정기주문내역의\n모든 연동데이터가 삭제됩니다.')){
			frm = document.change_stat_frm;
			frm.change_idx.value = idx;
			frm.change_stat.value = val;
			frm.submit();
		}
	}
</script>

<form name="change_stat_frm" method="post">
	<input type="hidden" name="change_idx">
	<input type="hidden" name="change_stat">
</form>