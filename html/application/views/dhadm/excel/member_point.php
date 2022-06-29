<?
	# URL를 파일명으로 지정.....
	$domain = $this->input->get('userid')."회원님의 적립금내역";
	# 엑셀 생성되는 디비명
	$path = '';
	if($this->input->get('sch_sdate') && $this->input->get('sch_edate')){
		$path = '_'.$this->input->get('sch_sdate')."부터 ".$this->input->get('sch_edate')."까지";
	}


	Header("Content-type: application/vnd.ms-excel");
	Header("Content-Disposition: attachment; filename=" . $domain . $path . "_".date("Y-m-d").".xls");
	Header("Content-Description: PHP5 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

?>

<table cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
	<tr align=center height=30 bgcolor="gray" style="color:#fff;">
		<th>회원아이디</th>
		<th>이름</th>
		<th>포인트내용</th>
		<th>포인트</th>
		<th>일시</th>
	</tr>
	<?php
	if($list){
		foreach($list as $lt){
		?>
		<tr>
			<td><?=$lt->userid?></td>
			<td><?=$lt->name?></td>
			<td><?=$lt->content?></td>
			<td><?=number_format($lt->point)?></td>
			<td><?=$lt->reg_date?></td>
		</tr>
		<?php
		}
	}
	?>
</table>