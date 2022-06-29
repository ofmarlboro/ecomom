					<div class="layer_pop_inner">
						<h1>
							<?=date("m월 d일",$deliv_code_arr[1])?> 배송상품
						</h1>
						<div class="scroll">
							<ul class="bu_list01">
								<?php
								foreach($list as $lt){
									if($lt->prod_cnt > 0){
									?>
									<li><?=$lt->name?> x <?=$lt->prod_cnt?> <?=($lt->recom_is == "Y")?"팩":"";?></li>
									<?php
									}
									else{
										if($lt->option_cnt > 0){
											$row = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '".$lt->trade_code."' and level = '2' and goods_idx = '".$lt->goods_idx."'","row");
										?>
										<li><?=$lt->name?><?=$row->name?> x <?=$row->cnt?></li>
										<?php
										}
									}
								}
								?>
							</ul>
						</div>
						<a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a>
					</div>