<?
	$PageName = "DEPOSIT";
	$SubName = "";
	$PageTitle = "예치금";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->
<div id="container">
  <?include("../include/top_menu.php");?>
  <?include("../include/mypage_top02.php");?>

  <div class="mypage">

		<div class="deposit-top">
			<h1>예치금</h1>
			<p>
				결제를 가장 편리하고 빠르게 할 수 있는 방법
			</p>
		</div>

		<div class="inner">
		

    <ol class="deposit-check">
      <li>
        ✓ 산골이유식 쇼핑몰에서 상품 구입시 현금과 동일하게 <br>사용가능한 적립금입니다
      </li>
      <li>
        ✓ 결제 시 현금(예치금1원=현금1원)처럼 사용 가능합니다.
      </li>
      <li>
        ✓ 산골이유식 본사 홈페이지 아이디를 기준으로 결제가 가능합니다.
      </li>
      <li>
        ✓ 예치금 유효기간이 없으며, 환불 신청 가능합니다.
      </li>
    </ol>

    <button type="button" class="deposit-charge-btn">충전하기</button>

    <div class="deposit-current">
      <div class="deposit-current__text">사용가능 예치금</div>
      <div class="deposit-current__money"><strong><?=number_format($total_deposit)?></strong>원</div>
    </div>

		<p class="deposit-tit float-l">
			예치금 사용내역
		</p>

		<p class="float-r">
			<a href="<?=cdir()?>/dh/deposit_list">내역보기</a>
		</p>

    <div class="tblTy02">
      <table>
        <colgroup>
          <col width="45px">
          <col width="auto">
          <col width="60px">
          <col width="auto">
        </colgroup>
        <tr>
          <th>구분</th>
          <th>상세내역</th>
          <th>금액</th>
          <th>발생일</th>
        </tr>

				<?php
				foreach($list as $lt){
					?>
					<tr>
						<td><?=$lt->content?></td>
						<td><?=$lt->trade_code?"주문번호 : ".$lt->trade_code:$lt->content?></td>
						<td><?=$lt->point>0?"+":""?><?=$lt->point?>원</td>
						<td><?=date('Y.m.d',strtotime($lt->reg_date))?></td>
					</tr>
					<?php
				}
				?>
      </table>
    </div>

		<p class="mt20"></p>

		<p class="deposit-tit float-l">예치금 환불내역</p>
		<p class="float-r">
			<a href="<?=cdir()?>/dh/deposit_return">내역보기</a>
		</p>

    <div class="tblTy02 fz12">
      <table>
        <colgroup>
          <col width="60px">
          <col width="auto">
          <col width="60px">
          <col width="60px">
          <col width="75px">
        </colgroup>
        <tr>
          <th>환불내역</th>
          <th>상세내역</th>
          <th>금액</th>
          <th>발생일</th>
          <th>승인내역</th>
        </tr>
				<?php
				foreach($return_list as $lt){
					?>
					<tr>
						<td><?=$lt->state=="승인대기"?"환불신청":"환불완료"?></td>
						<td><?=$lt->return_bank?> <?=$lt->return_account?> <?=$lt->return_accname?></td>
						<td><?=number_format($lt->return_deposit)?>원</td>
						<td><?=date("Y.m.d",strtotime($lt->wdate))?></td>
						<td><?=$lt->state?></td>
					</tr>
					<?php
				}
				?>
      </table>
    </div>

    <div class="deposit-warn">
      <p>예치금 적립 주문 취소등의 환불금액 발생 시 적립금으로 적립되니 참고 부탁드립니다.</p>
      <p>베이비페어 포인트판매는 예치금이 아닌 포인트이므로 7일 이 후 환불 불가합니다.</p>
      <p>주문 취소로 인한 예치금 적립시 무통장입금은 부분 취소금액 전액이 입금되며, <br>카드결제 및 휴대폰 결제는 취소 수수료 2.6%를 제외한 금액이 입금됩니다.</p>
      <p>환불 : 본인계좌 및 입금계좌로만 가능하며, 신청하신 날로부터 2-3일 내에 환불금액이 입금됩니다.(영업일 기준)</p>
    </div>


		<div class="tblTy02 tal">
				<p class="deposit-tit float-l">산골이유식 예치금 / 포인트 정책안내</p>
				<table>
					<colgroup>
						<col width="90px"/>
						<col width="auto"/>
					</colgroup>
            <tr>
              <th></th>
              <th>예치금</th>
            </tr>

						<tr>
							<td><strong>유효기간</strong></td>
							<td>없음</td>
						</tr>

						<tr>
							<td><strong>상품구매</strong></td>
							<td>산골이유식 홈페이지 내, 모든상품가능</td>
						</tr>

						<tr>
							<td><strong>적립방법</strong></td>
							<td>
								예치금 적립은, 고객과함께 > [예치금] 안내 혹은, 마이페이지> 예치금에서  
[충전하기]를 통해 예치금 적립 및 관리가 가능합니다 <br>
가상계좌금액과 동일하게 예치금 내역에서 확인가능 합니다
							</td>
						</tr>

						<tr>
							<td><strong>사용방법</strong></td>
							<td>
							* 현금 1원 = 예치금 1원과 동일하며, 제한 없이 사용가능합니다.<br>
* 포인트와 함께 사용가능합니다. <br />
* 예치금 부족으로 인해 결제가 안될 시 추가적립 후 결제 가능합니다
							</td>
						</tr>

						<tr>
							<td><strong>상시 이벤트<br>안내</strong></td>
							<td>
								* 예치금 이벤트 안내 <br />
   예치금 50만원 적립 시, 1만원 포인트 지급 <br /> 
* 예치금 50만원 사용 중, 중도 환불 요청 시 포인트는 환급됩니다 <br />
   만약, 포인트 금액을 이미 사용한 경우 예치금에서 사용된 포인트만큼 
   차감되어 환불됩니다. 
							</td>
						</tr>

						<tr>
							<td><strong>취소/환불</strong></td>
							<td>
							* 포인트를 제외한 현금(카드) 결제수단으로 구매한 고객의 경우,
   환불을 요청 할 시(CS건), 예치금으로 적립가능합니다. <br />
* 예치금으로만 구매 시 예치금으로 환불 가능합니다. <br />
   단, 구매자 본인신청 및 본인계좌로만 가능합니다. <br />
* 예치금과 포인트 중복 사용시 부분취소 경우,부분취소는 
   하기 가이드에 따라 수기로 진행 되므로, 다소 2-3일 시일이 걸릴 수 
   있는 점 꼭 참고 부탁드립니다. <br />
1) 부분취소금액이 포인트 금액을 넘지 않을 경우, 포인트로 수기 지급합니다 <br />
2) 부분취소금액이 포인트 금액을 넘을 경우, 사용된 예치금으로 일부 지급 
    수기로 가능합니다. 
							</td>
						</tr>
          </table>
					<table>
					<colgroup>
						<col width="90px"/>
						<col width="auto"/>
					</colgroup>
            <tr>
              <th></th>
              <th>포인트</th>
            </tr>

						<tr>
							<td><strong>유효기간</strong></td>
							<td>지급일로부터 1년</td>
						</tr>

						<tr>
							<td><strong>상품구매</strong></td>
							<td>산골이유식 홈페이지 내, 모든상품가능</td>
						</tr>

						<tr>
							<td><strong>적립방법</strong></td>
							<td>
								포인트 및 쿠폰은 산골이유식 자사 홈페이지 이벤트 및
프로모션 참여 시 감사한 마음을 전하기 위해 포인트가 지급됩니다

							</td>
						</tr>

						<tr>
							<td><strong>사용방법</strong></td>
							<td>
							*포인트는 1000원이상 부터 사용가능합니다 <br />
*포인트는 자사 홈페이지 모든 상품 구매가 가능하며, 구매금액의 최대 30%까지 사용가능합니다  
							</td>
						</tr>

						<tr>
							<td><strong>상시 이벤트<br>안내</strong></td>
							<td>
								* 신규회원 가입 시, 1000원 포인트 적립 <br />
* 신규회원 가입 시, 추천인 ID 이벤트 10% 포인트 적립 <br />
* 회원등급에 따른 금/은/동 구매시마다, 포인트 적립 <br />
  - 금 : 120만원 이상 주문고객, 구매시 마다 3% 적립 <br />
  - 은 : 60만원 이상 주문고객, 구매시 마다 2%적립 <br />
  - 동 : 60만원 미만 주문고객, 구매시 마다 1%적립 <br />
* 단계별 연속 정기배송 완료 시, 땡큐포인트 최대 10만원 포인트 적립 <br />
* 리뷰/후기 이벤트 당첨 시 포인트 적립 <br />
* 이 외 기타 이벤트 및 프로모션 관련 포인트 적립
							</td>
						</tr>

						<tr>
							<td><strong>취소/환불</strong></td>
							<td>
							* 구매금액의 일부 포인트로 결제 시 ,포인트로만 환불 가능합니다. <br />
  단,(배송비,포장비,이벤트실비 제외)된 금액으로 환불되니 
  꼭 유념 부탁드립니다. <br />
* 구매시점으로 부터,  안내된 취소시점 및 포인트 유효기간이 지날 시 
  취소가 불가능한 점 꼭 유념 부탁드립니다.
							</td>
						</tr>
          </table>
					</div>


    <!-- 예치금 팝업 -->
		<?php
		include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/order/deposit_inc.php";
		?>
    <!-- //예치금 팝업 -->

  </div>
  <!-- inner -->
	</div>
</div>
<!--END Container-->

<div class="mg95"></div>

<? include('../include/footer.php') ?>