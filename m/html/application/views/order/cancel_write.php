
			<!-- Shop Wrap -->
			<div class="shop-wrap">
		
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">
					<ul class="order-noti mb40">
						<li><em class="em">상품출고일 기준으로 7일 이내(평일기준)에 교환/반품이 가능합니다.</em></li>
						<li>고객님의 단순 변심에 의한 교환/반품의 경우, 배송비가 추가로 발생할 수 있습니다.</li>
						<li>상품명을 클릭하시면 제품에 대한 상세정보를 새창에서 확인하실 수 있습니다.</li>
						<li>반품/환불 처리완료 이후 복구는 불가능하며, 다시 상품을 구매하고 싶으시면 재주문 해 주셔야 합니다.</li>
					</ul>
					
					<!-- 반품/교환 상품 리스트 -->
					<h3 class="order-tit">취소 신청 상품</h3>
					<table class="shop-cart mb50">
						<caption>주문내역 리스트</caption>
						<thead>
							<tr>
								<!-- <th class="col-chk"><input type="checkbox"></th> -->
								<th class="col-df">상품코드</th>
								<th colspan="2">주문상품</th>
								<th class="col-date">주문일자</th>
								<th class="col-df">결제금액</th>
							</tr>
						</thead>
						<tbody>
							<tr>
							<? 
							$goods_cnt=0;
							foreach($goods_list as $lt){
								$goods_cnt++;
							?>
							<tr>
								<td><?=$lt->goods_code?></td>
								<!-- <td><input type="checkbox"></td> -->
								<td class="col-thumb"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt=""></td>
								<td>
									<div class="cart-prod">
										<p class="prod-name"><a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->goods_idx?>?&cate_no=<?=$lt->cate_no?>" target="_blank"><?=$lt->goods_name?></a></p>
										<p class="prod-op">										
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
											}
										}?>												
										</p>
									</div>
								</td>
								<td><?=substr($lt->trade_day,0,10)?></td>
								<td><?=number_format($lt->total_price)?>원</td>
							</tr>
							<?}?>
						</tbody>
					</table>
					<!-- END 반품/교환 상품 리스트 -->

					<form method="post" name="return_form" id="return_form">
					<input type="hidden" name="trade_stat" value="10">
					<!-- 반품/교환 신청서 -->
					<h3 class="order-tit"><?=$trade_name?> 신청서</h3>
					<table class="order-field">
						<caption><?=$trade_name?> 신청서</caption>
						<tbody>

							<tr>
								<th><label for="return_reason"><?=$trade_name?> 요청사유</label></th>
								<td>
									<textarea cols="30" rows="3" class="field-full" id="return_reason" name="return_reason" msg="<?=$trade_name?> 요청사유를"></textarea>
								</td>
							</tr>
							<tr>
								<th><label for="return-ct">기타 요청사항</label></th>
								<td><textarea cols="30" rows="3" class="field-full" id="return-ct" name="return_etc" placeholder="환불을 받으실 경우 계좌번호를 남겨 주세요."></textarea></td>
							</tr>
						</tbody>
					</table>
					<!-- END 반품/교환 신청서 -->
					</form>

				</div><!-- END 주문 Wrap -->


				<!-- 하단 버튼 -->
				<div class="align-c">
					<button type="button" class="btn-emp-border" onclick="window.history.back();">이전페이지로</button>
					<button type="button" class="btn-emp" onclick="frmChk('return_form')">신청하기</button>
				</div><!-- END 하단 버튼 -->
			
			
			</div><!-- END Shop Wrap -->
