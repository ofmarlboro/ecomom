
<h3 class="icon-list">블링포인트 관리</h3>

<form id="search_frm">
<table class="adm-table mb20">
	<tr>
		<th>아이디</th>
		<td>
			<input type="text" name="userid" value="<?=$this->input->get('userid')?>" msg="검색할 아이디를 입력해 주세요.">
			<input type="button" value="검색" onclick="frmChk('search_frm')">
			<span class="ml30">
				<?=number_format($total)?> 건
				(전체 합계 <?=number_format($point->sum_point)?>점)
			</span>
		</td>
	</tr>
</table>
</form>

<table class="adm-table align-c">
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