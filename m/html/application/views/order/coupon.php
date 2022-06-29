	<div class="inner mypage">
		<h1>쿠폰</h1>
		<p class="orderedit_top"> “<span><?=$this->session->userdata('NAME')?></span>”님이 사용하실 수 있는 쿠폰은 <span class="blue"><?=number_format($totalCnt)?></span>개 입니다. </p>
		<div class="tblTy02">
			<table>
				<tr>
					<th>쿠폰명</th>
					<th>쿠폰코드</th>
					<th>할인혜택</th>
					<!-- <th>사용조건</th> -->
					<th>발급일자</th>
					<th>유효기간</th>
				</tr>
				<?php
				if($list){
					foreach($list as $lt){
						?>
						<tr>
							<td><?=$lt->name?></td>
							<td><?=$lt->code?></td>
							<td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
							<!-- <td>100,000원 이상 결제시 사용</td> -->
							<td><?=date("Y년 m월 d일",strtotime($lt->reg_date))?></td>
							<td><?=date("Y년 m월 d일",strtotime($lt->end_date))?></td>
						</tr>
						<?php
					}
				}
				else{
					?>
					<tr><td colspan="6">등록된 쿠폰이 없습니다.</td></tr>
					<?php
				}
				?>
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


		<div class="coupon_register mt50">
			<div class="point-now shop-inner">
				<p class="tit"><strong class="dh_black">쿠폰등록</strong></p>
				<div class="couponFrm">
					<form name="cfrm" id="cfrm" method="post">
						<input type="text" name="coupon_code" msg="쿠폰번호를 입력해주세요." class="img-mid">
						<input type="button" value="쿠폰등록" onclick="frmChk('cfrm')" class="btnCoupon">
					</form>
				</div>
			</div>
		</div>
	</div>