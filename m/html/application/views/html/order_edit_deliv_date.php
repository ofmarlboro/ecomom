<!doctype html>
<html lang="ko">
<head>
	<title>배송일변경 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/m/css/@default.css?t=<?=time()?>" />
	<script type="text/javascript" src="/m/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/m/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/m/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/m/js/slick.min.js"></script>
	<script type="text/javascript" src="/m/js/setting.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/m/js/common.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script type="text/javascript">
		function move_calendar(mon){
			location.href="?mode=<?=$mode?>&deliv_code=<?=$deliv_code?>&this_mon="+mon;
		}

		function date_select(date){
			$(".days").removeClass('today');

			$(".days").each(function(){
				if($(this).data('nowdate') == date){
					if($(this).hasClass('check')){
						alert("배송이 예정된 날짜로 변경하시면, 배송회차가 합쳐지게 됩니다.\n한번 합쳐진 배송회차는 다신 분리할 수 없으니, 신중하게 선택하여 주시기 바랍니다.");
					}
					$(this).addClass('today');
				}
			});

			$("input[name='chg_date']").val(date);
		}

		function deliv_date_alert(){
			alert("배송일로 예정된 날짜로 변경하시려면 관리자에게 문의 하여 주시기 바라며,\n한번 합쳐진 배송일자는 재 변경이 불가하오니 신중히 선택해 주시기 바랍니다.");
		}

		function change_form_send(){
			var frm = document.deliv_date_chg;

			if(frm.chg_date.value == "" || frm.sel_date.value == frm.chg_date.value){
				alert("변경할 날짜를 선택해 주세요.");
				return;
			}

			if(confirm("선택 날짜로 배송일을 변경 하시겠습니까?")){
				$(".review_addfile_loading_wrap").show();
				frm.submit();
			}

		}

		function change_form_send_none(){
			alert("주문 시, 배송비 무료로 결제한 주문이\n포함된 경우 배송일 직접변경이 불가합니다\n예: 정기배송+간식주문 했을 시\n\n1:1문의게시판을 이용해주세요");
			opener.document.location.href='/m/html/dh_board/lists/withcons07/?myqna=Y';
			self.close();
		}
	</script>
</head>
<body>

	<div class="review_addfile_loading_wrap">
		<div class="review_box align-c">
			<img src="/image/load.gif" alt="">
		</div>
	</div>

	<div class="layer_pop" style="z-index:99999 !important;">
	<?php
	if($dup_cnt){
	?>
		<div class="pt20">
			<h1>
				배송일 변경
			</h1>
			<div class="inner clearfix">
				<p class="blue">
					※ 배송일이 동일한 다른 주문건이 있습니다.<br>&nbsp;&nbsp;&nbsp;
						 배송비 정책에 의하여 배송일을 바로 변경 하실 수 없습니다.
				</p>

				<p class="jung">
					배송일이 중복된 주문 내용입니다.
				</p>

				<ul class="jung02">
					<?php
					foreach($dup_list as $dl){
					?>
					<li><?=date("m/d",strtotime($dl->deliv_date))?> (<?=numberToWeekname($dl->deliv_date)?>) <?=$dl->prod_name?> (<?=$dl->trade_code?>)</li>
					<?php
					}
					?>
				</ul>
			</div>
			<div class="ac mt20">
				<button type="button" class="btn_y" title="취소" onclick='self.close()'>취소</button>
				<button type="button" class="btn_y" title="변경" onclick="change_form_send_none()">변경</button>
			</div>
		</div>
	<?php
	}
	else{
	?>
		<div class="pt20">
			<h1>
				배송일 변경
			</h1>
			<div class="inner clearfix">
			<p><?=$arr_deliv_date_to_count[$deliv_info->deliv_date]?$arr_deliv_date_to_count[$deliv_info->deliv_date]."회차 ":"";?> <?=$deliv_info->deliv_date?> (<?=numberToWeekname($deliv_info->deliv_date)?>) 변경하실 날짜를 선택하세요.</p>
				<p class="blue">※ 배송일을 변경하시면 배송되는 식단이 변경되므로 꼭 확인해주세요.</p>
				<p class="blue">※ 장기간 연장이 필요 시 “배송 일시정지”를 이용하세요.</p>
				<p class="blue">※ 변경 가능한 날짜만 클릭됩니다.<br>
				- 클릭이 안되는 날짜는 에코맘 배송휴무입니다
				</p>

				<?php
				$lastday = date("t",strtotime($this_mon));
				$startweek = date("w",strtotime($this_mon."-01"));
				$lastweek = date("w",strtotime($this_mon."-".$lastday));

				$totalweek = 5;
				if($startweek > 4 and (ceil($lastday/5) == 7)){
					$totalweek = 6;
				}
				if($startweek==1 and $lastday == 28){
					$totalweek = 4;
				}
				$arr_this_mon = explode("-",$this_mon);

				$prev_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]-1,1,$arr_this_mon[0]));
				$next_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]+1,1,$arr_this_mon[0]));

				//특정일 배송 몰림 현상에 대한 조치
				// 배송 휴무 앞 뒤로 배송이 몰리는 부분에 대한 업체측 고충 해소
				// 날짜 추가 하는 로직 생성
				array_push($arr_holi,'2020-12-24');
				array_push($arr_holi,'2021-02-02');
				array_push($arr_holi,'2021-02-03');
				array_push($arr_holi,'2021-02-04');
				?>

				<div class="drawSchedule">
					<form name="deliv_date_chg" id="deliv_date_chg" method="post">
						<input type="hidden" name="trade_code" value="<?=$trade_info->trade_code?>">
						<input type="hidden" name="deliv_code" value="<?=$deliv_code?>">
						<input type="hidden" name="sel_date" value="<?=$deliv_info->deliv_date?>">
						<input type="hidden" name="chg_date">

						<input type="hidden" name="recom_idx" value="<?=$deliv_info->recom_idx?>">
						<input type="hidden" name="recom_week_day_count" value="<?=$trade_info->recom_week_day_count?>">
						<input type="hidden" name="recom_delivery_sun_type" value="<?=$trade_info->recom_delivery_sun_type?>">
						<input type="hidden" name="recom_week_type" value="<?=$trade_info->recom_week_type?>">

						<input type="hidden" name="trade_goods_idx" value="<?=$trade_info->tg_idx?>">
					</form>

					<div class="date_view">
						<span class="year"><?=date("Y",strtotime($this_mon))?></span>년 <span class="month"><?=date("m",strtotime($this_mon))?></span>월
						<a href="javascript:;" onclick="move_calendar('<?=$prev_mon?>')" class="pre" title="이전">이전</a>
						<a href="javascript:;" onclick="move_calendar('<?=$next_mon?>')" class="next" title="다음">다음</a>
					</div>
					<div class="inner inner_">
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
									<th scope="col">일</th>
									<th scope="col">월</th>
									<th scope="col">화</th>
									<th scope="col">수</th>
									<th scope="col">목</th>
									<th scope="col">금</th>
									<th scope="col">토</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$day = "";
								for($rows=1;$rows<=$totalweek;$rows++){
								?>
								<tr>
									<?php
									for($col=0;$col<7;$col++){
										if((!$day) and ($col == $startweek)){
											$day = 1;
										}

										if($day > 0){
											$today_is_nottoday = date("Y-m",strtotime($this_mon))."-".str_pad($day,2,'0',STR_PAD_LEFT);
											$today_day_name_val = date("w",strtotime($today_is_nottoday));
											$chg_thursday_right = false;
											if($is_thursday and $today_day_name_val == 4){
												$chg_thursday_right = true;
											}
										?>
										<td class="<?= (in_array($today_is_nottoday,$arr_holi) || $limit_date > $today_is_nottoday) || ($is_thursday && !$chg_thursday_right)?"gray":"";?>">
											<!-- <a href="javascript:;"
												<?if(!in_array($today_is_nottoday,$arr_holi)){?>onclick="date_select('<?=$today_is_nottoday?>')"<?}?> data-nowdate="<?=$today_is_nottoday?>"
												class="days<?=( in_array($today_is_nottoday,$arr_deliv_date) and $deliv_info->deliv_date != $today_is_nottoday )?" check":"";?> <?=($today_is_nottoday == $deliv_info->deliv_date)?" today":"";?>"> -->
											<a href="javascript:;"
												<?php
												if( in_array($today_is_nottoday,$arr_holi) || $limit_date > $today_is_nottoday ){
													if(in_array($today_is_nottoday,$arr_deliv_date)){

													}
												}
												else{
													if( $is_thursday ){	//배송휴일이 아닌경우
														if( $chg_thursday_right ){
															?>
															onclick="date_select('<?=$today_is_nottoday?>')"
															<?
														}
													}
													else{
														?>
														onclick="date_select('<?=$today_is_nottoday?>')"
														<?
													}
												}
												?>
												data-nowdate="<?=$today_is_nottoday?>"
												class="days<?=( in_array($today_is_nottoday,$arr_deliv_date) and $deliv_info->deliv_date != $today_is_nottoday )?" check":"";?> <?=($today_is_nottoday == $deliv_info->deliv_date)?" today":"";?>">
												<?=$day?>
											</a>
										</td>
										<?php
										}
										else{
										?>
										<td>&nbsp;</td>
										<?php
										}


										if($day != $lastday){
											if(($day > 0) and ($day < $lastday)) $day++;
										}
										else{
											$day = "end";
										}
									}
									?>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
			<div class="ac mt20">
				<button type="button" class="btn_y" title="취소" onclick='self.close()'>취소</button>
				<button type="button" class="btn_y" title="변경" onclick="change_form_send()">변경</button>
			</div>
		</div>
	<?php
	}
	?>
	</div>
</body>
</html>
