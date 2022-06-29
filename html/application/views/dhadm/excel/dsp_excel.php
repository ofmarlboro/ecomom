<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "DPS_EXCEL";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=에코맘_DPS_".date("Y-m-d").".xls");
	Header("Content-Description: PHP5 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

	}
?>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
	<tr>
		<th>배송일자</th>
		<th>고객코드</th>
		<th>주문자</th>
		<th>주문번호</th>
		<th>수취자</th>
		<th>수취자 전화번호</th>
		<th>우편번호</th>
		<th>주소</th>
		<th>상세주소</th>
		<th>상품군</th>
		<th>상품코드</th>
		<th>골라담기유무</th>
		<th>수량</th>
		<th>첫주문 유무</th>
		<th>정기배송기간</th>
		<th>큰박스여부</th>
		<th>전달사항</th>
		<th>상품명</th>
		<th>배송번호</th>
		<!-- <th>운송장번호</th>
		<th>접수우체국</th>
		<th>가상전화번호</th>
		<th>도착집중국명</th>
		<th>배달우체국명</th>
		<th>배달구구분코드</th> -->
	</tr>
	<?php
	foreach($list as $k=>$lt){

//		if($_SERVER['HTTP_X_FORWARDED_FOR'] == '58.229.223.174'){
//			pr($list);
//			exit;
//		}

		$kcnt = count($lt);

		$box_size = "소";
		if($kcnt > 12){
			$box_size = "대";
		}

		foreach($lt as $kk=>$lt){
			if($lt['option_cnt']){
				foreach($lt['option_info'] as $olt){
					?>
					<tr>
						<td><?=$lt['deliv_date']?></td>
						<td><?=$lt['memidx']?></td>
						<td><?=$lt['order_name']?></td>
						<td><?=$lt['trade_code']?></td>
						<td><?=$lt['recv_name']?></td>
						<td style='mso-number-format:"\@";'><?=$lt['recv_phone']?></td>
						<td style='mso-number-format:"\@";'><?=$lt['zipcode']?></td>
						<td><?=$lt['addr1']?></td>
						<td><?=$lt['addr2']?></td>
						<td><?=$lt['title']?></td>
						<td><?=$lt['code']?></td>
						<td><?=$lt['recom_is']!="Y"?"N":$lt['recom_is'];?></td>
						<td><?=$olt['cnt']?></td>
						<td><?=$lt['first_order']?$lt['first_order']:"N";?></td>
						<td><?=$lt['recom_week_count']?>주</td>
						<td><?=$box_size?></td>
						<td><?=$lt['send_text']?></td>
						<td><?=$lt['goods_name']?> : <?=$olt['name']?></td>
						<td><?=$lt['deliv_code']?></td>
						<!-- <td><?=$lt['invoice_no']?></td>
						<td><?=$lt['regiPoNm']?></td>
						<td><?=$lt['vTelNo']?></td>
						<td><?=$lt['arrCnpoNm']?></td>
						<td><?=$lt['delivPoNm']?></td>
						<td><?=$lt['delivAreaCd']?></td> -->
					</tr>
					<?php
				}
			}
			else{
				?>
				<tr>
					<td><?=$lt['deliv_date']?></td>
					<td><?=$lt['memidx']?></td>
					<td><?=$lt['order_name']?></td>
					<td><?=$lt['trade_code']?></td>
					<td><?=$lt['recv_name']?></td>
					<td style='mso-number-format:"\@";'><?=$lt['recv_phone']?></td>
					<td style='mso-number-format:"\@";'><?=$lt['zipcode']?></td>
					<td><?=$lt['addr1']?></td>
					<td><?=$lt['addr2']?></td>
					<td><?=$lt['title']?></td>
					<td><?=$lt['code']?></td>
					<td><?=$lt['recom_is']!="Y"?"N":$lt['recom_is'];?></td>
					<td><?=$lt['prod_cnt']?></td>
					<td><?=$lt['first_order']?$lt['first_order']:"N";?></td>
					<td><?=$lt['recom_week_count']?>주</td>
					<td><?=$box_size?></td>
					<td><?=$lt['send_text']?></td>
					<td><?=$lt['goods_name']?></td>
					<td><?=$lt['deliv_code']?></td>
					<!-- <td><?=$lt['invoice_no']?></td>
					<td><?=$lt['regiPoNm']?></td>
					<td><?=$lt['vTelNo']?></td>
					<td><?=$lt['arrCnpoNm']?></td>
					<td><?=$lt['delivPoNm']?></td>
					<td><?=$lt['delivAreaCd']?></td> -->
				</tr>
				<?php
			}

		}

	}
	?>
</table>