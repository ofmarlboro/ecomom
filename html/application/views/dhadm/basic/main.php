
<div class="clearfix hj">
	<div class="fl">
		<h1>
			회원 가입현황
		</h1>
		<p class="ar mb10">
			<a href="<?=cdir()?>/member/user/m" class="btn01">회원리스트</a>
		</p>
		<table class="tblTy02">
			<colgroup>
			<col width="25%">
			<col width="25%">
			<col width="25%">
			<col width="25%">
			</colgroup>
			<tr>
				<td><h4>
						<?=number_format($member_total_count)?>
					</h4>
					<p>전체 가입자 수 </p></td>
				<td><h4>
						<?=number_format($today_reg_count)?>
					</h4>
					<p>오늘 가입자 수 </p></td>
				<td><h4>
						<?=number_format($this_week_reg_count)?>
					</h4>
					<p>최근 1주일 </p></td>
				<td><h4>
						<?=number_format($this_month_reg_count)?>
					</h4>
					<p>현재 月 </p></td>
			</tr>
		</table>
	</div>
	<div class="fr">
		<h1>
			접속자 집계
		</h1>
		<p class="ar mb10">
			<a href="<?=cdir()?>/total/cnt/1/m" class="btn01">접속통계</a>
		</p>
		<table class="tblTy02">
			<colgroup>
			<col width="25%">
			<col width="25%">
			<col width="25%">
			<col width="25%">
			</colgroup>
			<tr>
				<td><h4>
						<?=number_format($count['today'])?>
					</h4>
					<p>오늘 </p></td>
				<td><h4>
						<?=number_format($count['yester'])?>
					</h4>
					<p>어제 </p></td>
				<td><h4>
						<?=number_format($count['this_week'])?>
					</h4>
					<p>최근 1주일 </p></td>
				<td><h4>
						<?=number_format($count['this_month'])?>
					</h4>
					<p>현재 月 </p></td>
			</tr>
		</table>
	</div>
</div>
<div class="mt50 hj">
	<h1>
		주문 수량 현황 (<?=$date_value['this_day']?> <?=$date_value['this_day_name']?>)
	</h1>
	<p class="ar mb10">
		<a href="?this_day=<?=strtotime('-1 day',time())?>&day_type=yester" class="btn01 <?=($this->input->get('day_type') != "yester")?"off":"";?>">어제</a>
		<a href="?this_day=<?=time()?>&day_type=to" class="btn01 <?=($this->input->get('day_type') != "to" and $this->input->get('day_type') != "")?"off":"";?>">오늘</a>
	</p>
	<!-- 꺼진 버튼에만 클래스명 off 주세요 -->

	<table class="tblTy01">
		<thead>
			<tr>
				<th rowspan="2">구분</th>
				<th colspan="16">단계/상품 (팩 또는 개수)</th>
			</tr>
			<tr>
				<th>준비기</th>
				<th>초기</th>
				<th>중기준비기</th>
				<th>중기</th>
				<th>후기</th>
				<th>후기2식</th>
				<th>후기3식</th>
				<th>완료기</th>
				<th>반찬</th>
				<th>국</th>
				<th>반찬/국</th>
				<th>간식</th>
				<th>특가상품</th>
				<th>건강식품</th>
				<th>오!산골농부</th>
				<th>샘플신청</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th>정기배송</th>
				<td class="r1"><?=number_format($recom_order_cnt[0])?></td>
				<td class="r2"><?=number_format($recom_order_cnt[1])?></td>
				<td class="r3">-</td>
				<td class="r4"><?=number_format($recom_order_cnt[2])?></td>
				<td class="r5"><?=number_format($recom_order_cnt[3])?></td>
				<td class="r6">-</td>
				<td class="r7"><?=number_format($recom_order_cnt[4])?></td>
				<td class="r8"><?=number_format($recom_order_cnt[5])?></td>
				<td class="r9">-</td>
				<td class="r10">-</td>
				<td class="r11"><?=number_format($recom_order_cnt[6])?></td>
				<td class="r12">-</td>
				<td class="r13">-</td>
				<td class="r14">-</td>
				<td class="r15">-</td>
				<td class="r16">-</td>
			</tr>
			<tr>
				<th>자유배송</th>
				<td class="f1"><?=number_format($not_recom_order_cnt[0])?></td>
				<td class="f2"><?=number_format($not_recom_order_cnt[1])?></td>
				<td class="f3"><?=number_format($not_recom_order_cnt[2])?></td>
				<td class="f4"><?=number_format($not_recom_order_cnt[3])?></td>
				<td class="f5"><?=number_format($not_recom_order_cnt[4])?></td>
				<td class="f6">-</td>
				<td class="f7">-</td>
				<td class="f8"><?=number_format($not_recom_order_cnt[5])?></td>
				<td class="f9"><?=number_format($not_recom_order_cnt[6])?></td>
				<td class="f10"><?=number_format($not_recom_order_cnt[7])?></td>
				<td class="f11">-</td>
				<td class="f12"><?=number_format($not_recom_order_cnt[8])?></td>
				<td class="f13"><?=number_format($not_recom_order_cnt[9])?></td>
				<td class="f14"><?=number_format($not_recom_order_cnt[10])?></td>
				<td class="f15"><?=number_format($not_recom_order_cnt[11])?></td>
				<td class="f16"><?=number_format($not_recom_order_cnt[12])?></td>
			</tr>
			<tr>
				<th>합계</th>
				<td class="result1"></td>
				<td class="result2"></td>
				<td class="result3"></td>
				<td class="result4"></td>
				<td class="result5"></td>
				<td class="result6"></td>
				<td class="result7"></td>
				<td class="result8"></td>
				<td class="result9"></td>
				<td class="result10"></td>
				<td class="result11"></td>
				<td class="result12"></td>
				<td class="result13"></td>
				<td class="result14"></td>
				<td class="result15"></td>
				<td class="result16"></td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	for(i=1;i<=16;i++){
		var recom = $(".r"+i).html() != "-" ? $(".r"+i).html() : "0" ;
		var free = $(".f"+i).html() != "-" ? $(".f"+i).html() : "0" ;

		result = parseInt(recom) + parseInt(free);

		$(".result"+i).html(result);
	}
</script>