<?
	$deliv_between_date = $this->input->post('recom_delivery_detail_date');
	$delivery_detail_prod = $this->input->post('recom_delivery_detail_prod');
	$delivery_detail_sunday_prod = $this->input->post('recom_delivery_detail_sunday_prod');
	$recom_delivery_week_type_arr = $this->input->post('recom_delivery_week_type');
	$delivery_week_day_count = $this->input->post('recom_delivery_week_day_count');
	$delivery_week_type_key = $this->input->post('delivery_week_type_key');
?>
<form name="sendfrm" id="orderfrm" method="post" action="<?=cdir()?>/dh/event04_order_ok">
	<input type="hidden" name="recom_idx" value="<?=$this->input->post('recom_idx')?>">
	<input type="hidden" name="recom_default_deliv_start_day" value="<?=$this->input->post('recom_default_deliv_start_day')?>">
	<input type="hidden" name="recom_deliv_addr" value="<?=$this->input->post('recom_deliv_addr')?>">
	<input type="hidden" name="recom_zipcode" value="<?=$this->input->post('zipcode')?>">
	<input type="hidden" name="recom_addr1" value="<?=$this->input->post('addr1')?>">
	<input type="hidden" name="recom_addr2" value="<?=$this->input->post('addr2')?>">
	<input type="hidden" name="recom_delivery_sun_type" value="<?=$this->input->post('recom_delivery_sun_type')?>">
	<input type="hidden" name="recom_delivery_week_count" value="<?=$this->input->post('recom_delivery_week_count')?>">
	<input type="hidden" name="recom_delivery_week_day_count" value="<?=$this->input->post('recom_delivery_week_day_count')?>">
	<input type="hidden" name="recom_delivery_week_type" value="<?=$this->input->post('recom_delivery_week_type')?>">
	<input type="hidden" name="recom_total_origin_price" value="<?=$this->input->post('recom_total_origin_price')?>">
	<input type="hidden" name="recom_pack_ea" value="<?=$this->input->post('recom_pack_ea')?>">
	<input type="hidden" name="recom_per" value="<?=$this->input->post('recom_per')?>">
	<input type="hidden" name="recom_price" value="<?=$this->input->post('recom_price')?>">
	<input type="hidden" name="goods_name" value="<?=$this->input->post('goods_name')?>">
	<input type="hidden" name="step_code" value="<?=$this->input->post('step_code')?>">
	<input type="hidden" name="coupon_code" value="<?=$this->input->post('coupon_code')?>">
	<?php
	$sunday_cnt = 0;
	foreach($deliv_between_date as $dbd){	//???????????? ??????
		//????????? ?????? ???????????? ?????????
		$standard_cnt = $food_info[$delivery_week_day_count]['delivery_week_type'][$delivery_week_type_key]['count'][$week_name_arr[date("w",strtotime($dbd))]];
		?>
		<input type="hidden" name="recom_delivery_detail_date[]" value="<?=strtotime($dbd)?>">
		<input type="hidden" name="stan_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>">
		<input type="hidden" name="chg_cnt_<?=strtotime($dbd)?>" value="<?=$standard_cnt?>" passwd_match="<?=date("Y??? m??? d???",strtotime($dbd))?> (<?=$week_name_arr[date("w",strtotime($dbd))]?>) ????????? ?????? ?????? ?????? ????????? ?????? ?????? ????????????." matching_name="stan_cnt_<?=strtotime($dbd)?>">
		<input type="hidden" name="alg_chg_cnt_<?=strtotime($dbd)?>" value="<?=$this->input->post('alg_chg_cnt_'.strtotime($dbd))?>">
		<?php
		$pcnt = 0;

		$prod_cnt_key = 0;
		$prod_cnt_arr = $this->input->post(strtotime($dbd).'_prod_cnt');

		foreach($delivery_detail_prod as $rddp){	//????????? ???????????? ??????
			$pcnt++;
			$rddp_arr = explode(":",$rddp);	//????????? ?????????
			$goods_idx = $rddp_arr[0];
			$deliv_date = $rddp_arr[1];
			$sunday = $rddp_arr[2];
			if($deliv_date == $dbd){	//??????????????? ????????????
				foreach($goods as $g){	//?????? ??????????????? ??????
					if($g->idx == $goods_idx){	//?????? ????????? ??????
						?>
						<input type="hidden" class="cnt" title="??????" value="<?=($prod_cnt_arr[$prod_cnt_key])?$prod_cnt_arr[$prod_cnt_key]:"0";?>" name="<?=strtotime($deliv_date)?>_prod_cnt[]" data-delivdate="<?=strtotime($dbd)?>" readonly>
						<input type="hidden" name="<?=strtotime($deliv_date)?>_goods_idx[]" value="<?=$goods_idx?>">
						<input type="hidden" name="<?=strtotime($deliv_date)?>_sunday[]" value="<?=$sunday?>">
						<?php
						$prod_cnt_key++;
					}
				}
			}
		}
	}
	?>
</form>
<script type="text/javascript">
	document.sendfrm.submit();
</script>