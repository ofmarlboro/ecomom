<style>
	.tys04 {width: 100%;text-align: center;}
	.tys04 th {background: #F7F7F7;}
	.tys04 * {	border: 1px solid #E2E2E2;height: 35px;}
	.tys04 tbody th {background-color: #E9EDF0;	border-color: #DBE2E4;}
	.tys04 tbody tr:last-child * {border-bottom: 1px solid #000;}
	.tys04 tfoot th {height: 35px;padding: 0;border-bottom: 1px solid #000;background: #F0F0F0;}
	.tys04 tfoot th:first-child {border-left: 1px solid #000;}
	.tys04 tfoot th:last-child {border-right: 1px solid #000;}
	.tys04 .red {color: #D5011A;}
	.bdl {border-left: 1px solid #000;}
	.bdr {border-right: 1px solid #000;}
	.bdb {	border-bottom: 1px solid #000;}
	.tys03 {width: 85%;margin: 0 auto;}
	.excel {color: #fff;background: #499FEA;margin-bottom: 10px;width: 150px;height: 40px;}
	.tys03 {border-top: 70px solid #F8F9FB;}
	.tys03 th span {font-weight: bold;font-size: 15px;position: absolute;top: -30px;left: 0;right: 0;text-align: center;}
	.tys03 th {	position: relative;height: 500px;background: #F2F3F5;border-right: 10px solid #F8F9FB;border-bottom: 1px solid red;}
	.tys03 th:last-child {border-right: 0;}
	.yellow_box {position: absolute;bottom: 0;left: 0;right: 0;background: #FFC853;}
	.brown_box {position: absolute;bottom: 0;left: 0;right: 0;background: #BCA061;}
	.tys02 {font-size: 16px;font-weight: bold;}
	.tys02 th {	background: #D7E1E3;height: 50px;border: 1px solid #D7E1E3;}
	.tys02 td {border-top: 1px solid #CACACA;border-bottom: 1px solid #CACACA;padding-left: 20px;}
</style>

<script type="text/javascript">
	//날짜 자동 입력
	function set_date_val(sd, ed,mode){
		$("#start_date").val(sd);
		$("#end_date").val(ed);
		$("#date_mode").val(mode);

		if(mode!=""){
			$(".search-area").hide();
			if(mode=="day"){
				$("span.day").show();
			}
			else if(mode=="month"){
				$("span.month").show();
			}
		}
	}

	function excel_down(){
		$("#excel").val("ok");
		$("#ajax").val("1");
		$("#date_set").submit();
	}
</script>

<form name="date_set" id="date_set">
	<table class="adm-table">
		<caption>

		</caption>
		<colgroup>
		<col style="width:15%;">
		<col>
		</colgroup>
		<tbody>
			<tr>
				<th style="font-size: 16px;color: #000;font-weight: bold;"> 주문일 </th>
				<td>
					<input type="hidden" name="date_mode" id="date_mode" value="day">
					<input type="hidden" name="excel" id="excel">
					<input type="hidden" name="ajax" id="ajax">

					<span class="search-area day" <?if($this->input->get('date_mode')!='day'){?>style="display:none;"<?}?>>
						<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d", strtotime('-6 days')) ;?>" readonly> ~
						<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d") ;?>" readonly>
					</span>

					<span class="search-area month" <?if($this->input->get('date_mode')!='month'){?>style="display:none;"<?}?>>
						<select name="sch_year">
							<option value="">연도</option>
							<?php
							for($i=$min_year->year;$i<=date("Y");$i++){
								?>
								<option value="<?=$i?>"><?=$i?></option>
								<?php
							}
							?>
						</select>
					</span>

					<span>
						<button type="button" class="btn-clear" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>','day')">오늘</button>
						<button type="button" class="btn-clear" onclick="set_date_val('<?=date("Y-m-d", strtotime('-6 days'))?>','<?=date("Y-m-d")?>','day')">일주일</button>
						<button type="button" class="btn-clear" onclick="set_date_val('<?=date("Y-m-d", strtotime('-29 days'))?>','<?=date("Y-m-d")?>','day')">한달</button>
						<button type="button" class="btn-clear" onclick="set_date_val('<?=date("Y-m-01",strtotime('-5 months'))?>','<?=date("Y-m-01")?>','month')">월별</button>
						<button type="button" class="btn-clear" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>','year')">연간</button>
						<button class="ml20" onclick="frmChk('date_set')">검색하기</button></td>
					</span>
			</tr>
		</tbody>
	</table>
</form>

<?
$total_payment = 0;
$total_order_cnt = 0;
$total_order_ok_cnt = 0;
$total_order_cc = 0;

$graph = array();

$date_mode=$this->input->get('date_mode');
if($date_mode==""){
	$date_mode="day";
}

foreach($orders as $od){

	if($date_mode=="day"){
		$trade_day=$od[trade_day];
	}
	else if($date_mode=="month"){
		$trade_day=date("Y-m",strtotime($od[trade_day]));
	}
	else if($date_mode=="year"){
		$trade_day=date("Y",strtotime($od[trade_day]));
	}

	if($od[trade_stat] <= 4){

		$graph[$trade_day][total_payment]+=$od[total_price];

		$total_payment+=$od[total_price];
		$total_order_cnt++;
		if($od[trade_stat] > 1 and $od[trade_stat] <= 4){
			$total_order_ok_cnt++;
		}

	}
	else if($od[trade_stat] >= 9){
		$total_order_cc++;
		$graph[$trade_day][total_cc_payment]+=$od[total_price];
	}
}
?>

<table class="tys02 mt30">
	<colgroup>
	<col width="160px">
	<col width="240px">
	<col width="160px">
	<col width="240px">
	<col width="160px">
	<col width="240px">
	<col width="160px">
	<col width="240px">
	</colgroup>
	<tr>
		<th>총 결제금액</th>
		<td><?=number_format($total_payment)?></td>
		<th>총 주문건수</th>
		<td><?=number_format($total_order_cnt+$total_order_cc)?></td>
		<th>총 결제완료건</th>
		<td><?=number_format($total_order_ok_cnt)?></td>
		<th>총 주문취소</th>
		<td><?=number_format($total_order_cc)?></td>
	</tr>
</table>

<table class="tys03 mt50">
	<colgroup>
		<?php
		$arr_cnt = count($graph);
		$wid_per = round(100/$arr_cnt,2);

		if($date_mode=="day"){
			$max_total_pay = 70000000;
		}
		else if($date_mode=="month"){
			$max_total_pay = 700000000;
		}
		else if($date_mode=="year"){
			$max_total_pay = 7000000000;
		}



		for($i=1;$i<=$arr_cnt;$i++){
			?>
			<col width="<?=$wid_per?>%">
			<?php
		}
		?>
	</colgroup>

	<tr>
		<?php
		foreach($graph as $tdate=>$gp){
			$yellow = 100-round(($gp[total_payment]/$max_total_pay)*100);
			$brown = 100-round(($gp[total_cc_payment]/$max_total_pay)*100);
			?>
			<th>
				<div class="yellow_box" style="top: <?=$yellow?>%;"><?if($arr_cnt <= 7){?><span><?=number_format($gp[total_payment])?></span><?}?></div>
				<div class="brown_box" style="top: <?=$brown?>%"><?if($arr_cnt <= 7){?><span><?=number_format($gp[total_cc_payment])?></span><?}?></div>
				<div class="brown_box" style="top: 100%;"><?if($arr_cnt <= 7){?><?=$tdate?><?}else{ echo numberToWeekname($tdate); echo "<BR>"; echo date("d",strtotime($tdate)); }?></div>
			</th>
			<?php
		}
		?>
	</tr>
</table>
<div class="fr mt50">
	<button class="excel" onclick="excel_down()">엑셀 다운로드</button>
</div>

<?php
/*
$date_total_price=0;	//일자별 주문총액
$trade_method1_price=0;	//신용카드
$trade_method2_price=0;	//무통장
$trade_method3_price=0;	//계좌이체
$trade_method4_price=0;	//가상계좌
$trade_method5_price=0;	//포인트
$trade_method7_price=0;	//휴대폰
//쿠폰
//가상계좌 차후 추가할듯
$date_total_ccprice=0;	//일자별 취소총액

$date_total_order_cnt=0;	//일자별 주문 총 건수
$date_total_ordercc_cnt=0;	//일자발 취소 총 건수
$m1_cnt=0;	//신용카드 총 건수
$m2_cnt=0;	//무통장 총 건수
$m3_cnt=0;	//계좌이체 총 건수
$m4_cnt=0;	//가상계좌 총 건수
$m5_cnt=0;	//포인트 총 건수
$m7_cnt=0;	//휴대폰 총 건수
*/

$order_list = array();

foreach($orders as $dt){

	if($date_mode=="day"){
		$trade_day=$dt[trade_day];
	}
	else if($date_mode=="month"){
		$trade_day=date("Y-m",strtotime($dt[trade_day]));
	}
	else if($date_mode=="year"){
		$trade_day=date("Y",strtotime($dt[trade_day]));
	}

	if($dt[trade_stat] <= 4){	//주문 , 입금, 배송, 완료

		$order_list[$trade_day][date_total_price]+=$dt[total_price];
		$order_list[$trade_day][trade_method5_price]+=$dt[use_point];
		$order_list[$trade_day][date_total_order_cnt]++;

		switch($dt[trade_method]){
			case "1": $order_list[$trade_day][trade_method1_price]+=$dt[total_price]; $order_list[$trade_day][m1_cnt]++; break;
			case "2": $order_list[$trade_day][trade_method2_price]+=$dt[total_price]; $order_list[$trade_day][m2_cnt]++; break;
			case "3": $order_list[$trade_day][trade_method3_price]+=$dt[total_price]; $order_list[$trade_day][m3_cnt]++; break;
			case "4": $order_list[$trade_day][trade_method4_price]+=$dt[total_price]; $order_list[$trade_day][m4_cnt]++; break;
			case "5": $order_list[$trade_day][trade_method5_price]+=$dt[total_price]; $order_list[$trade_day][m5_cnt]++; break;
			case "7": $order_list[$trade_day][trade_method7_price]+=$dt[total_price]; $order_list[$trade_day][m7_cnt]++; break;
		}

	}
	else if($dt[trade_stat] >= 9){	//취소 신청, 완료
		$order_list[$trade_day][date_total_ccprice]+=$dt[total_price];
		$order_list[$trade_day][date_total_ordercc_cnt]++;
	}
}

?>
<table class="tys04">
	<thead>
		<tr>
			<th>주문일자</th>
			<th>주문수</th>
			<th>주문합계</th>
			<th colspan="2">무통장</th>
			<th colspan="2">계좌이체</th>
			<th colspan="2">카드입금</th>
			<th colspan="2">휴대폰</th>
			<th colspan="2">포인트입금</th>
			<th colspan="2">쿠폰</th>
			<th colspan="2">가상계좌</th>
			<th colspan="2" class="red">주문취소</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>분류</td>
			<th>총건수</th>
			<th>총 금액</th>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td>건</td>
			<td>금액</td>
			<td class="red">건</td>
			<td class="red">금액</td>
		</tr>
		<?php
		$list_total_cnt=0;	//총 주문수
		$list_total_price=0;	//총 주문 금액

		$list_total_cc_cnt=0;	//총 주문취소수
		$list_total_cc_price=0;	//총 주문취소 금액

		$tm1_cnt=0;	//카드 총 주문수
		$tm2_cnt=0;	//무통장 총 주문수
		$tm3_cnt=0;	//계좌이체 총 주문수
		$tm4_cnt=0;	//가상계좌 총 주문수
		$tm5_cnt=0;	//포인트 총 주문수
		$tm7_cnt=0;	//휴대폰 총 주문수
		$tm1_price=0;	//카드 총 금액
		$tm2_price=0;	//무통장 총 금액
		$tm3_price=0;	//계좌이체 총 금액
		$tm4_price=0;	//가상계좌 총 금액
		$tm5_price=0;	//포인트 총 금액
		$tm7_price=0;	//휴대폰 총 금액

		foreach($order_list as $odate=>$ol){
			$list_total_cnt+=$ol[date_total_order_cnt];
			$list_total_price+=$ol[date_total_price];

			//무통장 합계
			$tm2_cnt+=$ol[m2_cnt];
			$tm2_price+=$ol[trade_method2_price];

			//계좌이체 합계
			$tm3_cnt+=$ol[m3_cnt];
			$tm3_price+=$ol[trade_method3_price];

			//계좌이체 합계
			$tm4_cnt+=$ol[m4_cnt];
			$tm4_price+=$ol[trade_method4_price];

			//신용카드 합계
			$tm1_cnt+=$ol[m1_cnt];
			$tm1_price+=$ol[trade_method1_price];

			//휴대폰 합계
			$tm7_cnt+=$ol[m7_cnt];
			$tm7_price+=$ol[trade_method7_price];

			//포인트 합계
			$tm5_cnt+=$ol[m5_cnt];
			$tm5_price+=$ol[trade_method5_price];

			//주문취소 합계
			$list_total_cc_cnt+=$ol[date_total_ordercc_cnt];
			$list_total_cc_price+=$ol[date_total_ccprice];
			?>
			<tr>
				<td><?=$odate?></td>
				<th><?=number_format($ol[date_total_order_cnt])?></th>
				<th><?=number_format($ol[date_total_price])?></th>
				<td><?=number_format($ol[m2_cnt])?></td>
				<td><?=number_format($ol[trade_method2_price])?></td>
				<td><?=number_format($ol[m3_cnt])?></td>
				<td><?=number_format($ol[trade_method3_price])?></td>
				<td><?=number_format($ol[m1_cnt])?></td>
				<td><?=number_format($ol[trade_method1_price])?></td>
				<td><?=number_format($ol[m7_cnt])?></td>
				<td><?=number_format($ol[trade_method7_price])?></td>
				<td><?=number_format($ol[m5_cnt])?></td>
				<td><?=number_format($ol[trade_method5_price])?></td>
				<td>-</td>
				<td>-</td>
				<td><?=number_format($ol[m4_cnt])?></td>
				<td><?=number_format($ol[trade_method4_price])?></td>
				<td class="red"><?=number_format($ol[date_total_ordercc_cnt])?></td>
				<td class="red"><?=number_format($ol[date_total_ccprice])?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th>주문합계</th>
			<th><?=number_format($list_total_cnt)?></th>
			<th><?=number_format($list_total_price)?></th>
			<th><?=number_format($tm2_cnt)?></th>
			<th><?=number_format($tm2_price)?></th>
			<th><?=number_format($tm3_cnt)?></th>
			<th><?=number_format($tm3_price)?></th>
			<th><?=number_format($tm1_cnt)?></th>
			<th><?=number_format($tm1_price)?></th>
			<th><?=number_format($tm7_cnt)?></th>
			<th><?=number_format($tm7_price)?></th>
			<th><?=number_format($tm5_cnt)?></th>
			<th><?=number_format($tm5_price)?></th>
			<th>-</th>
			<th>-</th>
			<th><?=number_format($tm4_cnt)?></th>
			<th><?=number_format($tm4_price)?></th>
			<th colspan="2"></th>
		</tr>
		<tr>
			<th class="red">취소합계</th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"></th>
			<th class="red"><?=number_format($list_total_cc_cnt)?></th>
			<th class="red"><?=number_format($list_total_cc_price)?></th>
		</tr>
	</tfoot>
</table>

<!-- <img src="/image/tmp/show1.png" alt=""> -->

<!--
<ul class="list04 clearfix">
	<li>
		<h1>일일 매출</h1>

		<input type="text">일 하루
		<p class="ac"><button>검색</button></p>
	</li>



	<li>
		<h1>기간 매출</h1>

		<input type="text">일 ~ <input type="text">일
		<p class="ac"><button>검색</button></p>
	</li>



	<li>
		<h1>월간 매출</h1>

		<select name="" id="">
			<option value=""></option>
		</select>년 <select name="" id="">
			<option value=""></option>
		</select>월
		<p class="ac"><button>검색</button></p>
	</li>


	<li>
		<h1>연간 매출</h1>

		<select name="" id="">
			<option value=""></option>
		</select>년
		<p class="ac"><button>검색</button></p>
	</li>


</ul>


<div class="mt50">
	<h1 class="hj_h1">2017-10-10일 매출현황
</h1>
<p class="ar">
<a href="#" class="btn01">엑셀 다운로드</a>
</p>

<table class="tblTy01 mt10">

    <thead>
    <tr>
        <th scope="col">주문번호</th>
        <th scope="col">주문자</th>
        <th scope="col">주문합계</th>
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
        <th scope="col">주문취소</th>
        <th scope="col">미수금</th>
    </tr>
    </thead>
    <tbody>
            <tr>
            <td class="td_alignc"><a href="#">2018071717044242</a></td>
            <td class="td_name"><a href="#">김진주</a></td>
            <td class="td_numsum">24,600</td>
            <td class="td_numcoupon">0</td>
            <td class="td_numincome">0</td>
            <td class="td_numincome">0</td>
            <td class="td_numincome">0</td>
            <td class="td_numincome">0</td>
            <td class="td_numincome">24,600</td>
            <td class="td_numincome">0</td>
            <td class="td_numcancel1">0</td>
            <td class="td_numrdy">0</td>
        </tr>

        </tbody>
    <tfoot>
    <tr>
        <td colspan="2">합 계</td>
        <td>15,954,070</td>
        <td>0</td>
        <td>1,192,186</td>
        <td>0</td>
        <td>241,310</td>
        <td>10,740,409</td>
        <td>501,174</td>
        <td>379,611</td>
        <td>432,880</td>
        <td>2,707,980</td>
    </tr>
    </tfoot>
    </table>
</div> -->