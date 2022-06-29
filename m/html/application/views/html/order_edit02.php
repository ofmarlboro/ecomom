<?
	$PageName = "ORDER_EDIT02";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript">
<!--
	function menu_change(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();
		window.open("<?=cdir()?>/dh_order/order_edit02/?mode=menu_change&deliv_code="+encodeURIComponent(deliv_code) ,"menu_change" ,'');
	}

	function grade_change(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();
		window.open("<?=cdir()?>/dh_order/order_edit02/?mode=grade_change&deliv_code="+encodeURIComponent(deliv_code) ,"grade_change" ,'');
	}
//-->
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
				배송일 <strong class="dh_red">D-2일 PM 16:00까지</strong> 변경가능합니다
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
			<a href="#" class="btn_popup" onClick="openPop();">[필독]메뉴변경 상세보기</a>

			<h2 class="mt20">메뉴 변경</h2>



			<div class="tblTy02">
					<table>
						<colgroup>
							<col style="width:17%;">
							<col>
							<col>
							<col style="width:22%;">
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
							foreach($list as $lt){
								if($old_trade != $lt->trade_code){
									$list_cnt++;
									/*
									$recom_count_arr = array();
									$deliv_date_arr = explode("^",substr($lt->recom_dates,0,-1));
									foreach($deliv_date_arr as $key=>$val){
										$recom_count_arr[$val] = $key+1;	//배열에 날짜를 넣으면 회차가 나옴
									}
									*/
								?>
								<tr>
									<td>정기배송</td>
									<td><?=$lt->prod_name?></td>
									<td>
										<select name="deliv_code<?=$list_cnt?>" class="oe_sel">
											<?php
											foreach($list as $deliv_list){
												if($lt->trade_code == $deliv_list->trade_code){

													list($trade_code_tmp, $deliv_time) = explode("-",$deliv_list->deliv_code);
													list($tcode, $tnos) = explode("_",$trade_code_tmp);

													$prod_name_arr = explode(",",$deliv_list->prod_name);
													$prod_name = explode(":",$prod_name_arr[0]);
													if(count($prod_name_arr) > 1) $prod_name .= " 외 ".(count($prod_name_arr)-1)."건";

													$deliv_count = "";	//정기배송 회차 정보
													$deliv_code_arr = explode("-",$deliv_list->deliv_code);
													if($deliv_list->recom_is == "Y") $deliv_count = $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
												?>
												<!-- <option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option> -->
												<option value="<?=$deliv_list->deliv_code?>"><?=date("m/d", strtotime($deliv_list->deliv_date))."(".numberToWeekname($deliv_list->deliv_date).") ".$prod_name[1]." ".$deliv_count?></option>
												<?php
												}
											}
											?>
										</select>
									</td>
									<td>
										<a href="javascript:;" onClick="menu_change('<?=$list_cnt?>');" class="btn_y">메뉴 변경</a>
										<?php
										if($lt->recom_idx != "3" && $lt->recom_idx != "7" && $tnos < 2){
										?>
										<!-- <a href="javascript:;" onClick="grade_change('<?=$list_cnt?>');" class="btn_y mt10">단계 변경</a> -->
										<!-- <a href="javascript:;" onClick="alert('준비중 입니다.')" class="btn_y mt10">단계 변경</a> -->
										<?php
										}
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


		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>






	<!-- 02메뉴변경 : 메뉴변경-->
	<div class="layer_pop01" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				<span class="btn_y" style="margin-right:10px">메뉴변경</span>3/14(수) 배송 식단 변경
			</h1>
			<div class="inner clearfix">
				<span>알레르기 체크</span>
				<ul class="alrg_list clearfix">
					<li>
						<input type="checkbox" id="alrg13" value="13" class="allergy on" name="allergy13">
						<label for="alrg13">소고기</label>
					</li>
					<li>
						<input type="checkbox" id="alrg12" value="12" class="allergy on" name="allergy12">
						<label for="alrg12">닭고기</label>
					</li>
					<li>
						<input type="checkbox" id="alrg1" value="1" class="allergy" name="allergy1">
						<label for="alrg1">달걀</label>
					</li>
					<li>
						<input type="checkbox" id="alrg2" value="2" class="allergy" name="allergy2">
						<label for="alrg2">우유</label>
					</li>
					<li>
						<input type="checkbox" id="alrg6" value="6" class="allergy" name="allergy6">
						<label for="alrg6">콩</label>
					</li>
				</ul>
				<div class="bd">
				</div>
				<ul class="cart_menu clearfix">
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
					<li>
						<h3>
							c62.사과양배추옹근죽
						</h3>
						<div class="cart-prod-quick">
							<div class="cart-vol">
								<button type="button" class="plain vol-down">감소</button>
								<input type="text" class="vol-num" value="1">
								<button type="button" class="plain vol-up">추가</button>
							</div>
						</div>
					</li>
				</ul>


			</div>
			<button type="button" class="w50 close01" title="닫기" onclick='closeMenuView01();'>취소</button>
				<button type="button" class="w50 close" title="닫기">변경</button>

		</div>
	</div>
	<!-- END 메뉴변경 -->
	<!-- 02메뉴변경 단계변경-->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">

			<h1>
				단계 변경
			</h1>

			<div class="inner">
				<!-- 단계변경 step01 -->
				<!-- 				<p class="bu03">3회차 2018-03-18 수요일부터 적용됩니다.</p>

				<select name="" id="" class="pop_sel01">
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
				</select>
				<p class="blue fs12 mt10">※ 아이의 식단에 맞게 단계를 변경하실 수 있습니다.</p>
				<p class="blue fs12">※ 상위 단계로 변경하시면 추가 결제가 필요합니다.</p>
				<p class="bu03 mt10">“초기”에서 “후기 3식”으로 변경 안내입니다.</p>
				<p class="ac"><a href="" class="btn_green change_g">단계 변경 차액 : 58,000 원</a>

				</p>
				<p class="ac mt10"><a href="" class="btn_w">신용카드</a>
					<a href="" class="btn_w">계좌이체</a></p> -->
				<!-- /변경 step01 -->



				<!-- 단계변경 step02 결제완료 후 넘어가는 페이지-->
				<p class="ac fz16 mb10">단계변경이 완료되었습니다.</p>
				<p><span>변경 전</span><input type="text" class="oe_input"></p>
				<p class="ac pd20">
					<img src="/image/sub/arw.png" alt="">
				</p>
				<p><span>변경 후</span><input type="text" class="oe_input"></p>
				<p class="gray mt10">※ 3회차 : 2018-03-14 수요일부터 <span class="blue">“중기 이유식”</span>으로 배송됩니다.</p>

				<!-- /변경 step02 -->



			</div>

			<button type="button" class="w50 close01" title="취소" onclick='closeMenuView();'>취소</button>
				<button type="button" class="w50 close" title="변경">변경</button>




		</div>
	</div>
	<!-- END 단계변경 -->




	<script type="text/javascript">



		function menuView(){
			$(".layer_pop").fadeIn('fast');
			return false;
		}

		function menuView01(){
			$(".layer_pop01").fadeIn('fast');
			return false;
		}


		function closeMenuView(){

			$(".layer_pop").hide();
		}

		function closeMenuView01(){

			$(".layer_pop01").hide();
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

	<h1>메뉴 변경 사용안내</h1>
<p class="dot">메뉴변경은 <strong class="red">정기배송</strong>에만 해당되며 특정 알러지 제품에 한에서만 지원드립니다.</p>
<p class="dot">변경하실 회차를 선택 후, <strong>알러지 체크를 통해 메뉴/수량변경</strong>이 가능합니다.</p>
<p class="dot">알러지 해당제품만 수량 제외가능하며, <strong class="red">대체메뉴는 최대 2개까지 주문</strong>가능합니다. (특정메뉴 3개이상 주문불가)</p>
<p class="dot"><strong>일별 지정된 총 주문팩수</strong>의 수량을 정확히 채워야 주문이 정상적으로 완료됩니다.</p>
<p class="dot">특정회차에 알러지 제품이 많아 대체메뉴를 고를 수 없으면, 주문취소 후 <strong>낱개주문이용을 권장</strong>드립니다.</p>
<p class="dot">정기배송에 한에 지원드립니다.</p>
<p class="dot">이유식 외 상품을 함께 구매한 경우 (예:정기배송 1회차+간식) 배송비 정책에 의해
     1회차는 시스템 직접변경은 어려울 수 있으니, 1:1 문의게시판을 이용하세요.</p>
<p class="dot">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다</p>

<p class="ac"><a href="#" class="btn_popC" onClick="closePop();">확인</a></p>
	</div>

</div>






<? include('../include/footer.php') ?>


