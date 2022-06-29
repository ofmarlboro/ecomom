<?
	$PageName = "DEPOSIT";
	$SubName = "";
	$PageTitle = "예치금";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
	$(function(){
    $(".datepicker").datepicker({
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			dayNamesMin: ['일','월','화','수','목','금','토'],
			weekHeader: 'Wk',
			dateFormat: 'yy-mm-dd', //형식(20120303)
			autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)
			changeMonth: true, //월변경가능
			changeYear: true, //년변경가능
			showMonthAfterYear: true, //년 뒤에 월 표시
    });
	});

	function set_frm_date(sdate,edate){
		frm = document.schfrm;

		frm.sdate.value = sdate;
		frm.edate.value = edate;
	}

	function set_frm_type(type){
		frm = document.schfrm;

		frm.type.value = type;
		frm.submit();
	}

	function search_send(){
		frm = document.schfrm;

		if(frm.sdate.value == ''){
			alert("조회하실 날짜를 입력해주세요.");
			return;
		}

		if(frm.edate.value == ''){
			alert("조회하실 날짜를 입력해주세요.");
			return;
		}

		frm.submit();
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

				<form name="schfrm" id="schfrm">
				<input type="hidden" name="type" value="<?=$this->input->get('type')?>">

        <div class="deposit-form">
          <div class="deposit-form__btns">
            <p>조회기간</p>
            <button type="button" onclick="set_frm_date('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')">오늘</button>
            <button type="button" onclick="set_frm_date('<?=date("Y-m-d",strtotime('-7 day'))?>','<?=date("Y-m-d")?>')">7일</button>
            <button type="button" onclick="set_frm_date('<?=date("Y-m-d",strtotime('-30 day'))?>','<?=date("Y-m-d")?>')">1개월</button>
            <button type="button" onclick="set_frm_date('<?=date("Y-m-d",strtotime('-90 day'))?>','<?=date("Y-m-d")?>')">3개월</button>
          </div>

          <div class="deposit-form__date">
            <input type="text" class="deposit-picker datepicker" name="sdate" value="<?=$this->input->get('sdate')?$this->input->get('sdate'):''?>" size="10"> <img src="/image/sub/cal_icon.png" alt="">&nbsp;~&nbsp;
            <input type="text" class="deposit-picker datepicker" name="edate" value="<?=$this->input->get('edate')?$this->input->get('edate'):''?>" size="10"> <img src="/image/sub/cal_icon.png" alt="">
          </div>

          <button type="button" class="deposit-from__btn" onclick="search_send()">조회하기</button>
        </div>

				</form>


        <nav class="deposit-tab">
          <a href="javascript: set_frm_type('all');" class="<?=$this->input->get('type')=='all'||$this->input->get('type')==''?"active":""?>">전체</a>
          <a href="javascript: set_frm_type('pl');" class="<?=$this->input->get('type')=='pl'?"active":""?>">적립내역</a>
          <a href="javascript: set_frm_type('mn');" class="<?=$this->input->get('type')=='mn'?"active":""?>">사용내역</a>
        </nav>

        <div class="tblTy01">
          <table>
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
								<td><?=$lt->trade_code?"주문번호 : ".$lt->trade_code:"-"?></td>
								<td><?=$lt->point>0?"+":""?><?=$lt->point?>원</td>
								<td><?=date('Y.m.d',strtotime($lt->reg_date))?></td>
							</tr>
							<?php
						}

						if(count($list) <= 0){
							?>
							<tr>
								<td colspan="4">등록된 내용이 없습니다.</td>
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