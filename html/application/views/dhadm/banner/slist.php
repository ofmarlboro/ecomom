<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }

	$mobile_use = false;
	if($code == "pc_main"){	//공통-메인배너
		$mobile_use = true;
	}

	if($code == "pc_depart"){	//공통-메인백화점입점
		$mobile_use = true;
	}

	if($code == "pc_mid_farm"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}

	if($code == "pc_event_top" || $code=="snack_top" || $code=="nmk_top"){	//공통-이벤트페이지 상단
		$mobile_use = true;
	}

	if($code == "pc_event_bottom"){	//공통-이벤트페이지 하단
		$mobile_use = true;
	}

	if($code == "pc_farmlist"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}

	if($code == "pc_deliv" || $code == "pc_news" || $code == "pc_farm" || $code == "pc_event" || $code == "pc_spcdis"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}

	if($code == "newholi"){
		$mobile_use = true;
	}
?>

<div class="float-wrap">
	<h3 class="icon-list float-l"><?=$parent_info->name?></h3>
	<p class="float-r">배너등록/수정/삭제</p>
</div>

<?php
help_info("1개만 등록되는 배너의 경우 삭제 또는 수정을 통하여 관리 해 주시기 바랍니다.");
?>

<table class="adm-table line align-c">
	<caption>유저 목록</caption>
	<thead>
		<tr>
			<th>코드</th>
			<?php
			if($parent_info->used == "Y"){
			?>
			<th>타이틀</th>
			<?php
			}
			?>
			<th><?=($mobile_use)?"PC ":"";?>이미지</th>
			<?php
			if($mobile_use){
				?>
				<th>Mobile 이미지</th>
				<?php
			}
			?>
			<th>우선순위</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<?php
		foreach($s_list as $row)
		{
		?>
		<tr>
			<td><?=$row->parent_code?></td>
			<?php
			if($parent_info->used == "Y"){
			?>
			<td><?=$row->addinfo1?></td>
			<?php
			}
			?>
			<td><img src="/_data/file/banner/<?=$row->upfile1?>" width="100" onclick="window.open('/_data/file/banner/<?=$row->upfile1?>','','width=560,height=315,scrollbars=yes,resizeable=yes')" onerror="this.src='/image/default.jpg'"></td>
			<?php
			if($mobile_use){
				?>
				<td><img src="/_data/file/banner/<?=$row->upfile2?>" width="100" onclick="window.open('/_data/file/banner/<?=$row->upfile2?>','','width=560,height=315,scrollbars=yes,resizeable=yes')" onerror="this.src='/image/default.jpg'"></td>
				<?php
			}
			?>
			<td><?=$row->sort?></td>
			<td>
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='/html/banner/group/m/s_edit/?code=<?=$code?>&s_idx=<?=$row->idx?>';">
				<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')">
			</td>
		</tr>
		<?php
		}

		if(count($s_list) <= 0)
		{
		?>
		<tr>
			<td colspan="10">등록된 내용이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-l">
		<a href="/html/banner/group/m/" class="button">배너그룹 목록</a></span>
	</div>
	<div class="float-r">
		<a href="/html/banner/group/m/s_input/?code=<?=$code?>&parent_idx=<?=$parent_idx?>" class="button btn-ok">배너등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href = "/html/banner/group/m/s_del/?s_idx="+idx;
		}
	}
//-->
</script>