<h3 class="icon-list">메뉴 일괄 변경</h3>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".select_jq").select2();
	});

	function chg_send(){
		frm = document.gchfrm;
		if(frm.deliv_date.value == ""){
			alert("배송일자를 선택해 주세요.");
			return;
		}

		if(frm.goods_idx.value == ""){
			alert("변경할 상품을 선택해 주세요.");
			return;
		}

		if(frm.chg_goods_idx.value == ""){
			alert("변경될 상품을 선택해 주세요.");
			return;
		}

		frm.submit();
	}
</script>

<form name="gchfrm" id="gchfrm" method="post">
	<table class="adm-table">
		<tr>
			<th>배송일자</th>
			<td colspan="3">
				<input type="text" name="deliv_date" value="<?=$this->input->post('deliv_date')?>" id="start_date">
			</td>
		</tr>
		<tr>
			<th width="15%">변경할 상품</th>
			<td>
				<select name="goods_idx" class="select_jq">
					<option value="">일괄 변경 대상을 선택 해 주세요.</option>
					<?php
					foreach($goods_list as $gl1){
						?>
						<option value="<?=$gl1->idx?>" <?=$this->input->post('goods_idx') == $gl1->idx ? "selected" : "" ; ?>><?=$gl1->name?> [<?=$gl1->code?>]</option>
						<?php
					}
					?>
				</select>
			</td>
			<th width="15%">변경될 상품</th>
			<td>
				<select name="chg_goods_idx" class="select_jq">
					<option value="">일괄 변경될 대상을 선택 해 주세요.</option>
					<?php
					foreach($goods_list as $gl2){
						?>
						<option value="<?=$gl2->idx?>" <?=$this->input->post('chg_goods_idx') == $gl2->idx ? "selected" : "" ; ?>><?=$gl2->name?> [<?=$gl2->code?>]</option>
						<?php
					}
					?>
				</select>
			</td>
		</tr>
	</table>
	<?php
	if(!$_POST){
		?>
		<div class="mt20 align-c">
			<button type="button" onclick="chg_send()">변경하기</button>
		</div>
		<?php
	}
	else{
		?>
		<div class="mt20 align-c">
			<button type="button" onclick="location.href='/html/order/menu_allchange/m'">확인</button>
		</div>
		<?php
	}
	?>
</form>


<?php
if(count($log_arr) > 0){
	?>
	<table class="adm-table mt50">
		<tr>
			<th>No</th>
			<th>아이디</th>
			<th>변경내용</th>
			<th>변경상세</th>
			<th>변경일자</th>
			<th>시행자</th>
		</tr>
		<?php
		$total = count($log_arr);
		foreach($log_arr as $lg){
			?>
			<tr>
				<td><?=$total?></td>
				<td><?=$lg['userid']?></td>
				<td><?=$lg['type']?></td>
				<td><?=$lg['msg']?></td>
				<td><?=$lg['wdate']?></td>
				<td><?=$lg['writer']?></td>
			</tr>
			<?php
			$total--;
		}
		?>
	</table>

	<div class="mt20 align-c">
		<button type="button" onclick="location.href='/html/order/menu_allchange/m'">확인</button>
	</div>
	<?php
}
?>