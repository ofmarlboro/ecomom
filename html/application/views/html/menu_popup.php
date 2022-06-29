<!doctype html>
<html lang="ko">
<head>
  <title><?=$recom_info->recom_name?> 식단표 - 에코맘의 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=800">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<meta name="description" content="<?=$shop_info['description']?>">
	<meta property="og:description" content="<?=$shop_info['og_description']?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?=date("Y년 m월",$today)?>의 식단표(<?=$recom_info->recom_name?>) - 에코맘의 산골이유식">
	<? if($shop_info['og_image']){?><meta property="og:image" content="http://<?=$shop_info['shop_domain']?>/_data/file/<?=$shop_info['og_image']?>"><?}?>
	<meta property="og:url" content="http://<?=$shop_info['shop_domain']?>">
	<meta name="url" content="http://<?=$shop_info['shop_domain']?>">
	<link rel="canonical" href="<?=$shop_info['shop_domain']?>" />
	<? if($shop_info['search_use']!="y"){ ?>
	<meta name="robots" content="noindex"><!-- 검색엔진로봇 수집을 막음 -->
	<link rel="shortcut icon" href="/image/common/favicon.ico">
	<?}?>

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?php echo time(); ?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript">
	<!--
		function move_month(mon){
			location.href="?recom_idx=<?=$recom_idx?>&this_mon="+mon;
		}
	//-->
	</script>
</head>
<body>
	<div id="menu">
	<?php
	$lastday = date("t",strtotime($this_mon));
	$startweek = date("w",strtotime($this_mon."-01"));
	$lastweek = date("w",strtotime($this_mon."-".$lastday));

	$totalweek = 5;
	if($startweek > 4 and (ceil($lastday/5) == 7)){
		$totalweek = 6;
	}
	if($startweek==1 and $lastday == 28){
		$totalweek = 5;
	}
	$arr_this_mon = explode("-",$this_mon);

	$prev_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]-1,1,$arr_this_mon[0]));
	$next_mon = date("Y-m",mktime(0,0,0,$arr_this_mon[1]+1,1,$arr_this_mon[0]));
	?>
		<div class="top">
			<div class="tit">
				<h1><?=date("Y년 m월",strtotime($this_mon))?>의 식단표</h1>

				<button type="button" class="plain btn_prev" onclick="move_month('<?=$prev_mon?>')"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
				<button type="button" class="plain btn_next" onclick="move_month('<?=$next_mon?>')"><img src="/image/sub/cal_next.png" alt="다음달"></button>
			</div>

			<h2 class="time"><?=$recom_info->recom_name?></h2>
			<a href="#" id="close05" onclick="self.close()"><img src="/image/main/close02.png" alt=""></a>
			<button type="button" class="plain btn_print" onclick="window.print()"><img src="/image/sub/btn_print.png" alt=""></button>


		</div>

		<table class="menu_tbl" style="width: 100%;">
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
				<?php
				for($row=1;$row<=$totalweek;$row++){
				?>
				<tr>
					<?php
					for($col=0;$col<7;$col++){
						if((!$day) and ($col == $startweek)){
							$day = 1;
						}

						if($day > 0){
							$today_is_nottoday = $this_mon."-".str_pad($day,2,'0',STR_PAD_LEFT);
							$today_day_name_val = date("w",strtotime($today_is_nottoday));
						?>
						<td class="<?=($today_day_name_val == 0 or in_array($today_is_nottoday,$arr_holi))?"holi":"";?> <?=($today_is_nottoday == date("Y-m-d"))?" today":"";?>">
							<p class="date"><?=$day?></p>

							<?php
							if($recom_foods){
							?>
							<ul class="menu">
								<?php
								foreach($recom_foods as $rf){
									if($rf->recom_date == $today_is_nottoday){
									?>
									<li><?=$rf->name?></li>
									<?php
									}
								}
								?>
							</ul>
							<?php
							}
							?>

							<?php
							if($today_day_name_val == 0 or in_array($today_is_nottoday,$arr_holi)){
							?>
							<p class="cf"><?=($today_day_name_val == 0)?"일요일":$arr_holi_name[$today_is_nottoday];?></p>
							<?php
							}
							?>
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

				<?php
				/*
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="holi">
						<p class="date">1</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td class="holi">
						<p class="date">2</p>
						<ul class="menu">
							<li>D06. 한우모듬채소진밥</li>
							<li>D65. 근대두부진밥</li>
							<li>D61. 양송이야채진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td>
						<p class="date">2</p>
						<ul class="menu">
							<li>D11. 흰살생선두부진밥</li>
							<li>D60. 근대두부진밥</li>
							<li>D48. 한우콩나물진밥</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="holi">
						<p class="date">4</p>
						<p class="cf">일요일</p>
					</td>
					<td class="holi">
						<p class="date">5</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td>
						<p class="date">6</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">7</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">8</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">9</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">10</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="holi">
						<p class="date">11</p>
						<p class="cf">일요일</p>
					</td>
					<td class="holi">
						<p class="date">12</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td>
						<p class="date">13</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">14</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">15</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">16</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">17</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="holi">
						<p class="date">18</p>
						<p class="cf">일요일</p>
					</td>
					<td class="holi">
						<p class="date">19</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td>
						<p class="date">20</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">21</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td class="today">
						<p class="date">22</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">23</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">24</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td class="holi">
						<p class="date">25</p>
						<p class="cf">일요일</p>
					</td>
					<td class="holi">
						<p class="date">26</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
						<p class="cf">배송휴일</p>
					</td>
					<td>
						<p class="date">27</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">28</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">29</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">30</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
					<td>
						<p class="date">31</p>
						<ul class="menu">
							<li>D51. 발아현미소고기무아욱진밥</li>
							<li>D30. 근대두부진밥</li>
							<li>D64. 오이채소무침진밥</li>
						</ul>
					</td>
				</tr>
				*/
				?>
			</tbody>
		</table>
	</div>
</body>
</html>
