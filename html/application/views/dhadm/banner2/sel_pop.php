<!doctype html>
<html lang="ko">
 <head>
  <title>게시물 <?=$mode == "copy" ? "복사" : "이동" ;?></title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css" />
	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>

	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	input[type="button"],input[type='submit'] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	h3 em { font-size:12.5px;}
	.adm-table td a { color:#09569c; }
	-->
	</style>

	<script type="text/javascript">
	<!--
		function bbs_mc(frm){
			if(frm.act_code.value == ""){
				alert('<?=$mode == "copy" ? "복사" : "이동" ;?>할 게시판을 선택 해 주세요.');
				return false;
			}
		}
	//-->
	</script>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>배너 <?=$mode == "copy" ? "복사" : "이동" ;?></h3>

		<h4 class="mt25">· <?=$mode == "copy" ? "복사" : "이동" ;?> 설정</h4>

		<form method="post" name="mcfrm" id="mcfrm" onsubmit="return bbs_mc(this)">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="chkval" value="<?=$chkval?>">
		<table class="adm-table v-line mt15">
			<tbody>
				<tr>
					<th><?=$mode == "copy" ? "복사" : "이동" ;?>할 게시판 선택</th>
					<td>
						<select name="act_code">
							<option value="">게시판 선택</option>
							<?php
							foreach($list as $lt){
							?>
							<option value="<?=$lt->code?>@@<?=$lt->idx?>"><?=$lt->name?></option>
							<?php
							}
							?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="float-wrap mt40">
			<p class="float-l"><input type="button" class="btn-l btn-cancel mr5" value="닫기" onclick="window.close();"></p>
			<p class="float-r"><input type="submit" class="btn-l mr5" value="확인"></p>
		</div>
		</form>
	</div>
 </body>
</html>