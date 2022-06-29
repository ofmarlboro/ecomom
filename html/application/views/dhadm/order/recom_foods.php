<!doctype html>
<html lang="ko" style="overflow-x:hidden;overflow-y:scroll;">
 <head>
  <title>에코맘 산골이유식 : 추천식단정보</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css?t=<?=time()?>" />

	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	<style type="text/css">
		.cntzero{
			background:#eee;
		}
	</style>
 </head>
 <body>
	<h1 style="font-size:20px;font-weight:600;margin:20px">
		식단정보
		<?php
		$dcodef_arr = explode("_",$this->input->get('dcodef'));
		?>
		( <?=$dcodef_arr[0]?> )
	</h1>

	<table class="adm-table">
		<tr>
			<th>배송일</th>
			<th>상품정보</th>
			<th>수량</th>
		</tr>
		<?php
		$prod_cnt = 0;
		foreach($recom_foods_list as $rf){
			$prod_cnt+=$rf->prod_cnt;
		?>
			<tr style="background:<?=($rf->prod_cnt <= 0)?"gray":"";?>;">
				<td data-value="<?=strtotime($rf->deliv_date)?>"><?=$rf->deliv_date?> (<?=numberToWeekname($rf->deliv_date)?>)</td>
				<td>
					<?php
					if($rf->list_img){
					?>
					<img src="/_data/file/goodsImages/<?=$rf->list_img?>" style="max-width:25px;vertical-align:middle">
					<?php
					}

					echo $rf->name;
					?>
				</td>
				<td><?=number_format($rf->prod_cnt)?> 팩</td>
			</tr>
		<?php
		}
		?>
		<tr>
			<td colspan="2">합계</td>
			<td><?=$prod_cnt?>팩</td>
		</tr>
	</table>

	<p class="mt50 mb50 align-c">
		<button class="btn" onclick="self.close();">닫기</button>
	</p>
	<script type="text/javascript">
	<!--
		$(function(){
			$(".adm-table").rowspan(0);
		});
	//-->
	</script>
 </body>
</html>
