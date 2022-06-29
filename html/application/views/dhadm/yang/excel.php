<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "의기양양 신청내역";

if($_SERVER['HTTP_X_FORWARDED_FOR'] != '58.229.223.174'){
		Header("Content-type: application/vnd.ms-excel");
		Header("Content-Disposition: attachment; filename=" . $path . "_".date("YmdHis").".xls");
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

<table width="100%" cellpadding="5" cellspacing="0" border="1">
	<tr align=center height=30 bgcolor="#EFEFEF">
		<th>의기양양명</th>
		<th>신청자 아이디</th>
		<th>주문기록</th>
		<th>신청자 이름</th>
		<th>신청자 연락처</th>
		<th>회원 우편번호</th>
		<th>회원 주소</th>
		<th>회원 상세주소</th>
		<th>신청단계</th>
		<th>신청일</th>
	</tr>
	<?php
	foreach($list as $lt){
		?>
		<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
			<td><?=$lt->goods_name?></td>
			<td class="xTxt"><?=$lt->userid?></td>
			<td><?=$lt->order_cnt?"O":"X";?></td>
			<td><?=$lt->name?></td>
			<td class="xTxt"><?=$lt->phone?></td>
			<td class="xTxt"><?=$lt->zip1?></td>
			<td><?=$lt->add1?></td>
			<td><?=$lt->add2?></td>
			<td><?=$lt->cate?></td>
			<td><?=$lt->wdate?></td>
		</tr>
		<?php
	}
	?>
</table>