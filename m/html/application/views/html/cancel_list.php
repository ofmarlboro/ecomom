<?
	if($_SERVER['REMOTE_ADDR'] != "58.229.223.174"){
		alert(cdir()."/dh_board/lists/withcons07?myqna=Y","취소환불은 1:1 문의 게시판을 이용부탁드립니다");
	}
	$PageName = "CANCELLIST";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			취소/환불 가능내역
		</h1>

		<!-- 안내사항 -->
		<p class="orderedit_top"> 변경가능내역만 조회되며, 배송완료/배송<!-- 준비 -->중은 <!-- 변경 불가하고, 제품에 이상이 있는 경우 교환신청 가능합니다. --> 변경이 불가 합니다. </p>
		<!-- //안내사항 -->

		<div class="tblTy02">
			<table>
				<colgroup>
					<col style="width:10%;">
					<col style="width:;">
					<col style="width:;">
					<col style="width:30%;">
				</colgroup>
				<tr>
					<th>구분</th>
					<th>주문내역</th>
					<th>배송상태</th>
					<th>비고</th>
				</tr>
				<?php
				if($list){
					$old_tcode = "";
					foreach($list as $lt){
						if($old_tcode != $lt->trade_code){
						?>
						<tr>
							<td>
								<?php
								if($lt->recom_is == "Y"){
									echo "정기배송";
								}
								else{
									if($lt->sample_is == "Y"){
										echo "샘플신청";
									}
									else{
										echo "일반배송";
									}
								}
								?>
							</td>
							<td>
								<?php
								if($lt->recom_is == "Y"){
									echo ($lt->grade_change) ? $lt->grade_change_recom_name : str_replace(",","<br>",$lt->prod_name) ;
								}
								else{
									$name_arr = explode(",",$lt->prod_name);
									$name_cnt = count($name_arr)-1;

									echo $name_arr[0];

									if($name_cnt > 0){
										echo " 외 ".$name_cnt."건";
									}
								}
								?>
							</td>
							<td>
								<?php
								if($lt->recom_is == "Y"){
									?>
									<!-- <select name="<?=$lt->trade_code?>_dl" class="oe_sel" onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;' style="display:@none;"> -->
									<?php
									$deliv_list_cnt = 0;
									foreach($list as $deliv_list){
										if($lt->trade_code == $deliv_list->trade_code){
											$deliv_list_cnt++;

											if($deliv_list->deliv_stat > 0){
												continue;
											}

											if($deliv_list->deliv_stat == 0){
												$chg_text = "취소가능";
											}
											else if($deliv_list->deliv_stat == 1){
												//$chg_text = "배송중";
												$chg_text = "배송준비중";
											}
											else if($deliv_list->deliv_stat == 2){
												$chg_text = "배송중";
											}
											else{
												//$chg_text = "배송준비중";
												$chg_text = "배송완료";
											}

											$prod_name_arr = explode(",",$deliv_list->prod_name);
											if(count($prod_name_arr) > 1){
												$prod_name_count = count($prod_name_arr) - 1;
											}
										?>
										<input type="hidden" name="<?=$lt->trade_code?>_dl" value="<?=$deliv_list->deliv_code?>">
										<!-- <option value="<?=$deliv_list->deliv_code?>"></option> -->

											<?=date("m/d",strtotime($deliv_list->deliv_date))?>
											(<?=numberToWeekname($deliv_list->deliv_date)?>)
											<?=$prod_name_arr[0]?>
											<?=($prod_name_count) ? "외 ".$prod_name_count."건" : "" ;?>
											<?php
											$deliv_code_arr = explode("-",$deliv_list->deliv_code);
											echo $deliv_count = $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
											?>
											<!-- [<?=$chg_text?>] -->

										<?php
											if($deliv_list_cnt){
												break;
											}
										}
									}
									?>
									<!-- </select> -->
									<?php
								}
								else{
									$name_arr = explode(",",$lt->prod_name);
									$name_cnt = count($name_arr)-1;

									echo date("m/d",strtotime($lt->deliv_date))."(".numberToWeekname($lt->deliv_date).") ".$name_arr[0];

									if($name_cnt > 0){
										echo " 외 ".$name_cnt."건";
									}
								}
								?>
							</td>
							<td>
								<?php
								if($lt->trade_stat == 1){
									//입금대기중
									if($lt->trade_method == 2 || $lt->trade_method == 5){
										//무통장의경우 바로취소
										$go_cancel = "cancel('".$lt->trade_code."',2)";
									}
									else{
										//pg 주문취소
										$go_cancel = "cancel('".$lt->trade_code."','1','".$lt->tno."')";
									}
								?>
								<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_y">취소</a>
								<?php
								}
								else if( $lt->trade_stat == 2 and $lt->deliv_stat == 0 ){
									//입금완료되었으나 배송이 한번도 안나간경우
									//환불 신청서 작성
									//PG는 바로 취소

									if($lt->trade_method == 2 || $lt->trade_method == 99){
										$go_cancel = "cancel_layer('".$lt->trade_code."')";	//무통장 환불신청
									}
									else{
										//pg 주문취소 (바로취소)
										//포인트 전액결제 주문취소
										if($lt->trade_method == "5"){
											$go_cancel = "cancel('".$lt->trade_code."','5')";
										}
										else{
											$go_cancel = "cancel('".$lt->trade_code."','1','".$lt->tno."')";
										}
									}
								?>
								<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_y">취소</a>
								<?php
								}
								else{
									//배송중 이상

									if($lt->trade_stat == 4){	//배송완료일때

									}
									else{	//배송중일때

										if($lt->recom_is == "Y"){	//정기배송의경우
											$go_cancel = "cancel_layer('".$lt->trade_code."')";	//환불신청
											$go_change = "trade_confirm()";
										?>
										<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_y">취소</a>
										<!-- <a href="javascript:;" onClick="<?=$go_change?>" class="btn_y">교환</a> -->
										<?php
										}
										else{
										?>
										<!-- <a href="javascript:;" onClick="cancel_layer();" class="btn_y">취소</a> -->
										<?php
										}

									}
								}
								?>
							</td>
						</tr>
						<?php
						}
						$old_tcode = $lt->trade_code;
					}
				}
				else{
				?>
				<tr>
					<td colspan="4">취소 / 환불 가능 내역이 없습니다.</td>
				</tr>
				<?php
				}
				?>

				<?php
				/*
					<tr>
						<td>자유<br>
							배송</td>
						<td>이유식 중기 8팩</td>
						<td>배송준비중 </td>
						<td><a href="javascript:;" onClick="cancel_layer();" class="btn_y">
							취소
							</a></td>
					</tr>
					<tr>
						<td>정기<br>
							배송</td>
						<td>이유식 중기 8팩</td>
						<td><select name="" id="" class="oe_sel">
								<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
								<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
								<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
							</select></td>
						<td><a href="javascript:;" onClick="cancel_layer();" class="btn_y">
							취소
							</a>
							<a href="javascript:;" onClick="cancel_layer();" class="btn_y">
							교환
							</a></td>
					</tr>
				*/
				?>
			</table>
		</div>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>

<?php
/*
<!-- 배송 3일전 / 조리가 되기 전 -->
<div class="layer_pop" style="display:none;">
	<div class="layer_pop_inner">
		<h1>
			배송 3일전
		</h1>
		<div class="inner clearfix">
			<p> 2018년 2월 1일 목요일 '준비기' 추천식단(정기배송) 주문/배송 내역입니다. </p>
			<div class="tblTy05 mt0">
				<table>
						<td>2018.02.07 수요일 첫 배송 예정입니다.</td>
				</table>
			</div>
			<p class="blue mt10"> ※주문취소는 30분 이내로 적용되며, 쿠폰 및 사용하신 적립금은 다시 복구됩니다. </p>
			<p class="mt20"> 취소사유를 적어 주시면 더 나은 서비스 제공을 위해 노력하겠습니다. </p>
			<p class="ac">
				<textarea name="" id="" class="cancel_area"></textarea>
			</p>
		</div>
		<button type="button" class="w50 close01" title="닫기" onclick='closecancel_layer();'>취소</button>
		<button type="button" class="w50 close" title="닫기">배송일시정지</button>
	</div>
</div>
<!-- END 배송 3일전 / 조리가 되기 전 -->
*/
?>

<!-- 배송중/상품준비중 이상 -->
<div class="layer_pop" style="display:none;">
	<?php
	/*
	<div class="layer_pop_inner">
		<h1>
			배송중
		</h1>
		<div class="inner clearfix">
			<p> 2018년 2월 1일 목요일 '준비기' 추천식단(정기배송) 주문/배송 내역입니다. </p>
			<p class="mt10">
				<select name="" id="" style="width:100%" class="sel">
					<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
					<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
					<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
				</select>
			</p>
			<p class="blue mt10"> ※주문취소는 30분 이내로 적용되며, 쿠폰 및 사용하신 적립금은 다시 복구됩니다. </p>
			<div class="tblTy05 mt0">
				<table>

						<td>취소완료 후 환불 받으실 금액은 <span class="fz18">38,000</span>원 입니다.</td>
				</table>
			</div>
			<p class="mt20"> 취소사유를 적어 주시면 더 나은 서비스 제공을 위해 노력하겠습니다. </p>
			<p class="ac">
				<textarea name="" id="" class="cancel_area"></textarea>
			</p>
		</div>
		<button type="button" class="w50 close01" title="닫기" onclick='closecancel_layer();'>취소</button>
		<button type="button" class="w50 close" title="닫기">배송일시정지</button>
	</div>
	*/
	?>
</div>
<!-- END 배송중/상품준비중 이상 -->

<script type="text/javascript">
	function cancel_layer(tcode){

		var dl = $("input[name='"+tcode+"_dl']").val();

		if(dl){
			deliv_code = dl;
		}
		else{
			deliv_code = tcode;
		}

		$.ajax({
			url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=cancel_layer&deliv_code="+deliv_code,
			type:"GET",
			cache:false,
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){

				$(".layer_pop").html(data.page);

			},
			complete:function(data){
				if(data){
					$(".layer_pop").fadeIn('fast');
				}
			}
		});
	}

	function closecancel_layer(){

		$(".layer_pop").hide();
	}

	function cancel(trade_code,trade_method,tno)
	{
		if(confirm("주문을 취소하시겠습니까?")){

			if(trade_method==1){
				card_cancel(trade_code,tno);
			}else{
				location.href="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/cancel_list/<?=$query_string.$param?>";
			}
		}
	}

	function order_cancel(deliv_code,recom,tm,tn,rp,dcode){
		//alert("취소신청이 완료 되었습니다.");
		//location.reload();

		if(confirm("주문취소를 요청하실 경우\n배송일정에 따른 무료배송으로 주문된 내역도 함께 취소 될수 있습니다.\n\n취소를 요청하시겠습니까?")){
			var tcode_tmp = deliv_code.split("-");
			var cancel_msg = $("#cancel_comment").val();
			$.ajax({
				url:"<?=cdir()?>/dh_order/order_cancel/?deliv_code="+deliv_code+"&ccmsg="+encodeURIComponent(cancel_msg)+"&rp="+rp+"&dcode="+dcode,
				type:"GET",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					if(data == "ok"){
						alert("취소 신청이 완료 되었습니다.");
						location.reload();
					}
					else{
						alert("취소 신청에 실패 하였습니다. 계속 오류가 생길경우 전화로 문의 해 주세요.");
						location.reload();
					}
				}
			});
		}

	}
</script>

<? include $_SERVER['DOCUMENT_ROOT']."/m/html/application/views/order/".$shop_info['pg_company']."_cancel.php"; ?>

<? include('../include/footer.php') ?>
