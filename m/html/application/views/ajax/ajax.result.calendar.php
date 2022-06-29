				<?php
				if(empty($this_mon)) $this_mon = date("Y-m",strtotime($deliv_between_date[0]));
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

				<div class="date_view">
					<span class="year"><?=date("Y", strtotime($this_mon))?></span>년 <span class="month"><?=date("m", strtotime($this_mon))?></span>월
					<a href="javascript:;" class="pre" title="이전" onclick="deliv_calendar_set('<?=$prev_mon?>')">이전</a>
					<a href="javascript:;" class="next" title="다음" onclick="deliv_calendar_set('<?=$next_mon?>')">다음</a>
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
							//$day = 1;
							for($row=1;$row <= $totalweek;$row++){
							?>
							<tr>
								<?php
								for($col=0;$col<7;$col++){

									if((!@$day) and ($col == $startweek)){
										$day = 1;
									}

									if(@$day > 0){
										$today_is_nottoday = $this_mon."-".str_pad(@$day,2,'0',STR_PAD_LEFT);
										?>
										<td class="<?if($holiday_arr and @in_array($today_is_nottoday,$holiday_arr)) echo " holiday";?>"><a class="<?if(in_array($today_is_nottoday,$deliv_between_date)){?>today<?}?> "><?=$day?></a></td>
										<?php
									}
									else{
										echo "<td>&nbsp;</td>";
									}

									if(@$day != $lastday){
										if((@$day > 0) and (@$day < $lastday)) $day++;
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
							<tr>
								<td colspan="7"  class="align-r pr10" style="height: auto;line-height: unset;"><img src="/image/sub/cal02.png" alt="" style="height:17px;"></td>
							</tr>

							<?php
							/*
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
							*/
							?>
						</tbody>
					</table>
				</div>
