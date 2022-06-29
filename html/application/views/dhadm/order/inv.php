<script type="text/javascript">
	//날짜 자동 입력
	function set_date_val(sd, ed){
		$("#start_date").val(sd);
		$("#end_date").val(ed);
	}
</script>
<h3 class="icon-search">배송검색</h3>
<form name="search_form">
	<!-- 제품검색 -->
	<table class="adm-table">
		<caption>제품 검색</caption>
		<colgroup>
			<col style="width:15%;"><col>
		</colgroup>
		<tbody>
			<tr>
				<th>
					<select name="sch_date" onchange="sch_date_btnset(this.value)">
						<option value="delivery_day">배송일자</option>
					</select>
				</th>
				<td>
					<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate')?>" readonly> ~
					<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate')?>" readonly>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')" class="btn-clear">오늘</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('tomorrow'))?>','<?=date("Y-m-d", strtotime('tomorrow'))?>')" class="btn-clear deliv">내일</button>
					<!-- <button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday this week'))?>','<?=date("Y-m-d", strtotime('sunday this week'))?>')" class="btn-clear">이번주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of this month'))?>','<?=date("Y-m-d", strtotime('last day of this month'))?>')" class="btn-clear">이번달</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday next week'))?>','<?=date("Y-m-d", strtotime('sunday next week'))?>')" class="btn-clear deliv">다음주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of next month'))?>','<?=date("Y-m-d", strtotime('last day of next month'))?>')" class="btn-clear deliv">다음달</button>
					<button type="button" onclick="set_date_val('','')" class="btn-clear">전체</button> -->
				</td>
			</tr>
			<tr>
				<th>
					<select name="sch_item">
						<option value="order_phone">주문자 휴대폰</option>
						<option value="userid">회원아이디</option>
						<option value="trade_code">주문번호</option>
						<option value="order_name">주문자 이름</option>
						<option value="recv_name">받는분 이름</option>
						<option value="recv_phone">받는분 휴대폰</option>
						<!-- <option value="enter_name">입금자</option> -->
					</select>
					<script type="text/javascript">
					<!--
						var sch_item = document.search_form.sch_item;
						for(i=0;i<sch_item.length;i++){
							if(sch_item.options[i].value == "<?=$this->input->get('sch_item')?>"){
								sch_item.options[i].selected = true;
							}
						}
					//-->
					</script>
				</th>
				<td>
					<input type="text" class="width-l" name="sch_item_val" value="<?=$this->input->get('sch_item_val')?>" onkeyup="enter_press();">
				</td>
			</tr>
			<?php
			/*
			<tr>
				<th>
					<?php
					// 차후 작업 예정
					?>
					<select name="order_type" onchange="call_select(this.value)">
						<option value="">주문선택</option>
						<option value="recom">정기배송</option>
						<option value="free">자유배송</option>
						<option value="gansik">산골간식</option>
						<option value="health">건강식품</option>
						<option value="farm">오!산골농부</option>
						<option value="discount">특가상품</option>
						<option value="sample">샘플신청</option>
					</select>
					<script type="text/javascript">
						var order_type = document.search_form.order_type;
						for(i=0;i<order_type.length;i++){
							if(order_type.options[i].value == "<?=$this->input->get('order_type')?>"){
								order_type.options[i].selected = true;
							}
						}
					</script>
					<?php
					if($this->input->get('order_type') != ""){
						?>
						<script type="text/javascript">
						$(function(){
							call_select('<?=$this->input->get("order_type")?>');
						});
						</script>
						<?php
					}
					?>
				</th>
				<td>
					<div class="float-wrap">
						<div class="float-l">
							<select name="" id="default">
								<option value="">----------</option>
							</select>
							<select name="order_type21" id="recom" style="display:none;" class="sub_select">
								<option value="">전체</option>
								<option value="1">준비기</option>
								<option value="2">초기</option>
								<option value="3">중기</option>
								<option value="4">후기2식</option>
								<option value="5">후기3식</option>
								<option value="6">완료기</option>
								<option value="7">반찬/국</option>
							</select>
							<script type="text/javascript">
								var order_type21 = document.search_form.order_type21;
								for(i=0;i<order_type21.length;i++){
									if(order_type21.options[i].value == "<?=$this->input->get('order_type21')?>"){
										order_type21.options[i].selected = true;
									}
								}
							</script>
							<select name="order_type22" id="free" style="display:none;" class="sub_select">
								<option value="">전체</option>
								<option value="1">준비기</option>
								<option value="2">초기</option>
								<option value="3">중기 준비기</option>
								<option value="4">중기</option>
								<option value="5">후기</option>
								<option value="6">완료기</option>
								<option value="7">반찬</option>
								<option value="8">국</option>
							</select>
							<script type="text/javascript">
								var order_type22 = document.search_form.order_type22;
								for(i=0;i<order_type22.length;i++){
									if(order_type22.options[i].value == "<?=$this->input->get('order_type22')?>"){
										order_type22.options[i].selected = true;
									}
								}
							</script>
							<select name="order_type23" id="discount" style="display:none;" class="sub_select">
								<option value="">전체</option>
								<option value="1">초기 6팩</option>
								<option value="2">중기 12팩</option>
								<option value="3">후기 18팩</option>
								<option value="4">완료기 18팩</option>
							</select>
							<script type="text/javascript">
								var order_type23 = document.search_form.order_type23;
								for(i=0;i<order_type23.length;i++){
									if(order_type23.options[i].value == "<?=$this->input->get('order_type23')?>"){
										order_type23.options[i].selected = true;
									}
								}
							</script>
							<select name="order_type24" id="sample" style="display:none;" class="sub_select">
								<option value="">전체</option>
								<option value="1">초기</option>
								<option value="2">중기</option>
								<option value="3">후기</option>
								<option value="4">완료기</option>
							</select>
							<script type="text/javascript">
								var order_type24 = document.search_form.order_type24;
								for(i=0;i<order_type24.length;i++){
									if(order_type24.options[i].value == "<?=$this->input->get('order_type24')?>"){
										order_type24.options[i].selected = true;
									}
								}
							</script>

							<!-- <input type="text" placeholder="상품명을 입력하세요" name="order_goods" value="<?=$this->input->get('order_goods')?>"> -->

							<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
							<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
							<script type="text/javascript">
							$(document).ready(function() {
								//$('select[name=check]').select2();
								//$('select[name=select_it_id2]').select2();
								//$('select[name=select_it_id3]').select2();
								$("#select_jq").select2();
							});
							</script>
							<select name="search_goods" id="select_jq">
								<option value="">상품을 선택하세요.</option>
								<?php
								foreach($search_goods as $sg){
								?>
								<option value="<?=$sg->idx?>" <?=($this->input->get('search_goods') == $sg->idx)?"selected":"";?>><?=$sg->name?></option>
								<?php
								}
								?>
							</select>

						</div>
						<div class="float-r">
							<select name="sch_deliv_stat">
								<option value="">배송상태</option>
								<option value="0">배송대기</option>
								<option value="1">배송준비중</option>
								<option value="2">배송중</option>
								<option value="3">배송완료</option>
								<option value="4">중지</option>
								<option value="5">취소</option>
								<option value="6">휴일정지</option>
								<!-- <option value="8">배송일시정지</option>
								<option value="9">배송취소</option> -->
							</select>
							<script type="text/javascript">
							<!--
								var sch_deliv_stat = document.search_form.sch_deliv_stat;
								for(i=0;i<sch_deliv_stat.length;i++){
									if(sch_deliv_stat.options[i].value == "<?=$this->input->get('sch_deliv_stat')?>"){
										sch_deliv_stat.options[i].selected = true;
									}
								}
							//-->
							</script>
							<select name="sch_trade_stat">
								<option value="">주문상태</option>
								<!-- <option value="1">입금대기</option> -->
								<option value="2">입금완료</option>
								<option value="3">배송중</option>
								<!-- <option value="4">배송완료</option> -->
								<!-- <option value="5">취소</option> -->
								<!-- <option value="31">배송 일시정지</option> -->
							</select>
							<script type="text/javascript">
							<!--
								var sch_trade_stat = document.search_form.sch_trade_stat;
								for(i=0;i<sch_trade_stat.length;i++){
									if(sch_trade_stat.options[i].value == "<?=$this->input->get('sch_trade_stat')?>"){
										sch_trade_stat.options[i].selected = true;
									}
								}
							//-->
							</script>
							<select name="sch_other">
								<option value="">기타검색</option>
								<option value="invoice">운송장정보 입력건</option>
								<option value="no_invoice">운송장정보 미입력건</option>
								<option value="overlap">중복주문 확인</option>
								<script type="text/javascript">
								<!--
									var sch_other = document.search_form.sch_other;
									for(i=0;i<sch_other.length;i++){
										if(sch_other.options[i].value == "<?=$this->input->get('sch_other')?>"){
											sch_other.options[i].selected = true;
										}
									}
								//-->
								</script>
							</select>
						</div>
					</div>
				</td>
			</tr>
			*/
			?>
		</tbody>
	</table><!-- END 제품검색 -->
	<p class="align-c mt15"><input type="button" value="검색하기" class="btn-ok" onclick="javascript:document.search_form.submit();"></p>
</form>

<?php
if(count($list)){
	?>
<!-- 	<script type="text/javascript">
		function yester_inv_upload_excel(){
			if(document.eupfrm2.upfile.value == ""){
				alert("업로드 하실 엑셀 파일을 첨부 해 주세요.");
				return;
			}
			document.eupfrm2.mode.value = "yester_inv_exc_up";
			document.eupfrm2.submit();
		}
	</script>
	<h3 class="icon-pen mt20">배송일이 지난 송장번호 엑셀저장 (* 알림톡 발송 됨)</h3>
	<form name="eupfrm2" enctype='multipart/form-data' method="post">
	<input type="hidden" name="mode">
		<table class="adm-table">
			<tr>
				<th>송장입력전용 엑셀파일</th>
				<td>
					<input type="file" name="upfile" style="width:600px">
					<input type="button" value="업로드" class="btn-ok" onclick="yester_inv_upload_excel()">
				</td>
			</tr>
		</table>
	</form> -->

	<script type="text/javascript">
		function inv_upload_excel(){
			if(document.eupfrm.upfile.value == ""){
				alert("업로드 하실 엑셀 파일을 첨부 해 주세요.");
				return;
			}
			document.eupfrm.mode.value = "inv_exc_up";
			document.eupfrm.submit();
		}
	</script>
	<h3 class="icon-pen mt20">송장번호 엑셀저장</h3>
	<form name="eupfrm" enctype='multipart/form-data' method="post">
	<input type="hidden" name="mode">
		<table class="adm-table">
			<tr>
				<th>송장입력전용 엑셀파일</th>
				<td>
					<input type="file" name="upfile" style="width:600px">
					<input type="button" value="업로드" class="btn-ok" onclick="inv_upload_excel()">
				</td>
			</tr>
		</table>
	</form>

	<h3 class="icon-list mt30">배송리스트 (<b><?=$totalCnt?></b>건)</h3>
	<table class="adm-table line align-c">
		<thead>
			<tr>
				<th>주문번호</th>
				<th>배송번호</th>
				<th>상품명</th>
				<th width="10%">구매자정보<br>(이름,아이디,연락처)</th>
				<th width="10%">수령자정보<br>(이름,연락처)</th>
				<th width="7%">배송상태</th>
				<th width="10%">배송회사</th>
				<th width="10%">송장번호</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($list as $lt){
				?>
				<tr>
					<td><?=$lt->trade_code?></td>
					<td><?=$lt->deliv_code?></td>
					<td><?=$lt->prod_name?></td>
					<td><?=$lt->order_name?><br><?=$lt->userid?><br><?=$lt->order_phone?></td>
					<td><?=$lt->recv_name?><br><?=$lt->recv_phone?></td>
					<td>
						<?php
						switch($lt->deliv_stat){
							case 0: echo "배송대기"; break;
							case 1: echo "배송준비중"; break;
							case 2: echo "배송중"; break;
							case 3: echo "배송완료"; break;
							case 4: echo "중지"; break;
							case 5: echo "취소"; break;
							case 6: echo "휴일정지"; break;
							case 7: echo "조기마감"; break;
						}
						?>
					</td>
					<td><?=$lt->invoice_company?></td>
					<td><?=$lt->invoice_no?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>

	<!-- Pager -->
	<p class="list-pager align-c mt30" title="페이지 이동하기">
		<?=$Page?>
	</p><!-- END Pager -->
	<?php
}
?>