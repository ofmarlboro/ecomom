<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "생산제품목록_병합출력";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){
		Header("Content-type: application/vnd.ms-excel");
		Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls");
		Header("Content-Description: PHP5 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");
	}

?>
<table border="1" cellspacing="0" cellpadding="5">
	<tr>
		<td>품목</td>
		<td>수량</td>
	</tr>
	<?php
	foreach($excel_arr as $k=>$v){
		if($v['option_cnts'] <= 0){
		?>
		<tr>
			<td><?=$v['name']?></td>
			<td><?=$v['prod_cnt']?></td>
		</tr>
		<?php
		}
		else{
			foreach($v['option_info'] as $option_idx=>$option_info){
			?>
			<tr>
				<td><?=$v['name']?> [옵션:<?=$option_info['option_name']?>]</td>
				<td><?=$option_info['option_cnt']?></td>
			</tr>
			<?php
			}
		}
	}
	?>
</table>