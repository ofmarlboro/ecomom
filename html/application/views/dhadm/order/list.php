<?
	$cate_no1 = $this->input->get('cate_no1');
	$cate_no2 = $this->input->get('cate_no2');
	$cate_no3 = $this->input->get('cate_no3');
	$cate_no4 = $this->input->get('cate_no4');

?>
<style>
.adm-table tr{min-height:47px;}
.deliv{display:none;}
</style>

<script type="text/javascript" src="/_data/js/jquery.form.js"></script>
<script type="text/javascript">
<!--
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

	function change_trade_stat(idx, val){
		if(confirm('상태를 변경 하시겠습니까?\n\n※ 주문이 취소될 경우 정기주문내역의\n모든 연동데이터가 삭제됩니다.')){
			frm = document.change_stat_frm;
			frm.change_idx.value = idx;
			frm.change_stat.value = val;
			frm.submit();
		}
	}

	function restart(tcode,restart_date,restart_count,ayo){
		if(confirm(restart_date+"("+ayo+")부터 배송이 재시작 됩니다.")){

			var frm = document.restart_frm;

			frm.trade_code.value = tcode;
			frm.restart_date.value = restart_date;
			frm.restart_count.value = restart_count;
			frm.submit();
		}
	}

	function enter_press(){
		if(event.keyCode == 13){
			document.search_form.submit();
		}
	}

	function show_layer(idx){
		$(".layer_t"+idx).slideToggle();
	}
	$(function(){
		$("html, body").on("click", function(){
			$(".layer_t").hide();
		});
	});
//-->
</script>

<form id="restart_frm" name="restart_frm">
	<input type="hidden" name="mode" value="restart_deliv">
	<input type="hidden" name="trade_code">
	<input type="hidden" name="restart_date">
	<input type="hidden" name="restart_count">
</form>

<form name="change_stat_frm">
	<input type="hidden" name="change_idx">
	<input type="hidden" name="change_stat">
</form>

	<h3 class="icon-search">주문 검색</h3>
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
							<option value="trade_day">주문일자</option>
							<option value="trade_day_ok">입금일자</option>
							<option value="trade_day_cancel">취소일자</option>
						</select>
						<script type="text/javascript">
						<!--
							var sch_date = document.search_form.sch_date;
							for(i=0;i<sch_date.length;i++){
								if(sch_date.options[i].value == "<?=$this->input->get('sch_date')?>"){
									sch_date.options[i].selected = true;
								}
							}
						//-->
						</script>
					</th>
					<td>
						<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : "" ;?>" readonly> ~
						<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate') ? $this->input->get('sch_edate') : "" ;?>" readonly>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')" class="btn-clear">오늘</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('yesterday'))?>','<?=date("Y-m-d", strtotime('yesterday'))?>')" class="btn-clear default">어제</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('tomorrow'))?>','<?=date("Y-m-d", strtotime('tomorrow'))?>')" class="btn-clear default">내일</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday this week'))?>','<?=date("Y-m-d", strtotime('sunday this week'))?>')" class="btn-clear">이번주</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of this month'))?>','<?=date("Y-m-d", strtotime('last day of this month'))?>')" class="btn-clear">이번달</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday last week'))?>','<?=date("Y-m-d", strtotime('sunday last week'))?>')" class="btn-clear default">지난주</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of last month'))?>','<?=date("Y-m-d", strtotime('last day of last month'))?>')" class="btn-clear default">지난달</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('monday next week'))?>','<?=date("Y-m-d", strtotime('sunday next week'))?>')" class="btn-clear deliv">다음주</button>
						<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('first day of next month'))?>','<?=date("Y-m-d", strtotime('last day of next month'))?>')" class="btn-clear deliv">다음달</button>
						<button type="button" onclick="set_date_val('','')" class="btn-clear">전체</button>
					</td>
				</tr>
				<tr>
					<th>
						<select name="sch_item">
							<option value="phone">주문자 휴대폰</option>
							<option value="userid">회원아이디</option>
							<option value="trade_code">주문번호</option>
							<option value="name">주문자 이름</option>
							<!-- <option value="">주문자 전화</option> -->

							<option value="send_name">받는분 이름</option>
							<!-- <option value="">받는분 전화</option> -->
							<option value="send_phone">받는분 휴대폰</option>
							<option value="enter_name">입금자</option>
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
							<option value="sample">매장간 이동</option>
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

								<!-- <input type="text" placeholder="상품명을 입력하세요"> -->
							</div>
							<div class="float-r">
								<select name="sch_trade_method">
									<option value="">결제수단</option>
									<option value="1">신용카드</option>
									<option value="3">계좌이체</option>
									<option value="5">휴대폰</option>
									<!-- <option value="8">PAYNOW</option> -->
									<option value="9">카카오PAY</option>
									<option value="4">가상계좌</option>
									<option value="2">무통장입금</option>
									<option value="8">상품권결제</option>
								</select>
								<script type="text/javascript">
									var sch_trade_method = document.search_form.sch_trade_method;
									for(i=0;i<sch_trade_method.length;i++){
										if(sch_trade_method.options[i].value == "<?=$this->input->get('sch_trade_method')?>"){
											sch_trade_method.options[i].selected = true;
										}
									}
								</script>
								<select name="sch_trade_stat">
									<option value="">주문상태</option>
									<option value="1">입금대기</option>
									<option value="2">입금완료/배송대기</option>
									<option value="3">배송중</option>
									<option value="4">판매완료</option>
									<option value="10">취소신청</option>
									<option value="9">취소완료</option>
									<option value="31">배송 일시정지</option>
								</select>
								<script type="text/javascript">
									var sch_trade_stat = document.search_form.sch_trade_stat;
									for(i=0;i<sch_trade_stat.length;i++){
										if(sch_trade_stat.options[i].value == "<?=$this->input->get('sch_trade_stat')?>"){
											sch_trade_stat.options[i].selected = true;
										}
									}
								</script>
								<select name="sch_other">
									<option value="">기타검색</option>
									<option value="first_order">첫 주문 고객</option>
									<option value="pc_order">PC 주문 고객</option>
									<option value="mobile_order">Mobile 주문 고객</option>
								</select>
								<script type="text/javascript">
									var sch_other = document.search_form.sch_other;
									for(i=0;i<sch_other.length;i++){
										if(sch_other.options[i].value == "<?=$this->input->get('sch_other')?>"){
											sch_other.options[i].selected = true;
										}
									}
								</script>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품검색 -->
		<p class="align-c mt15"><input type="button" value="검색하기" class="btn-ok" onclick="javascript:document.search_form.submit();"></p>
	</form>
	<?php
	//검색 차후 작업 확인해야함
	?>

	<!-- 제품리스트 -->
	<div class="float-wrap mt70">
		<h3 class="icon-list float-l">주문리스트 <strong><?=number_format($totalCnt)?>건</strong></h3>
		<p class="list-adding float-r">
			<a href="<?=$_SERVER['PHP_SELF'].$query_string?>" <?if(!$this->input->get("order")){?>class="on"<?}?>>등록순<em>▼</em></a>
			<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=1" <?if($this->input->get("order")=="1"){?>class="on"<?}?>>등록순<em>▲</em></a>
			<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=2" <?if($this->input->get("order")=="2"){?>class="on"<?}?>>결제금액순<em>▼</em></a>
			<a href="<?=$_SERVER['PHP_SELF'].$query_string?>&order=3" <?if($this->input->get("order")=="3"){?>class="on"<?}?>>결제금액순<em>▲</em></a>
		</p>
	</div>

	<table class="adm-table line align-c">
		<thead>
			<tr>
				<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
				<th>주문단계</th>
				<th>주문일자<br>주문번호 [PC/Mobile]</th>
				<th>구분</th>
				<th>주문내역</th>
				<th>주문자성명<br>회원아이디</th>
				<th>연락처</th>
				<th>받는분<br>연락처</th>
				<th>주문금액</th>
				<th>결제수단</th>
				<th>배송진행</th>
				<th>비고</th>
			</tr>
		</thead>
		<tbody>
			<form name="odlist" id="odlist" method="post">
			<input type="hidden" name="mode">
			<input type="hidden" name="change_stat_value">
			<?php
			//로딩이 안되는 문제로 리스트를 검색후 출력하게 변경하자
			if($list){
				$cnt = 0;
				foreach($list as $lt){
					$cnt++;
				?>
				<tr style="background:<?= ( $lt->trade_stat == 9 ? "#fdebf3" : ( $lt->trade_stat == 10 ? "#ebfdf1" : ( $lt->trade_stat == 1 ? "#9e9e9e6e" : "" ) ) );?>;">
					<td><input type="checkbox" name="check[]" value="<?=$lt->trade_code?>" class="sel"></td>
					<td style="text-align:left">
						<?php
						if($lt->trade_stat == "31"){

							echo "배송일시정지 ";

							$day_name_to_number = array('일'=>0,'월'=>1,'화'=>2,'수'=>3,'목'=>4,'금'=>5,'토'=>6);

							$arr_week_type = explode(":",$lt->recom_week_type);
							$arr_week_name = explode(",",$arr_week_type[1]);

							$restart_date = date("Y-m-d",strtotime('+2 day'));
							while(true){
								$restart_date = date("Y-m-d",strtotime('+1 day',strtotime($restart_date)));
								if(!in_array($restart_date,$arr_holi)){
									foreach($arr_week_name as $aw){
										if($day_name_to_number[$aw] == date('w',strtotime($restart_date))){
											$restart_day = $restart_date;
										}
									}
								}
								if($restart_day) break;
							}

							//$otc = (($arr_week_type[0] * $lt->recom_week_count) - $lt->remain_deliv_count)+1;
							$otc = $lt->remain_deliv_count;
						?>
						<button type="button" onclick="restart('<?=$lt->trade_code?>','<?=$restart_day?>','<?=$otc?>','<?=numberToWeekname($restart_day)?>')">배송 재시작</button>
						<?php
						}

						else{
						?>
						<select name="change_stat" id="change_stat" onchange="change_trade_stat('<?=$lt->idx?>',this.value)">
							<option value="1" <?=($lt->trade_stat==1)?"selected":"";?>>입금대기</option>
							<option value="2" <?=($lt->trade_stat==2)?"selected":"";?>>입금완료/배송대기</option>
							<option value="3" <?=($lt->trade_stat==3)?"selected":"";?>>배송중</option>
							<option value="4" <?=($lt->trade_stat==4)?"selected":"";?>>판매완료</option>
							<option value="10" <?=($lt->trade_stat==10)?"selected":"";?>>취소신청</option>
							<option value="9" <?=($lt->trade_stat==9)?"selected":"";?>>취소완료</option>
							<!-- <option value="31" <?=($lt->trade_stat==31)?"selected":"";?>>배송일시정지</option> -->
						</select>
						<?php
						}
						?>

						<?php
						if($lt->first_order == "Y"){
						?>
						<div style="background:#0000ff;color:#fff;width:15px;display:inline-block;text-align:center;">N</div>
						<?php
						}
						?>
					</td>
					<td>
						<?=$lt->trade_day?><br>
						<?=$lt->trade_code?><br>
						<?php
						if($lt->trade_stat > 1 and $lt->trade_stat < 4){
							?>
							<a href="/html/order/delivery/m?sch_item=trade_code&sch_item_val=<?=$lt->trade_code?>" target="_blank" class="btn-ok" style="color:#fff;padding:3px 7px; font-size:11px">배송내역조회</a><br>
							<?php
						}
						?>
						[<?=($lt->mobile)?"M":"P";?>]
					</td>
					<td>
						<?php
						if($lt->recom_is == "Y"){
							echo "<span style='color:blue;font-weight:600;'>정기배송</span>";
						}
						else if($lt->sample_is == "Y"){
							echo "<span style='color:#000;font-weight:600;'>매장간 이동</span>";
						}
						else{
							echo "<span style='color:red;font-weight:600;'>일반주문</span>";
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
					<td style="position: relative;">
						<a href="javascript:show_layer('<?=$lt->idx?>');"><?=$lt->name?></a><br>
						<div class="layer_t layer_t<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: relative;top: 0px;left: 0px;z-index:999">
							<a href="javascript:window.open('/html/member/user/m/edit/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
							<a href="javascript:window.open('/html/member/user/m/order/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
							<a href="javascript:window.open('/html/member/user/m/point/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">적립금내역</a>
							<a href="javascript:window.open('/html/member/user/m/deposit/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">예치금내역</a>
							<a href="javascript:window.open('/html/member/coupon/<?=$lt->useridx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
						</div>
						<?=$lt->userid?>
					</td>
					<td><?=$lt->phone?></td>
					<td><?=$lt->send_name?><br><?=$lt->send_phone?></td>
					<td><?=number_format($lt->total_price)?></td>
					<td>
						<?=$shop_info['trade_method'.$lt->trade_method]?><br>
						<span class="dh_blue_st">
						<?php
						if($lt->trade_method == '8'){
							echo strtoupper($lt->memo);
						}
						if($lt->cash_number){
							echo $lt->cash_receipt == 1 ? "소득공제" : "지출증빙" ;
							echo "<BR>";
							echo $lt->cash_number;
						}
						?>
						</span>
					</td>
					<td>
						<?php
						$deliv_total_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$lt->trade_code."' group by deliv_code","cnt");
						$deliv_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$lt->trade_code."' and deliv_stat > 1 group by deliv_code","cnt");

						echo $deliv_cnt."/".$deliv_total_cnt;
						?>
					</td>
					<td><input type="button" value="보기" onclick="location.href='<?=cdir()?>/order/lists/m/view/<?=$lt->idx?>/<?=$query_string.$param?>'"></td>
				</tr>
				<?php
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
			</form>
		</tbody>
	</table>

	<!-- 제품 액션 버튼 -->
	<div class="float-wrap mt20">
		<div class="float-l">
			<input type="button" value="선택삭제" onclick="order_del()">
			<input type="button" value="<?=($_GET)?"검색된 ":"";?>주문내역 엑셀저장" class="btn-alert" id="excel_down">
			<!-- <input type="button" value="선택엑셀저장" class="btn-etc" onclick="">
			<input type="button" value="전체엑셀저장" class="btn-etc" onclick="<?if($totalCnt>0){?>location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/excel_download/<?=$trade_stat?>/<?=$query_string?>&cont=lists&flag=1'<?}else{?>javascript:alert('저장할 주문건이 없습니다.');<?}?>">
			<input type="button" value="운송장번호 일괄저장" class="btn-special" onclick="delivery_ok();"> -->
		</div>
		<div class="float-r">
			※ 선택한 데이터를
			<select name="sel_chagne" id="sel_chagne">
				<option value="">선택</option>
				<option value="1">입금대기</option>
				<option value="2">입금완료/배송대기</option>
				<option value="3">배송중</option>
				<option value="4">배송완료</option>
				<option value="10">취소신청</option>
				<!-- <option value="9">취소</option> -->
				<!-- <option value="31">배송일시정지</option> -->
			</select>
			<input type="button" value="변경" class="btn-ok" onclick="sel_change();">
		</div>
	</div><!-- END 제품 액션 버튼 -->

	<? if(count($list) > 0){ ?>
		<!-- Pager -->
		<p class="list-pager align-c" title="페이지 이동하기">
			<?=$Page2?>
		</p><!-- END Pager -->
	<?}?>

				<?php
				/*
				<form method="post" name="select_form">
				<input type="hidden" name="del_ok">
				<input type="hidden" name="change_stat">
				<table class="adm-table line align-c">
					<caption>주문 목록</caption>
					<colgroup>
						<col style="width:1px;"><col style="width:142px;"><col style="width:190px;"><col style="width:113px;"><col style="width:110px;"><col style="width:80px;"><col style="width:90px;"><col style="width:85px;"><col style="width:30px;">
					</colgroup>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th>
							<th>주문번호</th>
							<th>운송장번호</th>
							<th>주문자<br>(아이디)</th>
							<th>결제금액</th>
							<th>결제방법</th>
							<th>주문일</th>
							<th>거래상태</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
					<?
					$list_result = 0;
					$cnt=0;
					if($totalCnt>0){
						$list_result=1;
						foreach($list as $lt){
							$cnt++;
					?>
						<input type="hidden" name="trade_idx<?=$cnt?>" value="<?=$lt->idx?>">
						<tr class="sel<?=$lt->idx?>">
							<td><input type="checkbox" name="check<?=$cnt?>" value="<?=$lt->trade_code?>" class="sel"></td>
							<td><?=$lt->trade_code?></td>
							<td class="pr0">
								<select name="delivery_idx<?=$lt->idx?>" id="delivery_idx<?=$lt->idx?>" style="max-width:90px;">
									<? for($i=1;$i<=$shop_info['delivery_cnt'];$i++){  ?>
									<option value="<?=$i?>" <? if($lt->delivery_idx == $i){?>selected<?}?> ><?=$shop_info['delivery_idx'.$i]?></option>
									<?}?>
								</select>
								<input type="text" name="delivery_no<?=$lt->idx?>" class="width-xs2" value="<?=$lt->delivery_no?>">
							</td>
							<td><? if($lt->mobile==1){?><img src="/_data/image/m.png" style="vertical-align:middle;"><?}?><?=$lt->name?><br><?if($lt->userid){?>(<a href="<?=cdir()?>/member/user/m?item=userid&val=<?=$lt->userid?>"><?=$lt->userid?></a>)<?}else{?><font color="gray">비회원</font><?}?></td>
							<td><?=number_format($lt->total_price)?>원</td>
							<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
							<td><?=substr($lt->trade_day,0,10)?></td>
							<td>
								<select name="" onchange="cancel('<?=$lt->trade_method?>',this.value,'<?=$lt->idx?>','<?=$lt->trade_code?>','<?=$lt->tno?>')">
									<option value="">선택</option>
									<? foreach($trade_stat_list as $t_list){
										$i = explode("trade_stat",$t_list->name);
										$i = $i[1];
									?>
									<option value="<?=$i?>" <?if($lt->trade_stat==$i){?>selected<?}?>><?=str_replace("중","",$t_list->val)?></option>
									<?
									}
									?>
								</select>
							</td>
							<td><input type="button" value="상세" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/order/lists/<?=$trade_stat?>/m/?view=1&idx=<?=$lt->idx?>';"></td>
						</tr>
						<?
						}
					}else{
					?>
						<tr>
							<td colspan="10">등록된 내용이 없습니다.</td>
						</tr>
					<?}?>
					</tbody>
				</table>
				<input type="hidden" name="formCnt" value="<?=$cnt?>">
				</form>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="del();">
						<!-- <input type="button" value="선택엑셀저장" class="btn-etc" onclick=""> -->
						<input type="button" value="전체엑셀저장" class="btn-etc" onclick="<?if($totalCnt>0){?>location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/excel_download/<?=$trade_stat?>/<?=$query_string?>&cont=lists&flag=1'<?}else{?>javascript:alert('저장할 주문건이 없습니다.');<?}?>">
						<input type="button" value="운송장번호 일괄저장" class="btn-special" onclick="delivery_ok();">
					</div>
					<div class="float-r">
						※ 선택한 데이터를
						<select name="sel_chagne" id="sel_chagne">
							<option value="">선택</option>
							<? for($i=1;$i<=$trade_stat_cnt;$i++){
								if(isset($shop_info['trade_stat'.$i]) && $i!=9){
							?>
								<option value="<?=$i?>"><?=str_replace("중","",$shop_info['trade_stat'.$i])?></option>
							<?}
							}
							?>
						</select>
						<input type="button" value="변경" class="btn-ok" onclick="sel_change();">
					</div>
				</div><!-- END 제품 액션 버튼 -->

				<!-- END 제품리스트 -->
				<? if($list_result==1){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
				<?}?>
				*/
				?>

		<form name="delFrm" method="post">
		<input type="hidden" name="del_ok" value="1">
		<input type="hidden" name="del_idx">
		</form>


<script>
	function order_del(){
		if($(".sel:checked").length > 0){
			if(confirm('주문을 영구히 삭제하시겠습니까?\n\n영구히 삭제하신 주문은 어떠한 수단으로도 복구할 수 없습니다.')){
				document.odlist.mode.value="order_del";
				document.odlist.submit();
			}
		}
		else{
			alert("삭제하실 주문을 선택해 주세요.");
		}
	}

				$(function(){
					$("input[name='search_flag']").on("change",function(){
						$("#s_flag1").hide();
						$("#s_flag2").hide();
						$("#s_flag"+$(this).val()).show();
						if($(this).val()==1){
							$("#search_order").show();
						}else{
							$("#search_order").hide();
						}
					});
				});

		function searchSend(form) {
			if(event.keyCode==13) {
				form.submit();
			}
		}


	<? if(isset($cate_no2)){ ?>
		cate_chg(2, "<?=$cate_no1?>","<?=$cate_no2?>");
	<?}?>

	<? if(isset($cate_no3)){ ?>
		setTimeout('cate_chg(3, "<?=$cate_no2?>","<?=$cate_no3?>")',50);
	<?}?>

	<? if(isset($cate_no4)){ ?>
		setTimeout('cate_chg(4, "<?=$cate_no3?>","<?=$cate_no4?>")',100);
	<?}?>

	function cate_chg(depth, cate_no, sel_no)
	{
			if(cate_no!=""){

				$.ajax({
					url: "<?=cdir()?>/product/write",
					data: {ajax : "1", depth : depth, cate_no: cate_no, sel_no: sel_no},
					async: true,
					cache: false,
					error: function(xhr){
					},
					success: function(data){
						for(i=depth;i<=4;i++){
							$("#cate_no"+i).hide();
							$("#cate_no"+i).val("");
						}
						if(data){
							$("#cate_no"+depth).html(data);
							$("#cate_no"+depth).show();
						}
					}
				});
			}else{
				for(i=depth;i<=4;i++){
					$("#cate_no"+i).hide();
					$("#cate_no"+i).val("");
				}

				$("#cate_depth").val(depth);
			}

	}


	function sel(depth, cate_no)
	{
		$("#cate_no"+depth).val(cate_no).attr("selected", "selected");
	}

	function del()
	{
		if($(".sel:checked").length > 0){
			if(confirm('거래가 완료되지 않은 주문을 삭제 하게되면 시스템상 오류가 발생할수도 있습니다.\n데이터가 유지되는걸 원하시면 거래상태를 주문취소로 변경하여 주십시오.\n정말로 삭제하시겠습니까?')){
				document.select_form.del_ok.value=1;
				document.select_form.submit();
			}
		}else{
			alert('삭제할 주문을 선택해주세요.');
		}
	}

	function sel_change()
	{
		if($("#sel_chagne").val()==""){
			alert('변경할 거래상태를 선택해주세요.');
			$("#sel_chagne").focus();
		}else if($(".sel:checked").length > 0){
			if(confirm("상태를 변경 하시겠습니까?\n\n※ 주문이 취소될 경우 정기주문내역의\n모든 연동데이터가 삭제됩니다.")){
				document.odlist.mode.value="change_stat";
				document.odlist.change_stat_value.value=$("#sel_chagne").val();
				document.odlist.submit();
			}
		}else{
			alert('변경할 주문을 선택해주세요.');
		}
	}

	function delivery_ok()
	{
		document.select_form.del_ok.value=3;
		document.select_form.submit();
	}

	$(function(){
		$(".sel").on("click",function(){
			var checkObj = $(this);

       if(checkObj.is(":checked") == true){
				$(".sel"+checkObj.val()).addClass("selected");
       }else{
				$(".sel"+checkObj.val()).removeClass("selected");
       }

		});

     $("#allcheck1").change(function(){

     var checkObj = $('.sel');

          if(this.checked){
             checkObj.prop("checked",true);
						$(".ft092 tr").addClass("selected");
          }else{
             checkObj.prop("checked",false);
						$(".ft092 tr").removeClass("selected");
          }
     });

		 $("#excel_down").on('click',function(){
			 location.href="<?=$_SERVER['PHP_SELF']?>?ajax=1&excel=ok&<?=$_SERVER['QUERY_STRING']?>";
		 });
	});


			function cancel(trade_method,change_stat,idx,trade_code,tno)
			{
				if(trade_method==1 && change_stat==9){

				if(confirm("카드주문을 취소하시겠습니까?")){
					card_cancel(trade_code,tno);
				}
				}else{
					if(confirm('거래상태를 변경하시겠습니까?')){
						location.href="<?=$_SERVER['PHP_SELF'].$query_string.$param?>&change_idx="+idx+"&change_stat="+change_stat;
					}
				}
			}
			</script>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>
