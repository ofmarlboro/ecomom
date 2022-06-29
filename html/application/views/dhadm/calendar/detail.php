<!doctype html>
<html lang="ko">
<head>
	<title>일별설정</title>
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
	<style type="text/css">
	<!--
		body, html {overflow:auto !important;}
		input[type="button"] { height:30px; border:0; font-size:12px; padding:0 15px; background:#5b5b5b; color:#fff; cursor:pointer; }
	-->
	</style>
	<script type="text/javascript">
	<!--
		function change_state(){
			if (confirm('당일 예약 설정을 변경 하시겠습니까?'))
			{
				document.statefrm.submit();
			}
			else
			{
				location.reload();
			}
		}

		function revervation_none(){
			if (confirm('당일 예약 일정을 모두 삭제 하시겠습니까?'))
			{
				location.href='/html/reservation/calendar_delete/?ajax=1&date=<?=$this->input->get("date")?>';
			}
		}

		function close_window(){
			opener.location.reload();
			self.close();
		}

		function ajax_resv_standard_update(idx,stat){
			if(confirm('변경하시겠습니까?')){
				var chg_stat = (stat == 0) ? "5":"0";
				location.href="/html/reservation/day_time_update/?ajax=1&idx="+idx+"&stat="+chg_stat;
			}
			else{
				$("#resv_"+idx).prop('checked',false);
			}
		}
	//-->
	</script>
</head>
<body>
	<div class="skin-indigo adm-wrap pd20">
		<h3>
			<?=$this->input->get("date")?> 예약일정표 <input type="button" value="닫기" onclick="close_window()" style="margin-left:20px">
		</h3>
		<hr>
		<?php
		if(count($list) > 0){
		?>
		<p class="align-c pt20">
			<input type="button" value="예약일정 일괄삭제" onclick="revervation_none()">
		</p>
		<?php
		}
		else{
		?>
		<form method="post" name="statefrm">
		<input type="hidden" name="date" value="<?=$this->input->get("date")?>">
			<p class="align-c pt20">
				<input type="button" value="예약일정 생성" onclick="change_state()">
			</p>
		</form>
		<?php
		}

		help_info('관리자는 예약 가능 / 불가만 설정 가능하며<br>대기 / 마감 된 예약은 예약 목록에서 설정 가능합니다.');
		?>
		<table class="adm-table v-line mt15">
			<colgroup>
				<col style="width:1%">
				<col>
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th></th>
					<th>예약일정표</th>
					<th>예약가능여부</th>
				</tr>
				<?php
				foreach($list as $row){
				?>
				<tr>
					<td>
						<input type="checkbox" value="<?=$row->idx?>" id="resv_<?=$row->idx?>" <?=($row->price)?"":"checked";?> <?if($row->price == 1 || $row->price == 9){?>disabled<?}else{?>onchange="ajax_resv_standard_update('<?=$row->idx?>','<?=$row->price?>')"<?}?>>
					</td>
					<td><label for="resv_<?=$row->idx?>" style="cursor:pointer"><?=$row->time?></label></td>
					<td>
						<?php
						if($row->price == 9){
							echo "<span style='color:gray'>대기</span>";
						}
						else if($row->price == 1){
							echo "<span style='color:red'>마감</span>";
						}
						else if($row->price == 5){
							echo "<span style='color:darkorchid'>불가</span>";
						}
						else{
							echo "<span style='color:blue'>가능</span>";
						}
						?>
					</td>
				</tr>
				<?php
				}

				if(count($list) <= 0){
				?>
				<tr>
					<td colspan="3" class="align-c">설정된 예약일정이 없습니다.</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<!-- <p class="align-c pt30">
			<input type="submit" value="<?=($mode=="edit")?"수정":"등록";?>">
		</p> -->
	</div>
 </body>
</html>
