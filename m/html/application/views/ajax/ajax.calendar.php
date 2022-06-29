<?php
		$lastday = date("t",strtotime($this_mon));
		$startweek = date("w",strtotime($this_mon."-01"));
		$lastweek = date("w",strtotime($this_mon."-".$lastday));

		$totalweek = 5;
		if($startweek > 4 and (ceil($lastday/5) >= 6)){
			$totalweek = 6;
		}
		if($startweek==1 and $lastday == 28){
			$totalweek = 4;
		}
		//$totalweek = ceil(($lastday + $startweek) / 7);
		$arr_this_mon = explode("-",$this_mon);

		$prev_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]-1,1,$arr_this_mon[0]));
		$next_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]+1,1,$arr_this_mon[0]));
?>


	<div class="cal_year">
		<em><?=date("Y년 m월", strtotime($this_mon))?></em>
		<button type="button" class="plain prev" title="이전달" onclick="go_calendar_set('<?=$prev_mon?>')"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
		<button type="button" class="plain next" title="다음달" onclick="go_calendar_set('<?=$next_mon?>')"><img src="/image/sub/cal_next.png" alt="다음달"></button>
	</div>
	<table class="cm_cal clickable regmark">
		<thead>
			<tr>
				<th>일</th>
				<th>월</th>
				<th>화</th>
				<th>수</th>
				<th>목</th>
				<th>금</th>
				<th>토</th>
			</tr>
		</thead>
		<tbody>
			<tr class="blank1">
				<td colspan="7"></td>
			</tr>

			<?php
			//$day = 1;
			for($row=1;$row <= $totalweek;$row++){
			?>
			<tr>
				<?php
				for($col=0;$col<7;$col++){

					if((!$day) and ($col == $startweek)){
						$day = 1;
					}

					if( $day > 0 ){
						$today_is_nottoday = $this_mon."-".str_pad($day,2,'0',STR_PAD_LEFT);
						$today_day_name_val = date("w",strtotime($today_is_nottoday));
						?>
						<td class="
						<?php
						$orderable = false;
						if($recom_max_date >= $today_is_nottoday and $today_is_nottoday > date("Y-m-d",$deliv_ok_date)){

							if( (strtotime($default_deliv_start_day) == strtotime($today_is_nottoday)) and in_array($week_name_arr[$today_day_name_val],$week_select_arr) and ( strtotime($today_is_nottoday) > time('+2 day') ) ){	//배송시작일 기본값
								?>
								start_deliv
								<?php
							}

							else{
								if($start_day > $today_is_nottoday){	//오늘이 달력날짜보다 크거나 같을경우 주문 못함
									?>
									dimmed
									<?php
								}
								else{
									if( in_array($week_name_arr[$today_day_name_val],$week_select_arr) and ( strtotime($today_is_nottoday) > time('+2 day') ) and !in_array($today_is_nottoday,$holiday_arr) ){	// 배송일에 따른 표기 (수토, 화금, 화목토)
										$orderable = true;
										?>
										other_deliv
										<?php
									}
									else{	//아니면 말고
										?>
										dimmed
										<?php
									}
								}
							}
						}
						else{
							?>
							dimmed
							<?php
						}

						if(in_array($today_is_nottoday,$holiday_arr)){
							echo " holiday";
						}
						?>"

							data-yoil="<?=$default_deliv_start_day?>" data-date="<?=$today_is_nottoday?>">
							<a href="javascript: <?if($orderable){?>loadScheduleDelivery('<?=$today_is_nottoday?>')<?}else{?><?}?>;"><?=$day?></a>
						</td>
						<?php
					}
					else{
						echo "<td>&nbsp;</td>";
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
			<tr class="blank2">
				<td colspan="7"></td>
			</tr>
			<tr>
				<td colspan="7"  class="align-r pr10" style="height: auto;"><img src="/image/sub/cal01.png" alt="" style="height:17px;"></td>
			</tr>
		</tbody>
	</table>