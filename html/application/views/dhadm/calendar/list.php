<?
	$th_data = "";
	for ($i=0; $i<count($strDay); $i++){
		$th_data.='<th scope="col">'.$strDay[$i].'</th>';
	}
?>
<!-- 날짜이동 스크립트 -->
<script type="text/javascript">
<!--
	function gocalendar(){
		var year = $(".year").val();
		var month = $(".month").val();
		location.href="<?=self_url()?>?year="+year+"&month="+month;
	}

	function holiday_set(date){
		openWinPopup("/html/product/holipop/m/?ajax=1&date="+date,"holi_list", 600, 500);
	}

	function holiday_del(date){
		if(confirm("삭제 하시겠습니까?")){
			location.href="?date="+date;
		}
	}
//-->
</script>
<!-- 날짜이동 스크립트 -->
<!-- 내부 스타일 -->
<style type="text/css">
	.arrow{vertical-align:middle;}
	.schedule_date {font-weight:600;font-size:3em;border:1px solid #eee;height:50px;}
	.schedule {width:100%;border-collapse: collapse;}
	.schedule th {height:10px;background-color:#f4f4f4;border-left:1px solid #ddd;}
	.schedule td {height:120px;border-left:1px solid #ddd;text-align:left;vertical-align:top;font-size:1.11em;}
	.schedule th:first-child, .schedule td:first-child {	border-left:none;}
	/*
	.schedule td:first-child {	color:#c80000;	font-weight:600;}
	.schedule td:last-child {	color:#0061d8;	font-weight:600;}
	*/
	.schedule td.dataOn {}
	.schedule td.dataOn em {	font-size:11.5px;	color:black;}
	.btn_blue{color:blue !important;background:#eee !important; border:1px solid blue !important;}
	select:disabled{background:gray;}
	.nostore{text-align:center !important;height:300px !important;vertical-align:middle !important;}
	.store_list{list-style:none;margin:0; padding:0;}
	.store_list li{margin:3px; padding:10px; float:left; border:1px solid #eee;font-size:16px;font-weight:600; background:#eee;cursor:pointer;}
	.store_list li.on{background:#395467;color:#fff;}
	.state_normal{font-size:12px;color:#000 !important;}
	.state_weekend{font-size:12px;color:red !important;}
</style>
<!-- 내부 스타일 -->

<?php
if($code == "holiday"){
?>
<div class="float-wrap">
	<h3 class="icon-list float-l">전체 배송휴일 관리</h3>
</div>
<?php
}
else{
?>
<div class="float-wrap">
	<h3 class="icon-list float-l">추천식단관리 | <?=$recom_food_info->recom_name?></h3>
</div>
<?php
}
?>

<!-- 날짜 및 이전달 다음달 화살표 -->
<p class="align-c pb20">
	<a href="<?=self_url()?>?year=<?=$prevYear?>&month=<?=$prevMonth?>"><img src="/_dhadm/image/icon/left.png" class='arrow'></a>
	<select name="year" class="schedule_date year" onchange="gocalendar()">
		<?php
		for($ii=date("Y")-10;$ii<date("Y")+3;$ii++){
		?>
		<option value="<?=$ii?>" <?=($year==$ii)?'selected':'';?>><?=$ii?></option>
		<?php
		}
		?>
	</select>
	.
	<select name="month" class="schedule_date month" onchange="gocalendar()">
		<?php
		for($m=1;$m<13;$m++){
			if(strlen($m) < 2){
				$m="0".$m;
			}
		?>
		<option value="<?=$m?>" <?=($month==$m)?'selected':'';?>><?=$m?></option>
		<?php
		}
		?>
	</select>
	<a href="<?=self_url()?>?year=<?=$nextYear?>&month=<?=$nextMonth?>"><img src="/_dhadm/image/icon/right.png" class='arrow'></a>
</p>
<!-- 날짜 및 이전달 다음달 화살표 -->

<!-- 이번달 바로가기 -->
<p class="align-c pb20">
	<input type="button" class="" value="이번달로 이동" onclick="location.href='<?=self_url()?>'">
</p>
<!-- 이번달 바로가기 -->

<!-- <p class="mb10">
	<input type="button" class="btn_blue" value="공휴일 설정" onclick="holiday_set()">
	<?php
	help_info("공휴일 설정은 예약활성화 이전에 기입하셔야 예약 일괄 활성화시 적용됩니다.");
	?>
</p> -->

<table class="adm-table schedule">
	<colgroup>
		<col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px">
	</colgroup>
	<thead>
		<tr>
			<?=$th_data?>
		</tr>
	</thead>
	<tbody>
		<?php
		$line = "5";
		if (($FirstDayPosition > 5) && (ceil($TotalDay/5) >= 6)) $line = 6;
		if (($FirstDayPosition == 1) && ($TotalDay == 28)) $line =4;

		$k = 0;

		for($i=1; $i<=$line; $i++){
		?>
		<tr>
			<?php
			for($j=1; $j<=7; $j++){

				if ((!$day) && ($j == $FirstDayPosition)) $day = 1;
				$daylen = strlen($day);
				if($daylen==1)
				{
					$day_text="0".$day;
				}
				else{
					$day_text = $day;
				}

				if ($day > 0){
					$today_date_value = $year."-".$month."-".$day_text;
					//전체 배송휴일 리스트
					if($code == "holiday"){
					?>
					<td style="<?=( date("Y-m-d") == $today_date_value ) ? "background:#eee" : "" ; ?>">
						<?=$day_text?>
						<br>
						<?php
						$recom_cnt = 0;
						if($list){
							foreach($list as $lt){
								if($lt->holiday == $today_date_value){
									echo "<span style='font-size:12px;font-weight:600;color:blue'>".$lt->holiday_name."</span><BR>";

									echo "<span style='font-size:11px;font-weight:600;color:red'>";
									echo $lt->regu ? "정기 / " : "" ;
									echo $lt->free ? "낱개,특가 / " : "" ;
									echo $lt->samp ? "샘플 / " : "" ;
									echo $lt->snhf ? "간식,건강식품" : "" ;
									echo "</span><br>";

									echo "<span style='font-size:12px;font-weight:600;color:gray;'>";
									echo $lt->type;
									echo "</span><br>";

									$recom_cnt++;
								}
							}
						}

						echo "<br>";

						if($recom_cnt > 0){
						?>
						<input type="button" class="btn-sm2" value="수정" onclick="holiday_set('<?=$today_date_value?>')">
						<input type="button" class="btn-sm" value="삭제" onclick="holiday_del('<?=$today_date_value?>')">
						<?php
						}
						else{
						?>
						<input type="button" class="btn-sm2" value="등록" onclick="holiday_set('<?=$today_date_value?>')">
						<?php
						}
						?>
					</td>
					<?php
					}
					// 추천식단 리스트
					else{
						$recom_cnt = 0;
					?>
					<td style="<?=( date("Y-m-d") == $today_date_value ) ? "background:#eee" : "" ; ?>">
						<?=$day_text?>
						<br>
						<?php
						$prd = "";
						if($list){
							foreach($list as $lt){
								if($lt->recom_date == $today_date_value){
									echo "<span class='dh_blue' style='font-size:12px;font-weight:600;'>".$lt->goods_name."<BR><span class='dh_red'>(".$lt->code.")</span></span><BR>";
									$prd .= $lt->goods_idx.",";
									$recom_cnt++;
								}
							}
						}

						echo "<br>";

						if($recom_cnt > 0){
						?>
						<input type="button" class="btn-sm2" value="수정" onclick="recom_food_edit('<?=$today_date_value?>','<?=$recom_food_idx?>','<?=$prd?>')">
						<input type="button" class="btn-sm2" value="전체삭제" onclick="recom_food_del('<?=$today_date_value?>','<?=$recom_food_idx?>','<?=$prd?>')">
						<?php
						}
						else{
						?>
						<input type="button" class="btn-sm2" value="등록" onclick="recom_food_add('<?=$today_date_value?>','<?=$recom_food_idx?>')">
						<?php
						}
						?>
					</td>
					<?php
					}
				}
				else{
				?>
				<td>&nbsp;</td>
				<?php
				}

				if ($day != $TotalDay) {
					if (($day > 0) && ($day < $TotalDay)) $day++;
				}
				else{
					$day = "none";
				}
			}
			?>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<script type="text/javascript">
<!--
	function recom_food_add(date,recom_idx){
		openWinPopup("<?=cdir()?>/product/recom_pop/"+recom_idx+"/?ajax=1&date="+date, "recom_food_table", 900, 600);
	}

	function recom_food_edit(date,recom_idx,prd){
		openWinPopup("<?=cdir()?>/product/recom_pop/"+recom_idx+"/?ajax=1&date="+date, "recom_food_table", 900, 600);
	}

	function recom_food_del(date,recom_idx){
		if(confirm('선택하신 일자의 추천식단을 모두 삭제 하시겠습니까?')){
			location.href="<?=cdir()?>/product/recom_pop/?ajax=1&recom_idx="+recom_idx+"&date="+date;
		}
	}
//-->
</script>

<script>

function view(year,month,day)
{
	openWinPopup("<?=cdir()?>/board/schedule_view/?ajax=1&year="+year+"&month="+month+"&day="+day, "evt_list", 370, 500);
}

function calendar_detail(date){
	openWinPopup("/html/reservation/calendar_detail/?ajax=1&date="+date,"cal_detail",480,700);
}

</script>