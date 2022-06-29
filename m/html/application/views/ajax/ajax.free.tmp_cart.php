<?php
/*
						<table>
							<colgroup>
							<col width="">
							<col width="">
							<col width="">
							<col width="18px">
							</colgroup>
							<tr>
								<th colspan="4">[3월 5일 화요일]</th>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="al">산골알밤</th>
								<td><span class="cart-vol">
									<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
									</span></td>
								<td>6,000</td>
								<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
							</tr>
							<tr>
								<th class="bg al">상품금액</th>
								<td class="orange bg">3개품목(수량 6개)</td>
								<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
							</tr>
*/
?>

				<?php
				foreach($deliv_date as $dd){
					?>
					<div class="mb20">
						<table>
							<colgroup>
							<col width="">
							<col width="">
							<col width="">
							<col width="18px">
							</colgroup>
							<tr>
								<th colspan="4">
									[<?=date("m월 d일",strtotime($dd->deliv_date))?> <?=$week_name_arr[date("w",strtotime($dd->deliv_date))]?>요일]
									<input type="hidden" name="result_deliv_date[]" value="<?=$dd->deliv_date?>">
								</th>
							</tr>

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
							<tr>
								<th class="al"><?=$lt->goods_name?></th>
								<td><span class="cart-vol">
									<button type="button" class="vol-down" onclick="prd_minus('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')">감소</button>
									<input type="text" value="<?=number_format($lt->cnt)?>" class="prod_cnt" name="prod_cnts[]" readonly id="prd_cnt<?=$lt->idx?>">
									<button type="button" class="vol-up" onclick="prd_plus('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')">추가</button>
									</span></td>
								<td><?=number_format($lt->price*$lt->cnt)?></td>
								<td><a href="javascript:;" class="cart_del" onclick="cart_ea_del('<?=$this->session->userdata('CART')?>','<?=$lt->idx?>')"><img src="/m/image/sub/del.png" alt=""></a></td>
								<input type="hidden" name="result_prod_info[]" value="<?=$dd->deliv_date?>:<?=$lt->goods_name?>:<?=$lt->price?>:<?=$lt->list_img?>:<?=$lt->goods_idx?>:<?=$lt->origin_price?>">
							</tr>
								<?php
								}
							}
							?>
							<tr>
								<th class="bg al">상품금액</th>
								<td class="orange bg"><?=number_format($prods)?>개품목(수량 <?=number_format($prods_cnt)?>개)</td>
								<td class="bg" colspan="2"><span class="pp"><?=number_format($prods_total_price)?></span>원</td>
							</tr>
						</table>
					</div>
					<?php
					$order_cnt_allofthat += $prods_cnt;
				}
				?>

				<input type="hidden" name="prod_all_cnt" id="prod_all_cnt" value="<?=$order_cnt_allofthat?>">