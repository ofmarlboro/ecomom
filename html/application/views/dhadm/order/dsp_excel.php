<style type="text/css">
	.step_select div{
		display:inline-block;
		text-align:center;
		vertical-align:middle;
		padding:10px;
		/* font-weight:600; */
		font-size:16px;
		background:#e4e4e4;
		color:#000;
		border:1px solid #000;
		cursor:pointer;
	}

	.step_select div.on{
		display:inline-block;
		text-align:center;
		vertical-align:middle;
		padding:10px;
		font-weight:600;
		font-size:16px;
		background:#000;
		color:#e4e4e4;
		border:1px solid #e4e4e4;
		cursor:pointer;
	}

	.step_select input[type="radio"]{
		display:none;
	}

	.allergy{
		border:1px solid #BCA062;
		background:#BCA062;
		color:#fff;
		font-weight:bold;
	}
</style>

<?php
if($this->input->get('PageNumber')){
?>
<script type="text/javascript">
	$(function(){
		$("html, body").scrollTop(1000);
	});
</script>
<?php
}
?>

<script type="text/javascript">
	$(function(){
		$(".depth1 div").click(function(){
			$(".depth1 div").removeClass('on');
			$(this).addClass('on');
		});

		$(".depth2 div").click(function(){
			$(".depth2 div").removeClass('on');
			$(this).addClass('on');
		});

		$(".depth3 div").click(function(){
			$(".depth3 div").removeClass('on');
			$(this).addClass('on');
		});

		$(".goods_info div").click(function(){
			$(".goods_info div").removeClass('on');
			$(this).addClass('on');
		});


		$("input[name='cate_type']").on('change', function(){

			if($(this).val() <= "18"){

				$(".goods_info").hide();
				$("input[name='goods_info']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$(".depth3").hide();
				$("input[name='recom_deliv_suntype']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$("input[name='recom_week_day_count']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$("input[name='recom_week_day_count']").eq(0).prop('checked', true);
				$("input[name='recom_week_day_count']").siblings('label').eq(0).find('div').addClass('on');

				$(".depth2").show();

			}
			else if($(this).val() == "19"){
				$(".depth2").hide();
				$("input[name='recom_week_day_count']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$(".depth3").hide();
				$("input[name='recom_deliv_suntype']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$(".goods_info").show();
				$("input[name='goods_info']").eq(0).prop('checked', true);
				$("input[name='goods_info']").siblings('label').eq(0).find('div').addClass('on');
			}
			else{
				$(".depth2").hide();
				$("input[name='recom_week_day_count']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$(".depth3").hide();
				$("input[name='recom_deliv_suntype']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});

				$(".goods_info").hide();
				$("input[name='goods_info']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});
			}

		});

		$("input[name='recom_week_day_count']").on('change', function(){

			if($(this).val() == "7"){
				$(".depth3").show();
			}
			else{
				$(".depth3").hide();
				$("input[name='recom_deliv_suntype']").each(function(){
					$(this).prop('checked', false);
					$(this).siblings('label').find("div").removeClass('on');
				});
			}

		});

		$(".all_check").on("click",function(){	//전체선택 노란 버튼 토글기능 및 전체선택 기능과 가로행별 체크 불가하게
			var type = $(this).data('part');
			var attr = $(this).text();

			$(".ordertypes").prop('checked', false);

			if(attr == "전체선택 >"){
				$(this).text("전체해제 >");
				$(this).css({'background':'#333','color':'#fac655'});
				$("."+type).prop('checked',true);
				$(".orderg input[type='checkbox']").not("."+type).attr('disabled', true);
				$(".or_btn").not($(this)).attr('disabled', true);
			}
			else{
				$(this).text("전체선택 >");
				$(this).css({'background':'#fac655','color':'#333'});
				$("."+type).prop('checked',false);
				$(".orderg input[type='checkbox']").not("."+type).attr('disabled', false);
				$(".or_btn").not($(this)).attr('disabled', false);
			}
		});

		$(".ordertypes").on("change",function(){	//체크박스 가로행 체크시 다른 가로행 체크 못하게 막아주는 부분
			var className = $(this).attr('class').split(" ");
			var className = className[0];
			$("."+className).each(function(){
				checked_chk = $(this).prop('checked');
				if(checked_chk){
					$(".orderg input[type='checkbox']").not("."+className).attr('disabled', true);
					return false;
				}
				else{
					$(".orderg input[type='checkbox']").not("."+className).attr('disabled', false);
					return true;
				}
			});
		});

		$("#allcheck").on('change',function(){
			if(this.checked == true){
				$(".sel").prop('checked',true);
			}
			else{
				$(".sel").prop('checked',false);
			}
		});
	});

	//날짜 자동 입력
	function set_date_val(sd, ed){	// 배송일자 오늘 / 내일 버튼 클릭시 날짜 자동 입력
		$("#start_date").val(sd);
		$("#end_date").val(ed);
	}

	//검색 폼 전송
	function order_form_send(val){	//검색 폼 전송
		if(val){
			document.order_info.order_types.value = val;
			document.order_info.submit();
		}
		else{
			var checked_values = "";

			$(":input[type='checkbox']").each(function(){
				if($(this).prop('checked')){
					checked_values += $(this).val()+",";
				}
			});

			$(".all_check").each(function(){
				if($(this).text() == "전체해제 >"){
					document.order_info.all_check_btn.value = $(this).data('part');
					return false;
				}
			});

			document.order_info.order_types.value = checked_values

			if(document.order_info.order_types.value == ""){
				alert('검색하실 단계를 선택해 주세요.');
				return;
			}

			document.order_info.submit();
		}
	}

	function order_form_excel(){
		document.order_info.excel.value = "ok";
		document.order_info.ajax.value = "1";
		document.order_info.submit();
	}

	function deliv_stat_change(type){
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
				if(type == "with_print"){
					print_order();
				}
			}
		}
		else{
			alert("변경하실 배송내역을 선택해 주세요.");
		}
	}

	function print_order(){
		var frm = document.list_frm;
		frm.action = "<?=cdir()?>/order/delivery_print_new/m/?ajax=1";
		frm.target = "popup_window";
		window.open("","popup_window","width=1280,height=800,top=100,left=100,scrollbars=yes");
		frm.submit();
	}

	function excel_save_page(url){
		//alert(url);
		location.href=url+"&ajax=1&excel=ok";
	}
</script>

<?php
if($this->input->get('all_check_btn')){
?>
<script type="text/javascript">
	$(function(){
		$(".all_check").each(function(){
			var type = $(this).data('part');

			if( type == "<?=$this->input->get('all_check_btn')?>" ){
				$(this).text("전체해제 >");
				$(this).css({'background':'#333','color':'#fac655'});
				$("."+type).prop('checked',true);
				$(".orderg input[type='checkbox']").not("."+type).attr('disabled', true);
				$(".or_btn").not($(this)).attr('disabled', true);
				return false;
			}
		});
	});
</script>
<?php
}

if($this->input->get('order_types')){
	$json_arr = json_encode(explode(",", substr($this->input->get('order_types'),0,-1)));
?>
<script type="text/javascript">
	var get_param_json = <?=$json_arr?>;
	$(function(){
		$(".ordertypes").each(function(){
			if(get_param_json.includes($(this).val())){
				$(this).prop('checked', true);
			}
		});

		var className = $(".ordertypes:checked").attr('class').split(" ");
		var className = className[0];

		$("."+className).each(function(){
			checked_chk = $(this).prop('checked');
			if(checked_chk){
				$(".orderg input[type='checkbox']").not("."+className).attr('disabled', true);
				return false;
			}
			else{
				$(".orderg input[type='checkbox']").not("."+className).attr('disabled', false);
				return true;
			}
		});
	});
</script>
<?php
}
?>

	<div class="orderg">
		<h5><img src="/image/sub/task.png" alt="" class="mr5"> DPS 엑셀 출력</h5>
	</div>

	<form name="order_info">
	<input type="hidden" name="all_check_btn">
	<input type="hidden" name="order_types">
	<input type="hidden" name="excel">
	<input type="hidden" name="ajax">

	<table class="adm-table mb30">
		<tr>
			<th width="15%">
				<p style="color:#000">배송일자</p>
			</th>
			<td>
				<input type="text" name="sch_sdate" id="start_date" class="width-s" value="<?=$this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d",strtotime('+1 day')) ;?>" readonly> ~
				<input type="text" name="sch_edate" id="end_date" class="width-s" value="<?=$this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d",strtotime('+1 day')) ;?>" readonly>
				<button type="button" onclick="set_date_val('<?=date("Y-m-d")?>','<?=date("Y-m-d")?>')" class="btn-clear">오늘</button>
				<button type="button" onclick="set_date_val('<?=date("Y-m-d", strtotime('tomorrow'))?>','<?=date("Y-m-d", strtotime('tomorrow'))?>')" class="btn-clear deliv">내일</button>
			</td>
			<td>
				<input type="button" value="<?=date("Y년 m월 d일", strtotime('tomorrow'))?> 배송 전체 엑셀저장" class="btn-cancel" onclick="order_form_excel()">
			</td>
			<td>
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
					var sch_deliv_stat = document.order_info.sch_deliv_stat;
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
					var sch_trade_stat = document.order_info.sch_trade_stat;
					for(i=0;i<sch_trade_stat.length;i++){
						if(sch_trade_stat.options[i].value == "<?=$this->input->get('sch_trade_stat')?>"){
							sch_trade_stat.options[i].selected = true;
						}
					}
				</script>

				<select name="sch_other">
					<option value="">기타검색</option>
					<option value="invoice">운송장정보 입력건</option>
					<option value="no_invoice">운송장정보 미입력건</option>
					<option value="overlap">중복주문 확인</option>
				</select>
				<script type="text/javascript">
					var sch_other = document.order_info.sch_other;
					for(i=0;i<sch_other.length;i++){
						if(sch_other.options[i].value == "<?=$this->input->get('sch_other')?>"){
							sch_other.options[i].selected = true;
						}
					}
				</script>
			</td>
			<td>
				<input type="button" value="검색하기" class="btn-ok" onclick="order_form_send()">
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<?php
				$cnt = 0;
				//deliv_stat_arr
				echo date("Y년 m월 d일 배송현황 : ",strtotime('+1 day'));
				foreach($order_cnts as $oc){
					echo " ".$deliv_stat_arr[$cnt]." : ".$oc." 건 |";
					$cnt++;
				}
				?>
			</td>
		</tr>
	</table>

	<!-- 수정된 form 입니다. -->
	<div class="orderg">

		<table class="t01 mb30">
			<tr>
				<th>
					<p class="tit"><label for="a_all">낱개배송</label></p>
					<p>
						<button type="button" class="or_btn org all_check" data-part="a">전체선택 ></button>
					</p>
				</th>
				<td>
					<input type="checkbox" id="a1" class="a ordertypes" value="100000"> <label for="a1">준비기</label>
				</td>
				<td>
					<input type="checkbox" id="a2" class="a ordertypes" value="200000"> <label for="a2">초기</label>
				</td>
				<td>
					<input type="checkbox" id="a3" class="a ordertypes" value="600000"> <label for="a3">중기준비기</label>
				</td>
				<td>
					<input type="checkbox" id="a4" class="a ordertypes" value="500000"> <label for="a4">중기</label>
				</td>
				<td>
					<input type="checkbox" id="a5" class="a ordertypes" value="400000"> <label for="a5">후기</label>
				</td>
				<td>
					<input type="checkbox" id="a6" class="a ordertypes" value="300000"> <label for="a6">완료기</label>
				</td>
				<td>
					<input type="checkbox" id="a7" class="a ordertypes" value="700000"> <label for="a7">반찬</label>
				</td>
				<td>
					<input type="checkbox" id="a8" class="a ordertypes" value="800000"> <label for="a8">국</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //낱개배송 -->
			<tr style="display:none;">
				<th>
					<p class="tit">낱개배송+간식</p>
					<p><button type="button" class="or_btn org all_check" data-part="b">전체선택 ></button></p>
				</th>
				<td>
					<input type="checkbox" id="b1" class="b ordertypes" value="100010"> <label for="b1">준비기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b2" class="b ordertypes" value="200010"> <label for="b2">초기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b3" class="b ordertypes" value="600010"> <label for="b3">중기준비기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b4" class="b ordertypes" value="500010"> <label for="b4">중기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b5" class="b ordertypes" value="400010"> <label for="b5">후기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b6" class="b ordertypes" value="300010"> <label for="b6">완료기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b7" class="b ordertypes" value="700010"> <label for="b7">반찬<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="b8" class="b ordertypes" value="800010"> <label for="b8">국<br>+간식</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //낱개배송+간식 -->
			<tr>
				<th>
					<p class="tit">낱개배송+다른낱개</p>
					<p><button type="button" class="or_btn org all_check" data-part="c">전체선택 ></button></p>
				</th>
				<td>
					<input type="checkbox" id="c1" class="c ordertypes" value="100011"> <label for="c1">준비기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c2" class="c ordertypes" value="200011"> <label for="c2">초기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c3" class="c ordertypes" value="600011"> <label for="c3">중기준비기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c4" class="c ordertypes" value="500011"> <label for="c4">중기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c5" class="c ordertypes" value="400011"> <label for="c5">후기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c6" class="c ordertypes" value="300011"> <label for="c6">완료기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c7" class="c ordertypes" value="700011"> <label for="c7">반찬<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="c8" class="c ordertypes" value="800011"> <label for="c8">국<br>+낱개</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //낱개배송+다른날개 -->
		</table>

		<table class="t02 mb30">
			<tr>
				<th>
					<p class="tit">정기배송</p>
					<p><button type="button" class="or_btn org all_check" data-part="aa">전체선택 ></button></p>
				</th>
				<td>
					<input type="checkbox" id="aa1" class="aa ordertypes" value="1000"> <label for="aa1">준비기</label>
				</td>
				<td>
					<input type="checkbox" id="aa2" class="aa ordertypes" value="2000"> <label for="aa2">초기</label>
				</td>
				<td>

				</td>
				<td>
					<input type="checkbox" id="aa4" class="aa ordertypes" value="5000"> <label for="aa4">중기</label>
				</td>
				<td>
					<input type="checkbox" id="aa5" class="aa ordertypes" value="4100"> <label for="aa5">후기2식</label>
				</td>
				<td>
					<input type="checkbox" id="aa6" class="aa ordertypes" value="4200"> <label for="aa6">후기3식</label>
				</td>
				<td>
					<input type="checkbox" id="aa7" class="aa ordertypes" value="3000"> <label for="aa7">완료기</label>
				</td>
				<td>
					<input type="checkbox" id="aa8" class="aa ordertypes" value="7000"> <label for="aa8">반찬국</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //정기배송 -->
			<tr style="display:none;">
				<th>
					<p class="tit">정기배송+간식</p>
					<p><button type="button" class="or_btn org all_check" data-part="bb">전체선택 ></button></p>
				</th>
				<td>
					<input type="checkbox" id="bb1" class="bb ordertypes" value="1010"> <label for="bb1">준비기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="bb2" class="bb ordertypes" value="2010"> <label for="bb2">초기<br>+간식</label>
				</td>
				<td>

				</td>
				<td>
					<input type="checkbox" id="bb4" class="bb ordertypes" value="5010"> <label for="bb4">중기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="bb5" class="bb ordertypes" value="4110"> <label for="bb5">후기2식<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="bb6" class="bb ordertypes" value="4210"> <label for="bb6">후기3식<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="bb7" class="bb ordertypes" value="3010"> <label for="bb7">완료기<br>+간식</label>
				</td>
				<td>
					<input type="checkbox" id="bb8" class="bb ordertypes" value="7010"> <label for="bb8">반찬국<br>+간식</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //정기배송+간식 -->
			<tr>
				<th>
					<p class="tit">정기배송+다른낱개</p>
					<p><button type="button" class="or_btn org all_check" data-part="cc">전체선택 ></button></p>
				</th>
				<td>
					<input type="checkbox" id="cc1" class="cc ordertypes" value="1011"> <label for="cc1">준비기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="cc2" class="cc ordertypes" value="2011"> <label for="cc2">초기<br>+낱개</label>
				</td>
				<td>

				</td>
				<td>
					<input type="checkbox" id="cc4" class="cc ordertypes" value="5011"> <label for="cc4">중기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="cc5" class="cc ordertypes" value="4111"> <label for="cc5">후기2식<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="cc6" class="cc ordertypes" value="4211"> <label for="cc6">후기3식<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="cc7" class="cc ordertypes" value="3011"> <label for="cc7">완료기<br>+낱개</label>
				</td>
				<td>
					<input type="checkbox" id="cc8" class="cc ordertypes" value="7011"> <label for="cc8">반찬국<br>+낱개</label>
				</td>
				<!-- <td>
					<button type="button" class="or_btn black" onclick="">검색 ></button>
				</td> -->
			</tr>
			<!-- //정기배송+다른낱개 -->
		</table>

		<table>
			<tr>
				<!-- <th class="col1">
					<p class="tit">정기+낱개+간식</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('999999')">전체검색 ></button></p>
				</th> -->
				<th class="col2">
					<p class="tit">특가세트</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('9020')">전체검색 ></button></p>
				</th>
				<th class="col2">
					<p class="tit">간식+건강식품</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('9100')">전체검색 ></button></p>
				</th>
				<th class="col2">
					<p class="tit">오! 산골농부</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('9200')">전체검색 ></button></p>
				</th>
				<th class="col2">
					<p class="tit">산골 맛보기 세트</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('9010')">전체검색 ></button></p>
				</th>
				<th class="col2">
					<p class="tit">기타</p>
					<p><button type="button" class="or_btn org" onclick="order_form_send('999999')">전체검색 ></button></p>
				</th>
				<!-- <td></td>
				<td></td>
				<td></td>
				<td></td> -->
			</tr>

		</table>

	</div>
	</form>

<!-- END 수정된 form 입니다. -->


	<div class="float-wrap mt30 mb20">
		<div class="float-l" style="font-size:20px;font-weight:600;line-height:120px">
			총 <?=number_format($totalCnt)?>건의 배송내역이 검색되었습니다.
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

	<?php
	/*
	<table class="adm-table line align-c">
		<thead>
			<tr>
				<th style="width:1%;"><input type="checkbox" id="allcheck"> <label for="allcheck" class="hidden">모두선택</label></th>
				<th style="width:7%;">주문단계<br>배송일<br>배송일변경</th>
				<th>주문일자<br>주문번호 [PC/Mobile]<br>배송상태</th>
				<th>주문내역</th>
				<th>알레<br>르기<br>체크</th>
				<th style="width:7%;">주문자성명<br>아이디<br>연락처</th>
				<th style="width:8%;">받는분<br>연락처</th>
				<th style="width:7%;">결제수단<br>주문금액</th>
				<th>배송지<br>배송시요청사항</th>
				<th>송장번호</th>
				<th style="width:7%;">비고</th>
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
				<tr>
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
						<?=$lt->deliv_date?><br>
						<input type="button" value="배송일 변경" class="btn-sm btn-alert" onclick="deliv_date_chg('<?=$lt->deliv_code?>')">
					</td>
					<td>
						<?=date("Y-m-d",strtotime($lt->trade_day))?><br>
						<?=$lt->trade_code?>[<?=($lt->mobile)?"M":"P";?>]<br>
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
						if($lt->recom_idx > 0){
							//echo "[영양식단] ".$recom_name_arr[$lt->recom_idx];
							echo str_replace(",","<br>",$lt->prod_name);
						}
						else{
							$dprow = $this->common_m->self_q("select *,(select name from dh_goods where idx = dh_trade_deliv_prod.goods_idx) as goods_name from dh_trade_deliv_prod where deliv_code = '{$lt->deliv_code}' and recom_is != 'Y'","result");
							foreach($dprow as $dp){
								echo $dp->goods_name."<BR>";
							}
						}
						?>
					</td>
					<td>
						<?php
						if($lt->allergy){
						?>
						<span class="allergy">AL</span>
						<?php
						}
						?>
					</td>
					<td><?=$lt->order_name?><br><?=$lt->userid?><br><?=$lt->order_phone?></td>
					<td><?=$lt->recv_name?><br><?=$lt->recv_phone?></td>
					<td><?=$shop_info['trade_method'.$lt->trade_method]?><br><?=$lt->total_price > 0 ? number_format($lt->total_price) : "" ;?></td>
					<td>
						<?=$lt->addr1?><br><?=$lt->addr2?><br>
						<?=($lt->send_text)?"<span style='color:blue;font-weight:bold'>요청사항 : </span>".$lt->send_text:"";?>
					</td>
					<td><?=($lt->invoice_no)?"우체국<br>".$lt->invoice_no:'-';?></td>
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
	*/
	?>

	<!-- <div class="float-wrap mt30">
		<div class="float-l">
			<input type="button" value="선택된 항목 주문내역서 검색 (새창)" onclick="print_order()"><p class="mt10"></p>
			선택된 항목을
			<select name="chagne_deliv_stat">
				<option value="1">배송준비중</option>
				<option value="2">배송중</option>
				<option value="3">배송완료</option>
			</select>
			(으)로
			<input type="button" value="변경" onclick="deliv_stat_change('change')">
			합니다.

			<br><br>

			<label><input type="checkbox" name="deliv_info_mail" value='1'> 배송안내 이메일발송</label>
			<br>
			<label><input type="checkbox" name="deliv_info_sms" value='1'> 배송안내 알림톡발송</label>

			<br><br>

			<label><input type="checkbox" class="chk_rdo" name="auto_invoice_check" value='1'> 우체국택배 운송장번호 자동받기</label>
			<br>
			<label><input type="checkbox" class="chk_rdo" name="auto_invoice_check2" value='2'>CJ택배 운송장번호 자동받기 (추후 작업예정 - 계약하신후 정보전달 해주세요.)</label>
			<br><br>
			<input type="button" value="선택된 주문 수정 및 주문내역서 출력" onclick="deliv_stat_change('with_print')">
		</div>

		<div class="float-r">
			<input type="button" value="배송완료 일괄처리">
		</div>
	</div> -->

	<!-- <? if(count($list) > 0){ ?>
		Pager
		<p class="list-pager align-c mt30" title="페이지 이동하기">
			<?=$Page?>
		</p>END Pager
	<?}?> -->

<!-- <iframe src="" id="invoiceframe" frameborder="0" style="width:0px; height:0px;"></iframe> -->