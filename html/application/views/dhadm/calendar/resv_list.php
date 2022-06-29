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
		<?
		if($this->input->get("store"))
		{
		?>
		var store = '&store=<?=$this->input->get("store")?>';	
		<?
		}	
		?>

		location.href="/html/<?=uri_string()?>/?year="+year+"&month="+month+store;
	}
//-->
</script>
<!-- 날짜이동 스크립트 -->
<!-- 내부 스타일 -->
<style type="text/css">
	.arrow{vertical-align:middle;}
	.schedule_date {font-weight:600;font-size:3em;border:1px solid #eee;height:50px;}
	.schedule {width:100%;border-collapse: collapse;}
	.schedule th {height:35px;background-color:#f4f4f4;border-left:1px solid #ddd;}
	.schedule td {height:70px;border-left:1px solid #ddd;text-align:left;vertical-align:top;font-size:1.11em;}
	.schedule th:first-child, .schedule td:first-child {	border-left:none;}
	.schedule td:first-child {	color:#c80000;	font-weight:600;}
	.schedule td:last-child {	color:#0061d8;	font-weight:600;}
	.schedule td.dataOn {}
	.schedule td.dataOn em {	font-size:11.5px;	color:black;}
	.btn_blue{color:blue !important;background:#eee !important;}
	select:disabled{background:gray;}
	.nostore{text-align:center !important;height:300px !important;vertical-align:middle !important;}
	.store_list{list-style:none;margin:0; padding:0;}
	.store_list li{margin:3px; padding:10px; float:left; border:1px solid #eee;font-size:16px;font-weight:600; background:#eee;cursor:pointer;}
	.store_list li.on{background:#395467;color:#fff;}
	.state_normal{font-size:12px;color:#000 !important;}
	.state_weekend{font-size:12px;color:red !important;}
</style>
<!-- 내부 스타일 -->

<!-- 지점 선택하는 탭 -->
<ul class="store_list pb50">
	<?php
	foreach($store_info as $st){
	?>
	<li onclick="location.href='/html/<?=uri_string()?>?store=<?=$st->idx?>'" <?=($store==$st->idx)?"class='on'":"";?>><?=$st->store_name?></li>
	<?php
	}
	?>
</ul>
<!-- 지점 선택하는 탭 -->

<!-- 날짜 및 이전달 다음달 화살표 -->
<p class="align-c pb20">
	<a href="/html/<?=uri_string()?>/?year=<?=$prevYear?>&month=<?=$prevMonth?><?=($this->input->get("store"))?"&store=".$this->input->get("store"):"";?>"><img src="/_dhadm/image/icon/left.png" class='arrow'></a>
	<select name="year" class="schedule_date year" onchange="gocalendar()">
		<?php
		for($ii=date("Y")-2;$ii<date("Y")+3;$ii++){
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
	<a href="/html/<?=uri_string()?>/?year=<?=$nextYear?>&month=<?=$nextMonth?><?=($this->input->get("store"))?"&store=".$this->input->get("store"):"";?>"><img src="/_dhadm/image/icon/right.png" class='arrow'></a>
</p>
<!-- 날짜 및 이전달 다음달 화살표 -->

<!-- 이번달 바로가기 -->
<p class="align-c pb20">
	<input type="button" class="" value="이번달로 이동" onclick="location.href='/html/<?=uri_string()?>/<?=($this->input->get("store"))?"?store=".$this->input->get("store"):"";?>'">
</p>
<!-- 이번달 바로가기 -->

<!-- 	<input type="button" class="btn_blue" value="이번달 일괄 예약활성화" onclick=""> -->

<table class="adm-table schedule">
	<colgroup>
		<col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px"><col width="132px">
	</colgroup>
	<thead>
		<tr>
			<?=$th_data?>
		</tr>
	</thead>
	<?php
	$db_date = array();
	foreach($list as $row){
		$db_date[$row->date] = $row->state;
	}			
	?>
	<tbody>
		<?php
		$line = "5";
		if (($FirstDayPosition > 5) && (ceil($TotalDay/5) == 7)) $line = 6;
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
				?>
				<td>
					<?=$day?>
					<?php
					foreach($resv_list as $row){
						if($row->dodate == $today_date_value){
							echo "예약있음";
						}
					}
					?>
				</td>
				<?php
				}
				else{
				?>
				<td></td>
				<?php
				}

				if ($day != $TotalDay) {
					if (($day > 0) && ($day < $TotalDay)) $day++;
				} else {
					$day = "&nbsp;";
				}

			}
			?>
		</tr>
		<?php
		}
		?>
	</tbody>	
	<?php
	?>
</table>


<script>

function view(year,month,day)
{
	openWinPopup("<?=cdir()?>/board/schedule_view/?ajax=1&year="+year+"&month="+month+"&day="+day, "evt_list", 370, 500);
}

	function calendar_detail(date){
		openWinPopup("/html/reservation/calendar_detail/?ajax=1&date="+date+"&store=<?=$this->input->get('store')?>","cal_detail",440,500);
	}

</script>