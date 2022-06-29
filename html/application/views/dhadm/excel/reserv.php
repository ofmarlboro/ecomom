<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "사전예약신청내역";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.1741"){

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=" . $path .".xls");
	Header("Content-Description: PHP5 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

	}
?>

<style>
.xTxt{mso-number-format:"\@";}
</style>

<table cellpadding="5" cellspacing="0" border="1">
	<thead>
		<tr>
			<th>번호</th>
			<th>날짜</th>
			<th>시간</th>
			<th>이름</th>
			<th>연락처</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cnt=0;
		foreach($list as $lt){
			$cnt++;
			?>
			<tr>
				<td><?=$cnt?></td>
				<td><?=$lt->date?></td>
				<td><?=$lt->time?></td>
				<td><?=$lt->name?></td>
				<td class="xTxt"><?=$lt->phone?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>