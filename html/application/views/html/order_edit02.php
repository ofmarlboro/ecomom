<?
	$PageName = "ORDEREDIT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript" src="/js/orderPage.js"></script>
<script type="text/javascript">
<!--
	function menu_change(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (630/2);
		var popupY = (window.screen.height / 2) - (670/2);
		window.open("<?=cdir()?>/dh_order/order_edit02/?mode=menu_change&deliv_code="+encodeURIComponent(deliv_code) ,"menu_change" ,'scrollbar=yes, width=630, height=670, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
	}

	function grade_change(no){

		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (1024/2);
		var popupY = (window.screen.height / 2) - (768/2);
		window.open("<?=cdir()?>/dh_order/order_edit02/?mode=grade_change&deliv_code="+encodeURIComponent(deliv_code) ,"grade_change" ,'scrollbar=no, width=660, height=660, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);

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
						배송일 <strong class="dh_red">D-2일 PM 16:00까지</strong> 변경가능합니다
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
			<p class="orderedit_top">메뉴변경은 정기배송에만 해당되며 특정 알러지 제품에 한에서만 지원드립니다. <br></p>
	<p class="orderedit_top mt5">변경하실 회차 선택 후, 알러지 체크를 통해 메뉴/수량변경이 가능합니다.<br></p>
	<p class="orderedit_top mt5">알러지 해당 제품만 수량 제외 가능하며, 대체메뉴는 최대 2개까지 주문 가능합니다. (특정메뉴 3개이상 주문 불가)<br></p>
	<p class="orderedit_top mt5"><strong>일별 지정된 총 주문팩수</strong>의 수량을 정확히 채워야 주문이 정상적으로 완료됩니다.<br></p>
	<p class="orderedit_top mt5">특정회차에 알러지 제품이 많아 대체메뉴를 고를 수 없으면, 주문취소 후 낱개주문이용을 권장드립니다.</p>
	<p class="orderedit_top mt5">정기배송에 한에 지원드립니다.</p>
	<!-- <p class="orderedit_top mt5">이유식 외 상품을 함께 구매한 경우(예:정기배송 1회차+간식) 배송비 정책에 의해<br>
	     1회차는 시스템 직접변경은 어려울 수 있으니, 1:1 문의게시판을 이용하세요.</p>
	<p class="orderedit_top mt5">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다.</p> -->

			<div>
				<div class="my_tit">
					메뉴 변경
				</div>
				<div class="tblTy01">
					<table>
						<colgroup>
							<col width="15%">
							<col>
							<col>
							<col>
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
									<td>
										<?=str_replace(",","<br>",$lt->prod_name)?>
									</td>
									<td>
										<select name="deliv_code<?=$list_cnt?>" class="reg_sel">
											<?php
											foreach($list as $deliv_list){
												if($lt->trade_code == $deliv_list->trade_code){

													list($trade_code_tmp, $deliv_time) = explode("-",$deliv_list->deliv_code);
													list($tcode, $tnos) = explode("_",$trade_code_tmp);

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
												}
											}
											?>

											<?php
											/*
											<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
											<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
											<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
											*/
											?>
										</select>
									</td>
									<td>
										<a href="javascript:;" onClick="menu_change('<?=$list_cnt?>');" class="btn_yy">메뉴 변경</a>
										<?php
										if($lt->recom_idx != "3" && $lt->recom_idx != "7" && $tnos < 2){
										?>
										<!-- <a href="javascript:;" onClick="grade_change('<?=$list_cnt?>');" class="btn_yy">단계 변경</a> -->
										<!-- <a href="javascript:;" onClick="alert('준비중 입니다.')" class="btn_yy">단계 변경</a> -->
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

						<?php
						/*
						<tr>
							<td>정기배송</td>							<td>이유식 중기 8팩</td>
							<td>
								<select name="" id="reg_sel">
									<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
								</select>
							</td>
							<td>
								<a href="javascript:;" onClick="menuView01();" class="btn_yy">메뉴 변경</a>
								<a href="javascript:;" onClick="menuView();" class="btn_yy">단계 변경</a>
							</td>
						</tr>
						*/
						?>
					</table>
				</div>
			</div>
			<!-- // 02 메뉴변경 -->
		</div>
	</div>

	<?php
	/*
	<!-- 02메뉴변경 : 메뉴변경-->
	<div class="layer_pop01" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				<span class="btn_yy" style="margin-right:10px">메뉴변경</span>3/14(수) 배송 식단 변경
			</h1>
			<div class="bg clearfix">
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
				<div class="ac bd">
					<a href="" class="btn_big">
					변경
					</a>
					<a href="" class="btn_big">
					취소
					</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close" onclick='closeMenuView01();'>
			</a>
		</div>
	</div>
	<!-- END 메뉴변경 -->
	<!-- 02메뉴변경 단계변경-->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner layer_pop_inner02">

			<h1>
				<span class="btn_yy" style="margin-right:10px">단계변경</span>단계 변경
			</h1>

			<div class="bg">
				<!-- 단계변경 step01 -->
				<p class="bu03">3회차 2018-03-18 수요일부터 적용됩니다.</p>
				<span class="btn_green mt20">단계선택</span>
				<select name="" id="" class="sel">
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
					<option value="">변경하실 단계를 선택하여 주세요.</option>
				</select>
				<p class="blue fs12 mt20">※ 아이의 식단에 맞게 단계를 변경하실 수 있습니다.</p>
				<p class="blue fs12 mt10">※ 상위 단계로 변경하시면 추가 결제가 필요합니다.</p>
				<p class="bu03 mt20">“초기”에서 “후기 3식”으로 변경 안내입니다.</p>
				<p><a href="" class="btn_green mt10 change_g">단계 변경 차액 : 58,000 원</a>
					<a href="" class="btn_w">신용카드</a>
					<a href="" class="btn_w">계좌이체</a>
				</p>
				<div class="ac bd">
					<a href="" class="btn_big">
					변경
					</a>
					<a href="" class="btn_big">
					취소
					</a>
				</div>
				<!-- 단계변경 step01 -->
				<!-- 단계변경 step02 결제완료 후 넘어가는 페이지-->
				<p class="bu03">3회차 2018-03-18 수요일부터 적용됩니다.</p>
				<p class="change02"><span>변경 전</span><input type="text"></p>
				<p class="ac pd20">
					<img src="/image/sub/arw.png" alt="">
				</p>
				<p class="change02"><span>변경 후</span><input type="text"></p>
				<p class="gray mt10">※ 3회차 : 2018-03-14 수요일부터 <span class="blue">“중기 이유식”</span>으로 배송됩니다.</p>
				<p class="ac bd">
					<a href="" class="btn_big">닫기</a>
				</p>
				<!-- /변경 step02 -->
			</div>
			<a href="javascript:;" class="btn_close" onclick='closeMenuView();'>
			</a>




		</div>
	</div>
	<!-- END 단계변경 -->
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

		function menuView01(){
			$(".layer_pop01").fadeIn('fast');
			return false;
		}
		function closeMenuView01(){
			$(".layer_pop01 .scroll").scrollTop(0);
			$(".layer_pop01").hide();
		}
	</script>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
