	<div class="inner mypage">
		<h1>주문배송조회</h1>
		<h2>최근주문내역</h2>
		<!-- <div class="red ac">최근 주문내역 변경이 적용되었습니다.</div> -->
		<?php
		if($list){
			foreach($list as $lt){
			?>
			<div class="tblTy01 mt10">
				<table>
					<tr>
						<th>주문서번호</th>
						<td>

							<?php
							if($lt->trade_stat <= 4){
								?>
								<a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code.$query_string.$param?>">
								<?php
							}
							else{
								?>
								<a href="javascript:void(0);">
								<?php
							}
							?>

								<span class="blue"><?=$lt->trade_code?></span><br>
								<?php
								if($lt->recom_is == "Y"){
									echo "정기배송";
								}
								else if($lt->sample_is == "Y"){
									echo "샘플신청";
								}
								else{
									echo "일반주문";
								}
								?>
								<?php
								$goods_row = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '".$lt->trade_code."' order by goods_idx asc, idx desc","result");
								foreach($goods_row as $key=>$gname){
									if($key == 0){
										if(strpos($gname->goods_name,":")!==false){
											$goods_name_arr = explode(":",$gname->goods_name);
											echo "[".trim($goods_name_arr[1])."]";
										}
										else{
											echo $gname->goods_name;
										}

										if(count($goods_row) > 1){
											$goods_cnt = count($goods_row)-1;
											echo " 외 ".$goods_cnt." 건";
										}
									}
								}
								?>
							</a>
						</td>
						<td colspan="2"><em><?=number_format($lt->total_price)?></em>원</td>
					</tr>
					<tr>
						<td class="bg link" colspan="3">
							<?php
							if($lt->trade_stat > 4){
									echo $shop_info['trade_stat'.$lt->trade_stat];
							}
							else{
								if($lt->newzip == 'deposit'){
									?>
									<span class="link01 <?=($lt->trade_stat==1)?"on":"";?>"><img src="/image/sub/link01.png" alt="" class="icon">입금대기중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
									<span class="link02 <?=($lt->trade_stat==2)?"on":"";?>"><img src="/image/sub/link04.png" alt="" class="icon">충전완료</span>
									<?php
								}
								else{
									?>
									<span class="link01 <?=($lt->trade_stat==1)?"on":"";?>"><img src="/image/sub/link01.png" alt="" class="icon">입금대기중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
									<span class="link02 <?=($lt->trade_stat==2)?"on":"";?>"><img src="/image/sub/link02.png" alt="" class="icon">배송준비중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
									<span class="link03 <?=($lt->trade_stat==3)?"on":"";?>"><img src="/image/sub/link03.png" alt="" class="icon">배송중<img src="/image/sub/arw01.png" alt="" class="arw"></span>
									<span class="link04 <?=($lt->trade_stat==4)?"on":"";?>"><img src="/image/sub/link04.png" alt="" class="icon">배송완료</span>
									<?php
								}
							}
							?>
						</td>
					</tr>
					<!-- <tr>
						<th>운송장번호</th>
						<td colspan="2"><span class="blue">우체국 : 20156225522155</span></td>
					</tr> -->
					<tr>
						<th>주문일시</th>
						<td colspan="2"><?=date("y-m-d",strtotime($lt->trade_day))?></td>
					</tr>
				</table>
			</div>
			<?php
			}
		}
		?>
	</div>


	<? $self_url = str_replace("/index.php","",$_SERVER['PHP_SELF']); ?>

			<script>
			function cancel(trade_code,trade_method,tno)
			{
				if(confirm("주문을 취소하시겠습니까?")){

					if(trade_method==1){
						card_cancel(trade_code,tno);
					}else{
						location.href="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/list/<?=$query_string.$param?>";
					}
				}
			}

			function search_day(num)
			{
				location.href="<?=$self_url?>?search_day="+num;
			}
			</script>

<? include $shop_info['pg_company']."_cancel.php"; ?>
