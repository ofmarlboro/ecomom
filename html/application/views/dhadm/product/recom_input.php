<?php
$food_config = array();
$food_config['delivery_week_day_count'] = array(7, 6, 4);
$food_config['delivery_week_type'] = array();
$food_config['delivery_week_type'][1] = '1:목';
$food_config['delivery_week_type'][2] = '2:수,토';
$food_config['delivery_week_type'][3] = '2:화,금';
$food_config['delivery_week_type'][4] = '3:화,목,토';
$food_config['delivery_week_count'] = array(1, 2, 3, 4);
$food_config['delivery_sun'] = array(4=>'목',5=>'금',6=>'토');
?>

	<h3 class="icon-pen"><?if($mode == "add"){?>등록<?}else{?>수정<?}?>하기</h3>
	<form name="recom_frm" id="writefrm" method="post">

	<?php
	if($mode == "edit"){
	?>
	<input type="hidden" name="idx" value="<?=@$row->idx?>">
	<?php
	}
	?>

	<table class="adm-table mb70">
		<tbody>
			<tr>
				<th style="width:200px;">추천식단선택 (택1)</th>
				<td>
					<select name="recom_name" <?if($mode == "edit"){?>onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;'<?}?>>
						<option value="">-</option>
						<?php
						if($recom_select){
							foreach($recom_select as $rs){
							?>
							<option value="<?=$rs->idx?>::<?=$rs->title?>" <?if(@$row->brand_idx == $rs->idx){?>selected<?}?>><?=$rs->title?></option>
							<?php
							}
						}
						?>
					</select>
					<?php
					help_info('명칭은 배송그룹관리에서 연동됩니다. / 추천식단은 중복하여 등록할 수 없도록 되어있습니다.');
					?>
				</td>
			</tr>
			<tr>
				<th>연동할 카테고리 선택 (다중)</th>
				<td>
					<?php
					if($recom_cate){
						foreach($recom_cate as $rc){
						?>
						<input type="checkbox" name="recom_cate[]" value="<?=$rc->cate_no?>" id="cate_<?=$rc->idx?>" <?if(@in_array($rc->cate_no,$un_recom_cate)){?>checked<?}?>> <label for="cate_<?=$rc->idx?>"><?=$rc->title?></label>
						<?php
						}
					}
					help_info('선택한 카테고리에 등록된 제품이 식단관리시 연동됩니다.');
					?>
				</td>
			</tr>
			<?php
			if($mode == "edit"){
			?>
			<tr>
				<th>우선순위(정렬순서)</th>
				<td>
					<input type="text" class="width-xxs" name="sort" value="<?=(@$row->sort) ? $row->sort : $row->idx ;?>">
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>

	<h3 class="icon-pen">추천식단 주기/수량/가격</h3>
	<?php
	help_info('- 아래 가격표는 별도로 연산되는 부분이 없습니다.<br>- 직접 할인율과 판매가격을 기입해 주세요.<br>- 연산은 할인금액으로 통일합니다.<br>- 추가할인금액은 주차 선택에 따라 곱해집니다.<br>- 모든 항목은 숫자만 입력해주세요. ( 콤마(,) 등의 특수기호는 입력하지 말아주세요. )');
	?>
	<script type="text/javascript">
	<!--
		function all_chk(key){
			var checked_val = $("#all_chk_"+key).is(':checked');
			if(checked_val){
				$("."+key).prop('checked',true);
			}
			else{
				$("."+key).prop('checked',false);
			}
		}
	//-->
	</script>

	<table class="adm-table mt10 mb50">
		<tbody>
			<?php foreach($food_config['delivery_week_day_count'] as $delivery_week_day_count) { ?>
			<?php $key1 = $delivery_week_day_count; ?>
			<tr>
				<td colspan="2" style="background: #f9f9f9;">
					<input type="hidden" name="food_info[<?=$key1; ?>][val]" value="<?=$delivery_week_day_count; ?>" />
					<label><input type="checkbox" onclick="all_chk('<?=$key1?>')" id="all_chk_<?=$key1?>" name="food_info[<?=$key1; ?>][use]" value="1" <?=@$food_info[$key1]['use'] ? ' checked="checked" ' : ''; ?> /> 사용</label>
					||
					<?=$delivery_week_day_count; ?>일분
					*
					하루<input type="text" name="food_info[<?=$key1; ?>][pcount]" value="<?=@$food_info[$key1]['pcount']; ?>" class="width-xxs">팩
 					(<input type="text" name="food_info[<?=$key1; ?>][count]" value="<?=@$food_info[$key1]['count']; ?>" class="width-xxs">팩)
					|
					1팩당 가격
					<input type="text" name="food_info[<?=$key1; ?>][unit_price]" value="<?=@$food_info[$key1]['unit_price']; ?>" class="width-xs">원
					|
					판매원가
					<input type="text" name="food_info[<?=$key1; ?>][price_origin]" value="<?=@$food_info[$key1]['price_origin']; ?>" class="width-xs">원
				</td>
			</tr>
			<tr>
				<td style="background: #f9f9f9;">
				<?php foreach($food_config['delivery_week_count'] as $delivery_week_count) { ?>
					<?php $key2 = $delivery_week_count; ?>
					<input type="hidden" name="food_info[<?=$key1; ?>][delivery_week_count][<?=$key2; ?>][val]" value="<?=$key2; ?>" />
					<label>
						<input type="checkbox" class="<?=$key1?>" name="food_info[<?=$key1; ?>][delivery_week_count][<?=$key2; ?>][use]" value="1" <?=@$food_info[$key1]['delivery_week_count'][$key2]['use'] ? ' checked="checked" ' : ''; ?> />
						<?=$key2; ?>주
					</label>
					::
					할인율
					<input type="text" name="food_info[<?=$key1; ?>][delivery_week_count][<?=$key2; ?>][price_per]" value="<?=@$food_info[$key1]['delivery_week_count'][$key2]['price_per']; ?>" class="width-xxs"> %
					|
					할인금액
					(-) <input type="text" name="food_info[<?=$key1?>][delivery_week_count][<?=$key2; ?>][price]" value="<?=@$food_info[$key1]['delivery_week_count'][$key2]['price']?>" class="width-xs"> 원
					<p class="mb5"></p>
				<?php } ?>
				</td>

				<td valign="top">
					<?php foreach($food_config['delivery_week_type'] as $key2 => $delivery_week_type) { ?>
						<?php $arr_delivery_week_type = explode(':', $delivery_week_type); ?>
						<input type="hidden" name="food_info[<?=$key1; ?>][delivery_week_type][<?=$key2; ?>][val]" value="<?=$delivery_week_type; ?>" />
						<label>
							<input type="checkbox" class="<?=$key1?>" name="food_info[<?=$key1; ?>][delivery_week_type][<?=$key2; ?>][use]" value="1" <?=@$food_info[$key1]['delivery_week_type'][$key2]['use'] ? ' checked="checked" ' : ''; ?> />
							주 <?=$arr_delivery_week_type[0]; ?>회 배송
							::
							<?php
								$arr_yoil = explode(',', $arr_delivery_week_type[1]);
								$i = 0;
								foreach ($arr_yoil as $yoil) {
							?>
								<?=$i>0 ? ',' : ''; ?> <?=$yoil; ?>요일
								<input type="text" name="food_info[<?=$key1; ?>][delivery_week_type][<?=$key2; ?>][count][<?=$yoil; ?>]" value="<?=@$food_info[$key1]['delivery_week_type'][$key2]['count'][$yoil]; ?>" class="width-xxs">팩
							<?php $i ++; } ?>
						</label>
						|
						추가할인금액
						(-) <input type="text" name="food_info[<?=$key1; ?>][delivery_week_type][<?=$key2; ?>][price]" value="<?=@$food_info[$key1]['delivery_week_type'][$key2]['price']; ?>" class="width-xs"> 원
						|
						추가할인율
						<input type="text" name="food_info[<?=$key1; ?>][delivery_week_type][<?=$key2; ?>][price_per]" value="<?=@$food_info[$key1]['delivery_week_type'][$key2]['price_per']; ?>" class="width-xxs"> %
						<p class="mb5"></p>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	</form>

	<p class="align-c mt20">
		<input type="button" value="목록" class="btn-cancel btn-l" onclick="location.href='<?=cdir()?>/product/recom/m'">
		<input type="button" value="<? echo (@$row->idx) ? "수정" : "등록";?>" name="writeBtn" class="btn-ok btn-l" onclick="frmChk('writefrm')">
	</p>