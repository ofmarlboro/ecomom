
				<div class="float-wrap mt50">
					<p class="list-adding float-r">
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$year?>년 방문자수 : <a href="#" class="on"><? echo isset($total_year_counter[0]) ? number_format($total_year_counter[0]) : 0;?></a><br>
						<img src="/_dhadm/image/icon/bl_list.png"> <?=$year?>년 접속횟수 : <a href="#" class="on"><? echo isset($total_year_counter[1]) ? number_format($total_year_counter[1]) : 0;?></a>
					</p>
				</div>


				<table class="adm-table v-line align-l" style="border-top:0px;">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:9%;"><col style=""><col style="width:13%;">
					</colgroup>
					<thead>
					<tbody class="ft092">
					<?
						for($i=0;$i<12;$i++)
						{
						 $per1=(int)($time_count1[$i]/$max1*100+1);
						 $per2=(int)($time_count2[$i]/$max2*100+1);
						 if($per1>100)$per1=99;
						 if($per2>100)$per2=99;
						 $j=$i+1;
					?>
						<tr>
							<th><?=$j?> 월</th>
							<td>
							<img src="/_dhadm/image/icon/count_body.gif" border=0 width=<?=$per1?>% height=20 alt='방문자수 : <?=$time_count1[$i]?>'><br>
							<img src="/_dhadm/image/icon/count_body2.gif" border=0 width=<?=$per2?>% height=20 alt='접속횟수 : <?=$time_count2[$i]?>'>
							</td>
							<td>방문자수 : <?=$time_count1[$i]?><br><font color=#A92B05>접속횟수 : <?=$time_count2[$i]?></font></td>
						</tr>
					<?
					 }
					?>
					</thead>
				</tbody>
			</table>