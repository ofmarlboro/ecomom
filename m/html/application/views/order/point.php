		<div class="inner mypage">
		<h1>적립금</h1>
				<p class="orderedit_top">
					“<span><?=$this->session->userdata('NAME')?></span>”님의 보유 적립금은 <span class="blue"><?=number_format($total_point)?></span>원 입니다.
				</p>
				<div class="tblTy02">
					<table>
						<tr>
							<th>일시</th>
							<th>내용</th>
							<th>적립금<br>획득</th>
							<th>적립금<br>사용</th>
							<!-- <th>적립금<br>누계</th> -->
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
									<!-- <td>12,000원</td> -->
								</tr>
								<?php
							}
						}
						else{
							?>
							<tr>
								<td colspan="4">적립금 내역이 없습니다.</td>
							</tr>
							<?php
						}
						?>



						<!-- <tr>
							<td colspan="5">적립금 내역이 없습니다.</td>
						</tr> -->

					</table>
				</div>

				<?php
				if(count($list) > 0){
				?>
					<!-- Pager -->
					<p class="board-pager align-c mt10" title="페이지 이동하기">
						<?=$Page?>
					</p><!-- END Pager -->
				<?php
				}
				?>

		</div>