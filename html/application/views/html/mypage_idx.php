<?
	$PageName = "MYPAGE_IDX";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/mypage_top.php");?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">
				<div class="near">
					<div class="my_tit">최근 주문내역</div>
					<div class="tblTy01">
						<table>
							<tr>
								<th>구분</th>
								<th>주문서 번호</th>
								<th>주문일시</th>
								<th>결제 금액</th>
								<th>배송현황</th>
								<th>비고</th>
							</tr>
							<?php
							if($list){
								foreach($list as $lt){
								?>
								<tr>
									<td>
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
									</td>
									<td>
										<p class="blue"><?=$lt->trade_code?></p>
										<?php
										$goods_row = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '".$lt->trade_code."' order by goods_idx asc, idx desc","result");
										foreach($goods_row as $key=>$gname){
											if($key == 0){
												echo $gname->goods_name;
												if(count($goods_row) > 1){
													$goods_cnt = count($goods_row)-1;
													echo " 외 ".$goods_cnt." 건";
												}
											}
										}
										?>
									</td>
									<td><?=date("y-m-d H:i",strtotime($lt->trade_day))?> (<?=numberToWeekname($lt->trade_day)?>)</td>
									<td><?=number_format($lt->total_price)?>원</td>
									<td><?=$shop_info['trade_stat'.$lt->trade_stat]?><!-- <p class="blue">우체국: 123456-7890</p> --></td>
									<td><a href="<?=cdir()?>/dh_order/shop_order_detail/<?=$lt->trade_code?>" class="<?=( ($lt->trade_stat > 1 and $lt->trade_stat < 4) and is_null($lt->sample_is) )?"btn_y":"btn_g";?>"><?=( ($lt->trade_stat > 1 and $lt->trade_stat < 4) and is_null($lt->sample_is) )?"주문확인 및 변경":"주문확인";?></a></td>
								</tr>
								<?php
								}
							}
							else{
							?>
							<tr>
								<td colspan="6">최근 주문 기록이 없습니다.</td>
							</tr>
							<?php
							}
							?>
							<?php
							/*
								<tr>
									<td>자유배송</td>
									<td><p class="blue">201701009005222</p>골라담기 [후기] 외 8건</td>
									<td>17-10-10 09:01 (화)</td>
									<td>100,000원</td>
									<td>배송중<p class="blue">우체국: 123456-7890</p></td>
									<td><a href="" class="btn_y">주문확인 및 변경</a></td>
								</tr>
								<tr>
									<td>정기배송</td>
									<td><p class="blue">201701009005222</p>골라담기 [후기] 외 8건</td>
									<td>17-10-10 09:01 (화)</td>
									<td>100,000원</td>
									<td>정기배송중</td>
									<td><a href="" class="btn_y">주문확인 및 변경</a></td>
								</tr>
								<tr>
									<td>자유배송</td>
									<td><p class="blue">201701009005222</p>골라담기 [후기] 외 8건</td>
									<td>17-10-10 09:01 (화)</td>
									<td>100,000원</td>
									<td>입금대기중</td>
									<td><a href="" class="btn_g">주문확인</a></td>
								</tr>
							*/
							?>
						</table>
					</div>
					<a href="<?=$ORDERLIST->url?>" class="btn_more">더보기</a>
				</div>
				<div class="notice fl">
					<div class="my_tit">산골알림장</div>
					<ul class="mnoti">
						<?php
						if($notice){
							foreach($notice as $nt){
							?>
							<li>
								<a href="<?=cdir()?>/dh_board/views/<?=$nt->idx?>">
									<p class="tit"><?=$nt->subject?></p>
									<p class="date"><?=$nt->reg_date?></p>
								</a>
							</li>
							<?php
							}
						}
						?>

						<?php
						/*
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						*/
						?>
					</ul>
					<a href="<?=cdir()?>/dh_board/lists/withcons01/" class="btn_more">더보기</a>
				</div>
				<div class="ponp fr">
					<div class="my_tit">1:1 문의</div>
					<ul class="mnoti">
						<?php
						if($qna){
							foreach($qna as $qa){
							?>
							<li>
								<a href="<?=cdir()?>/dh_board/views/<?=$qa->idx?>/?myqna=Y">
									<p class="tit"><?=$qa->subject?></p>
									<p class="date"><?=$qa->reg_date?></p>
								</a>
							</li>
							<?php
							}
						}
						?>

						<?php
						/*
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						<li>
							<a href="#">
								<p class="tit">2017년 전국 이민자 사회통합 프로그램 운영 관계자 워크숍 개최...</p>
								<p class="date">2018-01-03</p>
							</a>
						</li>
						*/
						?>
					</ul>

					<a href="<?=cdir()?>/dh_board/lists/withcons07/?myqna=Y" class="btn_more">더보기</a>
				</div>

			</div>
		</div>


	</div><!--END Container-->


<? include('../include/footer.php') ?>

