<h3 class="icon-list">의기양양 신청내역</h3>

<form name="sfrm">
<input type="hidden" name="excel">
<input type="hidden" name="ajax">
<table class="adm-table mb30">
	<tr>
		<th>신청기간</th>
		<td>
			<input type="text" class="datepicker" name="sdate" value="<?=$this->input->get('sdate')?>"> ~
			<input type="text" class="datepicker" name="edate" value="<?=$this->input->get('edate')?>">

			<button type="button" class="btn-sm btn-ok" onclick="schfrm()">검색</button>
		</td>
	</tr>
	<tr>
		<th>
			<select name="sch_item">
				<option value="phone">신청자 휴대폰</option>
				<option value="userid">신청자 아이디</option>
				<option value="name">신청자 이름</option>
			</select>
			<script type="text/javascript">
			<!--
				var sch_item = document.sfrm.sch_item;
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
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
	function enter_press(){
		if(event.keyCode == 13){
			schfrm();
		}
	}

	function schfrm(){
		frm = document.sfrm;
		frm.excel.value = '';
		frm.ajax.value = '';
		frm.submit();
	}

	function excel_down(){
		frm = document.sfrm;
		frm.excel.value = 1;
		frm.ajax.value = 1;
		frm.submit();
	}

	function row_del(idx){
		if(confirm('삭제된 데이터는 복구할 수 없습니다.\n삭제 하시겠습니까?')){
			location.href="<?=cdir()?>/order/apply_order/?ajax=1&del=ok&idx="+idx;
		}
	}
</script>

<div class="float-l mb10">
	<button type="button" onclick="excel_down()">엑셀저장</button>

	<span>총 <?=number_format($totalCnt)?>건의 신청 내역이 있습니다.</span>
</div>

<table class="adm-table align-c mb30">
	<tr>
		<th>의기양양명</th>
		<th>신청자 아이디</th>
		<th>주문기록</th>
		<th>신청자 이름</th>
		<th>신청자 연락처</th>
		<th>신청단계</th>
		<th>신청일</th>
		<th>비고</th>
	</tr>
	<?php
	foreach($list as $lt){
		?>
		<tr>
			<td><?=$lt->goods_name?></td>
			<td><?=$lt->userid?></td>
			<td><?=$lt->order_cnt?"O":"X";?></td>
			<td><?=$lt->name?></td>
			<td><?=$lt->phone?></td>
			<td><?=$lt->cate?></td>
			<td><?=$lt->wdate?></td>
			<td><button type="button" class="btn-sm btn-alert" onclick="row_del('<?=$lt->idx?>')">삭제</button></td>
		</tr>
		<?php
	}

	if($totalCnt <= 0){
		?>
		<tr>
			<td colspan="7">표시할 내용이 없습니다.</td>
		</tr>
		<?php
	}
	?>
</table>

<? if($totalCnt > 0){ ?>
<!-- Pager -->
<p class="list-pager align-c" title="페이지 이동하기">
	<?=$Page2?>
</p><!-- END Pager -->
<?}?>