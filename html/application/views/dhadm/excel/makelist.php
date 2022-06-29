<?
	# URL를 파일명으로 지정.....
	$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
	# 엑셀 생성되는 디비명
	$path = "생산제품목록";

	if($_SERVER['HTTP_X_FORWARDED_FOR'] != "58.229.223.174"){
		Header("Content-type: application/vnd.ms-excel");
		Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls");
		Header("Content-Description: PHP5 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");
	}




//$case = array('1-6'=>'준비기','1-7'=>'초기','1-8'=>'중기준비기','1-9'=>'중기','1-10'=>'후기','1-11'=>'완료기','2-12'=>'반찬','2-13'=>'국','3'=>'산골간식','4'=>'건강식품','5'=>'오!산골농부','6'=>'특가상품셋트','7'=>'샘플신청','8'=>'간식추가용제품');
//$make_arr = array();
//
//foreach($case as $k=>$v){
//	$make_arr[$k] = $v;
//}
//
//foreach($list as $lt){
//	$make_arr[$lt->cate_no][$lt->name] += $lt->prod_cnt;
//}
//
//pr($make_arr);

foreach($case as $key=>$val){
?>
<table border="1" cellspacing="0" cellpadding="5">
	<tr>
		<th colspan="2"><?=$val?></th>
	</tr>
	<tr>
		<td>품목</td>
		<td>수량</td>
	</tr>
	<?php
	if(count($list[$key])){
		foreach($list[$key] as $k=>$v){
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
	}
	?>
</table>
<br><br>
<?php
}
?>


