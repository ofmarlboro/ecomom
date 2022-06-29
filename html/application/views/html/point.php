<?
	$PageName = "POINT";
	$SubName = "";
	$PageTitle = "적립금";
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
					“<span><?=$this->session->userdata('NAME')?></span>”님의 보유 적립금은 <span class="blue"><?=number_format($total_point)?></span>원 입니다.
				</p>
				<div class="tblTy01">
					<table>
						<tr>
							<th>일시</th>
							<th>내용</th>
							<th>적립금 획득</th>
							<th>적립금 사용</th>
							<!-- <th>적립금 누계</th> -->
						</tr>
						<?php
						if($list){
							foreach($list as $lt){
							?>
							<tr>
								<td><?=date('Y년 m월 d일',strtotime($lt->reg_date))?></td>
								<td class="al"><?=$lt->content?></td>
								<td><?=($lt->point > 0)?number_format($lt->point)."원":"-";?></td>
								<td><?=($lt->point < 0)?number_format($lt->point)."원":"-";?></td>
								<!-- <td><?=number_format($point_clac)?>원</td> -->
							</tr>
							<?php
							}
						}
						else{
						?>
						<tr>
							<td colspan="5">적립금 내역이 없습니다.</td>
						</tr>
						<?php
						}
						?>
						<!-- <tr>
							<td>2018년 2월 20일</td>
							<td class="al">추천인 : "애기맘마"님 결제 10% 적립</td>
							<td>100,000원</td>
							<td>-</td>
							<td>12,000원</td>
						</tr>
						<tr>
							<td>2018년 2월 20일</td>
							<td class="al">추천인 : "애기맘마"님 결제 10% 적립</td>
							<td>100,000원</td>
							<td>5,000원</td>
							<td>12,000원</td>
						</tr> -->
					</table>
				</div>

				<?php
				if(count($list) > 0){
				?>
					<!-- Pager -->
					<p class="board-pager align-c" title="페이지 이동하기">
						<?=$Page?>
					</p><!-- END Pager -->
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
