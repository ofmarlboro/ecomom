<!doctype html>
<html lang="ko">
<head>
	<title>전체 배송 휴일 설정</title>
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

	<style type="text/css">
	<!--
		body, html {overflow:auto !important;}
		input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	-->
	</style>
</head>
<body>
	<div class="skin-indigo adm-wrap pd20" style="min-width:380px;">

		<h3>전체 배송 휴일 설정</h3>
		<form name="holifrm" id="holifrm" method="post" onsubmit="return false">

		<input type="hidden" name="holiday" value="<?=$this->input->get('date')?>">

		<table class="adm-table v-line mt15">
			<tbody>
				<tr>
					<th style="width:100px;">날짜</th>
					<td>
						<?php
						echo $this->input->get('date');
						?>
					</td>
				</tr>
				<tr>
					<th>배송</th>
					<td>
						<input type="checkbox" id="allchk"><label for="allchk">전체선택</label><br><br>
						<input type="checkbox" name="regu" value="1" class="delivtype" id="deliv01" <?=@$row->regu?"checked":"";?>><label for="deliv01">정기</label>
						<input type="checkbox" name="free" value="1" class="delivtype" id="deliv02" <?=@$row->free?"checked":"";?>><label for="deliv02">낱개/특가</label>
						<input type="checkbox" name="samp" value="1" class="delivtype" id="deliv03" <?=@$row->samp?"checked":"";?>><label for="deliv03">샘플</label>
						<input type="checkbox" name="snhf" value="1" class="delivtype" id="deliv04" <?=@$row->snhf?"checked":"";?>><label for="deliv04">간식/건강식품</label>
					</td>
				</tr>
				<tr>
					<th>정기배송<br>휴일사유</th>
					<td>
						<input type="radio" name="type" value="배송휴무" id="type01" <?=@$row->type == "배송휴무"?"checked":"";?>><label for="type01">배송휴무</label>
						<input type="radio" name="type" value="조기마감" id="type02" <?=@$row->type == "조기마감"?"checked":"";?>><label for="type02">조기마감</label>
					</td>
				</tr>
				<tr>
					<th>휴일명</th>
					<td>
						<input type="text" name="holiday_name" value="<?=@$row->holiday_name?>">
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품 옵션 설정 테이블 -->
		</form>
		<br><br>

		<p class="align-c">
			<input type="button" value="<?if(@$row){?>수정<?}else{?>등록<?}?>" onclick="send_frm()">
		</p>
	</div>


	<script language="javascript">
		$(function(){
			$("#allchk").on('click',function(){
				$(".delivtype").prop('checked',$(this).prop('checked'));
			});
		});

		function send_frm(){

			frm = document.holifrm;

			var punch = false;
			$(".delivtype").each(function(){
				if($(this).prop('checked')){
					punch = true;
					return;
				}
			});

			if(!punch){
				alert("휴일설정하실 배송을 선택해주세요.");
				return;
			}

			var type = $(":input[name='type']:radio:checked").val();
			if(!type){
				alert("휴일 사유를 선택해 주세요.");
				return;
			}

			if(frm.holiday_name.value == ""){
				alert("휴일명을 입력해주세요.");
				return;
			}

			$("#holifrm").ajaxSubmit({
				success:function(data){
					if(data == "ok"){
						opener.location.reload();
						alert('등록 되었습니다.');
						self.close();
					}else if(data == "no"){
						alert('처리에 오류가 있습니다. 다시 한번 확인해 주세요.');
					}else{
						alert("뭐하심?");
					}

				},
				error:function(xhr){alert(xhr.responseText)}
			});
		}

		function enterkey(){
			if (window.event.keycode == 13)
			{
				send_frm();
			}
		}
	</script>

 </body>
</html>
