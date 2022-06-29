<h3 class="icon-search">검색</h3>
<form name="sfrm" id="sfrm">
	<input type="hidden" name="excel">
	<input type="hidden" name="ajax">
	<table class="adm-table">
		<tr>
			<th>날짜</th>
			<td>
				<input type="text" class="datepicker" name="sdate" value="<?=$this->input->get('sdate')?>"> ~
				<input type="text" class="datepicker" name="edate" value="<?=$this->input->get('edate')?>">

				<input type="button" value="검색" onclick="searchfrm()">
			</td>
		</tr>
	</table>
</form>

<p class="mt30"></p>

<div class="float-wrap">
	<h3 class="icon-list float-l">신청내역</h3>
	<p class="float-r">
		<input type="button" class="btn-ok" value="엑셀저장" onclick="excel_down()">
	</p>
</div>
<table class="adm-table align-c">
	<tr>
		<th width="1%"><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
		<th>번호</th>
		<th>날짜</th>
		<th>시간</th>
		<th>이름</th>
		<th>연락처</th>
		<th>관리</th>
	</tr>

	<form name="order_form" method="post" >
	<?php
	$tt = count($list);
	$list_cnt = 0;
	foreach($list as $lt){
		$list_cnt++;
		?>
		<tr>
			<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
			<td><?=$listNo--?></td>
			<td><?=$lt->date?></td>
			<td><?=$lt->time?></td>
			<td><?=$lt->name?></td>
			<td><?=$lt->phone?></td>
			<td><input type="button" class="btn-sm btn-alert" value="삭제" onclick="del_row('<?=$lt->idx?>')"></td>
		</tr>
		<?php
		$tt--;
	}
	?>
	<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
	</form>
</table>

<div class="float-wrap mt20">
	<div class="float-l">
		<span class="btn-inline btn-tinted-02"><a href="javascript: all_del();">선택삭제</a></span>
	</div>
	<div class="float-r"></div>
</div>

<?php
if($list_cnt > 0){
	?>
	<!-- Pager -->
	<p class="list-pager align-c" title="페이지 이동하기">
		<?=$Page2?>
	</p><!-- END Pager -->
	<?php
}
?>


<form method="post" name="delfrm">
	<input type="hidden" name="mode" value="del">
	<input type="hidden" name="idx">
</form>

<script type="text/javascript">
	function searchfrm(){
		frm = document.sfrm;
		if(frm.sdate.value==''){
			alert("검색 시작일자를 입력해주세요.");
			return;
		}
		if(frm.edate.value==''){
			alert("검색 종료일자를 입력해주세요.");
			return;
		}
		frm.submit();
	}

	function excel_down(){
		frm = document.sfrm;
		frm.excel.value = '1';
		frm.ajax.value = '1';
		frm.submit();
	}

	function del_row(idx){
		if(confirm('삭제된 내용은 복구 할 수 없습니다. 삭제 하시겠습니까?')){
			frm = document.delfrm;
			frm.idx.value = idx;
			frm.submit();
		}
	}
</script>