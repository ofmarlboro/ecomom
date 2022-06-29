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

<?php
$date_mode=$this->input->get('date_mode');
if($date_mode==""){
	$date_mode="day";
}
?>

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

					<span class="search-area day" <?if($date_mode!="day"){?>style="display:none;"<?}?>>
						<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d", strtotime('-6 days')) ;?>" readonly> ~
						<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d") ;?>" readonly>
					</span>

					<span class="search-area month" <?if($date_mode!='month'){?>style="display:none;"<?}?>>
						<select name="sch_year" <?if($date_mode=='month'){?>msg="검색하실 연도를"<?}?>>
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
		<td><?=number_format($roof_top[total_payment])?></td>
		<th>총 주문건수</th>
		<td><?=number_format($roof_top[total_order_ok_cnt]+$roof_top[total_order_cc_cnt])?></td>
		<th>총 결제완료건</th>
		<td><?=number_format($roof_top[total_order_ok_cnt])?></td>
		<th>총 주문취소</th>
		<td><?=number_format($roof_top[total_order_cc_cnt])?></td>
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
			$brown = 100-round(($gp[total_paycancel]/$max_total_pay)*100);
			?>
			<th>
				<div class="yellow_box" style="top: <?=$yellow?>%;"><?if($arr_cnt <= 7){?><span><?=number_format($gp[total_payment])?></span><?}?></div>
				<div class="brown_box" style="top: <?=$brown?>%"><?if($arr_cnt <= 7){?><span><?=number_format($gp[total_paycancel])?></span><?}?></div>
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
- 표
주문일자,주문수,주문합계,무통장 건/금액, 계좌이체 건/금액, 카드입금 건/금액, 휴대폰 건/금액, 포인트입금 건/금액, 쿠폰 건/금액, 가상계좌 건/금액, 주문취소 건/금액
주문합계,이상동일
취소합계, 빈값 , 제일끝 취소 합계


//신용카드 1, 무통장 2, 계좌이체 3, 가상계좌 4, 휴대폰 7
- array :
	$table[date][total_order_cnt]								[일자][총 주문수]
	$table[date][total_order_price]							[일자][주문합계]
	$table[date][m2_cnt]												[일자][무통장 주문합계]
	$table[date][m2_total]											[일자][무통장 주문액 합계]
	$table[date][m3_cnt]												[일자][계좌이체 주문합계]
	$table[date][m3_total]											[일자][계좌이체 주문액 합계]
	$table[date][m1_cnt]												[일자][신용카드 주문합계]
	$table[date][m1_total]											[일자][신용카드 주문액 합계]
	$table[date][m7_cnt]												[일자][휴대폰결제 주문합계]
	$table[date][m7_total]											[일자][휴대폰결제 주문액 합계]
	$table[date][use_point_cnt]									[일자][포인트입금 주문합계]
	$table[date][use_point_price]								[일자][포인트입금 주문액 합계]
	$table[date][use_coupon_cnt]								[일자][쿠폰 주문합계]
	$table[date][use_coupon_price]							[일자][쿠폰 주문액 합계]
	$table[date][m4_cnt]												[일자][가상계좌 주문합계]
	$table[date][m4_total]											[일자][가상계좌 주문액 합계]
	$table[date][total_order_cc_cnt]						[일자][주문취소 주문합계]
	$table[date][total_order_cc_price]					[일자][주문취소 주문액 합계]
*/
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
		foreach($table as $odate=>$ol){
			$list_total_cnt+=$ol[total_order_cnt];
			$list_total_price+=$ol[total_order_price];

			//무통장 합계
			$tm2_cnt+=$ol[m2_cnt];
			$tm2_price+=$ol[m2_total];

			//계좌이체 합계
			$tm3_cnt+=$ol[m3_cnt];
			$tm3_price+=$ol[m3_total];

			//가상계좌 합계
			$tm4_cnt+=$ol[m4_cnt];
			$tm4_price+=$ol[m4_total];

			//신용카드 합계
			$tm1_cnt+=$ol[m1_cnt];
			$tm1_price+=$ol[m1_total];

			//휴대폰 합계
			$tm7_cnt+=$ol[m7_cnt];
			$tm7_price+=$ol[m7_total];

			//포인트 합계
			$tm5_cnt+=$ol[use_point_cnt];
			$tm5_price+=$ol[use_point_price];

			//쿠폰 합계
			$cp_cnt+=$ol[use_coupon_cnt];
			$cp_price+=$ol[use_coupon_price];

			//주문취소 합계
			$list_total_cc_cnt+=$ol[total_order_cc_cnt];
			$list_total_cc_price+=$ol[total_order_cc_price];
			?>
			<tr>
				<td><?=$odate?></td>
				<th><?=number_format($ol[total_order_cnt])?></th>
				<th><?=number_format($ol[total_order_price])?></th>
				<td><?=number_format($ol[m2_cnt])?></td>
				<td><?=number_format($ol[m2_total])?></td>
				<td><?=number_format($ol[m3_cnt])?></td>
				<td><?=number_format($ol[m3_total])?></td>
				<td><?=number_format($ol[m1_cnt])?></td>
				<td><?=number_format($ol[m1_total])?></td>
				<td><?=number_format($ol[m7_cnt])?></td>
				<td><?=number_format($ol[m7_total])?></td>
				<td><?=number_format($ol[use_point_cnt])?></td>
				<td><?=number_format($ol[use_point_price])?></td>
				<td><?=number_format($ol[use_coupon_cnt])?></td>
				<td><?=number_format($ol[use_coupon_price])?></td>
				<td><?=number_format($ol[m4_cnt])?></td>
				<td><?=number_format($ol[m4_total])?></td>
				<td class="red"><?=number_format($ol[total_order_cc_cnt])?></td>
				<td class="red"><?=number_format($ol[total_order_cc_price])?></td>
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
			<th><?=number_format($cp_cnt)?></th>
			<th><?=number_format($cp_price)?></th>
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