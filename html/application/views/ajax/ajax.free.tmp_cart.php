<div class="order_cart_head">
	<p class="prod">단계/상품명</p>
	<p class="unit">단가</p>
	<p class="cnt">수량</p>
	<p>금액</p>
</div>

<?php
foreach($deliv_date as $dd){
	?>
	<div class="order_cart_group">
		<p class="date">[<?=date("m월 d일",strtotime($dd->deliv_date))?> <?=$week_name_arr[date("w",strtotime($dd->deliv_date))]?>요일]</p>
		<input type="hidden" name="result_deliv_date[]" value="<?=$dd->deliv_date?>">
		<ul class="added_prod">
			<?php
			$prods = 0;
			$prods_cnt = 0;
			$prods_total_price = 0;
			foreach($tmp_list as $lt){
				if($dd->deliv_date == $lt->deliv_date){
					$prods++;
					$prods_cnt += $lt->cnt;
					$prods_total_price += ($lt->price*$lt->cnt);
				?>
				<li>
					<div class="row">
						<p class="prod"><?=$lt->goods_name?></p>
						<p class="unit_price"><?=number_format($lt->price)?><span>원</span></p>
						<div class="cnt">
							<button type="button" class="plain" title="1개 감소" onclick="prd_minus('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
							<input type="text" value="<?=number_format($lt->cnt)?>" class="prod_cnt" name="prod_cnts[]" readonly id="prd_cnt<?=$lt->idx?>">
							<button type="button" class="plain" title="1개 추가" onclick="prd_plus('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
						</div>
						<p class="total_price"><?=number_format($lt->price*$lt->cnt)?><span>원</span></p>
						<button type="button" class="plain del" title="삭제" onclick="cart_ea_del('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')"><img src="/image/sub/opt_del.png" alt="삭제"></button>

						<input type="hidden" name="result_prod_info[]" value="<?=$dd->deliv_date?>:<?=$lt->goods_name?>:<?=$lt->price?>:<?=$lt->list_img?>:<?=$lt->goods_idx?>:<?=$lt->origin_price?>">
					</div>
				</li>
				<?php
				}
			}
			?>
		</ul>
		<div class="total">
			<p class="tit">상품금액</p>
			<p class="float-r">
				<em class="cnt"><?=number_format($prods)?>개품목 (수량<?=number_format($prods_cnt)?>개)</em>
				<em class="price"><?=number_format($prods_total_price)?></em>
				<span>원</span>
			</p>
		</div>
	</div>
	<?php
	$order_cnt_allofthat += $prods_cnt;
}
?>

<input type="hidden" name="prod_all_cnt" id="prod_all_cnt" value="<?=$order_cnt_allofthat?>">