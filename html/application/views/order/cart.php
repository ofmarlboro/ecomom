
<input type="hidden" id="totalPrice" value="<?=$totalPrice?>">
<input type="hidden" id="delivery_price" value="<?=$delivery_price?>">

			<!-- Shop Wrap -->
			<?php
			$order_confirm = false;
			$totalCnt=0;
			?>
			<div class="shop-wrap">
				<!-- 상단 step -->
				<div class="shop-order-step">
					<h2><span class="so-step so-step1 on">장바구니</span></h2>
					<span class="so-arr"></span>
					<span class="so-step so-step2">주문결제</span>
					<span class="so-arr"></span>
					<span class="so-step so-step3">주문완료</span>
				</div><!-- END 상단 step -->


			<!-- 장바구니 Wrap -->
			<div class="shop-cart-wrap">
				<h3 class="order-tit">장바구니에 담긴 상품</h3>

				<form name="cartFrm" id="cartFrm" method="post" onsubmit="return false;">
				<input type="hidden" name="mode">

				<?php
				if($cart_arr[1]){		//이유식
					?>
					<p class="order-tit">이유식</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk1" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td><!-- 판매가 -->
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td><!-- 수량 / 식단정보 -->
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><!-- 소계금액 -->
											<?=number_format($lt->total_price)?>원
										</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][1]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][1]['dp']?>"><!-- 배송비 -->
											<?php
											if($this->input->get('sample') == "ok"){
												echo number_format($delivery_price)." 원";
											}
											else{
												if($dp_arr[$lt->date_bind][1]['is_recom'] == 'excep'){
													echo $dp_arr[$lt->date_bind][1]['add_txt'];
												}
												else{
													echo number_format($dp_arr[$lt->date_bind][1]['dp'])." 원";
												}
											}
											?>
										</td>

										<td class="cart-edit"><!-- 삭제 -->
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
										</td>
										<td><!-- 체크박스 -->
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

							if($frmCnt<=0){
								?>
								<tr>
									<td colspan='9'>
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
					<p class="order-tit">간식</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk2" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td><!-- 판매가 -->
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td><!-- 수량 -->
											<div class="cart-vol-wrap">
											<?php
											if($lt->option_cnt == 0){
												echo $lt->goods_cnt;
												?>
												<!-- <div class="cart-vol"> -->
													<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
													?>
														<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
														<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
													<?php
													}
													?>
												<!-- </div> -->
												<?php
												if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
													?>
													<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
													<?php
												}
											}
											else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
												echo $lt->option_cnt."개";
											}
											else{
												if($lt->goods_cnt>0){
													echo $lt->goods_cnt;
												}
											}
											?>
											</div>
										</td>
										<td><!-- 소계금액 -->
											<?=number_format($lt->total_price)?>원
										</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

										<td data-value="<?=strtotime($dp_arr[$lt->date_bind][2]['deliv_date'])?>-<?=$dp_arr[$lt->date_bind][2]['dp']?>"><!-- 배송비 -->
											<?php
											if($this->input->get('sample') == "ok"){
												echo number_format($delivery_price)." 원";
											}
											else{
												echo number_format($dp_arr[$lt->date_bind][2]['dp'])." 원";
											}
											?>
										</td>

										<td class="cart-edit"><!-- 삭제 -->
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
										</td>
										<td><!-- 체크박스 -->
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

							if($frmCnt<=0){
							?>
							<tr>
								<td colspan='9'>
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
					<p class="order-tit">프로모션</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td>
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td>
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><?=number_format($lt->total_price)?>원</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

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

										<td class="cart-edit">
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
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

							if($frmCnt<=0){
							?>
							<tr>
								<td colspan='9'>
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
					<p class="order-tit">기획/특가</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td>
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td>
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><?=number_format($lt->total_price)?>원</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

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

										<td class="cart-edit">
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum4 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
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

							if($frmCnt<=0){
							?>
							<tr>
								<td colspan='9'>
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
				if($cart_arr[5]){		//합배송불가
					?>
					<p class="order-tit">단독배송상품</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk5" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td>
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td>
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><?=number_format($lt->total_price)?>원</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

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

										<td class="cart-edit">
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
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

							if($frmCnt<=0){
								?>
								<tr>
									<td colspan='9'>
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
					<p class="order-tit">무료배송상품</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk6" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>
										<td>
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
														?>
														<del><?=number_format($lt->goods_origin_price)?>원</del>
														<ins><?=number_format($lt->goods_price)?>원</ins>
														<?php
													}
													else{
														?>
														<?=number_format($lt->goods_price)?>원
														<?php
													}
												}
												?>
											</p>
										</td>
										<td>
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><?=number_format($lt->total_price)?>원</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

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

										<td class="cart-edit">
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum6 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
											<input type="hidden" name="cart_idx[<?=$totalCnt?>]" value="<?=$lt->idx?>">
										</td>
									</tr>
									<?php
									if($lt->date_bind != $deliv_date6){
										$deliv_price_t6 += $dp_arr[$lt->date_bind][6]['dp'];
									}
									$total_price_t6 += $lt->total_price;
									$deliv_date6 = $lt->date_bind;
								}
							}

							if($frmCnt<=0){
								?>
								<tr>
									<td colspan='9'>
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
					<p class="order-tit">프로모션3</p>
					<table class="shop-cart" id="shop_cart">
						<caption>장바구니 리스트</caption>
						<thead>
							<tr>
								<th class="col-df">배송일</th>
								<th colspan="2">상품정보</th>
								<th class="col-df">판매가</th>
								<th class="col-vol">수량</th>
								<th class="col-df">소계금액</th>
								<!-- <? if($this->session->userdata('USERID')){?><th class="col-df">적립금</th><?}?> -->
								<!-- <th class="col-wide">쿠폰</th> -->
								<th class="col-delivprice">배송비</th>
								<th class="col-df">삭제</th>
								<th class="col-chk" style="width:5%;"><input type="checkbox" class="all_chk all_chk3" checked></th>
							</tr>
						</thead>
						<tbody>
							<?
							$frmCnt=0;
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
									<?php
									/*
									<input type="hidden" name="express_check<?=$lt->idx?>" id="express_check<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_check?>">
									<input type="hidden" name="express_money<?=$lt->idx?>" id="express_money<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_money?>">
									<input type="hidden" name="express_free<?=$lt->idx?>" id="express_free<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_free?>">
									<input type="hidden" name="express_no_basic<?=$lt->idx?>" id="express_no_basic<?=$lt->idx?>" value="<?=@$goods_info[$lt->goods_idx]->express_no_basic?>">
									*/
									?>
									<tr>
										<?php
										//배송일 < 추천식단은 주 몇회 무슨요일?
										if($lt->recom_is == "Y"){
											$wt_arr = explode(":",$lt->recom_week_type);
											echo "<td data-value='".$wt_arr[1]."'>주 ".$wt_arr[0]."회<br>".$wt_arr[1]." 배송</td>";
										}
										else{
											?>
											<td data-value="<?=strtotime($lt->date_bind)?>"><?echo $lt->date_bind;?> (<?=$week_name_arr[date('w', strtotime($lt->date_bind))]?>)</td>
											<?php
										}
										?>

										<?php
										if($lt->list_img){	//제품사진이 있는경우
											?>
											<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name">
														<?php
														if($this->input->get('sample') == "ok"){
															?>
															<?=$lt->goods_name?>
															<?php
														}
														else{
															?>
															<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=($lt->cate_no == "8")? "3":$lt->cate_no; ?>"><?=$lt->goods_name?></a>
															<?php
														}
														?>
													</p>
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
													}?>
												</div>
											</td>
											<?php
										}
										else{	//제품 사진이 없는 경우
											?>
											<td class="col-thumb"></td>
											<td>
												<div class="cart-prod">
													<p class="prod-name"><a href="javascript:;"><?=$lt->goods_name?></a></p>
													<? if($lt->option_cnt > 0){
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
													}?>
												</div>
											</td>
											<?php
										}
										?>

										<td>
											<p class="cart-price">
												<?php
												if($lt->option_cnt > 0){
													?>
													<?=number_format($lt->total_price)?>원
													<?php
												}
												else{
													if($lt->goods_origin_price){
													?>
													<del><?=number_format($lt->goods_origin_price)?>원</del>
													<ins><?=number_format($lt->goods_price)?>원</ins>
													<?php
													}
													else{
													?>
													<?=number_format($lt->goods_price)?>원
													<?php
													}
												}
												?>
											</p>
										</td>
										<td>
											<?php
											if($lt->recom_is == "Y"){	//추천식단
												?>
												<?=$lt->recom_pack_ea?>팩<br>
												<button type="button" class="cart-btn2" onclick="window.open('<?=cdir()?>/dh_order/recom_food_list/?ajax=1&cart=<?=$lt->idx?>','recom_food_list','width=600,height=800')">식단정보</button><br>
												<?php
											}
											else{	//추천식단 이외
												?>
												<div class="cart-vol-wrap">
												<?php
												if($lt->option_cnt == 0){
													echo $lt->goods_cnt;
													?>
													<!-- <div class="cart-vol"> -->
														<!-- <input type="text" name="goods_cnt<?=$lt->idx?>" id="goods_cnt<?=$lt->idx?>" value="<?=$lt->goods_cnt?>" readonly> -->
														<?php
														if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
															<!-- <button class="vol-up" onclick="goodsCntChange('<?=$lt->idx?>','u')">추가</button>
															<button class="vol-down" onclick="goodsCntChange('<?=$lt->idx?>','d')">감소</button> -->
														<?php
														}
														?>
													<!-- </div> -->
													<?php
													if($this->input->get('sample') != "ok"){	//샘플 신청이 아닌 경우에
														?>
														<!-- <button type="button" class="cart-btn2" onclick="cartChange('<?=$lt->idx?>','<?=$lt->goods_idx?>','<?=$lt->goods_price?>')">적용</button> -->
														<?php
													}
												}
												else if($lt->option_cnt > 0){	//옵션이 있는경우 옵션 수량 표기
													echo $lt->option_cnt."개";
												}
												else{
													if($lt->goods_cnt>0){
														echo $lt->goods_cnt;
													}
												}
												?>
												</div>
												<?php
											}
											?>
										</td>
										<td><?=number_format($lt->total_price)?>원</td>
										<!-- <? if($this->session->userdata('USERID')){?><td>회원구매시<br><?=number_format($lt->goods_point)?>원</td><?}?> -->
										<!-- <td></td> -->

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

										<td class="cart-edit">
											<button type="button" class="cart-btn3" onclick="goFrm('del','<?=$lt->idx?>')">삭제하기</button>
										</td>
										<td>
											<input type="checkbox" name="chk<?=$totalCnt?>" value="1" class="chkNum chknum4 <?=strtotime($lt->date_bind)?>" checked data-idx="<?=$lt->idx?>" data-price="<?=$lt->total_price?>" data-deliv_date_time="<?=strtotime($lt->date_bind)?>" data-order="<?=($order_confirm)?"Y":"N";?>">
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

							if($frmCnt<=0){
							?>
							<tr>
								<td colspan='9'>
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

					<?php
					if($this->input->get('sample') == "ok"){
					}
					else{
						?>

						<!-- 옵션버튼 -->
						<p class="cart-op-btns">
							<button type="button" class="cart-btn2" onclick="allChk()">전체선택</button>
							<!-- <button type="button" class="cart-btn1">선택상품 위시리스트 추가</button> -->
							<button type="button" class="cart-btn3" onclick="frmSubmit('allDel')">선택상품 삭제</button>
						</p><!-- END 옵션버튼 -->

						<?php
						$all_total_price = $total_price_t1+$total_price_t2+$total_price_t3+$total_price_t4+$total_price_t5+$total_price_t6+$total_price_t7;
						$all_total_deliv_price = $deliv_price_t1+$deliv_price_t2+$deliv_price_t3+$deliv_price_t4+$deliv_price_t5+$deliv_price_t6+$deliv_price_t7;
						?>

						<!-- 총 주문금액  -->
						<div class="order-total-box">
							<div class="each-price-box">
								<p class="total-tit"><img src="/image/shop/total_tit.png" alt="총 주문금액"></p>
								<ul class="each-price">
									<li><span>상품 총 금액</span>
										<em class="price"><?=number_format($all_total_price)?>원</em>
									</li>
									<li><span>배송비</span>
										<em class="devPrice"><?=number_format($all_total_deliv_price)?>원</em>
									</li>
								</ul>
							</div>
							<div class="total-price">
								<!-- <? if($this->session->userdata('USERID')){?><span class="acc-p">( 적립예정 포인트 : <?=number_format($totalPoint)?>P )</span><?}?> -->
								결제 예정 금액 <span class="tt-price"><em><?=number_format($all_total_price+$all_total_deliv_price)?></em> 원</span>
							</div>
						</div><!-- END 총 주문금액 -->
						<?php
					}
					?>

				</div><!-- END 장바구니 Wrap -->


				<!-- 하단 버튼 -->
				<div class="float-wrap">

					<?php
					if($this->input->get('sample') == "ok"){
						?>
						<div class="align-c">
							<!-- <button type="button" class="btn-emp" onclick="javascript:location.href='<?=cdir()?>/dh_order/shop_order/<?=$lt->idx?>/ok';">샘플 신청</button> -->
							<?php
							if($order_confirm){
								?>
								<button type="button" class="btn-emp" onclick="javascript:location.href='<?=cdir()?>/dh_order/shop_order/<?=$lt->idx?>/ok';">샘플 신청</button>
								<?php
							}
							else{
								?>
								<button type="button" class="btn-emp" onclick="javascript:alert('배송일이 지난 샘플입니다. 삭제후 재신청 해주세요.');">샘플 신청</button>
								<?php
							}
							?>
						</div>
						<?php
					}
					else{
					?>
					<div class="float-l">
						<button type="button" class="btn-border" onclick="javascript:location.href='/'">계속 쇼핑하기</button>
					</div>
					<?php
						if($order_confirm){
							if($orderable_485){
								?>
								<div class="float-r">
									<!-- <button type="button" class="btn-normal" onclick="sel_order();">선택상품 주문</button> -->
									<!-- <button type="button" class="btn-emp" onclick="<?if($totalCnt>0){?>location.href='/html/dh_order/shop_order'<?}else{?>alert('주문할 상품이 없습니다.')<?}?>;">전체 주문</button> -->
									<button type="button" class="btn-emp" onclick="<?if($totalCnt>0){?>location.replace('/html/dh_order/shop_order')<?}else{?>alert('주문할 상품이 없습니다.')<?}?>;">전체 주문</button>
								</div>
								<?php
							}
							else{
								?>
								<div class="float-r">
									<!-- <button type="button" class="btn-normal" onclick="sel_order();">선택상품 주문</button> -->
									<!-- <button type="button" class="btn-emp" onclick="<?if($totalCnt>0){?>location.href='/html/dh_order/shop_order'<?}else{?>alert('주문할 상품이 없습니다.')<?}?>;">전체 주문</button> -->
									<button type="button" class="btn-emp" onclick="alert('구매가 제한된 상품이 1개 이상 있습니다.')">전체 주문</button>
								</div>
								<?php
							}
						}
						else{
							if($frmCnt <= 0){
								?>
								<div class="float-r">
									<!-- <button type="button" class="btn-normal" onclick="sel_order();">선택상품 주문</button> -->
									<button type="button" class="btn-emp" onclick="alert('주문하실 상품이 없습니다.')">전체 주문</button>
								</div>
								<?php
							}
							else{
								?>
								<div class="float-r">
									<!-- <button type="button" class="btn-normal" onclick="sel_order();">선택상품 주문</button> -->
									<button type="button" class="btn-emp" onclick="alert('배송일이 지난 상품은 주문할 수 없습니다.\n<?=date("Y년 m월 d일",strtotime($order_cant_date))?> 이전으로\n배송일이 지정된 상품은 주문할 수 없습니다.')">전체 주문</button>
								</div>
								<?php
							}
						}
					}
					?>
				</div><!-- END 하단 버튼 -->

			</div><!-- END Shop Wrap -->

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

	//$(".shop-cart-wrap table tbody").rowspan(0);
	$(".shop-cart-wrap table tbody").rowspan(6);

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

	$(".all_chk6").on("click", function (){
		$(".chknum6").prop("checked",$(this).prop("checked"));
	});

	$(".all_chk7").on("click", function (){
		$(".chknum7").prop("checked",$(this).prop("checked"));
	});

	/*
  $(".all_chk").change(function(){

	  var checkObj = $('.chkNum');

		if(this.checked){
      checkObj.prop("checked",true);

			$("#totalPrice").val("<?=$totalPrice?>");
			$("#delivery_price").val("<?=$delivery_price?>");

			$(".price").html("<?=number_format($totalPrice)?>원");
			$(".devPrice").html("<?=number_format($delivery_price)?>원");
			$(".tt-price em").html("<?=number_format($totalPrice+$delivery_price)?>");

    }else{
      checkObj.prop("checked",false);
			$(".price").html("0원");
			$("#delivery_price").val(0);
			$(".devPrice").html("0원");
			$(".tt-price em").html("0");
			$("#totalPrice").val(0);
    }

  });
	*/

	/*
	$(".chkNum").change(function(){

		var totalPrice = $("#totalPrice").val();
		var delivery_price = $("#delivery_price").val();

		var idx = $(this).data("idx");
		var price = $(this).data("price");

		if(this.checked){
			totalPrice = parseInt(totalPrice)+parseInt(price);
		}else{
			totalPrice = parseInt(totalPrice)-parseInt(price);
		}

		$("#totalPrice").val(totalPrice);
		$(".price").html(number_format(totalPrice,0)+"원");

		var basic="";


		//if($(".chkNum:checked").length==1){ //단일상품일때
		//
		//	var idx = $(".chkNum:checked").attr("idx");
		//
		//	var express_check = $("#express_check"+idx).val();
		//	var express_money = $("#express_money"+idx).val();
		//	var express_free = $("#express_free"+idx).val();
		//	var express_no_basic = $("#express_no_basic"+idx).val();
		//
		//	basic = "2";
		//
		//
		//	if(express_no_basic==1){ //배송 기본정책 미사용
		//		if(express_check==1){ //일반배송 일때
		//
		//			if(totalPrice >= express_free){ //총 구매액이 지정한도 이상이면 무료배송
		//				delivery_price = 0;
		//			}else{
		//				delivery_price = express_money;
		//			}
		//		}else{ //무료배송 일때
		//			delivery_price = 0;
		//		}
		//	}else{ //배송 기본정책 사용
		//		basic="1";
		//	}
		//
		//
		//}
		//
		//if($(".chkNum:checked").length > 1 || basic==1){ //다중상품일때 기본정책으로 적용
		//
		//	<? if(!$shop_info['express_money']){ $shop_info['express_money'] = 0; } ?>
		//
		//	if(<?=$shop_info['express_check']?>==1){ //일반배송 일때
		//		if(totalPrice >= <?=$shop_info['express_free']?>){ //총 구매액이 지정한도 이상이면 무료배송
		//			delivery_price = 0;
		//		}else{
		//			delivery_price =  <?=$shop_info['express_money']?>;
		//		}
		//	}else{ //무료배송 일때
		//		delivery_price = 0;
		//	}
		//
		//}else if(basic==""){
		//	delivery_price = 0;
		//}


		//var deliv_add = $(this).data('deliv_add');
		//if(deliv_add == "Y"){	//배송비 추가되는경우
		//
		//}
		//else{
		//	delivery_price = 0;
		//}

		//var cart_idx = "";
		//
		//var sec_class = $(this).data('deliv_date_time');
		//
		//$("."+sec_class).each(function(){
		//
		//});

		var form_serialize = $("#cartFrm").serialize();
		console.log(form_serialize);
		$.ajax({
			url:"<?=cdir()?>/dh_order/cart_deliv_calc",
			type:"post",
			data:form_serialize,
			cache:false,
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){
				delivery_price = data;

				$("#delivery_price").val(delivery_price);
				$(".devPrice").html(number_format(delivery_price,0)+"원");
				$(".tt-price em").html(number_format(parseInt(totalPrice)+parseInt(delivery_price),0));

			}
		});

	});
	*/

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
	var formCnt = <?=$frmCnt?>;
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
