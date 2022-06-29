<?

	if($_SERVER['REMOTE_ADDR'] != "112.221.155.109"){
		alert("배송일시정지/재시작은 점검중입니다","/html/dh_board/lists/withcons07/?myqna=Y");
	}

	$PageName = "ORDER_EDIT04";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
	function deliv_pause(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();
		window.open("<?=cdir()?>/dh_order/order_edit04/?mode=deliv_pause&deliv_code="+encodeURIComponent(deliv_code) ,"deliv_pause" ,'');
	}

	function restart(tcode,restart_date,restart_count,ayo){
		if(confirm(restart_date+"("+ayo+")부터 배송이 재시작 됩니다.\n별도 안내가 어려우니 날짜를 꼭 기억해 주세요!\n기존 변경내역은 초기화 됩니다.(배송일, 배송지, 메뉴변경 등")){
			$("#frm"+tcode).submit();
		}
	}
</script>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?include("../include/mypage_top02.php");?>
		<div class="inner mypage">
			<h1>메뉴/배송지/배송일 변경</h1>
		<!-- 안내사항 -->
			<div class="orderedit_top pb0">현재 <strong>변경가능한 내역</strong>만 자동으로 조회됩니다.<br>
			<small>- 조리중/배송중/배송완료된 주문은 조회 및 변경이 불가함</small></div>
			<div class="orderedit_top">
				배송일 <strong class="dh_red">D-2일 PM 24:00까지</strong> 변경가능합니다
				<table class="order_table">
					<tr>
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
				</table>
			</div>
			<!-- //안내사항 -->

			<?include("../include/oe_menu.php");?>
			<a href="#" class="btn_popup" onClick="openPop();">[필독]배송일시정지/재시작 상세보기</a>
			<h2 class="mt20">배송 일시정지</h2>
			<div class="tblTy02">
				<table>
					<colgroup>
					<col width="15%">
					<col>
					<col>
					<col width="18%">
					</colgroup>
					<tr>
						<th>구분</th>
						<th>주문내역</th>
						<th>배송회차</th>
						<th>비고</th>
					</tr>

					<?php
					if($list){
						$list_cnt = 0;
						$old_trade = "";
						foreach($list as $lt){
							if($old_trade != $lt->trade_code){
								$list_cnt++;
								if($lt->grade_change){
									$prd_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$lt->grade_change_recom_idx."'","row");
									$prod_name = "[영양식단] ".$prd_info->recom_name;
								}
								else{
									$prod_name = $lt->prod_name;
								}
								?>
								<tr>
									<td>정기<br>배송</td>
									<td><?=($prod_name) ? $prod_name : $lt->goods_name ; ?></td>
									<td>
										<select name="deliv_code<?=$list_cnt?>" class="oe_sel" onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;alert("죄송합니다.\n이 항목은 변경할 수 없습니다.")'>
											<?php
											$pause_accept_date = date("Y-m-d",strtotime("+3 day",time()));
											$dcnt = 0;
											foreach($list as $deliv_list){
												//if( $lt->trade_code == $deliv_list->trade_code and $deliv_list->deliv_stat == 0 and $deliv_list->deliv_date >= $pause_accept_date ){
												if( $lt->trade_code == $deliv_list->trade_code ){
													$prod_name_arr = explode(",",$deliv_list->prod_name);
													$prod_name = $prod_name_arr[0];
													if(count($prod_name_arr) > 1) $prod_name .= " 외 ".(count($prod_name_arr)-1)."건";

													$deliv_count = "";	//정기배송 회차 정보
													$deliv_code_arr = explode("-",$deliv_list->deliv_code);
													if($deliv_list->recom_is == "Y") $deliv_count = $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
													?>
													<!-- <option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option> -->
													<option value="<?=$deliv_list->deliv_code?>"><?=date("m/d", strtotime($deliv_list->deliv_date))."(".numberToWeekname($deliv_list->deliv_date).") ".$prod_name." ".$deliv_count?></option>
													<?php
													foreach($info_list as $deliv){
														if($deliv->deliv_date == $deliv_list->deliv_date){
															$dcnt++;
														}
													}
												}
											}
											?>
										</select>
									</td>
									<td>
										<a href="javascript:;" onClick="deliv_pause('<?=$list_cnt?>');" class="btn_y">배송 일시정지</a>
										<?php
										/*
										if($dcnt){
											?>
											<a href="javascript:;" onClick="alert('죄송합니다.\n배송 일정에 다른 주문/배송건이 존재 하여 일시정지를 바로 이용하실 수 없습니다.\n1대1 문의를 통해 접수해 주세요.');location.href='/html/dh_board/lists/withcons07/?myqna=Y'" class="btn_y">배송 일시정지</a>
											<?php
										}
										else{
											?>
											<a href="javascript:;" onClick="deliv_pause('<?=$list_cnt?>');" class="btn_y">배송 일시정지</a>
											<?php
										}
										*/
										?>
									</td>
								</tr>
								<?php
							}
							$old_trade = $lt->trade_code;
						}
					}
					else{
					?>
					<tr>
						<td colspan="4">변경 가능한 주문 내역이 없습니다.</td>
					</tr>
					<?php
					}
					?>

				</table>
			</div>


			<h2 class="mt20">배송 재시작</h2>
			<div class="tblTy02">
				<table>
					<colgroup>
					<col width="15%">
					</colgroup>
					<tr>
						<th>구분</th>
						<th>주문내역</th>
						<th>비고</th>
					</tr>

					<?php
					if($pause_list){
						$list_cnt = 0;
						$old_trade = "";
						foreach($pause_list as $lt){
							if($old_trade != $lt->trade_code){
								$list_cnt++;
								if($lt->grade_change){
									$prd_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$lt->grade_change_recom_idx."'","row");
									$prod_name = "[영양식단] ".$prd_info->recom_name;
								}
								else{
									$prod_name = $lt->prod_name;
								}
								?>
								<tr>
									<td>정기<br>배송</td>
									<td><?=($prod_name) ? $prod_name : $lt->goods_name ; ?></td>
									<?php
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
									//echo $restart_day;

									//배송회차도 구해줘야되는구나..
									//$otc = (($arr_week_type[0] * $lt->recom_week_count) - $lt->remain_deliv_count)+1;
									$otc = $lt->remain_deliv_count;
									?>
									<td>

										<form id="frm<?=$lt->trade_code?>">
											<input type="hidden" name="mode" value="restart_deliv">
											<input type="hidden" name="trade_code" value="<?=$lt->trade_code?>">
											<input type="hidden" name="restart_date" value="<?=$restart_day?>">
											<input type="hidden" name="restart_count" value="<?=$otc?>">
										</form>

										<a href="javascript:;" onclick="restart('<?=$lt->trade_code?>','<?=$restart_day?>','<?=$otc?>','<?=numberToWeekname($restart_day)?>')" class="btn_y">배송 재시작</a>
									</td>
								</tr>
								<?php
							}
							$old_trade = $lt->trade_code;
						}
					}
					else{
					?>
					<tr>
						<td colspan="4">변경 가능한 주문 내역이 없습니다.</td>
					</tr>
					<?php
					}
					?>

				</table>
			</div>


		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>






	<!-- -->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				배송일지정지
			</h1>
			<div class="inner clearfix">

				<p class="bu03">
					배송 일시정지는 실시간으로 적용됩니다.
				</p>


				<p class="bu03">
					지금 배송 일시정지를 요청하시면 <span class="blue mr5">3회차 : 2018.03.04 수요일</span>부터 일시정지가 됩니다.
				</p>
				<p class="blue fs12 mt10">
					※ 배송 일시정지는 배송일 3일전까지 요청하실 수 있습니다.<br>
					※ 이후 재시작을 원하실 경우 "배송 재시작"을 눌러주세요.
				</p>


			</div>
			<button type="button" class="w50 close01" title="닫기" onclick='closeMenuView();'>취소</button>
				<button type="button" class="w50 close" title="닫기">배송일시정지</button>

		</div>
	</div>
	<!-- END  -->





	<script type="text/javascript">



		function menuView(){
			$(".layer_pop").fadeIn('fast');
			return false;
		}

		function closeMenuView(){

			$(".layer_pop").hide();
		}

function openPop(){
			$(".popUp").fadeIn('fast');
			return false;
		}
		function closePop(){
			$(".popUp").hide();
		}
</script>

<div class="popUp" style="display: none;" onClick="closePop();">
	<div class="popMsg">

	<h1>배송 일시정지/재시작 사용안내</h1>
<p class="dot">배송일시정지/재시작은 정기배송에만 해당됩니다.</p>
<p class="dot">배송일시정지는 선택가능한 가장 빠른 회차부터 일시정지 가능합니다.</p>
<p class="dot">재시작을 원하실 경우, 마이페이지 배송일시정지/재시작 현재페이지에 들어와 재시작 버튼을 누르세요.</p>
<p class="dot">재시작 시점 이후로 가능한 일정과 메뉴로 선택하실 수 있습니다.</p>
<p class="dot">일시정지가 장기간 지속되어도 에코맘에서는 별도로 연락을 취하지 않습니다.</p>
<p class="dot">정기배송에 한에 지원드립니다.</p>
<p class="dot">이유식 외 상품을 함께 구매한 경우 (예:정기배송 1회차+간식) 배송비 정책에 의해
     1회차는 시스템 직접변경은 어려울 수 있으니, 1:1 문의게시판을 이용하세요.</p>
<p class="dot">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다</p>
<p class="ac"><a href="#" class="btn_popC" onClick="closePop();">확인</a></p>
	</div>

</div>





<? include('../include/footer.php') ?>


