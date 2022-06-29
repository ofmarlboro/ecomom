<?php
/*
** 리스트 일반형으로 정리 **
코드명 노출 불필요
우선순위 노출 불필요
사용여부 노출 불필요
수정 / 삭제 디자인허브 IP 로만 우선 활성화
*/
?>

<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }
?>

<style type="text/css">
	.banner_list{
		background:#fff;
	}

	.banner_list:hover{
		background:#eee;
	}
</style>

<div class="float-wrap">
	<h3 class="icon-list float-l">백화점/인스타후기</h3>
</div>
<?php
helps('그룹명은 수정을 통해 변경 가능합니다. EX)4월 산골아기 인스타후기 모음');
?>
<table class="adm-table line align-c">
	<caption>유저 목록</caption>
	<thead>
		<tr>
			<th>그룹명</th>
			<!-- <th>코드명</th> -->
			<th>등록된배너수</th>
			<!-- <th>우선순위</th>
			<th>사용여부</th> -->
			<!-- <th>팝업배너 여부</th> -->
			<th>관리</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<?php
		foreach($list as $row)
		{
		?>
		<tr class="banner_list">
			<td><a href="<?=self_url()?>/s_add/?code=<?=$row->code?>&parent_idx=<?=$row->idx?>"><?=$row->name?></a>
				<?php
				if($row->used == "Y"){
					if($row->pageurl == "show"){
						echo "<br><span class='dh_red'>노출중인배너</span>";
					}
				}
				?>
			</td>
			<!-- <td><?=$row->code?></td> -->
			<td><b><?=$row->num?></b>개</td>
			<!-- <td><?=$row->sorting?></td> -->
			<!-- <td><?=($row->used=="Y")?"팝업배너":"팝업배너 아님";?></td> -->
			<td>
				<input type="button" value="배너관리" class="btn-sm2" onclick="javascript:location.href='<?=self_url()?>/s_add/?code=<?=$row->code?>&parent_idx=<?=$row->idx?>';">
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url()?>/edit/<?=$row->idx?>';">
				<?php
				if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
				?>
				<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')">
				<?php
				}
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
		<a href="<?=self_url()?>/add/" class="button btn-ok">그룹 등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("삭제하시면 그룹안의 모든 배너가 삭제됩니다.\n\n정말 삭제하시겠습니까?")){
			location.href = "/html/banner2/group/m/del/"+idx;
		}
	}
//-->
</script>