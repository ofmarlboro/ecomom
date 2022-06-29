<?php
$delivery_item_count = 0;

$arr_delivery_week_day_count = explode(':', $delivery_week_day_count);

$var1 = $arr_delivery_week_day_count[1];
$var2 = $delivery_week_count;
$total_delivery_item_count = $var1 * $var2;

// 1주 배송 수량이 7일분이 아닐 경우는 일요일 추가가 아닌걸로 간주처리함.
$var0 = $arr_delivery_week_day_count[0];
if ($var0 != 7) $delivery_sun_type = 0;

$arr_week = array('일' => 'sun', '월' => 'mon', '화' => 'tue', '수' => 'wed', '목' => 'thu', '금' => 'fri', '토' => 'sat');
$arr_delivery_week_type = explode(':', $delivery_week_type);

// 7일 일 경우에만 일요일 선택
// $delivery_sun_type = $arr_delivery_week_day_count[0] == 7 ? true : false;

$arr_sun_week = array(0 => 'now', 4 => 'thursday this week', 5 => 'friday this week', 6 => 'saturday this week');
$arr_week2 = array('일' => 0, '월' => 1, '화' => 2, '수' => 3, '목' => 4, '금' => 5, '토' => 6);
$last_day_text = end(explode(',', $arr_delivery_week_type[1]));
$search_last_week = $arr_week2[$last_day_text];


$search_idx = $arr_delivery_week_day_count[0];
$search_week_type = array();

foreach ($food_info[$search_idx]['delivery_week_type'] as $info) {
	if ($delivery_week_type==$info['val']) {
		$search_week_type = $info['count'];
		break;
	}
}

foreach ($delivery_day['delivery_day'] as $value) {

	$date = $value[0];
	$count = $search_week_type[$value[1]];
	$week = $value[1];

	$start_date = '';
	$end_date = '';
	$current_time = strtotime($date);

	//strtotime bug catch Fuck bugs
	if(date("w",$current_time) == 1) $start_monday = $current_time;
	else $start_monday = strtotime('last monday',$current_time);

	//$current_time = $start_monday;

	$mon_date = date('Y-m-d', strtotime('monday this week', $start_monday));
	$wed_date = date('Y-m-d', strtotime('wednesday this week', $start_monday));
	$thu_date = date('Y-m-d', strtotime('thursday this week', $start_monday));
	$fri_date = date('Y-m-d', strtotime('friday this week', $start_monday));
	$sat_date = date('Y-m-d', strtotime('saturday this week', $start_monday));
	$sun_date = date('Y-m-d', strtotime('sunday this week', $start_monday));

	/*
	// 7일분 주 2회배송 (화,금 or 수,토)
	if ($arr_delivery_week_day_count[0] == 7 && $arr_delivery_week_type[0] == 2) {

		$_week = date('w', $current_time);
		// 월~수요일이면
		if ($_week < 4) {
			$start_date = $mon_date;
			$end_date = $wed_date;

		// 목~토요일이면
		} else {
			$start_date = $thu_date;
			$end_date = $sun_date;

		}

	// 7일분 주 3회배송 (화,목토)
	} else if ($arr_delivery_week_day_count[0] == 7 && $arr_delivery_week_type[0] == 3) {

		$_week = date('w', $current_time);
		// 토요일이면
		if ($_week==7) {
			// 오늘
			$start_date = date('Y-m-d', strtotime('yesterday', $current_time));
			$end_date = date('Y-m-d', strtotime('+1 day', $current_time));

		} else {
			// 오늘
			$start_date = date('Y-m-d', strtotime('yesterday', $current_time));
			$end_date = $date;

		}

	// 6일분 주 2회배송 (화,금 or 수,토)
	} else if ($arr_delivery_week_day_count[0] == 6 && $arr_delivery_week_type[0] == 2) {
	*/

	// 7일분/6일분 주 2회배송 (화,금 or 수,토)
	if (($arr_delivery_week_day_count[0] == 6 || $arr_delivery_week_day_count[0] == 7) && ($arr_delivery_week_type[0] == 2 || $arr_delivery_week_type[0] == 1)) {

		$_week = date('w', $current_time);
		// 월~수요일이면
		if ($_week < 4) {
			$start_date = $mon_date;
			$end_date = $wed_date;

		// 목~토요일이면
		} else {
			$start_date = $thu_date;
			$end_date = $sat_date;
		}

	// 주 3회배송 or 4일분 주 2회배송
	}
	else if($arr_delivery_week_day_count[0] == 4 && $arr_delivery_week_type[0] == 1){
		$_week = date('w', $current_time);

		$start_date = $thu_date;
		$end_date = $fri_date;
	}
	else {

		// 오늘
		$start_date = date('Y-m-d', strtotime('yesterday', strtotime($date)));
		$end_date = $date;

	}

	$search_delivery_item_count = 0;
	$standard_cnt = 0;

	//$standard_cnt = $food_info[$search_idx]['delivery_week_type'][$delivery_week_type_key]['count'][$value[1]];

	$sql = "select a.*, b.name, b.list_img, b.allergys
	from dh_recom_food_table a, dh_goods b
	where a.recom_food_idx = '{$recom_idx}'
	and a.recom_date between '{$start_date}' and '{$end_date}'
	and a.goods_idx = b.idx
	order by a.recom_date desc " . ($count ? 'limit '.$count : '');

	$_row = $this->common_m->self_q($sql,"fetch_array");

	$row = array();

	foreach($_row as $_row){
		if ($total_delivery_item_count > $delivery_item_count) {
			$_row['date'] = $date;
			$row[] = $_row;
			$delivery_item_count ++;
			$search_delivery_item_count ++;

			$standard_cnt++;
		}
	}

	if($arr_delivery_week_type[0] == 1){
		$sql = "select a.*, b.name, b.list_img, b.allergys
		from dh_recom_food_table a, dh_goods b
		where a.recom_food_idx = '{$recom_idx}'
		and a.recom_date between '{$start_date}' and '{$end_date}'
		and a.goods_idx = b.idx
		order by a.recom_date desc " . ($count ? 'limit '.$count : '');

		$_row = $this->common_m->self_q($sql,"fetch_array");

		foreach($_row as $_row){
			if ($total_delivery_item_count > $delivery_item_count) {
				$_row['date'] = $date;
				$row[] = $_row;
				$delivery_item_count ++;
				$search_delivery_item_count ++;

				$standard_cnt++;
			}
		}
	}

	// 일요일 추가건 검색
	if (($count > $search_delivery_item_count) && $delivery_sun_type && $arr_delivery_week_day_count[0] == 7 && $search_last_week == date('w', $current_time)) {
		$count -= $search_delivery_item_count;
		$start_date = date('Y-m-d', strtotime($arr_sun_week[$delivery_sun_type], $start_monday));
		$end_date = $start_date;

		$sql = "select a.*, b.name, b.list_img, b.allergys
						from dh_recom_food_table a, dh_goods b
						where a.recom_food_idx = '{$recom_idx}'
							and a.recom_date = '{$sun_date}'
							and a.goods_idx = b.idx
						order by a.recom_date desc " . ($count ? 'limit '.$count : '');
		$_row = $this->common_m->self_q($sql,"fetch_array");
		foreach($_row as $_row){
			// 전체 배송 팩수를 초과 할수 없도록 처리한다.
			if ($total_delivery_item_count > $delivery_item_count) {
				$_row['date'] = $date;
				$_row['sunday'] = 1;
				$row[] = $_row;

				$delivery_item_count ++;

				$standard_cnt++;
			}

		}
	}

	// 일요일 추가분이 있고, 시작일 이후 한주의 첫번째, 두번째 배송일에 일요일추가분을 현재 배송일에 추가한다.
//	if ($delivery_sun_type && $search_last_week != date('w', $current_time)) {
//		$sun_date = date('Y-m-d', strtotime($arr_sun_week[$search_last_week], $start_monday));
//		$check_date = $sun_date;
//		//$start_date = date('Y-m-d', strtotime($arr_sun_week[$delivery_sun_type], $start_monday));
//		//$end_date = $start_date;
//
//		$sun_checked = true;
//
//		// 주 3회 배송
//		if ($arr_delivery_week_type[0] == 3) {
//			// 화요일일 경우 다음 요일인 목요일을 체크한다.
//			if (date('w', $current_time) == 2) $check_date = $thu_date;
//		}
//
//		foreach ($delivery_day['delivery_day'] as $value2) {
//			if ($value2[0] == $check_date) {
//				$sun_checked = false;
//				break;
//			}
//		}
//
//		if ($sun_checked) {
//			$count = $search_week_type[$last_day_text] - $search_week_type[$value[1]];
//
//			$sql = "select a.*, b.name, b.list_img, b.allergys
//							from dh_recom_food_table a, dh_goods b
//							where a.recom_food_idx = '{$recom_idx}'
//								and a.recom_date between '{$start_date}' and '{$end_date}'
//								and a.goods_idx = b.idx
//							order by a.recom_date desc " . ($count ? 'limit '.$count : '');
//			$_row = $this->common_m->self_q($sql,"fetch_array");
//			foreach($_row as $_row){
//				// 전체 배송 팩수를 초과 할수 없도록 처리한다.
//				if ($total_delivery_item_count > $delivery_item_count) {
//
//					//$standard_cnt += 1;
//
//					$_row['date'] = $date;
//					$_row['sunday'] = 1;
//					$row[] = $_row;
//
//					$delivery_item_count ++;
//
//					$standard_cnt++;
//				}
//			}
//		}
//
//	}


	if (count($row)) {
		$deliv_info_count++;
	?>
	<h5 class="htit <?=$arr_holi[$date] ? "orange" : "" ;?>"><?=date("m월 d일",strtotime($date))?> (<?=$week?>) <?=$arr_holi[$date] ? "[배송휴무일]" : "" ;?></h5>
	<div class="cnt_layer">
		<input type="text" name="chg_cnt_<?=strtotime($value[0])?>" value="<?=$standard_cnt?>" passwd_match="<?=date("m/d",strtotime($value[0]))?>(<?=$value[1]?>)메뉴^ : 대체메뉴를 ^&apos;1팩&apos;^ 더 추가하세요." matching_name="stan_cnt_<?=strtotime($value[0])?>" readonly class="cnt_text" onfocus="this.blur()">
		/
		<input type="text" name="stan_cnt_<?=strtotime($value[0])?>" value="<?=$standard_cnt?>" readonly class="cnt_text" onfocus="this.blur()">
		<input type="hidden" name="alg_chg_cnt_<?=strtotime($value[0])?>" value="0">
	</div>

	<div class="orderless orderless_<?=strtotime($value[0])?>" style="display:none;">알레르기 메뉴가 없을 경우<br>낱개주문을 이용하세요.</div>

	<input type="hidden" name="recom_delivery_detail_date[]" value="<?=date("Y-m-d",strtotime($date))?>">
	<ul class="sched_menu <? if($arr_holi[$date]){ if($arr_holitype[$date]['type'] == "배송휴무"){ echo "active"; }else{ echo "early_stop"; } } ?>">
		<?php
		$rcnt = 0;
		foreach($row as $r){
			$rcnt++;
		?>
		<li class="product<?=($rcnt%2==0)?" mr0":"";?><?=($r['sunday'])?" sunday":"";?>" data-goods_idx="<?=$r['goods_idx']?>" data-allergy="<?=$r['allergys']?>">
			<div class="box">
				<span class="cart-vol algy_btn" style="display:@none;">
					<button type="button" class="vol-down minus alrg-minus" style="display:none;" title="1개 빼기">감소</button>
					<input type="text" class="cnt" title="수량" value="1" name="<?=strtotime($value[0])?>_prod_cnt[]" data-delivdate="<?=strtotime($value[0])?>" readonly onfocus="this.blur()">
					<button type="button" class="vol-up plus alrg-plus" style="display:none;" title="1개 더하기">추가</button>
				</span>
				<input type="hidden" name="recom_delivery_detail_prod[]" id="prod_<?=strtotime($value[0])?>_<?=$rcnt?>" value="<?=$r['goods_idx']?>:<?=$date?>:<?=$r['sunday']?>">
				<!-- <a href="<?=cdir()?>/dh/pro_view/?idx=<?=$r['goods_idx']?>&recom_idx=<?=$recom_idx?>" title="상세보기"> -->
				<a href="javascript:menuView('<?=$r['goods_idx']?>');" title="상세보기">
					<span class="img"><img src="/_data/file/goodsImages/<?=$r['list_img']?>" alt="<?=$r['name']?>의 이미지" onerror="this.src='/image/default.jpg'"></span>
					<span class="alrg_mark" style="display:none;">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
				</a>
				<em class="tit"><?=$r['name']?></em>
				<?php
				if($r['sunday']){
				?>
				<span class="added">일요일 추가분</span>
				<?php
				}
				?>
			</div>

			<?php
			if($recom_idx == "2"){
			?>
			<div class="change align-c mt20">
				<button type="button" onclick="change_bomi('<?=strtotime($value[0])?>','<?=$rcnt?>')">쌀보미로 변경</button>
			</div>
			<?php
			}
			?>
		</li>
		<?php
		}
		?>
	</ul>
	<?php
	}
}
?>
<input type="hidden" name="deliv_info_count" value="<?=$deliv_info_count?>">