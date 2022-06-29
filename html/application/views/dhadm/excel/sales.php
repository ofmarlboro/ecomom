<?
	# URL를 파일명으로 지정.....
	$domain = "매출현황";
	# 엑셀 생성되는 디비명
	$path = $this->input->get('sch_sdate')."부터 ".$this->input->get('sch_edate')."까지";

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls");
	Header("Content-Description: PHP5 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

?>

<table cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
	<thead>
		<tr align=center height=30 bgcolor="#FAFF56">
			<th rowspan="2">주문일자</th>
			<th rowspan="2">총 주문수</th>
			<th rowspan="2">총 주문합계</th>
			<th colspan="2">무통장</th>
			<th colspan="2">계좌이체</th>
			<th colspan="2">카드입금</th>
			<th colspan="2">휴대폰</th>
			<th colspan="2">포인트입금</th>
			<th colspan="2">쿠폰</th>
			<th colspan="2">가상계좌</th>
			<th colspan="2" style="color:red;">주문취소</th>
		</tr>
		<tr align=center height=30 bgcolor="gray" style="color:#fff;">
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td  style="color:red;">건</td>
			<td  style="color:red;">금액</td>
		</tr>
	</thead>
	<tbody>

		<?php
		foreach($table as $odate=>$ol){
			$list_total_cnt+=$ol[total_order_cnt];
			$list_total_price+=$ol[total_order_price];

			//무통장 합계
			$tm2_cnt+=$ol[m2_cnt];
			$tm2_price+=$ol[m2_total];

			//계좌이체 합계
			$tm3_cnt+=$ol[m3_cnt];
			$tm3_price+=$ol[m3_total];

			//가상계좌 합계
			$tm4_cnt+=$ol[m4_cnt];
			$tm4_price+=$ol[m4_total];

			//신용카드 합계
			$tm1_cnt+=$ol[m1_cnt];
			$tm1_price+=$ol[m1_total];

			//휴대폰 합계
			$tm7_cnt+=$ol[m7_cnt];
			$tm7_price+=$ol[m7_total];

			//포인트 합계
			$tm5_cnt+=$ol[use_point_cnt];
			$tm5_price+=$ol[use_point_price];

			//쿠폰 합계
			$cp_cnt+=$ol[use_coupon_cnt];
			$cp_price+=$ol[use_coupon_price];

			//주문취소 합계
			$list_total_cc_cnt+=$ol[total_order_cc_cnt];
			$list_total_cc_price+=$ol[total_order_cc_price];
			?>
			<tr>
				<td><?=$odate?></td>
				<th><?=number_format($ol[total_order_cnt])?></th>
				<th><?=number_format($ol[total_order_price])?></th>
				<td><?=number_format($ol[m2_cnt])?></td>
				<td><?=number_format($ol[m2_total])?></td>
				<td><?=number_format($ol[m3_cnt])?></td>
				<td><?=number_format($ol[m3_total])?></td>
				<td><?=number_format($ol[m1_cnt])?></td>
				<td><?=number_format($ol[m1_total])?></td>
				<td><?=number_format($ol[m7_cnt])?></td>
				<td><?=number_format($ol[m7_total])?></td>
				<td><?=number_format($ol[use_point_cnt])?></td>
				<td><?=number_format($ol[use_point_price])?></td>
				<td><?=number_format($ol[use_coupon_cnt])?></td>
				<td><?=number_format($ol[use_coupon_price])?></td>
				<td><?=number_format($ol[m4_cnt])?></td>
				<td><?=number_format($ol[m4_total])?></td>
				<td style="color:red;"><?=number_format($ol[total_order_cc_cnt])?></td>
				<td style="color:red;"><?=number_format($ol[total_order_cc_price])?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th>주문합계</th>
			<th><?=number_format($list_total_cnt)?></th>
			<th><?=number_format($list_total_price)?></th>
			<th><?=number_format($tm2_cnt)?></th>
			<th><?=number_format($tm2_price)?></th>
			<th><?=number_format($tm3_cnt)?></th>
			<th><?=number_format($tm3_price)?></th>
			<th><?=number_format($tm1_cnt)?></th>
			<th><?=number_format($tm1_price)?></th>
			<th><?=number_format($tm7_cnt)?></th>
			<th><?=number_format($tm7_price)?></th>
			<th><?=number_format($tm5_cnt)?></th>
			<th><?=number_format($tm5_price)?></th>
			<th><?=number_format($cp_cnt)?></th>
			<th><?=number_format($cp_price)?></th>
			<th><?=number_format($tm4_cnt)?></th>
			<th><?=number_format($tm4_price)?></th>
			<th colspan="2"></th>
		</tr>
		<tr>
			<th style="color:red;">취소합계</th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"></th>
			<th style="color:red;"><?=number_format($list_total_cc_cnt)?></th>
			<th style="color:red;"><?=number_format($list_total_cc_price)?></th>
		</tr>
	</tfoot>
</table>