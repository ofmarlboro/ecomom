<?
	$PageName = "ORDEREDIT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript" src="/js/orderPage.js"></script>
<script type="text/javascript">
	function deliv_addr_change(no,od_type){

		if($("select[name='deliv_code"+no+"']").val() == ""){
			alert('주문/배송내역을 선택해 주세요.');
			return;
		}

		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (460/2);
		var popupY = (window.screen.height / 2) - (600/2);
		window.open("<?=cdir()?>/dh_order/order_edit/?mode=deliv_addr_chg&deliv_code="+encodeURIComponent(deliv_code)+"&od_type="+od_type ,"deliv_change" ,'scrollbar=no, width=460, height=600, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
	}

	function deliv_addr_change_new(deliv_code,od_type){

		//if($("select[name='deliv_code"+no+"']").val() == ""){
		//	alert('주문/배송내역을 선택해 주세요.');
		//	return;
		//}
		//
		//var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (460/2);
		var popupY = (window.screen.height / 2) - (600/2);
		window.open("<?=cdir()?>/dh_order/order_edit/?mode=deliv_addr_chg&deliv_code="+encodeURIComponent(deliv_code)+"&od_type="+od_type ,"deliv_change" ,'scrollbar=no, width=460, height=600, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
	}

	function deliv_addr_list_change(deliv_code,cnt){
		$.ajax({
			url:"<?=cdir()?>/dh_order/deliv_addr_list_change/?time=<?=time()?>",
			type:"GET",
			data:{'deliv_code':deliv_code},
			cache:false,
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){
				$(".deliv_addr"+cnt).html(data);
			}
		});
	}
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
					<div class="orderedit_top mt10 mb20">배송휴무가 없을 시,
						배송일 <strong class="dh_red"> D-2일 PM 16:00까지</strong> 변경가능합니다
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
			<!--// 탭 -->

			<!-- 안내사항 -->
			<p class="orderedit_top">정기배송은 회차별로 배송지를 변경할 수 있습니다. </p>
			<p class="orderedit_top mt5">배송일 <strong class="red">D-2일 PM 16:00까지</strong> 변경가능 합니다.</p>
			<p class="orderedit_top mt5">마이페이지 배송지관리를 통해 배송지를 추가하여 더 편리하게 이용하세요.</p>
			<!-- <p class="orderedit_top mt5">정기배송에 한에 지원드립니다.</p>
			<p class="orderedit_top mt5">이유식 외 상품을 함께 구매한 경우(예:정기배송 1회차+간식) 배송비 정책에 의해<br>1회차는 시스템 직접변경은 어려울 수 있으니, 1:1 문의게시판을 이용하세요.</p>
			<p class="orderedit_top mt5">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다.</p> -->
			<!-- //안내사항 -->

			<!-- 주문내역이 없는 경우
			<p class="ac mt50">주문 내역이 없습니다.</p>-->

			<!-- 01 배송지변경 -->
			<div>
				<div class="my_tit">
					배송지 변경
				</div>
				<div class="mt10">
					<p><strong>* 배송지 변경완료 후 아래에서 변경내용을 확인하세요</strong></p>
					<p>- 주문/배송내역을 재설정하시면 변경된 주소로 확인 가능합니다.</p>
				</div>
				<div class="tblTy01">
					<table>
						<colgroup>
							<col width="15%">
							<col>
							<col>
							<col width="15%">
						</colgroup>
						<tr>
							<th>구분</th>
							<th>주문 / 배송내역</th>
							<th>배송지</th>
							<th>비고</th>
						</tr>
						<?php
						if($list){

							//if($_SERVER['HTTP_X_FORWARDED_FOR']=='58.229.223.174'){

								$list_cnt = array();
								foreach($list as $lt){
									if($lt->recom_idx){
										$list_cnt[$lt->trade_code]['delivcnt']++;
										$list_cnt++;

										$deliv_type_text = "정기배송";
										$order_type = "recom";
									}
									else{
										$deliv_type_text = "일반배송";
										$order_type = "normal";
									}
									?>
									<tr>
										<td><?=$deliv_type_text?></td>
										<td class="al">
											<?=$lt->recom_name?$lt->recom_name:$lt->prod_name;?> <?if($lt->recom_idx){?><?=$list_cnt[$lt->trade_code]['delivcnt']?>회차<?}?><br>
											<small><b>배송일 : <?=$lt->deliv_date?> (<?=numberToWeekname($lt->deliv_date)?>)</b></small>
										</td>
										<td class="deliv_addr"><span class="blue"> #<?=DelivAddrName($lt->deliv_addr)?>: </span><?=$lt->addr1?><br><?=$lt->addr2?></td>
										<td>
											<?php
											$limit_date_stamp = strtotime('-2 day',strtotime($lt->deliv_date));
											if($lt->deliv_stat == 0 && $limit_date_stamp > time()){
												if($lt->recom_idx){
													?>
													<a href="javascript:;" onClick="deliv_addr_change_new('<?=$lt->deliv_code?>','<?=$order_type?>');" class="btn_yy">배송지 변경</a>
													<?php
												}
												else if( ($lt->deliv_price || $deliv_type_text == "일반배송") && $lt->delivPoNm != "N" ){
													?>
													<a href="javascript:;" onClick="deliv_addr_change_new('<?=$lt->deliv_code?>','<?=$order_type?>');" class="btn_yy">배송지 변경</a>
													<?php
												}
												else{
													?>
													<a href="javascript:;" onClick="alert('주문 시, 배송비 무료로 결제한 주문이\n포함된 경우 배송지 직접변경이 불가합니다\n예: 정기배송+간식주문 했을 시\n\n1:1문의게시판을 이용해주세요')" class="btn_yy">배송지 변경</a>
													<?php
												}
											}
											?>
										</td>
									</tr>
									<?php
								}

							/*
							}
							else{

								$list_cnt = 0;
								foreach($list as $lt){
									if($_SERVER['HTTP_X_FORWARDED_FOR']=='58.229.223.174'){
										//pr($list);
									}
									if($old_trade_code != $lt->trade_code){
										$list_cnt++;

										$recom_count_arr = array();
										$deliv_type_text = "";
										$order_type = "";

										if($lt->recom_is == "Y"){
											$deliv_type_text = "정기배송";
											$order_type = "recom";
										}
										else{
											if($lt->sample_is == "Y"){
												$deliv_type_text = "샘플신청";
												$order_type = "sample";
											}
											else{
												$deliv_type_text = "일반배송";
												$order_type = "normal";
											}
										}

									?>
									<tr>
										<td><?=$deliv_type_text?></td>
										<td class="al">
											<select name="deliv_code<?=$list_cnt?>" class="reg_sel" onchange="deliv_addr_list_change(this.value,'<?=$list_cnt?>')">
												<!-- <option value="">- 선택해 주세요. -</option> -->
												<?php
												foreach($list as $deliv_list){	//옵션들
													if($lt->trade_code == $deliv_list->trade_code){
														$prod_name_arr = explode(",",$deliv_list->prod_name);
														$prod_name = $prod_name_arr[0];
														if(count($prod_name_arr) > 1) $prod_name .= " 외 ".(count($prod_name_arr)-1)."건";

														$deliv_count = "";	//정기배송 회차 정보
														$deliv_code_arr = explode("-",$deliv_list->deliv_code);
														if($deliv_list->recom_is == "Y") $deliv_count = $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
													?>
													<option value="<?=$deliv_list->deliv_code?>"><?=date("m/d", strtotime($deliv_list->deliv_date))."(".numberToWeekname($deliv_list->deliv_date).") ".$prod_name." ".$deliv_count?></option>
													<?php
													}
												}
												?>
												<!-- <option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
												<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
												<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option> -->
											</select>
										</td>
										<td class="deliv_addr<?=$list_cnt?>"><span class="blue"> #<?=DelivAddrName($lt->deliv_addr)?>: </span><?=$lt->addr1?></td>
										<td>
											<?php
											if($lt->recom_idx > 0){
											?>
											<a href="javascript:;" onClick="deliv_addr_change('<?=$list_cnt?>','<?=$order_type?>');" class="btn_yy">배송지 변경</a>
											<?php
											}
											else{
												if($lt->deliv_price > 0){
												?>
												<a href="javascript:;" onClick="deliv_addr_change('<?=$list_cnt?>','<?=$order_type?>');" class="btn_yy">배송지 변경</a>
												<?php
												}
												else{
												?>
												<a href="javascript:;" onClick="alert('주문 시, 배송비 무료로 결제한 주문이\n포함된 경우 배송지 직접변경이 불가합니다\n예: 정기배송+간식주문 했을 시\n\n1:1문의게시판을 이용해주세요')" class="btn_yy">배송지 변경</a>
												<?php
												}
											}
											?>
										</td>
									</tr>
									<?php
									}
									$old_trade_code = $lt->trade_code;
								}

							}
							*/

						}
						else{
						?>
						<tr>
							<td colspan="4">변경 가능한 주문 내역이 없습니다.</td>
						</tr>
						<?php
						}
						?>

						<?php
						/*
						<tr>
							<td>자유배송</td>
							<td class="al">3/14 골라담기 [후기] 외 8건</td>
							<td><span class="blue"> #자택: </span>서울 강서구 화곡로 119</td>
							<td><a href="javascript:;" onClick="menuView();" class="btn_yy">
								배송지 변경
								</a></td>
						</tr>
						<tr>
							<td>정기배송</td>
							<td class="al"><select name="" id="reg_sel">
									<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
								</select></td>
							<td><span class="blue"> #자택: </span>서울 강서구 화곡로 119</td>
							<td><a href="javascript:;" onClick="menuView();" class="btn_yy">
								배송지 변경
								</a></td>
						</tr>
						*/
						?>
					</table>
				</div>
			</div>
			<!-- // 01 배송지변경 -->
		</div>
	</div>

	<!-- 01배송지변경 : 자유배송 -->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				<span class="btn_yy" style="margin-right:10px">자유배송</span>배송지 변경
			</h1>
			<div class="bg">
				<p class="bu03">
					3/14(수) 골라담기 후기 외 8건
				</p>
				<select name="" id="" class="pop_sel">
					<option value="">자택</option>
					<option value="">친정</option>
					<option value="">시댁</option>
					<option value="">새로입력</option>
				</select>
				<input type="text" class="pop_in">
				<p class="gray fs12 mt10">
					변경하실 주소를 선택하여 주세요.
				</p>
				<p class="blue fs12 mt10">
					※마이페이지>배송지관리에서 주소를 관리하실 수 있습니다.
				</p>
				<p class="ac">
					<a href="" class="btn_g mt10">
					배송지 관리
					</a>
				</p>

				<!--정기배송일 경우 추가
					<p class="mt20"><input type="checkbox" id="all"><label for="all" style="margin-left:5px">이후부터 일괄 적용하기</label></p>
					<p><input type="checkbox" id="once"><label for="once" style="margin-left:5px">1회만 적용하기</label></p> -->

				<div class="ac bd">
					<a href="" class="btn_big">
					변경
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
	<!-- END 자유배송 배송지변경 -->










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
