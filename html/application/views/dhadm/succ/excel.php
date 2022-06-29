<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "의기양양 당첨자내역";


		Header("Content-type: application/vnd.ms-excel");
		Header("Content-Disposition: attachment; filename=" . $path . "_".date("YmdHis").".xls");
		Header("Content-Description: PHP5 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

?>

<style>
.xTxt{mso-number-format:"\@";}
td{font-size:11px;}
.xTxtF{color:red;}
</style>

<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<tr align=center height=30 bgcolor="#EFEFEF">
		<th>년도</th>
		<th>월</th>
		<th>의기양양명</th>
		<th>당첨자 주문기록</th>
		<th>신청자 아이디</th>
		<th>신청자 이름</th>
		<th>신청자 연락처</th>
		<th>신청단계</th>
		<th>날짜</th>
	</tr>
	<?php
	foreach($list as $lt){
		?>
		<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
			<td><?=$lt->year?></td>
			<td><?=$lt->month?></td>
			<td><?=$lt->prod?></td>
			<td><?=$lt->trade_code?"O":"X";?></td>
			<td><?=$lt->userid?></td>
			<td><?=$lt->name?></td>
			<td><?=$lt->phone?></td>
			<td><?=$lt->cate?></td>
			<td><?=$lt->wdate?></td>
		</tr>
		<?php
	}
	?>
</table>