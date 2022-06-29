<?
	$PageName = "DEPOSIT";
	$SubName = "";
	$PageTitle = "예치금";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
	function send_return(){
		frm = document.return_frm;

		if(frm.return_deposit.value == ''){
			alert("환불요청액을 입력해주세요.");
			frm.return_deposit.focus();
			return;
		}

		if(frm.return_bank.value == ''){
			alert("환불금액을 입금받으실 은행명을 입력해주세요.");
			frm.return_bank.focus();
			return;
		}
		if(frm.return_account.value == ''){
			alert("환불금액을 입금받으실 계좌번호를 입력해주세요.");
			frm.return_account.focus();
			return;
		}
		if(frm.return_accname.value == ''){
			alert("환불금액을 입금받으실 계좌의 예금주 성명을 입력해주세요.");
			frm.return_accname.focus();
			return;
		}

		if(confirm('환불 신청을 진행 하시겠습니까?')){
			frm.submit();
		}
	}

	function deposit_return_chk(value){
		max_deposit = parseInt("<?=$total_deposit?>");

		input_value = uncomma(value);

		if(max_deposit < parseInt(input_value)){
			alert("보유하신 예치금을 초과 하였습니다.");

			if(max_deposit <= 0){
				$("input[name='return_deposit']").val('0');
			}
			else{
				$("input[name='return_deposit']").val(add_comma(max_deposit));
			}

			return;
		}
	}
</script>

<!--Container-->
<div id="container">
  <?include("../include/my_top.php");?>
  <div class="inner clearfix">
    <?include("../include/mypage_lnb.php");?>

    <div class="my_cont clearfix">
      <div>
        <ol class="deposit-check">
          <li>
            ✓ 산골이유식 쇼핑몰에서 상품 구입시 현금과 동일하게 사용가능한 적립금입니다
          </li>
          <li>
            ✓ 상품 결제시 현금(예치금 1원 = 현금1원)처럼 사용하실 수 있습니다.
          </li>
          <li>
            ✓ 산골이유식 본사 홈페이지 아이디를 기준으로 결제가 가능합니다.
          </li>
          <li class="deposit-check__emp">
            ✓ 예치금 유효기간이 없으며, 환불 신청 가능합니다.
          </li>
        </ol>

        <button type="button" class="deposit-charge-btn">충전하기</button>

        <div class="deposit-current">
          <div class="deposit-current__text">사용가능 예치금</div>
          <div class="deposit-current__money"><strong><?=number_format($total_deposit)?></strong>원</div>
        </div>

        <p class="deposit-tit">예치금 환불신청</p>
				<p class="deposit-msg">✓ 본인명의의 계좌 및 입금계좌로만 환불신청이 가능합니다. </p>
				<p class="deposit-msg">✓ 예치금포인트는 환불신청 시점으로 바로 적용되나 환불금액은 영업일 기준 2~3일 이후 입금되니 이 점 유의하시고 환불 진행 바랍니다. </p>


				<form method="post" name="return_frm" id="return_frm">

        <div class="deposit-form">
          <div class="deposit-form__input">
            <p>환불요청액</p>
            <input type="text" name="return_deposit" onkeyup="deposit_return_chk(this.value); inputNumberFormat(this)">원
          </div>

          <div class="deposit-form__input">
            <p>입금받을 계좌</p>
            <!-- <select name="" id="">
              <option value="">선택</option>
              <option value="">신한은행</option>
            </select> -->
						<input type="text" placeholder="은행명" name="return_bank">
            <input type="text" placeholder="계좌번호" class="long" name="return_account">
            <input type="text" placeholder="예금주" name="return_accname">
          </div>

          <button type="button" class="deposit-from__btn" onclick="send_return()">환불신청</button>
        </div>

				</form>


        <div class="tblTy01">
          <table>
            <tr>
              <th>환불내역</th>
              <th>상세내역</th>
              <th>금액</th>
              <th>발생일</th>
              <th>승인내역</th>
            </tr>

						<?php
						foreach($list as $lt){
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

				<?php
				if($totalCnt > 0){
					?>
					<p class="board-pager align-c" title="페이지 이동하기">
						<?=$Page?>
					</p>
					<?php
				}
				?>

        <div class="deposit-warn">
          <p>예치금 적립 주문 취소등의 환불금액 발생 시 적립금으로 적립되니 참고 부탁드립니다.</p>
          <p>적립금 : 이유식과 간식만 주문가능하며, 이 외 [협업상품(예: 오산골농부 농산물)]은 구매가 불가능합니다.</p>
          <p>예치금 : 모든 상품 구매 가능합니다.</p>
          <p>베이비페어 포인트판매는 예치금이 아닌 포인트이므로 7일 이 후 환불 불가합니다.</p>
          <p>주문 취소로 인한 예치금 적립시 무통장입금은 부분 취소금액 전액이 입금되며, <br>카드결제 및 휴대폰 결제는 취소 수수료 2.6%를 제외한 금액이 입금됩니다.</p>
          <p>환불 : 본인계좌 및 입금계좌로만 가능하며, 신청하신 날로부터 2-3일 내에 환불금액이 입금됩니다.(영업일 기준)</p>
        </div>


        <!-- 예치금 팝업 -->
				<?php
				include $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/deposit_inc.php";
				?>
        <!-- //예치금 팝업 -->

      </div>
    </div>
  </div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>