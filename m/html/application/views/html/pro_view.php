<?
	$PageName = "PRO_VIEW";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');

	$refer = $_SERVER['HTTP_REFERER'];
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>

			<!-- 탭메뉴 -->
			<!-- <div class="oe_menu order_opt">
									<div class="selbox">
										<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span">2뎁스 메뉴명 노출</span></button>
										<ul>
											<li>
												<input type="radio" id="menu01" checked="" onclick="location.href='pro_view.php'">
												<label for="menu01">2뎁스 메뉴명 노출</label>
											</li>
											<li>
												<input type="radio" id="menu02" checked=""
												onclick="location.href='pro_view.php'">
												<label for="menu02">2뎁스 메뉴명 노출</label>
											</li>
											<li>
												<input type="radio" id="menu03"
												onclick="location.href='pro_view.php'">

												<label for="menu03">2뎁스 메뉴명 노출</label>
											</li>
											<li>
												<input type="radio" id="menu04"
												onclick="location.href='pro_view.php'">
												<label for="menu04">2뎁스 메뉴명 노출</label>
											</li>
											<li>
												<input type="radio" id="menu05" onclick="location.href='pro_view.php'">
												<label for="menu05">2뎁스 메뉴명 노출</label>
											</li>
										</ul>
									</div>

			</div> -->
			<script type="text/javascript" src="/js/orderPage.js"></script>
			<!-- //탭메뉴  -->



	<div class="inner view">
		<h1 class="tit01"><?=$row->name?></h1>
		<div class="pro_img">
			<img src="/_data/file/goodsImages/<?=$row->list_img?>" alt="">
		</div>
		<table class="info_tbl">
			<tbody>
				<tr>
					<th class="bl0">단계</th>
					<th>식품유형</th>
					<th>용량</th>
					<th>유통기한</th>
					<th class="br0">제조원</th>
				</tr>
				<tr>
					<td class="bl0"><?=$row->step_name?></td>
					<td><?=$row->food_type?></td>
					<td><?=$row->size?></td>
					<td><?=$row->expire?></td>
					<td class="br0"><?=$row->make_com?></td>
				</tr>
			</tbody>
		</table>

		<?php
		if($row->cate_no != "6"){
		?>
		<h3 class="ptit">영양분석표 (100g당 함량)</h3>
		<?php
		$calories_arr = explode("^",substr($row->calories,0,-1));
		?>
		<table class="info_tbl">
			<tbody>
				<tr>
					<th class="bl0">열량</th>
					<th>탄수화물</th>
					<th>당류</th>
					<th>단백질</th>
					<th class="br0">지방</th>
				</tr>
				<tr>
									<td rowspan="3" class="bl0"><span class="kcal"><?=number_format($row->all_calorie)?></span> kcal</td>
									<td><?=number_format($calories_arr[0])?>g</td>
									<td><?=number_format($calories_arr[1])?>g</td>
									<td><?=number_format($calories_arr[2])?>g</td>
									<td class="br0"><?=number_format($calories_arr[3])?>g</td>
				</tr>
				<tr>
					<th>포화지방</th>
					<th>트랜스지방</th>
					<th>콜레스테롤</th>
					<th class="br0">나트륨</th>
				</tr>
				<tr>
									<td><?=number_format($calories_arr[4])?>g</td>
									<td><?=number_format($calories_arr[5])?>g</td>
									<td><?=number_format($calories_arr[6])?>mg</td>
									<td class="br0"><?=number_format($calories_arr[7])?>mg</td>
				</tr>
			</tbody>
		</table>
		<h3 class="ptit">원재료 및 함량</h3>
		<?php
		$menual_arr = explode(",",$row->menual);
		?>
		<table class="info_tbl ft086">
			<tbody>
				<tr>
						<?php
						$cnt = 0;
						$ttcnt = count($menual_arr);
						foreach($menual_arr as $ma){
							$cnt++;
						?>
						<td class="<?if($cnt == 1){?>bl0<?}?> <?if($cnt == $ttcnt){?>br0<?}?>"><?=$ma?></td>
						<?php
							if($cnt%3 == 0){
								echo "</tr><tr>";
							}
						}
						?>
				</tr>
			</tbody>
		</table>
		<h3 class="ptit">알러지 유발식품 포함여부를 확인해주세요!</h3>
				<?php
				$allergy_arr1 = array('1'=>'계란','2'=>'우유','3'=>'밀','4'=>'메밀','5'=>'땅콩');
				$allergy_arr2 = array('6'=>'대두','7'=>'토마토','8'=>'돼지고기','9'=>'게','10'=>'새우');
				$allergy_arr3 = array('11'=>'호두','12'=>'닭고기','13'=>'쇠고기','14'=>'오징어','15'=>'조개류');

				$allergys_db_arr = explode("^",substr($row->allergys,0,-1));
				?>
		<table class="info_tbl alrg_tbl">
			<tbody>
				<tr>
					<th class="bl0"><img src="/image/icons/egg.png" alt=""><em>계란</em></th>
					<th><img src="/image/icons/milk.png" alt=""><em>우유</em></th>
					<th><img src="/image/icons/wheat.png" alt=""><em>밀</em></th>
					<th><img src="/image/icons/buckwheat.png" alt=""><em>메밀</em></th>
					<th class="br0"><img src="/image/icons/nut.png" alt=""><em>땅콩</em></th>
				</tr>
				<tr>
					<?php
					foreach($allergy_arr1 as $k=>$v){
						?>
						<td class="<?=($k == 1)?"bl0":"";?> <?=($k == 5)?"br0":"";?>">
							<?php
							if(in_array($k,$allergys_db_arr)){
							?>
							<img src="/image/icons/o.png" alt="O">
							<?php
							}
							else{
							?>
							<img src="/image/icons/x.png" alt="X">
							<?php
							}
							?>
						</td>
						<?php
					}
					?>
				</tr>
				<tr>
					<th class="bl0"><img src="/image/icons/bean.png" alt=""><em>대두</em></th>
					<th><img src="/image/icons/tomato.png" alt=""><em>토마토</em></th>
					<th><img src="/image/icons/pork.png" alt=""><em>돼지고기</em></th>
					<th><img src="/image/icons/crab.png" alt=""><em>게</em></th>
					<th class="br0"><img src="/image/icons/shrimp.png" alt=""><em>새우</em></th>
				</tr>
				<tr>
					<?php
					foreach($allergy_arr2 as $k=>$v){
						?>
						<td class="<?=($k == 1)?"bl0":"";?> <?=($k == 5)?"br0":"";?>">
							<?php
							if(in_array($k,$allergys_db_arr)){
							?>
							<img src="/image/icons/o.png" alt="O">
							<?php
							}
							else{
							?>
							<img src="/image/icons/x.png" alt="X">
							<?php
							}
							?>
						</td>
						<?php
					}
					?>
				</tr>
				<tr>
					<th class="bl0"><img src="/image/icons/walnut.png" alt=""><em>호두</em></th>
					<th><img src="/image/icons/chicken.png" alt=""><em>닭고기</em></th>
					<th><img src="/image/icons/beef.png" alt=""><em>쇠고기</em></th>
					<th><img src="/image/icons/squid.png" alt=""><em>오징어</em></th>
					<th class="br0"><img src="/image/icons/clam.png" alt=""><em>조개</em></th>
				</tr>
				<tr>
					<?php
					foreach($allergy_arr3 as $k=>$v){
						?>
						<td class="<?=($k == 1)?"bl0":"";?> <?=($k == 5)?"br0":"";?>">
							<?php
							if(in_array($k,$allergys_db_arr)){
							?>
							<img src="/image/icons/o.png" alt="O">
							<?php
							}
							else{
							?>
							<img src="/image/icons/x.png" alt="X">
							<?php
							}
							?>
						</td>
						<?php
					}
					?>
				</tr>
			</tbody>
		</table>
		<?php
		}
		?>

		<?php
		if($recom_is == "N"){
		?>
		<p class="mt40 align-c"><button type="button" class="plain" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$goods_idx?>','<?=$price?>','<?=$name?>','<?=$oprice?>');closeMenuView();"><img src="/image/sub/btn_order2.jpg" alt="주문하기"></button></p>
		<?php
		}
		?>

		<hr>
		<h3 class="ctit">이유식 <strong>데우는 방법</strong></h3>
		<h4 class="bgtit">
			방법1. 전자레인지
		</h4>
		<table class="dt_how1">
			<tbody>
				<tr>
					<th><img src="/image/sub/dt_how1.jpg" alt="전자레인지"></th>
				</tr>
				<tr>
					<td><ul>
							<li>
								1. 뚜껑을 개봉합니다.<br>
								<span class="">- 산골이유식은 최상의 신선도를 유지하기 위해 외부 필름포장을 하지않습니다.</span><br>
								<span class="dh_gray ft086">(외부필름포장 공정상 신선한 온도를 유지하고 있는 이유식에 재가열하여 압착하는 원리이므로 신선도가 떨어질수있습니다.)</span>
							</li>
							<li>
								2. 수분증발 방지를 위해 이유식에 생수를 티 스푼으로 1-2회 정도 넣습니다.
							</li>
							<li>
								3. 전자렌지에 1분 정도 뜨겁게 데웁니다.
							</li>
							<li>
								4. 아가에게 먹이기 전에 엄마가 꼭 이유식의 상태를 확인하여 주세요.
							</li>
							<li>
								5. 아가에게 적당한 온도인지 확인하시어 맛있게 먹여주세요.
							</li>
						</ul></td>
				</tr>
			</tbody>
		</table>
		<h4 class="bgtit">
			방법2. 중탕을 이용할 경우
		</h4>
		<table class="dt_how1">
			<tbody>
				<tr>
					<th><img src="/image/sub/dt_how2.jpg" alt="중탕">
					</th>
				</tr>
				<tr>
					<td><ul>
							<li>
								1. 냄비에 물을 (이유식 1/2 정도 잠길 양) 담습니다.
							</li>
							<li>
								2. 이유식의 뚜껑을 열고물에 담그어 10분가량 데웁니다.
							</li>
							<li>
								3. 아기에게 먹이기 전에 엄마가 꼭 이유식의 상태를 확인하여 주세요.
							</li>
							<li>
								4. 아가에게 적당한 온도인지 확인하시어 맛있게 먹여주세요.
							</li>
						</ul></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<h3 class="ctit">이유식 <strong>데우는 방법</strong></h3>
		<h4 class="bgtit mb15">
			이유식 보관방법
		</h4>
		<table class="dt_how2">
			<colgroup>
			<col style="width:100px;">
			</colgroup>
			<tbody>
				<tr>
					<th><img src="/image/sub/dt_keep1.jpg" alt="나누어 먹일 경우"></th>
					<td>1. 나누어 먹이실 경우에는 먹일 양만큼 다른 용기에 덜어내고 병에 남은 이유식은 반드시 뚜껑을 닫아 냉장보관 하세요.<br>
						<span class="dh_red ft092">※ 냉동보관시 안전한 타용기에 덜어서 보관하세요.</span></td>
				</tr>
				<tr>
					<th><img src="/image/sub/dt_keep2.jpg" alt="주의사항"></th>
					<td>2. 열어서 아가에게 먹이시고 남은 이유식은 침 등으로 인해 변질 될 수 있으므로 아가에게 다시 먹이시면 안됩니다.</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<h3 class="ctit"><strong>생산공정</strong> 소개해요</h3>
		<div class="bdbox">
			<h4 class="sptit">
				산골이유식은 이렇게 만들어집니다.
			</h4>
			<ul class="ml25">
				<li>
					1. 청정지역 지리산 500m고지에 위치해있습니다.
				</li>
				<li>
					2. 세계 111번째 슬로시티인 하동군 악양면의 현지 농산물을 공급받아 사용합니다.
				</li>
				<li>
					3. 식재료의 이동은 거리가  짧아 가장 신선한 재료로 이유식이 만들어집니다.
				</li>
			</ul>
		</div>
		<h4 class="bgtit">
			에코맘 안심 생상 공정
		</h4>
		<h5 class="sptit ml10">
			식품위생법 제 4조에 입각한 위생시스템 관리공정으로 에코맘 안심생산 공정을 공개합니다.
		</h5>
		<ul class="dt_step">
			<li>
				<span class="img"><img src="/image/sub/dt_step1.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						01. 식재료 입고 및 검수
					</h6>
					<p class="desc">지리산골의 오전 7시, 푸드마일리지가 짧은 신선한 재료가 입고되면 생산자와 유통기한부터 온도, 중량 등을 꼼꼼하게 검수해요.</p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step2.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						02. 1/2차 전처리 세척, 다듬기
					</h6>
					<p class="desc">세척하고 확인, 그리고 1차, 2차 전처리를 시작해요.<br>
						아가가 먹기 좋은 이유식 단계별 규격에 맞추어 손질해요.</p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step3.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						03. 정밀검수
					</h6>
					<p class="desc">육안검수와 정밀검수를 모두 실시해요.<br>
						절단은 규격에 맞게 잘 절단되었는지, 이물 등은 없는지! </p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step4.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						04. 100% 핸드메이드조리
					</h6>
					<p class="desc">지리산 청정수로 천연 맛국물을 만든답니다!<br>
						영양분과 맛을 보존하며 100% 핸드메이드로 조리해요.</p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step5.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						05. 1차 내포장
					</h6>
					<p class="desc">1차 내포장은 자동화 포장기에 의해 1차/2차 실링을 하여 외부로부터의 오염을 차단합니다.</p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step6.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						06. 검수 3단계
					</h6>
					<p class="desc">1차 중량선별기로 중량을 체크하고 2차 X-Ray 이물검출기와  3차 금속검출기로 이물검수를 거칩니다.</p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step7.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						07. 칠러(Chiller)급속냉각시스템
					</h6>
					<p class="desc l3">외부온도에노출이 되지 않은 상태로 급속냉각 칠러시스템으로 이동하여 이유식 심부온도를 빠르게 영하 40도이하로 떨어뜨린 후, 워크인쿨러에서 가장 안전한 온도 0~3℃로 보관된답니다. </p>
				</div>
			</li>
			<li>
				<span class="img"><img src="/image/sub/dt_step8.png" alt=""></span>
				<div class="txt">
					<h6 class="tit">
						08. 2차 외포장
					</h6>
					<p class="desc l3">완제품은 자체 품질검사 진행 후외포장실에서 안전한 보냉박스에 포장되어 우체국택배를 통해 즉시 배송 출발합니다. </p>
				</div>
			</li>
		</ul>
		<hr>
		<h3 class="ctit"><strong>당일발송, 익일수령, 주문마감시간</strong> 안내</h3>
		<h4 class="sptit">
			매주 월요일, 공휴일 다음날은 수령이안되오니 주문에 참고해주세요.
		</h4>
		<table class="info_tbl">
			<colgroup>
			<col style="width:46%;">
			<col style="width:26%;">
			<col>
			</colgroup>
			<thead>
				<tr>
					<th class="bl0">주문요일</th>
					<th>생산요일</th>
					<th class="br0">수령요일</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="bl0">금요일 오전 7시 이후 ~ 월요일 오전 7시 이전</td>
					<td>월</td>
					<td class="br0">화</td>
				</tr>
				<tr>
					<td class="bl0">월요일 오전 7시 이후 ~ 화요일 오전 7시 이전</td>
					<td>화</td>
					<td class="br0">수</td>
				</tr>
				<tr>
					<td class="bl0">화요일 오전 7시 이후 ~ 수요일 오전 7시 이전</td>
					<td>수</td>
					<td class="br0">목</td>
				</tr>
				<tr>
					<td class="bl0">수요일 오전 7시 이후 ~ 목요일 오전 7시 이전</td>
					<td>목</td>
					<td class="br0">금</td>
				</tr>
				<tr>
					<td class="bl0">목요일 오전 7시 이후 ~ 금요일 오전 7시 이전</td>
					<td>금</td>
					<td class="br0">토</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
