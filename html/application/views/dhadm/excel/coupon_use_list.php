<?
	# 엑셀 생성되는 디비명
	$path = "쿠폰사용내역-";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){

		Header("Content-type: application/vnd.ms-excel");
		Header("Content-Disposition: attachment; filename=".$path.date("Y-m-d").".xls");
		Header("Content-Description: PHP5 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

	}
?>

<style>
.xTxt{mso-number-format:"\@";}
td{font-size:11px;}
.xTxtF{color:red;}
</style>

<table border="1" cellspacing="0" cellpadding="5" width="100%">
	<tr style="background:#ddd;color:#000;">
		<th>쿠폰코드</th>
		<th>쿠폰명</th>
		<th>할인(금액)</th>
		<th>유효기간</th>
		<th>고객명</th>
		<th>아이디</th>
		<th>전화번호</th>
		<th>발급일자</th>
		<th>등록일자</th>
		<th>사용일자</th>
		<th>거래번호</th>
	</tr>
	<?php
	foreach($list as $lt){
		?>
		<tr>
			<td><?=$lt->code?></td>
			<td><?=$lt->name?></td>
			<td><?=number_format($lt->price)?>원</td>
			<td><?=$lt->start_date?> ~ <?=$lt->end_date?></td>
			<td><?=$lt->mem_name?></td>
			<td><?=$lt->userid?></td>
			<td><?=$lt->mem_phone?></td>
			<td class='xTxt'><?=date("Y-m-d",strtotime($lt->coupon_reg_date))?></td>
			<td class='xTxt'><?=date("Y-m-d",strtotime($lt->reg_date))?></td>
			<td class='xTxt'><?=$lt->use_date!='-'?date("Y-m-d",strtotime($lt->use_date)):$lt->use_date;?></td>
			<td><?=$lt->trade_code?></td>
		</tr>
		<?php
	}
	?>
</table>