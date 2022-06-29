<!doctype html>
<html lang="ko">
<head>
  <title><?=$recom_info->recom_name?> 식단표 - 에코맘의 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<!-- <meta name="viewport" content="width=800"> -->
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
	<!--
		function move_month(mon){
			location.href="?recom_idx=<?=$recom_idx?>&this_mon="+mon;
		}
	//-->
	</script>

	<style>

	/* 식단표 팝업 */
#menu {
	width:100%;
	margin:0 auto;

}
#menu .top {
	overflow:hidden;
	position:relative;
	height:70px;
	padding:0 20px;
	background:#105f5f;
	color:#fff;
}
#menu .top .tit {
	position:absolute;
	width:200px;
	left:50%; top:30px;
	margin-left:-150px;
	text-align:center;
	padding:0 57px;
}
#menu .top h1 {
	font-size:20px;
	letter-spacing:-0.03em;
}
#menu .top .tit button {
	position:absolute;
	top:-80%;
}
#menu .top .tit .btn_prev {left:0;}
#menu .top .tit .btn_next {right:0;}
#menu .top .time {

	font-weight:600;
}
#menu .btn_print {
	float:right;
	margin-top:11px;
}
.menu_tbl {
	width:100%;
	table-layout:fixed;
}
.menu_tbl thead th {
	height:44px;
	background:#ffc852;
	border:1px solid #ffc852;
	color:#fff;
	font-size:16px;
}
.menu_tbl td {
	border:1px solid #ddd;
	padding:3px;
	font-size:11px;
	line-height:16px;
	letter-spacing:-0.5px;
	color:#666;
	vertical-align:top;
}
.menu_tbl .holi,
.menu_tbl .holi .date {
	color:#d05656;
}
.menu_tbl .date {
	font-size:15px;
	margin-bottom:5px;
	color:#333;
}
.menu_tbl .cf {
	margin-top:5px;
	/* background: #C82506;color: #fff;text-align: center;-webkit-border-radius: 3px;
	-moz-border-radius: 3px;font-size: 11px;padding: 3px 0;line-height: 12px;
	border-radius: 3px; */
}
.menu_tbl .today {
	border-width:3px;
	border-color:#ffc852;
}

	</style>
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


			<h2 class="time"><?=$recom_info->recom_name?></h2>
			<!-- <button type="button" class="plain btn_print" onclick="window.print()"><img src="/image/sub/btn_print.png" alt=""></button> -->


			<div class="tit">
				<h1><?=date("Y년 m월",strtotime($this_mon))?>의 식단표</h1>

				<button type="button" class="plain btn_prev" onclick="move_month('<?=$prev_mon?>')"><img src="/image/sub/cal_prev.png" alt="이전달"></button>
				<button type="button" class="plain btn_next" onclick="move_month('<?=$next_mon?>')"><img src="/image/sub/cal_next.png" alt="다음달"></button>
			</div>

		</div>

		<table class="menu_tbl">
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
							<p class="cf">
								<!-- <?=($today_day_name_val == 0)?"일요일":$arr_holi_name[$today_is_nottoday];?> -->
								<img src="/m/image/sub/dd.png" alt="">
							</p>
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

		<p class="align-c mt20">
			<button type='button' class="btn_gg" onclick="self.close()">닫기</button>
		</p>
	</div>
</body>
</html>
