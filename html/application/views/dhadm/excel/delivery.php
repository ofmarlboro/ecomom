<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "deliv_list";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".$this->input->get('sch_sdate')." ~ ".$this->input->get('sch_edate').".xls");
	Header("Content-Description: PHP5 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

	}
?>
<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<thead>
		<tr>
			<th>주문단계</th>
			<th>첫주문여부</th>
			<th>배송일</th>
			<th>주문일자</th>
			<th>주문번호 [PC/Mobile]</th>
			<th>배송상태</th>
			<th>주문내역</th>
			<th>주문자성명</th>
			<th>아이디</th>
			<th>연락처</th>
			<th>받는분</th>
			<th>연락처</th>
			<th>결제수단</th>
			<th>주문금액</th>
			<th>우편번호</th>
			<th>배송지</th>
			<th>배송시요청사항</th>
			<th>택배사</th>
			<th>송장번호</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			foreach($list as $lt){
			?>
			<tr>
				<td><?=$shop_info['trade_stat'.$lt->trade_stat]?></td>
				<td><?php if($lt->first_order == "Y"){ ?> [첫주문] <?php } ?></td>
				<td><?=$lt->deliv_date?></td>
				<td><?=$lt->trade_day?></td>
				<td><?=$lt->trade_code?>[<?=($lt->mobile)?"M":"P";?>]</td>
				<td>
					<?php
					foreach($deliv_stat_arr as $k=>$v){
						echo ($k == $lt->deliv_stat)?$v:"";
					}
					?>
				</td>
				<td>
					<?php
					/*
					if($lt->recom_idx > 0){
						echo "[영양식단] ".$recom_name_arr[$lt->recom_idx];
					}
					else{
						foreach($goods_name_arr[$lt->deliv_code] as $gname){
							echo $gname;
						}
					}
					*/
					echo $lt->prod_name;
//					if($lt->option_name){
//						echo '-'.$lt->option_name;
//					}
					?>
				</td>
				<td><?=$lt->order_name?></td>
				<td><?=$lt->userid?></td>
				<td style='mso-number-format:"\@";'><?=$lt->order_phone?></td>
				<td><?=$lt->recv_name?></td>
				<td style='mso-number-format:"\@";'><?=$lt->recv_phone?></td>
				<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
				<td><?=number_format($lt->total_price)?></td>
				<td style='mso-number-format:"\@";'><?=$lt->zipcode?></td>
				<td><?=$lt->addr1?> <?=$lt->addr2?></td>
				<td><?=($lt->send_text)?"<span style='color:blue;font-weight:bold'>요청사항 : </span>".$lt->send_text:"";?></td>
				<td><?=$lt->invoice_company?></td>
				<td style='mso-number-format:"\@";'><?=$lt->invoice_no?></td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>