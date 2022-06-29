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

						<div class="cal_year">
							<em><?=date("Y년 m월", strtotime($this_mon))?></em>
							<button type="button" class="plain prev" title="이전달" onclick="deliv_calendar_set('<?=$prev_mon?>')"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
							<button type="button" class="plain next" title="다음달" onclick="deliv_calendar_set('<?=$next_mon?>')"><img src="/image/sub/cal_next.png" alt="다음달"></button>
						</div>
						<table class="cm_cal static">
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

										if($day > 0){
											$today_is_nottoday = $this_mon."-".str_pad($day,2,'0',STR_PAD_LEFT);
											?>
											<td class="<?foreach($deliv_between_date as $k=>$v){ if($v == $today_is_nottoday) echo "reg_on"; else echo ""; }?> <?if($holiday_arr and @in_array($today_is_nottoday,$holiday_arr)) echo " holiday";?>"><span><?=$day?></span></td>
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

								<?php
								/*
									<tr>
										<td class="dimmed">25</td>
										<td class="dimmed">26</td>
										<td class="dimmed">27</td>
										<td class="dimmed">28</td>
										<td><span>1</span></td>
										<td><span>2</span></td>
										<td><span>3</span></td>
									</tr>
									<tr>
										<td><span>4</span></td>
										<td><span>5</span></td>
										<td><span>6</span></td>
										<td><span>7</span></td>
										<td><span>8</span></td>
										<td><span>9</span></td>
										<td class="reg_on"><span>10</span></td>
									</tr>
									<tr>
										<td><span>11</span></td>
										<td><span>12</span></td>
										<td><span>13</span></td>
										<td class="reg_on"><span>14</span></td>
										<td><span>15</span></td>
										<td><span>16</span></td>
										<td class="reg_on"><span>17</span></td>
									</tr>
									<tr>
										<td><span>18</span></td>
										<td><span>18</span></td>
										<td><span>20</span></td>
										<td class="reg_on"><span>21</span></td>
										<td><span>22</span></td>
										<td><span>23</span></td>
										<td class="reg_on"><span>24</span></td>
									</tr>
									<tr>
										<td><span>25</span></td>
										<td><span>26</span></td>
										<td><span>27</span></td>
										<td class="reg_on"><span>28</span></td>
										<td><span>29</span></td>
										<td><span>30</span></td>
										<td class="reg_on"><span>31</span></td>
									</tr>
								*/
								?>
								<tr class="blank2">
									<td colspan="7"></td>
								</tr>

									<tr>
										<td colspan="7"  class="align-r pr10" style="height: auto;"><img src="/image/sub/cal02.png" alt="" style="height:20px;"></td>
									</tr>

							</tbody>
						</table>