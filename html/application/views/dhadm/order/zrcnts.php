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

<h3 class="icon-list">배송 상품이 없는 주문내역</h3>
<div class="float-wrap mt30 mb20">
	<div class="float-l">
		총 <?=number_format($totalCnt)?>건이 검색되었습니다.
	</div>
</div>

<table class="adm-table line align-c">
	<thead>
		<tr>
			<!-- <th style="width:1%;"><input type="checkbox" id="allcheck"><label for="allcheck" class="hidden">모두선택</label></th> -->
			<th style="width:7%;"><!-- 주문단계<br> -->배송일<!-- <br>배송일변경 --></th>
			<th><!-- 주문일자<br> -->주문번호 [PC/Mobile]<br>배송상태</th>
			<th>주문내역</th>
			<th style="width:8%;">연락처<br>주문자성명<br>아이디</th>
			<th style="width:8%;">연락처<br>받는분</th>
			<!-- <th style="width:7%;">결제수단<br>주문금액</th> -->
			<th>배송지<br>배송시요청사항</th>
			<!-- <th colspan="2" style="width:10%;">송장번호</th> -->
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
				<!-- <td><input type="checkbox" name="check[]" value="<?=$lt->deliv_code?>" class="sel"></td> -->
				<td style="text-align:left">
					<!-- <?=$shop_info['trade_stat'.$lt->trade_stat]?>
					<?php
					if($lt->first_order == "Y"){
					?>
					<div style="background:#0000ff;color:#fff;width:15px;display:inline-block;text-align:center;">N</div>
					<?php
					}
					?>
					<br> -->
					<span style="font-weight:600;color:blue;"><?=$lt->deliv_date?></span>
					<!-- <br>
					<input type="button" value="배송일 변경" class="btn-sm btn-alert" onclick="deliv_date_chg('<?=$lt->deliv_code?>')"> -->
				</td>
				<td>
					<!-- <?=$lt->trade_day?><br> -->
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
						echo $lt->prod_name;
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
					<div class="layer_t layer_t<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: absolute;top: 50px;left: 0px;z-index:999">
						<a href="javascript:window.open('/html/member/user/m/edit/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
						<a href="javascript:window.open('/html/member/user/m/order/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
						<a href="javascript:window.open('/html/member/user/m/point/<?=$lt->useridx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">포인트내역</a>
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
					<div class="layer_t layer_r<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: absolute;top: 60px;left: 0px;z-index:999">
						<a href="javascript:window.open('/html/member/smspop?ajax=1&phone=<?=$lt->recv_phone?>&name=<?=$lt->recv_name?>&uid=<?=$lt->userid?>','sms_pop','width=505, height=526');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">SMS 발송</a>
					</div>
				</td>
				<!-- <td><?=$shop_info['trade_method'.$lt->trade_method]?><br><?=number_format($lt->total_price)?></td> -->
				<td>
					<?=$lt->addr1?><br><?=$lt->addr2?><br>
					<?=($lt->send_text)?"<span style='color:blue;font-weight:bold'>요청사항 : </span>".$lt->send_text:"";?>
				</td>
				<?php
				/*
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
				*/
				?>
				<td class="title">
					<input type="button" value="보기" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/delivery/<?=$this->uri->segment(3)?>/view/<?=$lt->deliv_code?>'">

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