<div class="float-wrap">
	<h3 class="icon-list float-l">추천식단관리</h3>
</div>

<table class="adm-table">
	<thead>
		<tr class="align-l">
			<th style="padding-left:15px">추천식단명</th>
			<th style="padding-left:15px">관리</th>
			<th style="padding-left:15px">등록 카테고리</th>
			<th style="padding-left:15px">등록일</th>
			<th style="padding-left:15px">수정일</th>
			<th style="padding-left:15px">우선순위</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<?php
		foreach($list as $row)
		{
		?>
		<tr>
			<td>
				<?=$row->recom_name?>
				<?php
				if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
				?>
				<span style="color:darkred">
				- &nbsp;i&nbsp;n&nbsp;d&nbsp;e&nbsp;x&nbsp; - (<?=$row->idx?>)
				</span>
				<?php
				}
				?>
			</td>
			<td>
				<input type="button" value="식단관리" class="btn-sm2" onclick="javascript:location.href='<?=self_url()?>/food_table/<?=$row->idx?>/';">
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url()?>/edit/<?=$row->idx?>';">
				<!-- <input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')"> -->
			</td>
			<td>
				<?php
				$cate_info = explode("^",substr($row->recom_cate,0,-1));
				foreach($cate_info as $ci){
					echo $arr_cate[$ci]."<BR>";
				}
				?>
			</td>
			<td>
				<?php
				echo strDatecut($row->wdate,3);
				?>
			</td>
			<td>
				<?php
				echo strDatecut($row->udate,3);
				?>
			</td>
			<td>
				<?php
				echo $row->sort;
				?>
			</td>
		</tr>
		<?php
		}

		if(count($list) <= 0)
		{
		?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-r">
		<a href="<?=self_url()?>/add/" class="button btn-ok">추천식단등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("정말 삭제하시겠습니까?")){
			//location.href = "/html/banner/group/m/del/"+idx;
		}
	}
//-->
</script>