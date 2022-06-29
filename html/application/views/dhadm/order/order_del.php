<script type="text/javascript">
	//일자별 버튼 셋팅
	function sch_date_btnset(val){
		if(val == "deliv_date"){
			$(".default").hide();
			$(".deliv").show();
		}else{
			$(".default").show();
			$(".deliv").hide();
		}
	}

	//날짜 자동 입력
	function set_date_val(sd, ed){
		$("#start_date").val(sd);
		$("#end_date").val(ed);
	}
</script>

<h3 class="icon-search">주문내역 데이터베이스 삭제</h3>
<form name="search_form">
	<!-- 제품검색 -->
	<table class="adm-table">
		<colgroup>
			<col style="width:15%;"><col>
		</colgroup>
		<tbody>
			<tr>
				<th>
					<select name="sch_date" onchange="sch_date_btnset(this.value)">
						<option value="trade_day">주문일자</option>
					</select>
				</th>
				<td>
					<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate')?>" readonly> ~
					<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate')?>" readonly>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')" class="btn-clear">오늘</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('tomorrow'))?>','<?=date("Y-m-d", strtotime('tomorrow'))?>')" class="btn-clear deliv">내일</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday this week'))?>','<?=date("Y-m-d", strtotime('sunday this week'))?>')" class="btn-clear">이번주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of this month'))?>','<?=date("Y-m-d", strtotime('last day of this month'))?>')" class="btn-clear">이번달</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday next week'))?>','<?=date("Y-m-d", strtotime('sunday next week'))?>')" class="btn-clear deliv">다음주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of next month'))?>','<?=date("Y-m-d", strtotime('last day of next month'))?>')" class="btn-clear deliv">다음달</button>
					<button type="button" onclick="set_date_val('','')" class="btn-clear">전체</button>
				</td>
			</tr>
		</tbody>
	</table><!-- END 제품검색 -->
	<p class="align-c mt15"><input type="button" value="검색하기" class="btn-ok" onclick="javascript:document.search_form.submit();"></p>
</form>

<?php
if($list){
	?>
	<table class="adm-table mt50">
		<tr>
			<th>검색된 주문 <?=number_format($list)?>건</th>
			<td><input type="button" value="주문 일괄 삭제" onclick="order_delete()"></td>
		</tr>
	</table>
	<script type="text/javascript">
		function order_delete(){
			if(confirm("선택하신 기간동안의 주문을 일괄 삭제 합니다.\n진행 하시겠습니까?")){
				var sdate = $("#start_date").val();
				var edate = $("#end_date").val();

				location.href="/html/order/order_del/del_all/?ajax=1&sdate="+sdate+"&edate="+edate;
			}
		}
	</script>
	<?php
}
?>