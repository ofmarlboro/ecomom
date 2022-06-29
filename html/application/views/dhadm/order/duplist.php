<style>
.adm-table tr{min-height:47px;}
.deliv{display:none;}
</style>


	<h3 class="icon-search">검색</h3>
	<form name="search_form">
		<!-- 제품검색 -->
		<table class="adm-table">
			<caption>제품 검색</caption>
			<colgroup>
				<col style="width:15%;">
				<col style="width:20%;">
				<col>
			</colgroup>
			<tbody>
				<tr>
					<th>
						<select name="sch_item">
							<option value="userid">회원아이디</option>
							<!-- <option value="trade_code">주문번호</option>
							<option value="name">주문자 이름</option>
							<option value="">주문자 전화</option>
							<option value="phone">주문자 휴대폰</option>
							<option value="send_name">받는분 이름</option>
							<option value="">받는분 전화</option>
							<option value="send_phone">받는분 휴대폰</option>
							<option value="enter_name">입금자</option> -->
						</select>
						<script type="text/javascript">
							var sch_item = document.search_form.sch_item;
							for(i=0;i<sch_item.length;i++){
								if(sch_item.options[i].value == "<?=$this->input->get('sch_item')?>"){
									sch_item.options[i].selected = true;
								}
							}
						</script>
					</th>
					<td>
						<input type="text" class="width-l" name="sch_item_val" value="<?=$this->input->get('sch_item_val')?>">
					</td>
					<td><input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();"></td>
				</tr>
			</tbody>
		</table><!-- END 제품검색 -->
	</form>

	<!-- 제품리스트 -->
	<div class="float-wrap mt70">
		<h3 class="icon-list float-l">단계 업그레이드 | <strong><?=number_format($totalCnt)?>건</strong>의 결제내역이 검색되었습니다.</h3>
	</div>

	<table class="adm-table line align-c">
		<thead>
			<tr>
				<th>No.</th>
				<th>주문일자<br>주문번호 [PC/Mobile]</th>
				<th>기존 단계</th>
				<th>변경 단계</th>
				<th>잔여회차</th>
				<th>주문자<br>아이디</th>
				<th>연락처</th>
				<th>결제금액</th>
				<th>결제수단</th>
				<th>비고</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if($list){
				$cnt = 0;
				foreach($list as $lt){
					$cnt++;
				?>
				<tr>
					<td><?=$listNo?></td>
					<td><?=date("Y-m-d",strtotime($lt->wdate))?><br><?=$lt->grade_code?></td>
					<td><?=$lt->recom_name?></td>
					<td><?=$lt->chg_recom_name?></td>
					<td><?=$lt->remain_deliv_count?></td>
					<td><?=$lt->name?><br><?=$lt->userid?></td>
					<td><?=$lt->send_phone?><br><?=$lt->phone?></td>
					<td style="text-align:right"><?=number_format($lt->price)?> 원</td>
					<td><?if($lt->pay_method == "card" or $lt->pay_method == "1"){ echo "신용카드"; }else if($lt->pay_method == "bank" or $lt->pay_method == "3"){ echo "계좌이체"; }else if($lt->pay_method == "point"){ echo "포인트결제"; }?></td>
					<td>
						<input type="button" value="주문내역">
						<input type="button" value="배송내역">
					</td>
				</tr>
				<?php
					$listNo--;
				}
			}
			else{
				?>
				<tr>
					<td colspan="12">표시할 주문내역이 없습니다.</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	<? if(count($list) > 0){ ?>
		<!-- Pager -->
		<p class="list-pager align-c mt50" title="페이지 이동하기">
			<?=$Page?>
		</p><!-- END Pager -->
	<?}?>