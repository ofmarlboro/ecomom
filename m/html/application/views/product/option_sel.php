
							<li class="option<?=$option_row->idx?>">
								<div class="info">
									<div class="opt">
										<?=$option_row->title?> | <?=$option_row->name?>
									</div>
									<div class="vol">
										<input type="text" name="optionCnt<?=$option_row->idx?>" id="optionCnt<?=$option_row->idx?>" value="1" readonly>
										<?php
										if($row->idx == "543" || $row->idx == "504" || $row->idx == "540" || $row->idx == "552" || $row->idx == "553" || $row->idx == "561"  || $row->idx=="562"  || $row->idx=="575"  || $row->idx=="576"
											 || $row->idx=="584"  || $row->idx=="585"
											 || $row->idx=="818"
											 || $row->idx=="837"
											 || $row->idx=="847"
											 || $row->idx=="855"
											 || $row->idx == "932"
										){
										}
										else{
											?>
											<button type="button" class="vol-up" onclick="cntChange(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>,'u',<?=$option_row->unlimit?>,<?=$option_row->number?>)">추가</button>
											<button type="button" class="vol-down" onclick="cntChange(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>,'d',<?=$option_row->unlimit?>,<?=$option_row->number?>)">감소</button>
											<?php
										}
										?>
									</div>
								</div>
								<div class="edit">
									<?if($row->old_price){?><del><?=number_format($option_row->price+$row->old_price)?></del> <span class="unit">원</span> <img src="/m/image/sub/ar.jpg" alt=""><?}?>
									<?=number_format($option_row->price+$row->shop_price)?><span class="unit">원</span> <button type="button" class="opt-del" onclick="option_del(<?=$option_row->idx?>,<?=$option_row->price+$row->shop_price?>)">삭제</button>
								</div>
							</li>

							<script>
								var total_price = $("#total_price").val();
								total_price = parseInt(total_price)+<?=$option_row->price+$row->shop_price?>;
								$("#total_price").val(total_price);
								$(".total_price").html(number_format(0,total_price));
								$("#option_flag").val(1);
							</script>