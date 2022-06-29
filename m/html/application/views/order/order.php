<? if(empty($member_total_point) || !$member_total_point){ $member_total_point = 0; } ?>
			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<div class="tblTy02 tblTy02_1">
					<?php
					if($cart_arr[1]){
						?>
						<h3 class="order-tit pt30">이유식</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
							</tr>

							<tbody>
							<?php
							$frmCnt = 0;
							foreach($cart_list as $lt){
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
									</tr>
									<?php
									if($lt->date_bind != $deliv_date){
										$deliv_price_t1 += $dp_arr[$lt->date_bind][1]['dp'];
									}
									$total_price_t1 += $lt->total_price;
									$deliv_date = $lt->date_bind;
								}
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
					if($cart_arr[2]){
						?>
						<h3 class="order-tit pt30">간식</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($cart_list as $lt){
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
									</tr>
									<?php
									if($lt->date_bind != $deliv_date2){
										$deliv_price_t2 += $dp_arr[$lt->date_bind][2]['dp'];
									}
									$total_price_t2 += $lt->total_price;
									$deliv_date2 = $lt->date_bind;
								}
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
					if($cart_arr[3]){
						?>
						<h3 class="order-tit pt30">프로모션</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($cart_list as $lt){
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
									</tr>
									<?php
									if($lt->date_bind != $deliv_date3){
										$deliv_price_t3 += $dp_arr[$lt->date_bind][3]['dp'];
									}
									$total_price_t3 += $lt->total_price;
									$deliv_date3 = $lt->date_bind;
								}
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
					if($cart_arr[4]){
						?>
						<h3 class="order-tit pt40">맛보기 세트</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($cart_list as $lt){
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
									</tr>
									<?php
									if($lt->date_bind != $deliv_date3){
										$deliv_price_t4 += $dp_arr[$lt->date_bind][4]['dp'];
									}
									$total_price_t4 += $lt->total_price;
									$deliv_date3 = $lt->date_bind;
								}
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
					if($cart_arr[5]){
						?>
						<h3 class="order-tit pt30">단독배송상품</h3>
						<table>
							<colgroup>
								<col>
								<col>
								<col>
								<col width="70px">
							</colgroup>
							<tr>
								<th>배송일</th>
								<th>상품명</th>
								<th>총수량</th>
								<th>배송비</th>
							</tr>

							<tbody>

							<?php
							$frmCnt = 0;
							foreach($cart_list as $lt){
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
									</tr>
									<?php
									if($lt->date_bind != $deliv_date5){
										$deliv_price_t5 += $dp_arr[$lt->date_bind][5]['dp'];
									}
									$total_price_t5 += $lt->total_price;
									$deliv_date5 = $lt->date_bind;
								}
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
							foreach($cart_list as $lt){
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
							foreach($cart_list as $lt){
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
				</div>

				<?php
				$totalPrice = $total_price_t1+$total_price_t2+$total_price_t3+$total_price_t4+$total_price_t5+$total_price_t6+$total_price_t7;
				$delivery_price = $deliv_price_t1+$deliv_price_t2+$deliv_price_t3+$deliv_price_t4+$deliv_price_t5+$deliv_price_t6+$deliv_price_t7;
				$totalPoint = $totalPrice*$reward_percent*0.01;
				?>

				<div class="shop-cart-wrap" <?if($_SERVER['HTTP_X_FORWARDED_FOR']=='106.102.142.214'){?>style="display:none;"<?}?>>
					<!-- 총 가격 -->
					<div class="order-price-box">
						<ul class="order-price">
							<li>
								<div class="shop-inner">
									<span class="l">총 상품금액</span>
									<span class="r price"><?=number_format($totalPrice)?>원</span>
								</div>
							</li>
							<li>
								<div class="shop-inner">
									<span class="l">배송비</span>
									<span class="r devPrice"><?=number_format($delivery_price)?>원</span>
								</div>
							</li>
							<li class="order-total" style="background: #eee;">
								<div class="shop-inner">
									<em class="l">총 주문금액</em>
									<div class="r">
										<span class="total-price tt-price"><?=number_format($totalPrice+$delivery_price)?>원</span>
										<!-- <span class="save-point">적립 포인트 325P</span> -->
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- END 총 가격 -->
				</div>

					<?php
					//20190808 update
					// 배송비가 없는경우 배송주소 변경 못하도록
					// 단, 총 구매금액이 3만원 이상인경우 (상점에서 저장한 DB 데이터 가져와야함) 배송지 변경 가능하게 수정	20200911
					$readonly = false;
					if($delivery_price <= 0 and $lt->recom_is != "Y" and ($totalPrice < $shop_info['express_free'])){
						$readonly = true;
					}

					if($this->session->userdata('LEVEL') == 4){
						$totalPrice = $totalPrice/2;
						$delivery_price = 0;
					}
					else if($this->session->userdata('LEVEL') == 5){
						$totalPrice = 0;
						$delivery_price = 0;
					}
					?>

				<!-- Shop Order Wrap -->
				<div class="shop-order-wrap" <?if($_SERVER['HTTP_X_FORWARDED_FOR']=='106.102.142.214'){?>style="display:none;"<?}?>>
					<form name="order_form" id="order_form" method="post" >
					<input type="hidden" name="userid" value="<? echo isset($member_stat->userid) ? $member_stat->userid : ""; ?>">
					<input type="hidden" name="price" id="price" value="<?=$totalPrice+$delivery_price?>">
					<input type="hidden" name="total_price" id="total_price" value="<?=$totalPrice+$delivery_price?>">
					<input type="hidden" name="goods_price" id="goods_price" value="<?=$totalPrice?>">
					<input type="hidden" name="delivery_price" id="delivery_price" value="<?=$delivery_price?>">
					<input type="hidden" name="point" id="point" value="0">
					<input type="hidden" name="use_coupon" id="use_coupon" value="0">
					<input type="hidden" name="save_point" id="save_point" value="<? echo isset($member_stat->userid) ? @$totalPoint : "0"; ?>">
					<input type="hidden" name="trade_code" id="trade_code" value="<?=$TRADE_CODE?>">
					<input type="hidden" name="tmp" id="tmp" value="1">
					<input type="hidden" name="cart_code" value="<?=$cart_code?>">
					<input type="hidden" name="delivPoNm" value="<?=$readonly?"N":"";?>">

					<!-- 주문 고객 정보 -->
					<h4 class="order-field-tit"><img src="/m/image/shop/icon_user.png" alt="">주문 고객 정보</h4>
					<ul class="order-field">
						<li>
							<div class="of-label"><label for="o-name">주문고객명</label></div>
							<div class="of-field"><input type="text" class="field-full" id="o-name" name="name" value="<? echo isset($member_stat->name) ? $member_stat->name : ""; ?>" msg="주문고객명을"></div>
						</li>
						<li>
							<div class="of-label"><label for="o-email">이메일</label></div>
							<div class="of-field"><input type="text" class="field-full" id="o-email" name="email" value="<? echo isset($member_stat->email) ? $member_stat->email : ""; ?>" msg="이메일을"></div>
						</li>
						<li>
							<div class="of-label"><label for="o-tel">휴대폰</label></div>
							<div class="of-field">
								<input type="number" pattern="\d*" class="field-xs" id="o-tel" name="phone1" value="<? echo isset($member_stat->phone1) ? $member_stat->phone1 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4"> -
								<input type="number" pattern="\d*" class="field-xs" name="phone2" value="<? echo isset($member_stat->phone2) ? $member_stat->phone2 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4"> -
								<input type="number" pattern="\d*" class="field-xs" name="phone3" value="<? echo isset($member_stat->phone3) ? $member_stat->phone3 : ""; ?>" msg="주문고객의 휴대폰번호를" maxlength="4">
								<!-- <p class="mt5"><small>주문 정보를 SMS로 발송해 드립니다.</small></p> -->
							</div>
						</li>
					</ul>
					<!-- END 주문 고객 정보 -->

					<?php
					if($readonly){
						?>
						<ul class="order-field">
							<li>
								<small class="dh_red">배송비가 부과되지않는 주문의 경우 배송지를 변경 할 수 없습니다.</small>
							</li>
						</ul>
						<?php
					}
					?>

					<?php
					//배송지 기본값 설정
					//배송지 이것저것 합쳐서 할경우엔 어떻게 해야됨? 아 ~~ 어쩌란 말이냐 트위스트 추면서
					if($readonly){
						$deliv_addr_set = "home";
						$zip1 = $member_info->zip1;
						$addr1 = $member_info->add1;
						$addr2 = $member_info->add2;
						$rec_name = $member_info->name;
						$rec_phone1 = $member_info->phone1;
						$rec_phone2 = $member_info->phone2;
						$rec_phone3 = $member_info->phone3;
					}
					else{
						foreach($cart_list as $lt){
							if($lt->deliv_addr == "self"){
								$deliv_addr_set = "self";
								$zip1 = $lt->zipcode;
								$addr1 = $lt->addr1;
								$addr2 = $lt->addr2;
								$rec_name = $member_info->name;
								$rec_phone1 = $member_info->phone1;
								$rec_phone2 = $member_info->phone2;
								$rec_phone3 = $member_info->phone3;
							}
							else{
								if($lt->deliv_addr == "home" || $lt->deliv_addr == ""){
									$deliv_addr_set = "home";
									$zip1 = $member_info->zip1;
									$addr1 = $member_info->add1;
									$addr2 = $member_info->add2;
									$rec_name = $member_info->name;
									$rec_phone1 = $member_info->phone1;
									$rec_phone2 = $member_info->phone2;
									$rec_phone3 = $member_info->phone3;
								}
								else{
									$deliv_addr_set = $lt->deliv_addr;
									$zip1 = $member_info->{$lt->deliv_addr."_zip"};
									$addr1 = $member_info->{$lt->deliv_addr."_addr1"};
									$addr2 = $member_info->{$lt->deliv_addr."_addr2"};
									$rec_name = $member_info->{$lt->deliv_addr."_name"};
									$rec_phone1 = $member_info->{$lt->deliv_addr."_phone1"};
									$rec_phone2 = $member_info->{$lt->deliv_addr."_phone2"};
									$rec_phone3 = $member_info->{$lt->deliv_addr."_phone3"};
								}
							}
						}
					}
					?>

					<!-- 배송지 정보 -->
					<h4 class="order-field-tit"><img src="/m/image/shop/icon_delivery.png" alt="">배송지 정보</h4>
					<ul class="order-field">
						<li>
							<div class="of-label">배송지 선택</div>
							<div class="of-field" style="display:none;">
								<p><input type="radio" name="addr_list" id="addr_list1" onclick="infoComp(1)">
								<label for="addr_list1">주문고객과 동일</label></p>
								<p class="mt5"><input type="radio" name="addr_list" id="addr_list2" onclick="infoComp(2)">
								<label for="addr_list2">새로운 주소</label></p>
							</div>
							<div class="of-field">
								<select name="deliv_addr_set" <?if($readonly){?>onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;alert("알림 : 배송비가 없는 주문은 배송지를 변경 하실 수 없습니다.")'<?}else{?>onchange="addr_change(this.value)"<?}?>>
									<option value="home">자택</option>
									<?if($member_info->chin_zip and $member_info->chin_addr1 and $member_info->chin_addr2){?><option value="chin">친정</option><?}?>
									<?if($member_info->sidc_zip and $member_info->sidc_addr1 and $member_info->sidc_addr2){?><option value="sidc">시댁</option><?}?>
									<?if($member_info->bomo_zip and $member_info->bomo_addr1 and $member_info->bomo_addr2){?><option value="bomo">보모</option><?}?>
									<?if($member_info->oth1_zip and $member_info->oth1_addr1 and $member_info->oth1_addr2){?><option value="oth1">기타1</option><?}?>
									<?if($member_info->oth2_zip and $member_info->oth2_addr1 and $member_info->oth2_addr2){?><option value="oth2">기타2</option><?}?>
									<option value="">직접 입력</option>
								</select>
								<script type="text/javascript">
								<!--
									deliv_addr_set = document.order_form.deliv_addr_set;
									for(i=0;i<deliv_addr_set.length;i++){
										if(deliv_addr_set.options[i].value == "<?=$deliv_addr_set?>"){
											deliv_addr_set.options[i].selected = true;
										}
									}
								//-->
								</script>
							</div>
						</li>
						<li style="display:none;">
							<div class="of-label">도서산간지역</div>
							<div class="of-field">
								<input type="checkbox" name="local_far" id="local_far" value="1">
								<label for="local_far">도서산간/제주도 배송</label>
							</div>
						</li>
						<li>
							<div class="of-label"><label for="r-name">받으시는분</label></div>
							<div class="of-field"><input type="text" class="field-full" id="r-name" name="send_name" msg="받으시는분을" value="<?=$rec_name?>" <?=$readonly?"readonly":"";?>></div>
						</li>
						<li>
							<div class="of-label"><label for="address2">주소</label></div>
							<div class="of-field">
								<input type="text" class="field-s" name="zip1" id="zipcode1" readonly msg="우편번호를" value="<?=$zip1?>">
										<?php
										if(!$readonly){
											?>
											<button type="button" class="btn-order-field" onclick="<?=$readonly?"alert('알림 : 배송비가 없는 주문은 배송지를 변경 하실 수 없습니다.')":"sample6_execDaumPostcode()";?>">우편번호찾기</button><br>
											<?php
										}
										?>
								<input type="text" class="field-full mt5" id="address1" name="addr1" readonly msg="주소를" value="<?=$addr1?>">
								<input type="text" class="field-full mt5" id="address2" name="addr2" msg="상세주소를" value="<?=$addr2?>" <?=$readonly?"readonly":"";?>>
							</div>
						</li>
						<li>
							<div class="of-label"><label for="r-phone">휴대폰</label></div>
							<div class="of-field">
								<input type="number" pattern="\d*" class="field-xs" name="send_phone1" maxlength="4" msg="받으시는분의 휴대폰번호를" value="<?=$rec_phone1?>" id="r-phone" <?=$readonly?"readonly":"";?>> -
								<input type="number" pattern="\d*" class="field-xs" name="send_phone2" maxlength="4" msg="받으시는분의 휴대폰번호를" value="<?=$rec_phone2?>" <?=$readonly?"readonly":"";?>> -
								<input type="number" pattern="\d*" class="field-xs" name="send_phone3" maxlength="4" msg="받으시는분의 휴대폰번호를" value="<?=$rec_phone3?>" <?=$readonly?"readonly":"";?>>
							</div>
						</li>
						<!-- <li>
							<div class="of-label"><label for="r-tel">전화번호</label></div>
							<div class="of-field">
								<input type="number" pattern="d*" class="field-xs" id="r-tel" name="send_tel1" maxlength="4"> -
								<input type="number" pattern="d*" class="field-xs" name="send_tel2" maxlength="4"> -
								<input type="number" pattern="d*" class="field-xs" name="send_tel3" maxlength="4">
							</div>
						</li> -->
						<li>
							<div class="of-label"><label for="r-msg">배송요청사항</label></div>
							<div class="of-field">
								<input type="text" class="field-full" id="r-msg" name="send_text">
							</div>
							<small class="mt10" style="display: block;line-height: 1.4;">배송기사가 참고하는 내용으로 당사와 사전에 협의되지 않은 지정일 및 제품, 배송 관련된 요청사항은 반영되지 않습니다.</small>
						</li>
						<li>
							<div class="of-label">배송요청사항</div>
							<div class="of-field">
								<img src="/image/sub/PC_order_03.jpg" alt="">
							</div>
							<small style="display: block;line-height: 1.4;">원활한 배송을 위해 우체국과 CJ택배를 병행하여 운영합니다. 우체국 이용고객도 CJ택배로 변경 될 수 있습니다.</small>
						</li>
					</ul>
					<!-- END 배송지 정보 -->

					<? if(isset($member_stat->userid) and !$sample_is){?>
					<!-- 할인 정보 -->
					<h4 class="order-field-tit"><img src="/m/image/shop/icon_discount.png" alt="">할인 선택</h4>
					<div class="pay-option shop-inner pay_info">
						<ul class="pay-type">
							<li>
								<input type="radio" name="discount_type" id="coupon-no" value="" checked>
								<label for="coupon-no">할인사용안함</label>
							</li>
							<li>
								<input type="radio" name="discount_type" id="coupon-type1" value="coupon">
								<label for="coupon-type1">쿠폰사용</label>
							</li>
							<li>
								<input type="radio" name="discount_type" id="coupon-type2" value="point">
								<label for="coupon-type2">포인트사용</label>
							</li>
						</ul>
					</div>
					<ul class="order-field mb0">
						<li class="coupon_block" style="display:none;">
							<div class="of-label"><label for="coupon1">쿠폰선택</label></div>
							<div class="of-field">
								<select name="coupon_idx" id="coupon_idx" onchange="coupon_select(this.value);">
									<option value="">쿠폰사용안함</option>
									<?
									$use_ok_coupon = 0;	//사용가능 쿠폰
									foreach($couponList as $coupon){
										if($coupon->min_price <= $totalPrice){
											$use_ok_coupon++;	//사용가능 쿠폰카운트
											?>
											<option value="<?=$coupon->idx?>">
												<?=$coupon->name?>(-
												<? if($coupon->type==3){
													echo number_format($delivery_price)."원";
												}else{
													if($coupon->discount_flag==1){
														echo $coupon->price."%";
													}else{
														echo number_format($coupon->price)."원";
													}
												}?>) [~ <?=$coupon->end_date?>]
											</option>
											<?
										}
									}
									?>
								</select>
							</div>
						</li>
						<li class="point_block" style="display:none;">
							<div class="of-label"><label for="use_point">포인트 사용</label></div>
							<div class="of-field">
								<input type="number" pattern="\d*" class="field-s" value="" id="use_point"> P
								<small class="ml10"><button type="button" class="btn-border-s" onclick="pointChange()">적용</button></small>
								<p class="mt5 bl-noti">보유 포인트 : <strong class="em"><?=number_format($member_total_point)?>P</strong></p>
								<!-- <p class="mt5 bl-noti">사용가능포인트(주문금액의 <?=$shop_info['point_percent']?>%) : <strong class="em"><?=number_format((($totalPrice+$delivery_price)/100)*$shop_info['point_percent'])?>P</strong></p> -->
							</div>
						</li>
					</ul>

					<div class="shop-inner order-dark mb20 point_block" style="display:none;">
						<ul class="order-noti">
								<li>고객님께서 적립될 예정 포인트는 <?=number_format($totalPoint)?> P 입니다. </li>
								<li>단, 포인트 사용시에는 적립 포인트의 변동이 있을 수 있습니다.</li>
								<li>포인트 사용 한도는 총 구매액의 <?=$shop_info['point_percent']?> % 까지 입니다.</li>
								<li>포인트는 <?=number_format($shop_info['point_use'])?> P 이상 보유하셔야만 사용 가능합니다.</li>
								<li>이벤트 및 프로모션 혹은 일부 상품은 적립금(포인트) 적용되지 않을 수 있습니다.</li>
								<li>중단 취소할 경우 환불되지 않고 다시 적립금(포인트)으로 전환됩니다.</li>
								<li>적립금은 타인에게 양도나 판매가 허용되지 않습니다.</li>
								<li>자사 홈페이지 회원이 아닌 경우, 적립금(포인트)가 적립되지 않습니다.</li>
								<li>기타 궁금하신 사항은 고객센터에 문의하여 주십시오.</li>
						</ul>
					</div>
					<!-- END 할인 정보 -->
					<?}?>

					<!-- 결제 금액 -->
					<h4 class="order-field-tit"><img src="/m/image/shop/icon_price.png" alt="">결제 금액</h4>
					<div class="pay-price shop-inner">
						<ul class="order-price">
							<li><span class="l">총 상품금액(<?=number_format($frmCnt)?>개)</span>
								<span class="r"><?=number_format($totalPrice)?>원</span>
							</li>
							<li style="display:none;"class="use_point"><span class="l">포인트할인</span>
								<span class="r point_use">0P</span>
							</li>
							<li class="use_coupon" style="display:none;"><span class="l">쿠폰할인</span>
								<span class="r coupon_use">0원</span>
							</li>
							<li><span class="l">배송비</span>
								<span class="r"><?=number_format($delivery_price)?>원</span>
							</li>
							<li class="order-total">
								<em class="l">총 결제금액</em>
								<div class="r"><span class="total-price total_price"><?=number_format($totalPrice+$delivery_price)?>원</span></div>
							</li>
						</ul>
					</div><!-- END 결제 금액 -->

					<?php
					if($totalPrice+$delivery_price){
						?>
						<!-- 결제 수단 -->
						<h4 class="order-field-tit pay_info"><img src="/m/image/shop/icon_card.png" alt="">결제 수단</h4>
						<!-- 결제수단 선택 -->
						<div class="pay-option shop-inner pay_info">
							<ul class="pay-type">
								<li><input type="radio" name="trade_method" id="pay-way-card" checked value="1"><label for="pay-way-card">신용카드</label></li>
								<li><input type="radio" name="trade_method" id="pay-way-ig" value="4"><label for="pay-way-ig">가상계좌</label></li>
								<li><input type="radio" name="trade_method" id="pay-way-dps" value="9"><label for="pay-way-dps">예치금</label></li>
								<!-- <li><input type="radio" name="trade_method" id="pay-way-deposit" value="2"><label for="pay-way-deposit">무통장</label></li> -->
								<li><input type="radio" name="trade_method" id="pay-way-transf" value="3"><label for="pay-way-transf">실시간이체</label></li>
								<li><input type="radio" name="trade_method" id="pay-way-phone" value="7"><label for="pay-way-phone">휴대폰결제</label></li>

								<?if($this->session->userdata('USERID')=="test"){?>
								<li><input type="radio" name="trade_method" id="pay-way-naver" value="22"><label for="pay-way-naver">네이버페이</label></li>

								<?}?>
								<li style="display:none;"><input type="checkbox" name="point_pay" id="pay-way-point" value="1"><label for="pay-way-point">포인트 결제</label></li>
							</ul>
						</div>
						<!-- END 결제수단 선택 -->

						<!-- 카드결제 안내사항-->
						<div class="pay-info pay-way-card pay_info">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>신용카드 결제 시 화면 아래 [결제하기] 버튼을 클릭하시면 신용카드 결제 창이 나타납니다.</li>
									<li>신용카드 결제 창을 통해 입력되는 고객님의 카드 정보는 안전하게 암호화되어 전송되며, 승인 처리 후 카드 정보는 승인 성공·실패 여부에 상관없이 자동으로 폐기되므로, 안전합니다.</li>
									<li>신용카드 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</li>
									<li>신용카드/실시간 이체는 결제 후, 무통장입금은 입금확인 후 배송이 이루어집니다.</li>
								</ul>
							</div>
						</div><!-- END 무통장 -->

						<!-- 무통장-->
						<div class="pay-info pay-way-deposit pay_info" style="display:none;">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>무통장 입금은 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>무통장 주문 후 오전7시전 까지 입금해주셔야 주문 완료가 되며 그 이후 입금시 해당 주문건은 취소처리됩니다.</li>
									<li>계좌번호는 주문완료 페이지에서 확인 가능하며, SMS로도 안내 드립니다.</li>
								</ul>
							</div>
							<ul class="order-field">
								<li>
									<div class="of-label"><label for="enter_name">입금자명</label></div>
									<div class="of-field"><input type="text" class="field-full" name="enter_name" id="enter_name"></div>
								</li>
								<li>
									<input type="hidden" name="enter_info" id="enter_info">
									<input type="hidden" name="enter_account" id="enter_account">
									<div class="of-label"><label for="enter_bank">입금은행</label></div>
									<div class="of-field">
										<select name="enter_bank" id="enter_bank">
											<option value="">입금하실 은행을 선택하세요</option>
											<? for($i=1;$i<=$bank_cnt;$i++){?>
											<option value="<?=$shop_info['bank_name'.$i]?>" account="<?=$shop_info['bank_num'.$i]?>" info="<?=$shop_info['input_name'.$i]?>"><?=$shop_info['bank_name'.$i]?>(<?=$shop_info['bank_num'.$i]?>)</option>
											<?}?>
										</select>
										<p class="mt5 enter_info" style="display:none;">예금주 :</p>
									</div>
								</li>
								<li>
									<div class="float-wrap">
										<div class="of-label">현금영수증</div>
										<div class="of-field">
											<input type="checkbox" id="cash-receipt-yes" name="cash_yes" value="1"> <label for="cash-receipt-yes">현금영수증 발급요청</label>
										</div>
									</div>

									<!-- 현금영수증 발급요청 체크시에만 보임 -->
									<div class="pay-receipt-box" style="display:none;">
										<p class="mb15">
											<input type="radio" name="cash_receipt2" id="cash-receipt-p" value="1"> <label for="cash-receipt-p">소득공제용</label>
											<span class="ml20"></span>
											<input type="radio" name="cash_receipt2" id="cash-receipt-c" value="2"> <label for="cash-receipt-c">지출증빙용</label>
										</p>
										<p><label for="cash_number2"><strong>휴대폰번호/현금영수증카드/사업자번호</strong></label></p>
										<p class="mt5"><input type="number" pattern="\d*" class="field-full" name="cash_number2" id="cash_number2" placeholder="'-'를 빼고 입력하세요." maxlength="12"></p>

										<ul class="order-noti-dash mt15">
											<li>사업자, 현금영수증카드, 휴대폰번호가 유효하지 않으면 발급되지 않습니다.</li>
											<li>2016년 7월부터 10만원 이상 무통장 거래건에 대해, 출고후 2일내에 발급하지 않으시면 출고 3일후 자진 발급 합니다. 국세청 홈텍스 사이트에서 현금영수증 자진발급분 소비자 등록 메뉴로 수정 가능합니다.</li>
										</ul>
									</div>
									<!-- END 현금영수증 발급요청 체크시에만 보임 -->
								</li>
							</ul>
						</div><!-- END 무통장 -->

						<!-- 예치금 -->
						<div class="pay-info pay-way-dps pay_info" style="display:none;">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>사용 가능한 예치금 : <?=number_format($total_deposit)?></li>
								</ul>
							</div>
						</div><!-- END 예치금 -->

						<!-- 실시간 계좌이체 -->
						<div class="pay-info pay-way-transf pay_info" style="display:none;">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>실시간 이체 결제 시 화면 아래 '결제하기'버튼을 클릭하시면 실시간 이체 결제 창이 나타납니다.</li>
									<li>실시간 이체 결제 창을 통해 입력되는 고객님의 정보는 안전하게 암호화되어 전송되며 승인 처리 후 정보는 승인 성공/실패 여부에 상관없이 자동으로 폐기됩니다.</li>
									<li>실시간 이체 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</li>
									<li>실시간 계좌 이체 서비스는 은행계좌만 있으면 누구나 이용하실 수 있는 서비스로, 별도의 신청 없이 그 대금을 자신의 거래은행의 계좌로부터 바로 지불하는 서비스입니다.</li>
									<li>결제 시 공인인증서가 반드시 필요합니다.</li>
									<li>결제 후 1시간 이내에 확인되며, 입금 확인 후 배송이 이루어 집니다.</li>
									<li>은행 이용가능 서비스 시간은 은행사정에 따라 다소 변동될 수 있습니다.</li>
								</ul>
							</div>
						</div><!-- END 실시간 계좌이체 -->

						<!-- 가상계좌 안내사항 -->
						<div class="pay-info pay-way-ig pay_info" style="display:none;">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>가상계좌 결제 시 화면 아래 '결제하기'버튼을 클릭하시면 가상계좌 결제 창이 나타납니다.</li>
									<li>가상계좌 결제 창을 통해 입력되는 고객님의 정보는 안전하게 암호화되어 전송되며 승인 처리 후 정보는 승인 성공/실패 여부에 상관없이 자동으로 폐기됩니다.</li>
									<li>가상계좌 결제 신청 시 승인 진행에 다소 시간이 소요될 수 있으므로 '중지', '새로고침'을 누르지 마시고 결과 화면이 나타날 때까지 기다려 주십시오.</li>
									<li>가상계좌 결제는 입금 후 24시간 이내에 확인되며, 입금 확인시 배송이 이루어 집니다.</li>
									<li>가상계좌 결제는 주문 후 7일 이내에 입금이 되지 않으면 주문은 관리자에 의해 취소됩니다. 한정 상품 주문 시 유의하여 주시기 바랍니다.</li>
									<li>계좌번호는 주문완료 페이지에서 확인 가능하며, 이메일로도 안내 드립니다.</li>
								</ul>
							</div>
						</div><!-- END 실시간 계좌이체 -->

						<!-- 네이버 페이 -->
						<div class="pay-info pay-way-naver pay_info" style="display:none;">
							<div class="order-dark shop-inner">
								<ul class="order-noti">
									<li>주문 변경 시 카드사 혜택 및 할부 적용 여부는 해당 카드사 정책에 따라 변경될 수 있습니다.</li>
									<li>네이버페이는 네이버ID로 별도 앱 설치 없이 신용카드 또는 은행계좌 정보를 등록하여 네이버페이 비밀번호로 결제할 수 있는 간편결제 서비스입니다.</li>
									<li>결제 가능한 신용카드: 신한, 삼성, 현대, BC, 국민, 하나, 롯데, NH농협, 씨티, 카카오뱅크</li>
									<li>결제 가능한 은행: NH농협, 국민, 신한, 우리, 기업, SC제일, 부산, 경남, 수협, 우체국, 미래에셋대우, 광주, 대구, 전북, 새마을금고, 제주은행, 신협, 하나은행, 케이뱅크, 카카오뱅크, 삼성증권, KDB산업은행,씨티은행, SBI은행, 유안타증권, 유진투자증권</li>
									<li>네이버페이 카드 간편결제는 네이버페이에서 제공하는 카드사 별 무이자, 청구할인 혜택을 받을 수 있습니다.</li>
								</ul>
							</div>
						</div><!-- END 네이버페이 -->
						<?php
					}
					else{
						?>
						<input type="hidden" name="trade_method" value="99">
						<input type="checkbox" name="point_pay" id="pay-way-point" value="1" style="display:none;" checked><label for="pay-way-point" style="display:none;">포인트 결제</label>
						<?php
					}
					?>

					</form>
				</div><!-- END Shop Order Wrap -->


				<!-- 주문버튼 -->
				<div class="shop-inner mt20">
					<?php
					if($order_confirm){
						?>
						<button type="button" class="btn-emp field-full send_order" name="writeBtn"><?=($this->input->get('sample') == "ok")?"신청하기":"결제하기";?></button>
						<?php
					}
					else{
						?>
						<button type="button" class="btn-emp field-full" name="writeBtn" onclick="alert('배송일이 지난 상품은 주문할 수 없습니다.\n<?=date("Y년 m월 d일",strtotime($order_cant_date))?> 이전으로\n배송일이 지정된 상품은 주문할 수 없습니다.')"><?=($this->input->get('sample') == "ok")?"신청하기":"결제하기";?></button>
						<?php
					}
					?>

				</div>
				<!-- END 주문버튼 -->
			</div><!-- END Shop Wrap -->


<script>
	function addr_change(val){
		$.ajax({
			url:"<?=cdir()?>/dh_order/addr_change/?type="+val+"&userid=<?=$this->session->userdata('USERID')?>",
			type:"GET",
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){
				//console.log(data);
				$("input[name='send_name']").val(data.name);
				$("input[name='send_phone1']").val(data.phone1);
				$("input[name='send_phone2']").val(data.phone2);
				$("input[name='send_phone3']").val(data.phone3);
				$("input[name='zip1']").val(data.zipcode);
				$("input[name='addr1']").val(data.address1);
				$("input[name='addr2']").val(data.address2);
			}
		});
	}

	<? if(isset($member_stat->idx)){ ?>

	function pointChange() //포인트 정책 적용
	{
		if($("#use_point").val()==""){
			alert("포인트를 입력해주세요.");
			$("#use_point").focus();
			return;
		}else if(isNaN($("#use_point").val())){
			alert("포인트는 숫자로만 입력해주세요.");
			$("#use_point").val("");
			$("#use_point").focus();
			return;
		}

		var total_price = $("#price").val();
		//total_price = parseInt(total_price) + parseInt($("#point").val());

		var point_limit = parseInt((<?=$shop_info['point_percent']?>* total_price)/100); //포인트사용한도
		var point = <?=$member_total_point?>; //보유포인트
		var basic_point_limit = <?=$shop_info['point_use']?>; //포인트 기본 사용한도

		var use_point = $("#use_point").val();
		$("#use_point").val(use_point.replace(/[^0-9]/gi,''));

		if(use_point){

			if(use_point > point) {
				alert('적립된 포인트 보다 많이 입력 하셨습니다.');
				//$("#use_point").val('');
				$("#use_point").focus();
			}else if(use_point > point_limit) {
				alert("포인트 사용한도를 초과하였습니다.\n포인트는 총 구매액의 <?=$shop_info['point_percent']?>% 까지만 사용 가능합니다.");
				//$("#use_point").val('');
				$("#use_point").focus();
			}else if(use_point > 0 && use_point < basic_point_limit){
				alert("포인트는 "+number_format(basic_point_limit,0)+"P 부터 사용 가능합니다.");
				//$("#use_point").val('');
				$("#use_point").focus();
			}else{
				if(use_point > 0){
					total_price = parseInt(total_price) - parseInt(use_point);
					$(".use_point").show();
				}else{
					$(".use_point").hide();
				}
				$(".total_price").html(number_format(total_price,0)+"원");
				$("#total_price").val(total_price);

				if(use_point > 0){
					$(".point_use").html("-"+number_format(use_point,0)+"P");
				}

				$("#point").val(use_point);

				if($("#coupon_idx").val()){
					//coupon_select($("#coupon_idx").val());
				}
			}

			if(total_price==0){

				$("input[name='point_pay']").prop("checked",true);
				$(".pay_info").hide();

			}else{

				$("input[name='point_pay']").prop("checked",false);
				$(".pay_info").show();
				$(".pay-info").hide();
				$("."+$("input[name='trade_method']:checked").attr("id")).show();
			}
		}
	}

	<?}?>


	$(function(){
		$("#cash-receipt-yes").click(function(){
			if($(this).prop('checked') == true){
				$(".pay-receipt-box").show();
			}
			else{
				$(".pay-receipt-box").hide();
			}
		});

		//$(".tblTy02 table tbody").rowspan(0);

		$("input[name='cash_receipt2']").change(function(){
			if(this.checked){
				if(this.value == 0){
					$(".cash_receipt2").hide();
				}else{
					$(".cash_receipt2").show();
				}
			}
		});

		$("input[name='trade_method']").on("change",function(){
			if(this.checked){
				var id = $(this).attr("id");
				$(".pay-info").hide();
				$("."+id).show();
			}
		});

		$("input[name='discount_type']").on("change",function(){
			if(this.checked){
				$("#use_point").val('0');
				$(".point_use").html("0P");
				coupon_select();
				setTimeout("pointChange()",150);

				if($(this).val()){
					$(".coupon_block").hide();
					$(".point_block").hide();
					$("."+$(this).val()+"_block").show();
				}else{
					$(".coupon_block").hide();
					$(".point_block").hide();
				}
			}
		});

		$(".send_order").on("click",function(){

			var d_add_val = $("#address1").val();

			$.ajax({
				url:"<?=cdir()?>/dh/deliv_addr_check/?ajax=1&d_add_val="+encodeURIComponent(d_add_val),
				type:"GET",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					if(data){
						alert("이유식은 신선유통을 위해\n제주 및 도서산간 지역에는 배송이 어렵습니다.\n\n산골 간식 및 건강식품을 구매를 원하시는 경우\n유선으로 별도 문의 부탁드립니다.");
						return false;
					}
					else{
						var point_pay = $("input[name='point_pay']:checked").length;
						var tmp = $("#tmp").val();

						if (checkForm("order_form")) {

							var trade_method = $("input[name='trade_method']:checked").val();

							if( point_pay==0 && ( trade_method==2 || trade_method==3 || trade_method==4 )){
								if(trade_method==2 && $("#enter_bank").val()==""){ // 무통장입금 && 은행선택
									alert("입금하실 은행을 선택해주세요.");
									$("#enter_bank").focus();
									return;
								}else if(trade_method==2 && $("#enter_name").val()==""){ // 무통장입금 && 입금자명
									alert("입금자명을 입력해주세요.");
									$("#enter_name").focus();
									return;
								}

								var cash_yes = $("input[name='cash_yes']:checked").val();
								var cash_receipt = $("input[name='cash_receipt"+trade_method+"']:checked").val();
								var cash_number = $("#cash_number"+trade_method).val();
								if(cash_yes){
									if(cash_receipt!=0 && cash_number==""){
										alert("현금영수증 번호를 입력해주세요.");
										$("#cash_number"+trade_method).focus();
										return;
									}
								}
							}

							//if($("#point").val()!="" && $("#point").val() > 0 && <?=$frmCnt?> > <?=$real_cnt?>){
							//							if($("#point").val()!="" && <?=$frmCnt?> > <?=$real_cnt?>){
							//								var total_price = $("#total_price").val();
							//								var save_point = $("#save_point").val();
							//								var price = parseInt(total_price)-<?=$real_price?>;
							//
							//								save_point = parseInt(price)*parseInt(<?=$reward_percent?>)*0.01;
							//								save_point = save_point + <?=$real_save_point?>;
							//
							//								$("#save_point").val(save_point);
							//							}

							var goods_price = $("#goods_price").val();
							var use_point = $("#point").val();
							var delivery_price = "<?=$delivery_price?>";
							var real_fee = parseInt(goods_price)-parseInt(use_point)+parseInt(delivery_price);

							//예치금 여부 확인
								if(trade_method == 9){
									total_deposit = "<?=$total_deposit?>"||0;
									if(parseInt(total_deposit) < real_fee){
										if(confirm('보유하신 예치금 잔액이 부족하여 결제할 수 없습니다. 충전 페이지로 이동 하시겠습니까?')){
											location.href="<?=cdir()?>/dh/deposit";
											return;
										}
										else{
											return;
										}
									}
								}
							//예치금 여부 확인

							var $totalPrice = "<?=$totalPrice?>";

							if(parseInt($totalPrice)){
								save_point = parseInt(real_fee)*parseInt(<?=$reward_percent?>)*0.01;
							}
							else{
								save_point = 0;
							}

							$(".review_addfile_loading_wrap").show();

							$("#save_point").val(save_point);

							$("#order_form").attr("target","tmp_frame"); //tmp에 넣기
							$("#order_form").submit();
						}

					}
				}
			});
		});

		$("#enter_bank").on("change",function(){
				var id = "#enter_bank";
				if($(this).val()){
					var index = $(id+" option").index($("#enter_bank option:selected"));
					var account = $(id+" option:eq("+index+")").attr("account");
					var info = $(id+" option:eq("+index+")").attr("info");

					$("#enter_info").val(info);
					$("#enter_account").val(account);
				}
		});

		$("#local_far").on("change",function(){ //도서산간지역 배송비 추가
			var total_price = parseInt($("#total_price").val());
			var price = parseInt($("#price").val());
			var limit_price = parseInt("<?=$shop_info['express_free']?>");
			var express_money = "<?=$shop_info['express_money']?>";
			var express_money2 = "<?=$shop_info['express_money2']?>";
			var delivery_price = 0;

			if(!limit_price){ limit_price = 0; }
			if(!express_money){ express_money = 0; } //일반배송비
			if(!express_money2){ express_money2 = 0; } //도서산간지역배송비

			if(price < limit_price){
				if(this.checked){
					total_price = parseInt(total_price) - parseInt(express_money);
					total_price = parseInt(total_price) + parseInt(express_money2);
					delivery_price = express_money2;
				}else{
					total_price = parseInt(total_price) - parseInt(express_money2);
					total_price = parseInt(total_price) + parseInt(express_money);
					delivery_price = express_money;
				}

				$(".total_price").html(number_format(total_price,0)+"원");
				$("#total_price").val(total_price);
				$(".delivery_price_txt").html(number_format(delivery_price,0)+"원");
				$("#delivery_price").val(delivery_price);
			}


		});
	});


	function form_submit(){

		$("#order_form").attr("target","");

		var trade_method = $("input[name='trade_method']:checked").val();
		var point_pay = $("input[name='point_pay']:checked").length;

		if((trade_method != '2' && trade_method != '99' && trade_method != '9') && point_pay==0){//무통장이 아닐때
			if(trade_method == '22'){ //네이버결제
				// 100원 미만 상품 네이버결제 불가
				var trade_price = parseInt($("#total_price").val());
				if(trade_price <= 100){
					alert('100원 미만 상품은 네이버페이 결제가 불가합니다.');
					$(".review_addfile_loading_wrap").hide();
				}else{
					$('#naverPayBtn').trigger('click');
				}
			}
			else{
				checkPay();
			}
			$("#tmp").val(1);
		}else{
			$("#tmp").val(0);
			$("#order_form").submit();
			//document.order_form.writeBtn.disabled = true;
		}

	}


	function coupon_select(idx)
	{
		var total_price = $("#goods_price").val();
		var delivery_price = $("#delivery_price").val();
		var use_coupon = $("#use_coupon").val();

		if(idx){

			$.ajax({
					url: "<?=cdir()?>/dh_order/coupon/",
					data: {ajax: 1, coupon_idx: idx},
					async: true,
					cache: false,
					error: function(xhr){	},
					success: function(data){

						data = data.split("/");
						var type = data[0];
						var discount_flag = data[1];
						var price = data[2];

						console.log("total_price : "+total_price);
						console.log("delivery_price : "+delivery_price);
						console.log("use_coupon : "+use_coupon);

						if(parseInt(price) > parseInt(total_price)){
							price = total_price;
						}

						if(type == 3){ //무료배송쿠폰이면

							//total_price = parseInt(total_price)-parseInt(delivery_price);
							if(parseInt(total_price)){
								total_price = parseInt(total_price)-parseInt(delivery_price);
							}
							else{
								total_price = 0;
							}

							use_coupon = delivery_price;

						}else{

							if(discount_flag==1){ //할인율이면
								price = total_price * 0.01 * price;
							}

							console.log("price : "+price);

							total_price = (parseInt(total_price)-parseInt(price))+parseInt(delivery_price);
							use_coupon = price;

						}



						$(".total_price").html(number_format(total_price,0)+"원");
						$("#total_price").val(total_price);
						$("#use_coupon").val(use_coupon);
						$(".use_coupon span.coupon_use").html("-"+number_format(use_coupon,0)+"원");
						$(".use_coupon").show();



						if(total_price==0){

							$("input[name='point_pay']").prop("checked",true);
							$(".pay_info").hide();

						}else{

							$("input[name='point_pay']").prop("checked",false);
							$(".pay_info").show();
							$(".pay-info").hide();
							$("."+$("input[name='trade_method']:checked").attr("id")).show();
						}

					}
			});

		}else{
			$("#coupon_idx option:eq(0)").prop('selected','selected');
			total_price = parseInt(total_price)+parseInt(delivery_price);

			$(".use_coupon").hide();
			$("#use_coupon").val(0);
			$(".total_price").html(number_format(total_price,0));
			$("#total_price").val(total_price);
			$("#coupon_idx option:eq(0)").attr("selected", "selected");

		}
	}

</script>
<iframe name="tmp_frame" border=0 frameborder=0 style="display:none;width:100%;height;500px;"></iframe>

<? include $payView.".php"; ?>

<? include "naverpay.php"; ?>