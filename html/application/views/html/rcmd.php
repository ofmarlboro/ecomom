<?
	$PageName = "RCMD";
	$SubName = "";
	$PageTitle = "추천인 정보";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/my_top.php");?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">

				<div>
					<p class="myp_top">
				추천인 결제로 받은 보유 적립금은<span class="blue"><?=number_format($total_point->ttp)?></span>원 입니다.
				</p>

					<div class="tblTy01">
						<table>
							<tr>
								<th>추천인</th>
								<th>주문일</th>
								<th>내용</th>
								<th>결제 금액</th>
								<th>추천 적립금</th>
								<!-- <th>적립금 누계</th> -->
							</tr>
							<?php
							if($list){
								foreach($list as $lt){
								?>
								<tr>
									<td><?=$lt->name?></td>
									<td><?=date("Y년 m월 d일",strtotime($lt->trade_day))?></td>
									<td><?=$lt->gname?> <?=($lt->gt > 1)?"외 ".($lt->gt-1):"";?></td>
									<td><?=number_format($lt->total_price)?>원</td>
									<td><?=number_format($lt->point)?>원</td>
									<!-- <td>50,000원</td> -->
								</tr>
								<?php
								}
							}
							?>
						</table>
					</div>


					<!-- <div class="board-pager">
						 <button type="button">
						 <img width="8" height="8" alt="이전" src="/image/sub/btn_l.jpg">
						 </button>
						 <a class="on" href="">1</a>
						 <a class="" href="">2</a>
						 <a class="" href="">3</a>
						 <a class="" href="">4</a>
						 <a class="" href="">5</a>
						 <button type="button"><img width="8" height="8" alt="다음" src="/image/sub/btn_r.jpg">
						 </button>
						 </div> -->



				</div>



			</div>
		</div>


	</div><!--END Container-->


<? include('../include/footer.php') ?>

