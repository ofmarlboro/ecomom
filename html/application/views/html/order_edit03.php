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
	function deliv_date_chg(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var popupX = (window.screen.width / 2) - (484/2);
		var popupY = (window.screen.height / 2) - (640/2);
		window.open("<?=cdir()?>/dh_order/order_edit03/?mode=deliv_date_chg&deliv_code="+encodeURIComponent(deliv_code) ,"deliv_date_change" ,'scrollbar=no, width=484, height=640, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
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
					</div>
					<div class="orderedit_top mt10 mb20">
						목요일 주1 회 주문시 배송일은 목요일로만 변경 가능합니다.
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
			<p class="orderedit_top"><strong class="red">배송일 변경하신 후 잊지않도록 주의하세요.</strong><br>
			- 긴 연휴로 다음 회차도 미리 받고싶다면, 맨 마지막 배송일 날짜를 당겨받으시길 권장드립니다.<br>
			 &nbsp 정기배송 중 <strong><u>중간날짜를 당겨받으신 후 고객님이 잊으신다면</u></strong> 중간에 배송이 오지 않아,<br>
			 &nbsp 아기가 식사를 거를 수 있어 미리 당부드립니다.</p>
			<p class="orderedit_top mt5">배송휴무일에 배송일 변경을 진행하지 않으실 경우 맨 마지막 배송일 뒤로 자동배정됩니다. <br></p>
			<p class="orderedit_top mt5">정기배송 요일은 배송휴무일을 제외하고 자유롭게 변경가능합니다.</p>
			<p class="orderedit_top mt5">배송일 변경 시 메뉴도 함께 변경됩니다.</p>
			<p class="orderedit_top mt5">정기배송에 한에 지원드립니다.</p>
			<p class="orderedit_top mt5">목요일 주1 회 주문시 배송일은 목요일로만 변경 가능합니다.</p>
			<!-- <p class="orderedit_top mt5">이유식 외 상품구매가 없을 시 2회차부터는 시스템 변경됩니다.</p> -->
			</p>
			<!-- 03 배송일변경 -->
			<div>
				<div class="my_tit">
					배송일 변경
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
									/*
									$recom_count_arr = array();
									$deliv_date_arr = explode("^",substr($lt->recom_dates,0,-1));
									foreach($deliv_date_arr as $key=>$val){
										$recom_count_arr[$val] = $key+1;	//배열에 날짜를 넣으면 회차가 나옴
									}
									*/
								?>
								<tr>
									<td>정기배송<!-- [<?=$lt->trade_code?>] --></td>
									<td>
										<?=str_replace(",","<br>",$lt->prod_name)?>
									</td>
									<td>
										<script type="text/javascript">
											function ssap_chage_ok(no){
												$this = $("select[name='deliv_code"+no+"']");
												prod_cnt = $this.find("option:selected").data('prodcnt');
												prodcnt = parseInt(prod_cnt);
												if(prodcnt){
													$(".change_deliv_date"+no).hide();
												}
												else{
													$(".change_deliv_date"+no).show();
												}
											}

											$(function(){
												ssap_chage_ok('<?=$list_cnt?>');
											});
										</script>
										<select name="deliv_code<?=$list_cnt?>" class="reg_sel" onchange="ssap_chage_ok('<?=$list_cnt?>')">
											<?php
											$dpc = array();
											foreach($list as $deliv_list){
												if($lt->trade_code == $deliv_list->trade_code and $deliv_list->recom_idx > 0){
													$prod_name_arr = explode(",",$deliv_list->prod_name);
													$prod_name = $prod_name_arr[0];
													if(count($prod_name_arr) > 1) $prod_name .= " 외 ".(count($prod_name_arr)-1)."건";

													$prd_cnt = count($prod_name_arr)-1;

													$deliv_count = "";	//정기배송 회차 정보
													$deliv_code_arr = explode("-",$deliv_list->deliv_code);	//정기배송 중복 주문으로 로직 변경에 의한 회차 정보 리뉴얼
													if($deliv_list->recom_is == "Y") $deliv_count = $deliv_info_arr[$deliv_list->trade_code][$deliv_code_arr[0]][$deliv_list->deliv_date]."회차";
												?>
												<!-- <option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option> -->
												<option value="<?=$deliv_list->deliv_code?>" data-prodcnt="<?=$prd_cnt?>"><?=date("m/d", strtotime($deliv_list->deliv_date))."(".numberToWeekname($deliv_list->deliv_date).") ".$prod_name." ".$deliv_count?></option>
												<?php
												}
											}
											?>
										</select>
									</td>
									<td>
										<a href="javascript:;" onClick="deliv_date_chg('<?=$list_cnt?>');" class="btn_yy change_deliv_date<?=$list_cnt?>">배송일 변경</a>
										<a href="javascript:;" onClick="menuPop('<?=$lt->recom_idx?>');" class="btn_yy">월별 식단표</a>
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
							<td>정기배송</td>
							<td>이유식 중기 8팩</td>
							<td><select name="" id="reg_sel">
									<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
								</select></td>
							<td>
								<a href="javascript:;" onClick="menuView();" class="btn_yy">
								배송일 변경
								</a>
								<a href="#" onClick="menuPop();" class="btn_yy">
								월별 식단표
								</a>
							</td>
						</tr>
						*/
						?>
					</table>
				</div>
			</div>
			<!-- // 03 배송일변경 -->

		</div>
	</div>



	<!-- 03배송일변경-->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner">
			<h1>
				배송일 변경
			</h1>
			<div class="bg clearfix">
			<p class="bu03">3회차 2018-03-18 (수) 변경하실 날짜를 선택하세요.</p>
				<p class="blue fs12 mt20">※ 배송일을 변경하시면 배송되는 식단이 변경되므로 꼭 확인해주세요.</p>
				<p class="blue fs12 mt10">※ 장기간 연장이 필요 시 “배송 일시정지”를 이용하세요.</p>
				<div class="drawSchedule">

							<div class="date_view">
								<span class="year">2017</span>년 <span class="month">04</span>월
								<a href="#" class="pre" title="이전">이전</a><a href="#" class="next" title="다음">다음</a>
							</div>
							<div class="inner">
								<table>

									<colgroup>
										<col style="width:15%">
										<col style="width:14%">
										<col style="width:14%">
										<col style="width:14%">
										<col style="width:14%">
										<col style="width:14%">
										<col style="width:15%">
									</colgroup>
									<thead>
										<tr>
											<th scope="col" >일</th>
											<th scope="col">월</th>
											<th scope="col">화</th>
											<th scope="col">수</th>
											<th scope="col">목</th>
											<th scope="col">금</th>
											<th scope="col" >토</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="gray"><a href="">29</a></td>
											<td class="gray"><a href="">30</a></td>
											<td><a href="#" class="check">1</a></td>
											<td><a href="">2</a></td>
											<td><a href="">3</a></td>
											<td><a href="">4</a></td>
											<td ><a href="">5</a></td>
										</tr>
										<tr>
											<td ><a href="">6</a></td>
											<td><a href="">7</a></td>
											<td><a href="">8</a></td>
											<td><a href="#" class="check">9</a></td>
											<td><a href="#" class="check">10</a></td>
											<td><a href="">11</a></td>
											<td ><a href="">12</a></td>
										</tr>
										<tr>
											<td ><a href="">13</a></td>
											<td><a href="">14</a></td>
											<td><a href="">15</a></td>
											<td><a href="" class="today">16</a></td>
											<td><a href="">17</a></td>
											<td><a href="">18</a></td>
											<td ><a href="">19</a></td>
										</tr>
										<tr>
											<td ><a href="">20</a></td>
											<td><a href="">21</a></td>
											<td><a href="">22</a></td>
											<td><a href="">23</a></td>
											<td><a href="">24</a></td>
											<td><a href="">25</a></td>
											<td ><a href="">26</a></td>
										</tr>
										<tr>
											<td ><a href="">27</a></td>
											<td><a href="">28</a></td>
											<td><a href="">29</a></td>
											<td><a href="">30</a></td>
											<td><a href="">31</a></td>
											<td class="gray"><a href="">1</a></td>
											<td class="gray"><a href="">2</a></td>
										</tr>
										<tr>
											<td class="gray"><a href="">3</a></td>
											<td class="gray"><a href="">4</a></td>
											<td class="gray"><a href="">5</a></td>
											<td class="gray"><a href="">6</a></td>
											<td class="gray"><a href="">7</a></td>
											<td class="gray"><a href="">8</a></td>
											<td class="gray"><a href="">9</a></td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>


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
	<!-- END 배송일변경 -->



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
