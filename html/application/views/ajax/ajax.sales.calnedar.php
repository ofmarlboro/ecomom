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
						$today_date_format = $this_mon."-".str_pad($day,2,'0',STR_PAD_LEFT);
						?>
						<td class="
						<?php
						$orderable = false;
						if(in_array($today_date_format,$holiday_arr)){
							echo "dimmed";
						}
						else if( ($today_date_format < $start_date ) or ($today_date_format > $max_date) ){
							echo "dimmed";
						}
						else{
							$orderable = true;
							if($deliv_date == $today_date_format){
								echo "start_deliv";
							}
							else{
								echo "";
							}

							if(@in_array($today_date_format, $delivdate_arr)){
								echo " reg_on";
							}
						}
						?>">
							<a href="javascript: <?if($orderable){?>Loadsalesfood('<?=$today_date_format?>')<?}else{?><?}?>;"><?=$day?></a>
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
		</tbody>
	</table>