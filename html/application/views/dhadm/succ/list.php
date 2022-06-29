<script type="text/javascript">
	//날짜 자동 입력
	function set_date_val(sd, ed){
		$("#start_date").val(sd);
		$("#end_date").val(ed);
	}
</script>
<h3 class="icon-search">당첨자 검색</h3>
<form name="search_form">
	<!-- 제품검색 -->
	<table class="adm-table">
		<caption>제품 검색</caption>
		<colgroup>
			<col style="width:15%;"><col>
		</colgroup>
		<tbody>
			<tr>
				<th>
					<select name="sch_item">
						<option value="prod">의기양양명</option>
						<option value="phone">연락처</option>
						<option value="userid">아이디</option>
						<option value="name">이름</option>
					</select>
					<script type="text/javascript">
					<!--
						var sch_item = document.search_form.sch_item;
						for(i=0;i<sch_item.length;i++){
							if(sch_item.options[i].value == "<?=$this->input->get('sch_item')?>"){
								sch_item.options[i].selected = true;
							}
						}
					//-->
					</script>
				</th>
				<td>
					<input type="text" class="width-l" name="sch_item_val" value="<?=$this->input->get('sch_item_val')?>" onkeyup="enter_press();">

					<input type="button" value="검색" class="btn-sm btn-ok" onclick="javascript:document.search_form.submit();">
				</td>
			</tr>
		</tbody>
	</table><!-- END 제품검색 -->
</form>

<script type="text/javascript">
	function succ_upload_excel(){
		if(document.eupfrm.upfile.value == ""){
			alert("업로드 하실 엑셀 파일을 첨부 해 주세요.");
			return;
		}
		document.eupfrm.mode.value = "succ_exc_up";
		document.eupfrm.submit();
	}

	function excel_down(){
		frm = document.sfrm;
		frm.excel.value = 1;
		frm.ajax.value = 1;
		frm.submit();
	}

</script>

<form name="sfrm">
<input type="hidden" name="excel">
<input type="hidden" name="ajax">
</form>

<h3 class="icon-pen mt20">당첨자 엑셀저장</h3>
<form name="eupfrm" enctype='multipart/form-data' method="post">
<input type="hidden" name="mode">
	<table class="adm-table">
		<tr>
			<th>당첨자 엑셀파일</th>
			<td>
				<input type="file" name="upfile" style="width:600px">
				<input type="button" value="업로드" onclick="succ_upload_excel()">
			</td>
			<td>
				<a href="/_data/file/excel_sample/apply_success_list.xlsx" class="btn-clear" style="padding:10px;" download>등록샘플 다운로드</a>
			</td>
		</tr>
	</table>
</form>


<h3 class="icon-list mt30">당첨자리스트 (<b><?=$totalCnt?></b>건) <button type="button" onclick="excel_down()">전체 엑셀저장</button></h3>

<table class="adm-table line align-c">
	<thead>
		<tr>
			<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
			<th>년도</th>
			<th>월</th>
			<th>의기양양명</th>
			<th>당첨자 주문기록</th>
			<th>신청자 아이디</th>
			<th width="10%">신청자 이름</th>
			<th width="10%">신청자 연락처</th>
			<th width="10%">신청단계</th>
			<th width="10%">날짜</th>
		</tr>
	</thead>
	<tbody>
		<form name="order_form" method="post" >
			<?php
			$list_cnt=0;
			if($list){
				foreach($list as $lt){
					$list_cnt++;
					?>
					<tr>
						<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
						<td><?=$lt->year?></td>
						<td><?=$lt->month?></td>
						<td><?=$lt->prod?></td>
						<td><?=$lt->trade_code?"O":"X";?></td>
						<td><?=$lt->userid?></td>
						<td><?=$lt->name?></td>
						<td><?=$lt->phone?></td>
						<td><?=$lt->cate?></td>
						<td><?=date('Y-m-d',strtotime($lt->wdate))?></td>
					</tr>
					<?php
				}
			}else{
				?>
				<tr>
					<td colspan="7">
						등록된 당첨자가 없습니다.
					</td>
				</tr>
				<?php
			}
			?>
			<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
		</form>
	</tbody>
</table>

<div class="mt20">
	<span class="btn-inline btn-tinted-02"><a href="javascript:all_del();">삭제</a></span>
</div>

<!-- Pager -->
<?php
if(count($list)){
	?>
	<p class="list-pager align-c mt30" title="페이지 이동하기">
		<?=$Page?>
	</p><!-- END Pager -->
	<?php
}
?>
