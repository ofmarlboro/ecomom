
<h3 class="icon-list">적립금 관리</h3>

<form id="search_frm">
<table class="adm-table mb20">
	<tr>
		<th>아이디</th>
		<td>
			<input type="text" name="userid" value="<?=$this->input->get('userid')?>">
			<span class="ml30">
				<?=number_format($total)?> 건
				(전체 합계 <?=number_format($point->sum_point)?>점)
			</span>
		</td>
	</tr>
	<tr>
		<th>일자</th>
		<td>
			<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate')?>" readonly> ~
			<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate')?>" readonly>
			<input type="button" value="검색" onclick="frmChk('search_frm')">
		</td>
	</tr>
</table>
</form>

<?php
if($_GET){
	?>
	<script type="text/javascript">
	<!--
		function excel_down(){
			location.href = "?ajax=1&excel=ok&<?=$_SERVER['QUERY_STRING']?>";
		}
	//-->
	</script>
	<div class="mt30 align-r">
		<input type="button" class="btn-ok btn-xl" value="검색 결과 엑셀 저장" onclick="excel_down()">
	</div>
	<?php
}
?>

<table class="adm-table align-c mt30">
	<colgroup>
		<col style="width:10%">
		<col style="width:10%">
		<col>
		<col style="width:10%">
		<col style="width:10%">
	</colgroup>
	<tr>
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

<?php
if(count($list) > 0){
?>
<!-- Pager -->
<p class="list-pager align-c mt50" title="페이지 이동하기">
	<?=$Page?>
</p><!-- END Pager -->
<?php
}
?>