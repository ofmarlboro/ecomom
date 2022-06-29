<?

	if($_SERVER['REMOTE_ADDR'] != "112.221.155.109"){
		alert("배송일시정지/재시작은 점검중입니다","/html/dh_board/lists/withcons07/?myqna=Y");
	}

	$PageName = "ORDEREDIT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript" src="/js/orderPage.js"></script>
<script type="text/javascript">
<!--
	function deliv_pause(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (484/2);
		var popupY = (window.screen.height / 2) - (310/2);
		window.open("<?=cdir()?>/dh_order/order_edit04/?mode=deliv_pause&deliv_code="+encodeURIComponent(deliv_code) ,"deliv_pause" ,'scrollbar=no, width=484, height=310, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
	}

	function restart(tcode,restart_date,restart_count,ayo){
		if(confirm(restart_date+"("+ayo+")부터 배송이 재시작 됩니다.\n별도 안내가 어려우니 날짜를 꼭 기억해 주세요!\n기존 변경내역은 초기화 됩니다.(배송일, 배송지, 메뉴변경 등)")){
			$("#frm"+tcode).submit();
		}
	}
//-->
</script>

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
			<!-- 탭 -->
			<?php include "../include/order_edit_tabs.php";?>
			<!-- 안내사항 -->
			<p class="orderedit_top">배송일시정지/재시작은 정기배송에만 해당됩니다.</p>
				<p class="orderedit_top mt5">배송일시정지는 선택가능한 가장 빠른 회차부터 일시정지 가능합니다.  <br></p>
				<p class="orderedit_top mt5">재시작을 원하실 경우, 마이페이지 배송일시정지/재시작 현재페이지에 들어와 재시작 버튼을 누르세요. <br></p>
				<p class="orderedit_top mt5">재시작 시점 이후로 가능한 일정과 메뉴로 선택하실 수 있습니다. <br></p>
				<p class="orderedit_top mt5">일시정지가 장기간 지속되어도 에코맘에서는 별도로 연락을 취하지 않습니다. </p>
				<p class="orderedit_top mt5">해당되는 주문건이 있을 경우에 자동 표시되며, 배송일시정지를 할 수 있습니다.</p>
				<p class="orderedit_top mt5">정기배송에 한에 지원드립니다.</p>
				<p class="orderedit_top mt5">이유식 외 상품을 함께 구매한 경우(예:정기배송 1회차+간식) 배송비 정책에 의해<br>
				 1회차는 시스템 직접변경은 어려울 수 있으니, 1:1 문의게시판을 이용하세요.</p>
				<p class="orderedit_top mt5">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다.</p>
			<!-- <p class="orderedit_top">변경가능내역만 조회되며, 배송완료/배송준비중은 변경 불가합니다.</p> -->
			<!-- 04 배송일시정지/재시작 -->
			<div>
				<div class="my_tit">
					배송 일시정지
				</div>
				<div class="tblTy01">
					<table>
						<colgroup>
						<col width="15%">
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
										<td>정기배송<!-- [<?=$lt->trade_code?>] --><?=$lt->trade_code?></td>
										<td><?=($prod_name) ? str_replace(",","<br>",$prod_name) : str_replace(",","<br>",$lt->prod_name) ; ?></td>
										<td>
											<select name="deliv_code<?=$list_cnt?>" class="reg_sel" onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;alert("죄송합니다.\n이 항목은 변경할 수 없습니다.")'>
												<?php
												$pause_accept_date = date("Y-m-d",strtotime("+3 day",time()));
												$dcnt = 0;
												foreach($list as $deliv_list){
													//if( $lt->trade_code == $deliv_list->trade_code and $deliv_list->deliv_stat == 0 and $deliv_list->deliv_date >= $pause_accept_date){
													if( $lt->trade_code == $deliv_list->trade_code){
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

														foreach($info_list as $deliv){	//배송일정에 중복되는 배송건이 있는지 확인
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
											<a href="javascript:;" onClick="deliv_pause('<?=$list_cnt?>');" class="btn_yy">배송 일시정지</a>
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


				<div class="my_tit mt50">
					배송 재시작
				</div>
				<div class="tblTy01">
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
										<td>정기배송<?=$lt->trade_code?><!-- [<?=$lt->trade_code?>] --></td>
										<td><?=($prod_name) ? $prod_name : $lt->goods_name ; ?></td>

										<?php
										$day_name_to_number = array('일'=>0,'월'=>1,'화'=>2,'수'=>3,'목'=>4,'금'=>5,'토'=>6);

										$arr_week_type = explode(":",$lt->recom_week_type);
										$arr_week_name = explode(",",$arr_week_type[1]);

										$restart_date = date("Y-m-d",strtotime('+2 day'));
										while(true){
											$restart_date = date("Y-m-d",strtotime('+1 day',strtotime($restart_date)));
											if(!in_array($restart_date,$arr_holi[$lt->trade_code])){
												foreach($arr_week_name as $aw){
													if($day_name_to_number[$aw] == date('w',strtotime($restart_date))){
														$restart_day = $restart_date;
													}
												}
											}

											if($restart_day) break;
										}

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

											<a href="javascript:;" onclick="restart('<?=$lt->trade_code?>','<?=$restart_day?>','<?=$otc?>','<?=numberToWeekname($restart_day)?>')" class="btn_yy">배송 재시작</a>
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
			<!-- // 04 배송일시정지/재시작 -->
		</div>
	</div>

	<?php
	/*
	<!-- 04배송일지정지 -->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				배송일지정지
			</h1>
			<div class="bg">
				<p class="bu03">
					배송 일시정지는 실시간으로 적용됩니다.
				</p>
				<p class="bu03">
					지금 배송 일시정지를 요청하시면<br><span class="blue mr5">3회차 : 2018.03.04 수요일</span>부터 일시정지가 됩니다.
				</p>
				<p class="blue fs12 mt10">
					※ 배송 일시정지는 배송일 3일전까지 요청하실 수 있습니다.<br>
					※ 이후 재시작을 원하실 경우 "배송 재시작"을 눌러주세요.
				</p>
				<div class="ac bd">
					<a href="" class="btn_big">
					배송 일시정지
					</a>
					<a href="" class="btn_big">
					취소
					</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close" onclick='closeMenuView();'>
			</a>
		</div>
	</div>
	<!-- END 배송일지정지 -->
	*/
	?>

	<script type="text/javascript">
		function menuView(){
			$(".layer_pop").fadeIn('fast');
			return false;
		}
		function closeMenuView(){
			$(".layer_pop .scroll").scrollTop(0);
			$(".layer_pop").hide();
		}
	</script>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
