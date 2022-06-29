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
		<h3 class="icon-list float-l">총 | <strong><?=number_format($totalCnt)?>건</strong>의 내역이 검색되었습니다.</h3>
	</div>

	<table class="adm-table line align-c">
		<thead>
			<tr>
				<th>No.</th>
				<th>주문단계</th>
				<th>주문일자</th>
				<th>구분</th>
				<th>주문내역</th>
				<th>주문자</th>
				<th>연락처</th>
				<th>받는분</th>
				<th>주문금액</th>
				<th>결제수단</th>
				<!-- <th>배송진행</th> -->
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
					<td><?=($lt->trade_stat == "9")?"취소완료":"취소요청";?></td>
					<td><?=date("Y-m-d",strtotime($lt->trade_day))?><br><?=$lt->trade_code?>[<?=($lt->mobile)?"M":"P";?>]</td>
					<td>
						<?php
						if($lt->recom_is == "Y"){
							echo "정기배송";
						}
						else if($lt->sample_is == "Y"){
							echo "샘플신청";
						}
						else{
							echo "일반주문";
						}
						?>
					</td>
					<td class="title">
						<?php
						$goods_row = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '".$lt->trade_code."' order by idx desc","result");
						foreach($goods_row as $key=>$gname){
							$j = $key+1;
							echo $gname->goods_name;
							if($gname->goods_cnt > 0){
								echo "".($j > 0)?"<br>":"";
							}
							else{
								$options = $this->common_m->self_q("select * from dh_trade_goods_option where trade_goods_idx = '".$gname->idx."' and level = '2'","result");
								foreach($options as $option_row){
									echo "<br>&nbsp;&nbsp;".$option_row->name;
									//echo "(".number_format($option_row->price).")";
									echo " x ".$option_row->cnt."개";
								}
								echo "".($j > 0)?"<br>":"";
							}
						}
						?>
					</td>
					<td><?=$lt->name?><br><?=$lt->userid?></td>
					<td><?=$lt->phone?></td>
					<td><?=$lt->send_name?><br><?=$lt->send_phone?></td>
					<td><?=number_format($lt->total_price)?> 원</td>
					<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
					<!-- <td></td> -->
					<td>
						<?php
						if($lt->trade_stat == "9"){
						}
						else{
						?>
						<input type="button" value="보기" onclick="location.href='/html/order/cclist/m/ccview/<?=$lt->trade_code?>'">
						<?php
						}
						?>
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