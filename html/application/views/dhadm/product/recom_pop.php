<!doctype html>
<html lang="ko">
 <head>
  <title><?=$page_title?></title>
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
	<script type="text/javascript" src="/_data/js/jquery.form.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		//$('select[name=check]').select2();
		//$('select[name=select_it_id2]').select2();
		//$('select[name=select_it_id3]').select2();
		$(".select_jq").select2();
	});
	</script>

	<style type="text/css">
	<!--
	body, html {overflow:auto !important;}
	.select_jq{width:450px;}
	-->
	</style>
 </head>

 <body>
	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">

		<h3><?=$page_title?></h3>

		<form method="post" name="relation_frm" id="relation_frm">
		<input type="hidden" name="recom_food_idx" value="<?=$recom_food_info->idx?>">
		<input type="hidden" name="recom_date" value="<?=$date?>">

		<table class="adm-table line align-c">
			<tr>
				<th>상품선택1</th>
				<td>
					<select name="check[]" class="select_jq">
					<option value="">상품을 선택하세요.</option>
					<?php
					foreach($list as $lt){
					?>
					<option value="<?=$lt->idx?>" <?if(@$edit_data[0] and $lt->idx == @$edit_data[0]){?>selected<?}?>><?=$lt->name?> (<?=$lt->code?>)</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th>상품선택2</th>
				<td>
					<select name="check[]" class="select_jq">
					<option value="">상품을 선택하세요.</option>
					<?php
					foreach($list as $lt){
					?>
					<option value="<?=$lt->idx?>" <?if(@$edit_data[1] and $lt->idx == @$edit_data[1]){?>selected<?}?>><?=$lt->name?> (<?=$lt->code?>)</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th>상품선택3</th>
				<td>
					<select name="check[]" class="select_jq">
					<option value="">상품을 선택하세요.</option>
					<?php
					foreach($list as $lt){
					?>
					<option value="<?=$lt->idx?>" <?if(@$edit_data[2] and $lt->idx == @$edit_data[2]){?>selected<?}?>><?=$lt->name?> (<?=$lt->code?>)</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<th>상품선택4</th>
				<td>
					<select name="check[]" class="select_jq">
					<option value="">상품을 선택하세요.</option>
					<?php
					foreach($list as $lt){
					?>
					<option value="<?=$lt->idx?>" <?if(@$edit_data[3] and $lt->idx == @$edit_data[3]){?>selected<?}?>><?=$lt->name?> (<?=$lt->code?>)</option>
					<?php
					}
					?>
					</select>
				</td>
			</tr>
		</table>
		</form>

		<p class="align-c mt20">
			<input type="button" value="닫기" class="btn-cancel btn-l" onclick="self.close()">
			<input type="button" value="확인" name="writeBtn" class="btn-ok btn-l" onclick="select_product()">
		</p>
	</div>

<script>
	function select_product(){
		$("#relation_frm").ajaxSubmit({
			success:function(data){

				console.log(data);

				if(data == "ok"){
					opener.location.reload();
					alert('등록 되었습니다.');
					self.close();
				}else if(data == "no"){
					alert('처리에 오류가 있습니다. 다시 한번 확인해 주세요.');
				}
			},
			error:function(xhr){alert(xhr.responseText)}
		});
	}
</script>

 </body>
</html>
