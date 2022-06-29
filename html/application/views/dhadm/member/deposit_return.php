<h3 class="icon-list">예치금 입출금내역</h3>

<form id="search_frm">
<table class="adm-table mb20">
	<tr>
		<th>아이디</th>
		<td>
			<input type="text" name="userid" value="<?=$this->input->get('userid')?>">
			<!-- <span class="ml30">
				<?=number_format($total)?> 건
				(전체 합계 <?=number_format($point->sum_point)?>점)
			</span> -->
		</td>
	</tr>
	<tr>
		<th>발생일자</th>
		<td>
			<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate')?>" readonly> ~
			<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate')?>" readonly>
			<input type="button" value="검색" onclick="frmChk('search_frm')">
		</td>
	</tr>
</table>
</form>

<?php
/*
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
*/
?>

<style type="text/css">
	.bglist tr:hover{
		background:#eee;
	}
</style>

<table class="adm-table align-c mt30">
	<!-- <colgroup>
		<col style="width:10%">
		<col style="width:10%">
		<col>
		<col style="width:10%">
		<col style="width:10%">
	</colgroup> -->
	<tr>
		<th>회원아이디</th>
		<th>환불계좌정보</th>
		<th>환불금액</th>
		<th>발생일시</th>
		<th>처리일시</th>
		<th>상태</th>
		<th>처리</th>
	</tr>
	<tbody class="bglist">
	<?php
	if($list){
		foreach($list as $lt){
			switch($lt->state){
				case "승인대기":
					$bg = "";
				break;
				case "승인완료":
					$bg = "#D4D4FF";
				break;
				case "승인취소":
					$bg = "#FFD4D4";
				break;
			}
		?>
		<tr style="background:<?=$bg?>;">
			<td><?=$lt->userid?></td>
			<td><?=$lt->return_bank?> <?=$lt->return_account?> <?=$lt->return_accname?></td>
			<td><?=number_format($lt->return_deposit)?></td>
			<td><?=$lt->wdate?></td>
			<td><?=strtotime($lt->udate)<=0?"-":$lt->udate?></td>
			<td><?=$lt->state?></td>
			<td>
				<?php
				if(strtotime($lt->udate)<=0){
					?>
					<input type="button" class="btn-sm btn-ok" value="승인" onclick="accept_return(<?=$lt->idx?>)">
					<input type="button" class="btn-sm btn-alert" value="취소" onclick="cancel_return(<?=$lt->idx?>)">
					<?php
				}
				else{
					echo "처리완료";
				}
				?>
			</td>
		</tr>
		<?php
		}
	}

	if($totalCnt <= 0){
		?>
		<tr>
			<td colspan="5">등록된 내용이 없습니다.</td>
		</tr>
		<?php
	}
	?>
	</tbody>
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

<script type="text/javascript">
	function accept_return(idx){
		if(confirm("환불건을 승인 하시겠습니까?")){
			location.href = "?mode=apply&idx="+idx;
		}
	}

	function cancel_return(idx){
		if(confirm("환불건을 취소 하시겠습니까?")){
			location.href = "?mode=reject&idx="+idx;
		}
	}
</script>