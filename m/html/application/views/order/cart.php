
<input type="hidden" id="totalPrice" value="<?=$totalPrice?>">
<input type="hidden" id="delivery_price" value="<?=$delivery_price?>">

			<!-- Shop Wrap -->
			<?php
			$order_confirm = false;
			$totalCnt=0;
			?>
			<div class="shop-wrap mt10">
				<div class="tblTy02 tblTy02_1">
					<form name="cartFrm" id="cartFrm" method="post" onsubmit="return false;">
					<input type="hidden" name="mode">
					<?php
					if($cart_arr[1]){		//이유식
						?>
						<h3 class="order-tit pt30">이유식</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk1" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "이유식"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단<br>보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][1]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][1]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														//echo number_format($lt->deliv_price)." 원";
														//echo number_format($dp_arr[$lt->date_bind][1]['dp'])." 원";
														if($dp_arr[$lt->date_bind][1]['is_recom'] == 'excep'){
															echo $dp_arr[$lt->date_bind][1]['add_txt'];
														}
														else{
															echo number_format($dp_arr[$lt->date_bind][1]['dp'])." 원";
														}
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum1 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date){
											$deliv_price_t1 += $dp_arr[$lt->date_bind][1]['dp'];
										}
										$total_price_t1 += $lt->total_price;
										$deliv_date = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t1)?></em>원 + 배송비 <em><?=number_format($deliv_price_t1)?></em>원 = 총 합계 <em><?=number_format($total_price_t1+$deliv_price_t1)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[2]){		//간식
						?>
						<h3 class="order-tit pt30">간식</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk2" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "간식"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][2]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][2]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][2]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum2 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date2){
											$deliv_price_t2 += $dp_arr[$lt->date_bind][2]['dp'];
										}
										$total_price_t2 += $lt->total_price;
										$deliv_date2 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t2)?></em>원 + 배송비 <em><?=number_format($deliv_price_t2)?></em>원 = 총 합계 <em><?=number_format($total_price_t2+$deliv_price_t2)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[3]){		//프로모션
						?>
						<h3 class="order-tit pt30">프로모션</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "프로모션"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][3]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][3]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][3]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum3 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date3){
											$deliv_price_t3 += $dp_arr[$lt->date_bind][3]['dp'];
										}
										$total_price_t3 += $lt->total_price;
										$deliv_date3 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t3)?></em>원 + 배송비 <em><?=number_format($deliv_price_t3)?></em>원 = 총 합계 <em><?=number_format($total_price_t3+$deliv_price_t3)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[4]){		//프로모션2
						?>
						<h3 class="order-tit pt30">기획/특가</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "프로모션2"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][4]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][4]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][4]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum3 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date4){
											$deliv_price_t4 += $dp_arr[$lt->date_bind][4]['dp'];
										}
										$total_price_t4 += $lt->total_price;
										$deliv_date4 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t4)?></em>원 + 배송비 <em><?=number_format($deliv_price_t4)?></em>원 = 총 합계 <em><?=number_format($total_price_t4+$deliv_price_t4)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[5]){		//합배송불가 (무조건 단위별 배송비)
						?>
						<h3 class="order-tit pt30">단독배송상품</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk5" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "합배송불가"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][5]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][5]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][5]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum5 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date5){
											$deliv_price_t5 += $dp_arr[$lt->date_bind][5]['dp'];
										}
										$total_price_t5 += $lt->total_price;
										$deliv_date5 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
								?>
								<tr>
									<td colspan="5">
										장바구니에 담긴 상품이 없습니다.
									</td>
								</tr>
								<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t5)?></em>원 + 배송비 <em><?=number_format($deliv_price_t5)?></em>원 = 총 합계 <em><?=number_format($total_price_t5+$deliv_price_t5)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[6]){		//무료배송
						?>
						<h3 class="order-tit pt30">무료배송상품</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "무료배송"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][6]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][6]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][6]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum3 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date4){
											$deliv_price_t6 += $dp_arr[$lt->date_bind][6]['dp'];
										}
										$total_price_t6 += $lt->total_price;
										$deliv_date4 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t6)?></em>원 + 배송비 <em><?=number_format($deliv_price_t6)?></em>원 = 총 합계 <em><?=number_format($total_price_t6+$deliv_price_t6)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>

					<?php
					if($cart_arr[7]){		//프로모션3
						?>
						<h3 class="order-tit pt30">프로모션3</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
								<col width="45px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
								<th><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($list as $lt){
								if($lt->deliv_grp == "프로모션3"){
									$ltFlag=0;
									$frmCnt++;
									$totalCnt++;

									if((int)date("H") < 7){
										if($lt->date_bind >= date('Y-m-d', strtotime('+1 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									else{
										if($lt->date_bind >= date('Y-m-d', strtotime('+2 day'))){
											$order_confirm = true;
										}
										else{
											$order_confirm = false;
											$order_cant_date = $lt->date_bind;
										}
									}
									?>
									<input type="hidden" name="idx<?=$totalCnt?>" id="idx<?=$totalCnt?>" value="<?=$lt->idx?>">
									<tr class="al">
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td class='al' data-value=".$lt->date_bind.">주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td class='al' data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<td class="al">
											<?=$lt->goods_name?><br>
															<? if($lt->option_cnt > 0){
																$option_total_price = "";
																for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){
																	$price = explode("-",${'option_arr'.$lt->idx}[$i]['price']);
																	$plus="";
																	if(count($price)<2){ $plus="+"; }
																	$title = ${'option_arr'.$lt->idx}[$i]['title'];
																	$name = ${'option_arr'.$lt->idx}[$i]['name'];
																	$price = ${'option_arr'.$lt->idx}[$i]['price'];
																	$cnt = ${'option_arr'.$lt->idx}[$i]['cnt'];
																	$flag = ${'option_arr'.$lt->idx}[$i]['flag'];
																	if($flag==1){ $ltFlag=$flag; }
															?>
																<p class="prod-op">
																<em><?=$title?></em> : <?=$name?>
																<? if($price != 0){ ?> (<?=$plus?><?=number_format($price)?>)<?}?>
																<? if($flag==0){?> x <?=$cnt?> = <?=number_format( ($lt->goods_price+$price)*$cnt )?>원<?}?>
																</p>
															<?
																	$option_total_price += ($lt->goods_price+$price)*$cnt;
																}
																echo "소계 : <span style='font-weright:600'>" . number_format($option_total_price) . "</span> 원";
															}
															else{
																?>
																소계: <?=number_format($lt->goods_price * $lt->goods_cnt)?>원
																<?php
															}?>
										</td>

										<?php
										if($lt->recom_is == "Y"){	//추천식단
											?>
											<td>
												<?=$lt->recom_pack_ea?>팩
												<a href="javascript:;" class="btn_y" style="display: block; padding: 3px;" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','')">식단보기</a>
											</td>
											<?php
										}
										else{	//추천식단 이외
											if($lt->option_cnt == 0){
											?>
											<td style="position: relative;">
												<div class="cart-prod-quick">

													<?=$lt->goods_cnt?>
													<?php
													/*
													<div class="cart-vol">
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button>
														<?php
														}
														?>

														<input type="text" class="vol-num" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly>

														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<button type="button" class="plain vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<?php
														}
														?>
													</div>
													*/
													?>

												</div>

												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
												?>
												<!-- <a href="javascript:;" class="btn_green" style="display: block; padding: 3px;font-size: 12px;" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용하기</a> -->
												<?php
												}
												?>
											</td>
											<?php
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo "<td>";
												echo $lt->option_cnt."개";
												echo "</td>";
											}
											else{
												if($lt->goods_cnt>0){
													echo "<td>";
													echo $lt->goods_cnt;
													echo "</td>";
												}
											}
										}
										?>
										<!-- <td><a href="javascript:;" class="btn_lg" onclick="goFrm('del','<?=$lt->idx?>')">삭제</a></td> -->
										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][7]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][7]['dp']?>">
													<?php
													if($this->input->get('sample') == "ok"){
														echo number_format($delivery_price)." 원";
													}
													else{
														echo number_format($dp_arr[$lt->date_bind][7]['dp'])." 원";
													}
													?>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum3 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
										if($lt->date_bind != $deliv_date4){
											$deliv_price_t7 += $dp_arr[$lt->date_bind][7]['dp'];
										}
										$total_price_t7 += $lt->total_price;
										$deliv_date4 = $lt->date_bind;
								}
							}

							if($frmCnt <= 0){
							?>
							<tr>
								<td colspan="5">
									장바구니에 담긴 상품이 없습니다.
								</td>
							</tr>
							<?php
							}
							?>

							</tbody>

							<tfoot>
								<tr>
									<td colspan="10">
										<div class="cart-total">
											상품 합계금액 : <em><?=number_format($total_price_t7)?></em>원 + 배송비 <em><?=number_format($deliv_price_t7)?></em>원 = 총 합계 <em><?=number_format($total_price_t7+$deliv_price_t7)?></em>원
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
						<?php
					}
					?>
					<input type="hidden" name="frmCnt" value="<?=$totalCnt?>">
					</form>
				</div>
				<div class="shop-cart-wrap">
					<div class="ac">
						<a href="javascript:;" class="ch_del" onclick="frmSubmit('allDel')">선택삭제</a>
					</div>
					<!-- 총 가격 -->

					<?php
					$all_total_price = $total_price_t1+$total_price_t2+$total_price_t3+$total_price_t4+$total_price_t5+$total_price_t6+$total_price_t7;
					$all_total_deliv_price = $deliv_price_t1+$deliv_price_t2+$deliv_price_t3+$deliv_price_t4+$deliv_price_t5+$deliv_price_t6+$deliv_price_t7;
					?>

					<?php
					if($this->input->get('sample') == "ok"){
					}
					else{
					?>
					<div class="order-price-box">
						<ul class="order-price">
							<li>
								<div class="shop-inner">
									<span class="l">총 상품금액</span>
									<span class="r price"><?=number_format($all_total_price)?>원</span>
								</div>
							</li>
							<li>
								<div class="shop-inner">
									<span class="l">배송비</span>
									<span class="r devPrice"><?=number_format($all_total_deliv_price)?>원</span>
								</div>
							</li>
							<li class="order-total" style="background: #eee;">
								<div class="shop-inner">
									<em class="l">총 주문금액</em>
									<div class="r">
										<span class="total-price tt-price"><?=number_format($all_total_price+$all_total_deliv_price)?>원</span>
										<!-- <span class="save-point">적립 포인트 325P</span> -->
									</div>
								</div>
							</li>
						</ul>
					</div>
					<?php
					}
					?>
					<!-- END 총 가격 -->

				</div>
				<!-- END Shop Cart Wrap -->

				<!-- 주문버튼 -->
				<?php
				if($this->input->get('sample') == "ok"){

					if($order_confirm){
						?>
						<a href="<?=cdir()?>/dh_order/shop_order/<?=$lt->idx?>/ok" class="keep_shop">샘플 신청</a>
						<?php
					}
					else{
						?>
						<a href="javascript:alert('배송일이 지난 샘플입니다. 삭제후 재신청 해주세요.');" class="keep_shop">샘플 신청</a>
						<?php
					}

				}
				else{
				?>
				<div class="mt20">
					<?php
					if($order_confirm){
						if($orderable_485){
							?>
							<!-- <a href="javascript:;" class="ch_order" onclick="sel_order();">선택상품 주문하기</a> -->
							<a href="/m/" class="ch_order">쇼핑계속하기</a>
							<a href="javascript:;" class="all_order" onclick="<?if($totalCnt>0){?>location.replace('<?=cdir()?>/dh_order/shop_order')<?}else{?>alert('주문할 상품이 없습니다.')<?}?>;">전체상품 주문하기</a>
							<?php
						}
						else{
							?>
							<!-- <a href="javascript:;" class="ch_order" onclick="sel_order();">선택상품 주문하기</a> -->
							<a href="/m/" class="ch_order">쇼핑계속하기</a>
							<a href="javascript:;" class="all_order" onclick="alert('구매가 제한된 상품이 1개 이상 있습니다.');">전체상품 주문하기</a>
							<?php
						}
					}
					else{
						if($frmCnt <= 0){
							?>
							<!-- <a href="javascript:;" class="ch_order" onc<a href="/m/" class="keep_shop">쇼핑계속하기</a>lick="sel_order();">선택상품 주문하기</a> -->
							<a href="/m/" class="ch_order">쇼핑계속하기</a>
							<a href="javascript:;" class="all_order" onclick="alert('주문하실 상품이 없습니다.')">전체상품 주문하기</a>
							<?php
						}
						else{
							?>
							<!-- <a href="javascript:;" class="ch_order" onc<a href="/m/" class="keep_shop">쇼핑계속하기</a>lick="sel_order();">선택상품 주문하기</a> -->
							<a href="/m/" class="ch_order">쇼핑계속하기</a>
							<a href="javascript:;" class="all_order" onclick="alert('배송일이 지난 상품은 주문할 수 없습니다.\n<?=date("Y년 m월 d일",strtotime($order_cant_date))?>로 배송일이 지정된 상품은 주문할 수 없습니다.')">전체상품 주문하기</a>
							<?php
						}
					}
					?>
				</div>
				<!-- END 주문버튼 -->
				<!-- <a href="/m/" class="keep_shop">쇼핑계속하기</a> -->
				<?php
				}
				?>
			</div>


			<form method="post" name="cartChangeFrm" id="cartChangeFrm">
			<input type="hidden" name="cart_idx">
			<input type="hidden" name="goods_idx">
			<input type="hidden" name="total_price">
			<input type="hidden" name="goods_cnt">
			<input type="hidden" name="goods_cnt_chagne" value="1">
			<input type="hidden" name="mode">
			</form>

<script>
	$(function(){
		//$(".tblTy02 table tbody").rowspan(0);
		$(".tblTy02 table tbody").rowspan(3);

		$(".all_chk1").on("click", function (){
			$(".chknum1").prop("checked",$(this).prop("checked"));
		});

		$(".all_chk2").on("click", function (){
			$(".chknum2").prop("checked",$(this).prop("checked"));
		});

		$(".all_chk3").on("click", function (){
			$(".chknum3").prop("checked",$(this).prop("checked"));
		});

		$(".all_chk5").on("click", function (){
			$(".chknum5").prop("checked",$(this).prop("checked"));
		});
			//  $(".all_chk").change(function(){
			//
			//	  var checkObj = $('.chkNum');
			//
			//		if(this.checked){
			//      checkObj.prop("checked",true);
			//
			//			$("#totalPrice").val("<?=$totalPrice?>");
			//			$("#delivery_price").val("<?=$delivery_price?>");
			//
			//			$(".price").html("<?=number_format($totalPrice)?>원");
			//			$(".devPrice").html("<?=number_format($delivery_price)?>원");
			//			$(".tt-price").html("<?=number_format($totalPrice+$delivery_price)?>원");
			//
			//    }else{
			//      checkObj.prop("checked",false);
			//			$(".price").html("0원");
			//			$("#delivery_price").val(0);
			//			$(".devPrice").html("0원");
			//			$(".tt-price").html("0원");
			//			$("#totalPrice").val(0);
			//    }
			//
			//  });
			//
			//	$(".chkNum").click(function(){
			//
			//		var totalPrice = $("#totalPrice").val();
			//		var delivery_price = $("#delivery_price").val();
			//
			//		var idx = $(this).data("idx");
			//		var price = $(this).data("price");
			//
			//		if(this.checked){
			//			totalPrice = parseInt(totalPrice)+parseInt(price);
			//		}else{
			//			totalPrice = parseInt(totalPrice)-parseInt(price);
			//		}
			//
			//		$("#totalPrice").val(totalPrice);
			//		$(".price").html(number_format(totalPrice,0)+"원");
			//
			//		var basic="";
			//
			//		/*
			//		if($(".chkNum:checked").length==1){ //단일상품일때
			//
			//			var idx = $(".chkNum:checked").attr("idx");
			//
			//			var express_check = $("#express_check"+idx).val();
			//			var express_money = $("#express_money"+idx).val();
			//			var express_free = $("#express_free"+idx).val();
			//			var express_no_basic = $("#express_no_basic"+idx).val();
			//
			//			basic = "2";
			//
			//
			//			if(express_no_basic==1){ //배송 기본정책 미사용
			//				if(express_check==1){ //일반배송 일때
			//
			//					if(totalPrice >= express_free){ //총 구매액이 지정한도 이상이면 무료배송
			//						delivery_price = 0;
			//					}else{
			//						delivery_price = express_money;
			//					}
			//				}else{ //무료배송 일때
			//					delivery_price = 0;
			//				}
			//			}else{ //배송 기본정책 사용
			//				basic="1";
			//			}
			//
			//
			//		}
			//
			//		if($(".chkNum:checked").length > 1 || basic==1){ //다중상품일때 기본정책으로 적용
			//
			//			<? if(!$shop_info['express_money']){ $shop_info['express_money'] = 0; } ?>
			//
			//			if(<?=$shop_info['express_check']?>==1){ //일반배송 일때
			//				if(totalPrice >= <?=$shop_info['express_free']?>){ //총 구매액이 지정한도 이상이면 무료배송
			//					delivery_price = 0;
			//				}else{
			//					delivery_price =  <?=$shop_info['express_money']?>;
			//				}
			//			}else{ //무료배송 일때
			//				delivery_price = 0;
			//			}
			//
			//		}else if(basic==""){
			//			delivery_price = 0;
			//		}
			//		*/
			//
			//		//var deliv_add = $(this).data('deliv_add');
			//		//if(deliv_add == "Y"){	//배송비 추가되는경우
			//		//
			//		//}
			//		//else{
			//		//	delivery_price = 0;
			//		//}
			//
			//		//var cart_idx = "";
			//		//
			//		//var sec_class = $(this).data('deliv_date_time');
			//		//
			//		//$("."+sec_class).each(function(){
			//		//
			//		//});
			//
			//		var form_serialize = $("#cartFrm").serialize();
			//		//console.log(form_serialize);
			//		$.ajax({
			//			url:"<?=cdir()?>/dh_order/cart_deliv_calc",
			//			type:"post",
			//			cache:false,
			//			data:form_serialize,
			//			error:function(xhr){
			//				console.log(xhr.responseText);
			//			},
			//			success:function(data){
			//
			//				delivery_price = data;
			//
			//				$("#delivery_price").val(delivery_price);
			//				$(".devPrice").html(number_format(delivery_price,0)+"원");
			//				$(".tt-price").html(number_format(parseInt(totalPrice)+parseInt(delivery_price),0)+"원");
			//
			//			}
			//		});
			//
			//	});
	});

	function allChk()
	{
		$(".all_chk").prop("checked",true);
		$('.chkNum').prop("checked",true);
	}

	function frmSubmit(mode)
	{
		if($(".chkNum:checked").length==0){
			alert('상품을 선택해주세요.');
			return;
		}


		if(mode=="allDel"){
			if(!confirm("선택상품을 삭제하시겠습니까?")){
				return;
			}
		}

		var form = document.cartFrm;
		form.mode.value=mode;
		form.submit();
	}

	function goFrm(mode,idx)
	{
		var form = document.cartChangeFrm;

		if(mode=="del"){
			if(confirm("삭제하시겠습니까?")){
				form.mode.value=mode;
				form.cart_idx.value=idx;
				<?php
				if ($this->input->get('sample') == "ok")
				{
				?>
				form.action = "<?=$_SERVER['PHP_SELF']?>?sample=ok";
				<?php
				}
				?>
				form.submit();
			}
		}

	}

	function sel_order()
	{
		var formCnt = <?=$frmCnt?$frmCnt:0;?>;
		var send = "";
		var j=0;
		if($(".chkNum:checked").length==0){
			alert('주문할 상품을 선택해주세요.');
			return;
		}

		for(i=1;i<=formCnt;i++){
			if($("input[name='chk"+i+"']:checked").length > 0){
				if(j==0){ j=1; }
				if(j==1){
					if($("input[name='chk"+i+"']").data('order') == "Y"){
						send = send+$("#idx"+i).val();
					}
					else{
						alert('배송일이 지난 상품은 주문할 수 없습니다.');
						return;
					}
				}else{
					if($("input[name='chk"+i+"']").data('order') == "Y"){
						send = send+"a"+$("#idx"+i).val();
					}
					else{
						alert('배송일이 지난 상품은 주문할 수 없습니다.');
						return;
					}
				}
				j=2;
			}
		}

		//location.href="<?=cdir()?>/dh_order/shop_order/"+send;
		location.replace("<?=cdir()?>/dh_order/shop_order/"+send);

	}

	function cartChange(idx,goods_idx,shop_price)
	{
		var form = document.cartChangeFrm;
		var goods_cnt = $("#goods_cnt"+idx).val();

		form.cart_idx.value=idx;
		form.goods_idx.value=goods_idx;
		form.total_price.value=parseInt(shop_price)*parseInt(goods_cnt);
		form.goods_cnt.value=goods_cnt;
		form.mode.value="cart_cnt_update";

		form.submit();
	}

	function goodsCntChange(idx,mode,shop_price,unlimit,number)
	{
		var goods_cnt = $("#goods_cnt"+idx).val();

		if(mode=="u"){

			if(unlimit == 0 && number > 0){

			if(number==goods_cnt){
				alert("상품 재고수량이 부족합니다.");
				return;
			}

			}
			goods_cnt = parseInt(goods_cnt)+1;
			shop_price = parseInt(shop_price)*goods_cnt;

		}else if(mode=="d"){
			if(goods_cnt==1){
				alert("수량은 1개 이상부터 가능합니다.");
				return;
			}else{
				goods_cnt = parseInt(goods_cnt)-1;
			}
		}

		$("#goods_cnt"+idx).val(goods_cnt);
	}
</script>

<script type="text/javascript">
      kakaoPixel('5114912039431747532').viewCart();
</script>