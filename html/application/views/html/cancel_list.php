<?
	if($_SERVER['REMOTE_ADDR'] != "58.229.223.174"){
		alert(cdir()."/dh_board/lists/withcons07?myqna=Y","취소환불은 1:1 문의 게시판을 이용부탁드립니다");
	}
	$PageName = "CANCELLIST";
	$SubName = "";
	$PageTitle = "취소/환불 가능내역";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">

		<div class="sv <?=$PageName?>"></div>

		<div class="mypage_top">
			<div class="inner float-wrap clearfix">
				<div class="user" style="padding:20px; box-sizing: border-box; height:242px;">
					<?php
					if($this->session->userdata('USERID')){
					?>
						<a href="/html/dh_member/mypage"><img src="/image/sub/set.jpg" alt=""></a>
						<p>
							<em>
								<?php
								if($member_info->regist_type == "sns"){
									if(strpos($this->session->userdata('USERID'),"kko")!==false){
										echo "카카오 로그인 회원";
									}
									else{
										echo "네이버 로그인 회원";
									}
								}
								else{
									echo $this->session->userdata('USERID');
								}
								?>
							</em><!-- <img src="/image/sub/bar.gif" alt="" class="bar"><em><?=$this->session->userdata('NAME')?></em><span>님</span> -->
						</p>
						<p class="nick mt60"><?=$this->session->userdata('NAME')?></p>
					<?php
					}

					else{
					?>
					<img src="/image/mypage_logo.png" class="my_page_logo">
					<?php
					}
					?>
				</div>

				<div class="my_title">
					<h2 class="gn_tit mt5" style="margin:0 20px; float:none;"><?=$$PageName->tit?></h2>
					<p class="g8"><?=$$PageName->sub?></p>

					<!-- 안내사항 -->
					<div style="margin-left:30px;">
						<div class="orderedit_top mt0 pb0">현재 <strong>변경가능한 내역</strong>만 자동으로 조회됩니다.<br>
						<small>- 조리중/배송중/배송완료된 주문은 조회 및 변경이 불가함</small></div>
						<div class="orderedit_top mt10 mb20">
							배송일 <strong class="dh_red">D-2일 PM 24:00까지</strong> 변경가능합니다
							<table class="order_table">
								<tbody><tr>
									<th>배송일</th>
									<td>화</td>
									<td>수</td>
									<td>목</td>
									<td>금</td>
									<td>토</td>
								</tr>
								<tr>
									<th>변경가능일</th>
									<td>일</td>
									<td>월</td>
									<td>화</td>
									<td>수</td>
									<td>목</td>
								</tr>
							</tbody></table>
						</div>
					</div>
					<!-- //안내사항 -->
				</div>


			</div>
		</div><!-- //mypage_top -->

		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">

				<div>
				<p class="orderedit_top">변경가능한 내역만 조회되며, 배송완료/배송<!-- 준비 -->중은 <!-- 취소가 불가하고, 제품에 이상이 있는 경우 교환신청이 가능합니다. --> 변경이 불가 합니다. </p>

					<div class="tblTy01">
						<table>
					<colgroup>
						<col width="15%">
						<col>
						<col>
						<col width="100px">
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

								/*
								$recom_count_arr = array();
								$deliv_date_arr = explode("^",substr($lt->recom_dates,0,-1));
								$last_date = end($deliv_date_arr);
								foreach($deliv_date_arr as $key=>$val){
									$recom_count_arr[$val] = $key+1;	//배열에 날짜를 넣으면 회차가 나옴
								}
								*/

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
										<?=$lt->trade_code?>
									</td>
									<td>
										<?php
										if($lt->recom_idx){
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
										if($lt->recom_idx){
											?>
											<!-- <select name="<?=$lt->trade_code?>_dl" class="reg_sel" style="height:30px;overflow:hidden" multiple onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;'> -->
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
												<!-- <option value="<?=$deliv_list->deliv_code?>"> -->
													<?
													//배송일자
													echo date("m/d",strtotime($deliv_list->deliv_date))
													?>
													(<?=numberToWeekname($deliv_list->deliv_date)?>)
													<?=$prod_name_arr[0]?>
													<?=($prod_name_count > 1) ? "외 ".$prod_name_count."건" : "" ;?>
													<?php
													$deliv_code_arr = explode("-",$deliv_list->deliv_code);
													echo $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
													?>
													<!-- [<?=$chg_text?>] -->
												<!-- </option> -->
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
												//무통장 또는 포인트 전액결제 의경우 바로취소
												$go_cancel = "cancel('".$lt->trade_code."',2)";
											}
											else{
												//pg 주문취소
												$go_cancel = "cancel('".$lt->trade_code."','1','".$lt->tno."')";
											}
											?>
											<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy">취소</a>
											<?php
										}
										else if( $lt->trade_stat == 2 and $lt->deliv_stat == 0 ){
											//입금완료되었으나 배송이 한번도 안나간경우
											//환불 신청서 작성
											//PG는 바로 취소
											if($lt->trade_method == 2 || $lt->trade_method == 99){
												$go_cancel = "menuView('".$lt->trade_code."')";	//무통장 환불신청---
											}
											else{
												//pg 주문취소 (바로취소)
												// 하지말고 배송일 기준으로 3일전인지 체크 해라 (요청사항)
												//포인트 전액결제 주문취소
												if($lt->trade_method == "5"){
													$go_cancel = "cancel('".$lt->trade_code."','5')";
												}
												else{
													$go_cancel = "cancel('".$lt->trade_code."','1','".$lt->tno."')";
												}
											}
											?>
											<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy" data-cval="<?=$lt->deliv_date?>">취소</a>
											<?php
										}
										else{
											//배송중 이상

											if($lt->trade_stat == 4){	//배송완료일때

											}
											else{	//배송중일때

												if($lt->recom_is == "Y"){	//정기배송의경우
													$go_cancel = "menuView('".$lt->trade_code."')";	//환불신청
													$go_change = "trade_confirm()";
													?>
													<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy">취소</a>
													<!-- <a href="javascript:;" onClick="<?=$go_change?>" class="btn_yy">교환</a> -->
													<?php
												}
												else{
													?>
													<!-- <a href="javascript:;" onClick="menuView('<?=$lt->trade_code?>');" class="btn_yy">취소</a> -->
													<?php
												}

											}
										}

										/*
											if($lt->recom_is == "Y"){

											}
											else{

												if($lt->trade_stat == 1){
													//입금대기중
													if($lt->trade_method == 2){
														//무통장의경우 바로취소
														$go_cancel = "cancel('".$lt->trade_code."',2)";
													}
													else{
														//pg 주문취소
													}
												?>
												<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy">취소</a>
												<?php
												}
												else if( $lt->trade_stat == 2 and $lt->deliv_stat == 0 ){
													//입금완료되었으나 배송이 한번도 안나간경우
													//환불 신청서 작성
													//PG는 바로 취소
													if($lt->trade_method == 2){
														$go_cancel = "menuView('".$lt->trade_code."')";	//무통장 환불신청
													}
													else{
														//pg 주문취소 (바로취소)
													}
												?>
												<a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy">취소</a>
												<?php
												}
												else{
													//배송중 이상

													if($lt->trade_stat == 4){	//배송완료일때

													}
													else{	//배송중일때

														if($lt->recom_is == "Y"){	//정기배송의경우
															$go_cancel = "menuView('".$lt->trade_code."')";	//환불신청
															$go_change = "trade_confirm()";
														?>
														<!-- <a href="javascript:;" onClick="<?=$go_cancel?>" class="btn_yy">취소</a> -->
														<!-- <a href="javascript:;" onClick="<?=$go_change?>" class="btn_yy">교환</a> -->
														<?php
														}
														else{
														?>
														<!-- <a href="javascript:;" onClick="menuView('<?=$lt->trade_code?>');" class="btn_yy">취소</a> -->
														<?php
														}

													}
												}

											}
										*/
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
							<td>자유배송</td>
							<td>이유식 중기 8팩</td>
							<td>배송준비중
							</td>

							<td><a href="javascript:;" onClick="menuView();" class="btn_yy">취소</a></td>
						</tr>
						<tr>
							<td>정기배송</td>
							<td>이유식 중기 8팩</td>
							<td><select name="" id="reg_sel">
								<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
								<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
								<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
							</select>
							</td>

							<td><a href="javascript:;" onClick="menuView();" class="btn_yy">
								취소
								</a>
								<a href="javascript:;" onClick="menuView();" class="btn_yy">
								교환
								</a>


							</td>
						</tr>
						*/
						?>
					</table>
					</div>

				</div>



			</div>
		</div>


	</div><!--END Container-->



	<?php
	/*
	<!-- 배송 3일전 / 조리가 되기 전 -->
	<div class="layer_pop01" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				주문 취소
			</h1>
			<div class="bg">
				<p class="bu03">
					2018년 2월 1일 목요일 '준비기' 추천식단(정기배송) 주문/배송 내역입니다.
				</p>
				<div class="tblTy05 mt0">
					<table>
						<td>2018.02.07 수요일 첫 배송 예정입니다.</td>
					</table>
				</div>

				<p class="blue mt10">
					※주문취소는 30분 이내로 적용되며, 쿠폰 및 사용하신 적립금은 다시 복구됩니다.
				</p>
				<p class="bu03 mt20">
					취소사유를 적어 주시면 더 나은 서비스 제공을 위해 노력하겠습니다.
				</p>
				<p class="ac">
					<textarea name="" id="" class="cancel_area"></textarea>
				</p>


				<div class="ac bd">
					<a href="" class="btn_big">주문취소</a>
					<a href="javascript:;" class="btn_big" onclick='closeMenuView();'>닫기</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close" onclick='closeMenuView();'>
			</a>
		</div>
	</div>
	<!-- END 배송 3일전 / 조리가 되기 전 -->
	*/
	?>


	<!-- 배송중/상품준비중 이상 -->
	<div class="layer_pop01" style="display:none;">

		<?php
		/*
			<div class="layer_pop_inner">
				<h1>
					주문 취소
				</h1>
				<div class="bg">
					<p class="bu03">
						2018년 2월 1일 목요일 '준비기' 추천식단(정기배송) 주문/배송 내역입니다.
					</p>
					<p class="mt10">
						<select name="" id="reg_sel" style="width:100%">
							<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
							<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
							<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
						</select>
					</p>

					<p class="blue mt10">
						※주문취소는 30분 이내로 적용되며, 쿠폰 및 사용하신 적립금은 다시 복구됩니다.
					</p>

					<div class="tblTy05 mt0">
						<table>
							<td>취소완료 후 환불 받으실 금액은 <span class="fz18">38,000</span>원 입니다.</td>
						</table>
					</div>

					<p class="bu03 mt20">
						취소사유를 적어 주시면 더 나은 서비스 제공을 위해 노력하겠습니다.
					</p>
					<p class="ac">
						<textarea name="" id="" class="cancel_area"></textarea>
					</p>


					<div class="ac bd">
						<a href="javascript:;" class="btn_big" onclick="cancel('')">주문취소</a>
						<a href="javascript:;" class="btn_big" onclick='closeMenuView();'>닫기</a>
					</div>
				</div>
				<a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a>
			</div>
		*/
		?>

	</div>
	<!-- END 배송중/상품준비중 이상 -->




<script type="text/javascript">
function menuView(tcode){

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

			console.log(data);

			$(".layer_pop01").html(data.page);

		},
		complete:function(data){
			if(data){
				$(".layer_pop01").fadeIn('fast');
			}
		}
	});

	/*
	var deliv_stat = $("select[name='"+tcode+"_dl']").find(":selected").data('deliv_stat');

	if(deliv_stat){
		if(deliv_stat > 0){
			alert("배송이 시작된 주문은 취소 할 수 없습니다.");
			return false;
		}
	}
	else{

	}
	*/

	//console.log(deliv_stat);

}
function closeMenuView(){
	$(".layer_pop01 .scroll").scrollTop(0);
	$(".layer_pop01").hide();
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

<? include $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/".$shop_info['pg_company']."_cancel.php"; ?>

<? include('../include/footer.php') ?>

