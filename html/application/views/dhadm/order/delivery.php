<script type="text/javascript">
	//일자별 버튼 셋팅
	function sch_date_btnset(val){
		if(val == "deliv_date"){
			$(".default").hide();
			$(".deliv").show();
		}else{
			$(".default").show();
			$(".deliv").hide();
		}
	}

	//날짜 자동 입력
	function set_date_val(sd, ed){
		$("#start_date").val(sd);
		$("#end_date").val(ed);
	}

	function call_select(id){
		if(id){
			$("#default").hide();
			$(".sub_select").hide();
			$("#"+id).show();
		}
		else{
			$("#default").show();
			$(".sub_select").hide();
		}
	}

	$(function(){
		$("#allcheck").on('change',function(){
			if(this.checked == true){
				$(".sel").prop('checked',true);
			}
			else{
				$(".sel").prop('checked',false);
			}
		});
	});

	function deliv_stat_change(){
		var deliv_email = $("input[name='deliv_info_mail']").prop('checked');
		var deliv_sms = $("input[name='deliv_info_sms']").prop('checked');
		var auto_invoice = $("input[name='auto_invoice_check']").prop('checked');
		var chagne_deliv_stat = $("select[name='chagne_deliv_stat']").val();

		var frm = document.list_frm;
		if($(".sel:checked").length > 0){
			if(confirm("배송상태를 변경하시겠습니까?")){
				if(deliv_email) $("input[name='deliv_email']").val('1');
				if(deliv_sms) $("input[name='deliv_sms']").val('1');
				if(auto_invoice) $("input[name='auto_invoice']").val('1');
				if(chagne_deliv_stat) $("input[name='change_stat']").val(chagne_deliv_stat);
				frm.submit();
			}
		}
		else{
			alert("변경하실 배송내역을 선택해 주세요.");
		}
	}

	function update_food_list(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/food_update/?ajax=1&dcode="+deliv_code,"foods_update","width=700, height=800, scrollbars=yes");
	}

	function print_order(){
		var frm = document.list_frm;
		frm.action = "<?=cdir()?>/order/delivery_print/m/?ajax=1";
		frm.target = "popup_window";
		window.open("","popup_window","width=1280,height=800,top=100,left=100,scrollbars=yes");
		frm.submit();
	}

	function deliv_complete(){
		if(confirm("배송중인 주문내역 중 3일이 지난\n배송건을 배송완료로 변경합니다.")){
			location.href="<?=cdir()?>/order/delivery/m/deliv_complete";
		}
	}

	function deliv_date_chg(deliv_code){
		window.open("<?=cdir()?>/order/delivery/m/deliv_date_update/?ajax=1&deliv_code="+deliv_code,"deliv_date_update","width=600, height=800");
	}

	function deliv_stat_update(deliv_code, stat){
		if(confirm("배송상태를 변경 하시겠습니까?")){
			location.href="/html/order/delivery/m/deliv_stat_update/?deliv_code="+deliv_code+"&stat="+stat;
		}
	}

	function excel_save_page(url){
		//alert(url);
		location.href=url+"&ajax=1&excel=ok";
	}

	function invoice_reset(idx){
		if(confirm("삭제된 데이터는 되돌릴 수 없습니다.\n삭제 하시겠습니까?")){
			location.href="/html/order/delivery/m/invoice_reset/"+idx;
		}
	}

	function today_deliv_stat_ready(deliv_date){
		//alert(deliv_date);
		location.href="/html/order/delivery/m/today_deliv_stat_ready/"+deliv_date;
	}

	function enter_press(){
		if(event.keyCode == 13){
			document.search_form.submit();
		}
	}
	function show_layer(idx){
		$(".layer_t"+idx).slideToggle();
	}
	function show_layer_r(idx){
		$(".layer_r"+idx).slideToggle();
	}
	$(function(){
		$("html, body").on("click", function(){
			$(".layer_t").hide();
		});
	});
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
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday this week'))?>','<?=date("Y-m-d", strtotime('sunday this week'))?>')" class="btn-clear">이번주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of this month'))?>','<?=date("Y-m-d", strtotime('last day of this month'))?>')" class="btn-clear">이번달</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday next week'))?>','<?=date("Y-m-d", strtotime('sunday next week'))?>')" class="btn-clear deliv">다음주</button>
					<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of next month'))?>','<?=date("Y-m-d", strtotime('last day of next month'))?>')" class="btn-clear deliv">다음달</button>
					<button type="button" onclick="set_date_val('','')" class="btn-clear">전체</button>
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
								<option value="7">조기마감</option>
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
		</tbody>
	</table><!-- END 제품검색 -->
	<p class="align-c mt15"><input type="button" value="검색하기" class="btn-ok" onclick="javascript:document.search_form.submit();"></p>
</form>

<div class="float-wrap mt30 mb20">
	<div class="float-l">
		총 <?=number_format($totalCnt)?>건의 배송내역이 검색되었습니다.
		<input type="button" value="검색결과 배송대기 > 배송준비중으로 일괄 변경" onclick="today_deliv_stat_ready('<?=$this->input->get('sch_sdate')?>')" class="btn-sm"> <span style="color:red;font-weight:600">※필수 : 배송준비중으로 변경해야 당회차 취소를 방지할 수 있습니다. (오더지 작업전 반드시 먼저 눌러주세요)</span>
	</div>

	<?php
	if($totalCnt > 0){
	?>
	<div class="float-r">
		<input type="button" value="엑셀로 저장하기" onclick="excel_save_page('<?=$_SERVER['REQUEST_URI']?>')">
	</div>
	<?php
	}
	?>
</div>

<table class="adm-table line align-c">
	<thead>
		<tr>
			<th style="width:1%;"><input type="checkbox" id="allcheck"><label for="allcheck" class="hidden">모두선택</label></th>
			<th style="width:7%;">주문단계<br>배송일<br>배송일변경</th>
			<th>주문일자<br>주문번호 [PC/Mobile]<br>배송상태</th>
			<th>주문내역</th>
			<th style="width:8%;">연락처<br>주문자성명<br>아이디</th>
			<th style="width:8%;">연락처<br>받는분</th>
			<th style="width:7%;">결제수단<br>주문금액</th>
			<th>배송지<br>배송시요청사항</th>
			<th colspan="2" style="width:10%;">송장번호</th>
			<th style="width:7%;">비고</th>
			<th>AL</th>
		</tr>
	</thead>
	<tbody>
		<form method="post" id="list_frm" name="list_frm">

		<input type="hidden" name="deliv_email">
		<input type="hidden" name="deliv_sms">
		<input type="hidden" name="auto_invoice">
		<input type="hidden" name="change_stat">
		<?php
		if($list){
			foreach($list as $lt){
			?>
			<tr style="background-color:<?=$lt->deliv_stat == 4 ? "#ececec" : ( $lt->deliv_stat == 5 ? "#fdebf3" : ( $lt->deliv_stat == 6 ? "#d0d8ff" : ($lt->deliv_stat == 7?"#16ca39":"") ) ) ;?>;">
				<td><input type="checkbox" name="check[]" value="<?=$lt->deliv_code?>" class="sel"></td>
				<td style="text-align:left">
					<?=$shop_info['trade_stat'.$lt->trade_stat]?>
					<?php
					if($lt->first_order == "Y"){
					?>
					<div style="background:#0000ff;color:#fff;width:15px;display:inline-block;text-align:center;">N</div>
					<?php
					}
					?>
					<br>
					<span style="font-weight:600;color:blue;"><?=$lt->deliv_date?></span>
					<br>
					<input type="button" value="배송일 변경" class="btn-sm btn-alert" onclick="deliv_date_chg('<?=$lt->deliv_code?>')">
				</td>
				<td>
					<?=$lt->trade_day?><br>
					<a href="/html/order/lists/m/view/<?=$lt->tidx?>" target="_blank"><?=$lt->trade_code?></a>
					[<?=($lt->mobile)?"M":"P";?>]
					<br>
					<select name="deliv_stat" onchange="deliv_stat_update('<?=$lt->deliv_code?>',this.value)">
						<?php
						foreach($deliv_stat_arr as $k=>$v){
						?>
						<option value="<?=$k?>" <?=($k == $lt->deliv_stat)?"selected":"";?>><?=$v?></option>
						<?php
						}
						?>
					</select>
				</td>
				<td class="title">
					<?php
					/*
					$goods_name_arr = explode(",",$lt->prod_name);
					foreach($goods_name_arr as $gna){
						echo $gna;
						$trade_goods_row = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '".$lt->trade_code."' order by idx desc","result");
						foreach($trade_goods_row as $tg){
							if( $tg->cate_no == "recom" and ($tg->goods_name == $gna or $tg->grade_change_recom_name == $gna) ){
								?>
								<div class="float-r">
									<input type="button" value="식단정보수정" onclick="update_food_list('<?=$lt->deliv_code?>')">
								</div>
								<?php
							}
						}
						echo "<br>";
					}
					*/
					if($lt->recom_idx > 0){
						?>
						<span style="color:blue">
						<?php
						echo "[영양식단] ".$recom_name_arr[$lt->recom_idx];
						?>
						</span>
						<div class="float-r">
							<input type="button" value="식단수정" onclick="update_food_list('<?=$lt->deliv_code?>')">
						</div>
						<br>
						<span style="color:red">
						<?php
						$dprow = $this->common_m->self_q("select *,(select name from dh_goods where idx = dh_trade_deliv_prod.goods_idx) as goods_name from dh_trade_deliv_prod where deliv_code = '{$lt->deliv_code}' and recom_is != 'Y'","result");
						foreach($dprow as $dp){
							echo $dp->goods_name."<BR>";
						}
						?>
						</span>

						<?php
					}
					else{
						?>
						<span style="color:red">
						<?php
						$dprow = $this->common_m->self_q("select *,(select name from dh_goods where idx = dh_trade_deliv_prod.goods_idx) as goods_name from dh_trade_deliv_prod where deliv_code = '{$lt->deliv_code}' and recom_is != 'Y'","result");
						foreach($dprow as $dp){
							echo $dp->goods_name."<BR>";
						}
						?>
						</span>
						<?php
					}
					?>
				</td>
				<td style="position: relative;">
					<?=$lt->order_phone?>
					<br>
					<a href="javascript:show_layer('<?=$lt->idx?>');"><?=$lt->order_name?></a>
					<div class="layer_t layer_t<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: relative;top: 0px;left: 0px;z-index:999">
						<a href="javascript:window.open('/html/member/user/m/edit/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
						<a href="javascript:window.open('/html/member/user/m/order/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
						<a href="javascript:window.open('/html/member/user/m/point/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">적립금내역</a>
						<a href="javascript:window.open('/html/member/user/m/deposit/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">예치금내역</a>
						<a href="javascript:window.open('/html/member/coupon/<?=$lt->useridx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
						<a href="javascript:window.open('/html/member/smspop?ajax=1&phone=<?=$lt->order_phone?>&name=<?=$lt->order_name?>&uid=<?=$lt->userid?>','sms_pop','width=505, height=526');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">SMS 발송</a>
					</div>
					<br>
					<?=$lt->userid?>
					<a href="/html/member/user/m/order/<?=$lt->useridx?>/?outmode=0&order=" target="_blank"></a>
				</td>
				<td style="position: relative;">
					<?=$lt->recv_phone?><br>
					<a href="javascript:show_layer_r('<?=$lt->idx?>');"><?=$lt->recv_name?></a>
					<div class="layer_t layer_r<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: relative;top: 0px;left: 0px;z-index:999">
						<a href="javascript:window.open('/html/member/smspop?ajax=1&phone=<?=$lt->recv_phone?>&name=<?=$lt->recv_name?>&uid=<?=$lt->userid?>','sms_pop','width=505, height=526');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">SMS 발송</a>
					</div>
				</td>
				<td>
					<?=$shop_info['trade_method'.$lt->trade_method]?>
					<br>
					<?php
					if($lt->trade_method == '8'){
						echo strtoupper($lt->memo);
					}
					else{
						echo number_format($lt->total_price);
					}
					?>
				</td>
				<td>
					<?=$lt->addr1?><br><?=$lt->addr2?><br>
					<?=($lt->send_text)?"<span style='color:blue;font-weight:bold'>요청사항 : </span>".$lt->send_text:"";?>
				</td>
				<td>
					<?=$lt->invoice_company?><br>
					<?php
					if(strtoupper($lt->invoice_company) == "CJ"){
						?>
						<a href='https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no=<?=$lt->invoice_no?>' target='_blank'><?=$lt->invoice_no?></a>
						<?php
					}
					else{
						?>
						<a href='https://service.epost.go.kr/iservice/usr/trace/trace.RetrieveDomRigiTraceList.comm?sid1=<?=$lt->invoice_no?>' target='_blank'><?=$lt->invoice_no?></a>
						<?php
					}
					?>
					<!-- <?=($lt->invoice_no)?"우체국<br><a href='https://service.epost.go.kr/iservice/usr/trace/trace.RetrieveDomRigiTraceList.comm?sid1=".$lt->invoice_no."' target='_blank'>".$lt->invoice_no."</a>":'-';?> --><br>
					<?php
					if($lt->invoice_no){
					?>
					<input type="button" class="btn-sm btn-cancel" value="송장번호삭제" onclick="invoice_reset('<?=$lt->idx?>')">
					<?php
					}
					?>
				</td>
				<td>
					<?php
					if($lt->invoice_no == ""){
						echo str_replace(":","<br>",$lt->invoice_log);
					}
					?>
				</td>
				<td class="title">
					<input type="button" value="보기" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/view/<?=$lt->deliv_code?>'">

					<?php
					if($lt->log_count > 0){
					?>
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/order_change/<?=$lt->deliv_code?>">
						<div style="background:#a60000;color:#fff;width:15px;display:inline-block;text-align:center;">!</div>
					</a>
					<?php
					}
					?>
				</td>
				<td><?=$lt->allergy?"O":"X";?></td>
			</tr>
			<?php
			}
		}
		else{
		?>
		<tr>
			<td colspan="12">표시할 내역이 없습니다.</td>
		</tr>
		<?php
		}
		?>
		</form>
	</tbody>
</table>

<div class="float-wrap mt30">
	<div class="float-l">
		<input type="button" value="선택된 항목 주문내역서 출력 (새창)" onclick="print_order()"><p class="mt10"></p>
		선택된 항목을
		<select name="chagne_deliv_stat" onchange="stat_chg(this.value)">
			<option value="0">배송대기</option>
			<option value="1">배송준비중</option>
			<option value="2">배송중</option>
			<option value="3">배송완료</option>
			<option value="4">중지</option>
			<option value="5">취소</option>
			<option value="6">휴일정지</option>
			<option value="7">조기마감</option>
		</select>
		(으)로 변경합니다.

		<script type="text/javascript">
			function stat_chg(val){
				if(val != "0"){
					$(".chg_stat").css('display','inline');
				}
				else{
					$(".chg_stat").css('display','none');
					$("#deliv_info_mail").prop('checked',false);
					$("#deliv_info_sms").prop('checked',false);
					$("#auto_invoice_check").prop('checked',false);
				}
			}
		</script>

		<div class="chg_stat" style="display:none;">
			<input type="checkbox" name="deliv_info_mail" id="deliv_info_mail" value='1'> <label for="deliv_info_mail" class="dh_red">배송안내메일</label>
			<input type="checkbox" name="deliv_info_sms" id="deliv_info_sms" value='1'> <label for="deliv_info_sms" class="dh_red">배송안내 알림톡</label>
			<input type="checkbox" name="auto_invoice_check" id="auto_invoice_check" value='1'> <label for="auto_invoice_check" class="dh_red">우체국택배 운송장번호 자동받기</label>
		</div>
		<input type="button" value="선택수정" onclick="deliv_stat_change()">

		<p class="dh_blue_st">※ 배송대기로 변경시 배송안내메일, 배송안내 알림톡, 우체국택배 운송장번호 자동받기를 절대 클릭하시면 안되서 클릭 못하게 했습니다.</p>
	</div>

	<!-- <div class="float-r">
		<input type="button" value="배송완료 일괄처리">
	</div> -->
</div>

<? if(count($list) > 0){ ?>
	<!-- Pager -->
	<p class="list-pager align-c mt30" title="페이지 이동하기">
		<?=$Page?>
	</p><!-- END Pager -->
<?}?>