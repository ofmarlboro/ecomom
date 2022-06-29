<?php
$domain = "야시장 체험신청";
$path = "";

if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){
	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=" . $domain . "_".date("Y-m-d").".xls");
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

<table cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
	<tr align=center height=30 bgcolor="#EFEFEF">
		<th>번호</th>
		<th>아이디</th>
		<th>성함</th>
		<th>연락처</th>
		<th>배송지</th>
		<th>sns링크</th>
		<th>신청일</th>
	</tr>
	<tbody>
	<?php
	foreach($list as $lt){
		?>
		<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
			<td><?=$listNo--?></td>
			<td><?=$lt->userid?></td>
			<td><?=$lt->name?></td>
			<td><?=$lt->phone?></td>
			<td><?=$lt->addr1." ".$lt->addr2?></td>
			<td><?=$lt->snsurl?></td>
			<td><?=$lt->wdate?></td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>